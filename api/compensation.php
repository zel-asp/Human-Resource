<?php
require_once 'api/keys.php';
require_once 'api/functions.php';

// Validate API key
$apiInfo = validateApiKey();

$db = getDB();
$method = $_SERVER['REQUEST_METHOD'];

// GET: Get all compensation reviews
if ($method === 'GET') {
    $status = $_GET['status'] ?? null;

    $sql = "SELECT cr.*, e.full_name, e.department, e.position 
            FROM compensation_reviews cr
            JOIN employees e ON cr.employee_id = e.id";

    if ($status) {
        $sql .= " WHERE cr.status = :status ORDER BY cr.created_at DESC";
        $result = $db->query($sql, ['status' => $status])->find();
    } else {
        $sql .= " ORDER BY cr.created_at DESC";
        $result = $db->query($sql)->find();
    }

    sendResponse($result);
}

// POST: Approve or Reject compensation
if ($method === 'POST') {
    // Only systems with write permission can approve/reject
    if (!canWrite($apiInfo)) {
        sendError('Write permission required', 403);
    }

    $data = getRequestData();
    $action = $_GET['action'] ?? '';
    $id = $_GET['id'] ?? '';

    if (!$id) {
        sendError('Compensation ID is required', 400);
    }

    // Get the compensation review
    $review = $db->query(
        "SELECT cr.*, e.full_name, e.email, e.id as employee_id 
         FROM compensation_reviews cr
         JOIN employees e ON cr.employee_id = e.id
         WHERE cr.id = ?",
        [$id]
    )->fetch_one();

    if (!$review) {
        sendError('Compensation review not found', 404);
    }

    if ($action === 'approve') {
        // Only finance can approve (check by system name or you can add role)
        if ($apiInfo['name'] !== 'Finance System' && $apiInfo['name'] !== 'HR System') {
            sendError('Only finance can approve compensation', 403);
        }

        // Start transaction
        $db->beginTransaction();

        try {
            // Update compensation review
            $db->query(
                "UPDATE compensation_reviews 
                 SET status = 'approved', 
                     finance_approved_at = NOW() 
                 WHERE id = ?",
                [$id]
            );

            // Update employee hourly rate if proposed_hourly_rate exists
            if (!empty($review['proposed_hourly_rate'])) {
                $db->query(
                    "UPDATE employees SET hourly_rate = ? WHERE id = ?",
                    [$review['proposed_hourly_rate'], $review['employee_id']]
                );
            }

            $db->commit();

            // Notify employee
            notifyEmployee(
                $review['employee_id'],
                'Compensation Approved',
                "Your compensation has been approved! New rate: ₱" . number_format($review['proposed_hourly_rate'] ?? $review['proposed_salary'] / 160, 2)
            );

            sendResponse(['message' => 'Compensation approved successfully']);

        } catch (Exception $e) {
            $db->rollBack();
            sendError('Failed to approve: ' . $e->getMessage(), 500);
        }

    } elseif ($action === 'reject') {
        if (empty($data['reason'])) {
            sendError('Rejection reason is required', 400);
        }

        $db->query(
            "UPDATE compensation_reviews 
             SET status = 'rejected', 
                 finance_notes = ? 
             WHERE id = ?",
            [$data['reason'], $id]
        );

        // Notify employee
        notifyEmployee(
            $review['employee_id'],
            'Compensation Rejected',
            "Your compensation review was rejected. Reason: " . $data['reason']
        );

        sendResponse(['message' => 'Compensation rejected']);

    } elseif ($action === 'create') {
        // Create new compensation review
        $errors = [];
        if (empty($data['employee_id']))
            $errors[] = 'employee_id required';
        if (empty($data['current_salary']))
            $errors[] = 'current_salary required';
        if (empty($data['proposed_salary']))
            $errors[] = 'proposed_salary required';

        if (!empty($errors)) {
            sendError('Missing fields: ' . implode(', ', $errors), 400);
        }

        $db->query(
            "INSERT INTO compensation_reviews 
             (employee_id, current_salary, proposed_salary, proposed_hourly_rate, 
              review_type, review_date, effective_date, status, created_at) 
             VALUES (?, ?, ?, ?, ?, ?, ?, 'pending', NOW())",
            [
                $data['employee_id'],
                $data['current_salary'],
                $data['proposed_salary'],
                $data['proposed_hourly_rate'] ?? null,
                $data['review_type'] ?? 'annual',
                date('Y-m-d'),
                $data['effective_date'] ?? date('Y-m-d', strtotime('+30 days'))
            ]
        );

        sendResponse(['id' => $db->lastInsertId(), 'message' => 'Compensation review created'], 201);
    }
}

// PUT: Update compensation
if ($method === 'PUT') {
    if (!canWrite($apiInfo)) {
        sendError('Write permission required', 403);
    }

    $id = $_GET['id'] ?? '';
    if (!$id) {
        sendError('ID is required', 400);
    }

    $data = getRequestData();

    $db->query(
        "UPDATE compensation_reviews 
         SET proposed_salary = ?, 
             proposed_hourly_rate = ?,
             effective_date = ?
         WHERE id = ? AND status = 'pending'",
        [
            $data['proposed_salary'] ?? null,
            $data['proposed_hourly_rate'] ?? null,
            $data['effective_date'] ?? null,
            $id
        ]
    );

    sendResponse(['message' => 'Compensation updated']);
}

// DELETE: Delete compensation
if ($method === 'DELETE') {
    if (!canWrite($apiInfo)) {
        sendError('Write permission required', 403);
    }

    $id = $_GET['id'] ?? '';
    if (!$id) {
        sendError('ID is required', 400);
    }

    $db->query("DELETE FROM compensation_reviews WHERE id = ? AND status = 'pending'", [$id]);
    sendResponse(['message' => 'Compensation deleted']);
}