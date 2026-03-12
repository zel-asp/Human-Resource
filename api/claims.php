<?php
require_once 'api/keys.php';
require_once 'api/functions.php';

$apiInfo = validateApiKey();
$db = getDB();
$method = $_SERVER['REQUEST_METHOD'];

// GET: Get claims
if ($method === 'GET') {
    $status = $_GET['status'] ?? null;
    $employeeId = $_GET['employee_id'] ?? null;

    $sql = "SELECT c.*, e.full_name, e.department 
            FROM expense_claims c
            JOIN employees e ON c.employee_id = e.id";

    $params = [];

    if ($status && $employeeId) {
        $sql .= " WHERE c.status = ? AND c.employee_id = ?";
        $params = [$status, $employeeId];
    } elseif ($status) {
        $sql .= " WHERE c.status = ?";
        $params = [$status];
    } elseif ($employeeId) {
        $sql .= " WHERE c.employee_id = ?";
        $params = [$employeeId];
    }

    $sql .= " ORDER BY c.created_at DESC";

    $claims = $db->query($sql, $params)->find();
    sendResponse($claims);
}

// POST: Update claim status
if ($method === 'POST') {
    if (!canWrite($apiInfo)) {
        sendError('Write permission required', 403);
    }

    $data = getRequestData();
    $action = $_GET['action'] ?? '';
    $id = $_GET['id'] ?? '';

    if (!$id) {
        sendError('Claim ID is required', 400);
    }

    // Get claim details
    $claim = $db->query(
        "SELECT c.*, e.full_name, e.email 
         FROM expense_claims c
         JOIN employees e ON c.employee_id = e.id
         WHERE c.id = ?",
        [$id]
    )->fetch_one();

    if (!$claim) {
        sendError('Claim not found', 404);
    }

    if ($action === 'approve') {
        // Finance approves
        if ($apiInfo['name'] !== 'Finance System') {
            sendError('Only finance can approve claims', 403);
        }

        $db->query(
            "UPDATE expense_claims SET status = 'Approved', approved_at = NOW() WHERE id = ?",
            [$id]
        );

        // Notify employee
        notifyEmployee(
            $claim['employee_id'],
            'Claim Approved',
            "Your claim for ₱" . number_format($claim['amount'], 2) . " has been approved"
        );

        sendResponse(['message' => 'Claim approved']);

    } elseif ($action === 'reject') {
        if (empty($data['reason'])) {
            sendError('Rejection reason is required', 400);
        }

        $db->query(
            "UPDATE expense_claims SET status = 'Rejected', rejection_reason = ? WHERE id = ?",
            [$data['reason'], $id]
        );

        notifyEmployee(
            $claim['employee_id'],
            'Claim Rejected',
            "Your claim for ₱" . number_format($claim['amount'], 2) . " was rejected. Reason: " . $data['reason']
        );

        sendResponse(['message' => 'Claim rejected']);

    } elseif ($action === 'pay') {
        // Finance marks as paid
        if ($apiInfo['name'] !== 'Finance System') {
            sendError('Only finance can mark claims as paid', 403);
        }

        $db->query(
            "UPDATE expense_claims SET status = 'Paid' WHERE id = ?",
            [$id]
        );

        notifyEmployee(
            $claim['employee_id'],
            'Claim Paid',
            "Your claim for ₱" . number_format($claim['amount'], 2) . " has been paid"
        );

        sendResponse(['message' => 'Claim marked as paid']);
    }
}