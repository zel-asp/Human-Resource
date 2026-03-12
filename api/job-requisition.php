<?php
require_once 'api/keys.php';
require_once 'api/functions.php';

$apiInfo = validateApiKey();
$db = getDB();
$method = $_SERVER['REQUEST_METHOD'];

// GET: Get job requisitions
if ($method === 'GET') {
    $status = $_GET['status'] ?? null;

    if ($status) {
        $result = $db->query(
            "SELECT * FROM job_requisitions WHERE status = ? ORDER BY created_at DESC",
            [$status]
        )->find();
    } else {
        $result = $db->query("SELECT * FROM job_requisitions ORDER BY created_at DESC")->find();
    }

    sendResponse($result);
}

// POST: Create job requisition
if ($method === 'POST') {
    if (!canWrite($apiInfo)) {
        sendError('Write permission required', 403);
    }

    $data = getRequestData();

    // Validate required fields
    $required = ['job_title', 'department', 'requested_by', 'positions', 'needed_by'];
    $missing = [];
    foreach ($required as $field) {
        if (empty($data[$field])) {
            $missing[] = $field;
        }
    }

    if (!empty($missing)) {
        sendError('Missing fields: ' . implode(', ', $missing), 400);
    }

    $db->query(
        "INSERT INTO job_requisitions 
         (job_title, department, requested_by, positions, needed_by, priority, justification, status, created_at) 
         VALUES (?, ?, ?, ?, ?, ?, ?, 'pending', NOW())",
        [
            $data['job_title'],
            $data['department'],
            $data['requested_by'],
            $data['positions'],
            $data['needed_by'],
            $data['priority'] ?? 'medium',
            $data['justification'] ?? null
        ]
    );

    sendResponse(['id' => $db->lastInsertId(), 'message' => 'Job requisition created'], 201);
}

// PUT: Update job requisition
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
        "UPDATE job_requisitions 
         SET job_title = ?, department = ?, requested_by = ?, 
             positions = ?, needed_by = ?, priority = ?, justification = ?
         WHERE id = ?",
        [
            $data['job_title'] ?? null,
            $data['department'] ?? null,
            $data['requested_by'] ?? null,
            $data['positions'] ?? null,
            $data['needed_by'] ?? null,
            $data['priority'] ?? null,
            $data['justification'] ?? null,
            $id
        ]
    );

    sendResponse(['message' => 'Job requisition updated']);
}

// DELETE: Delete job requisition
if ($method === 'DELETE') {
    if (!canWrite($apiInfo)) {
        sendError('Write permission required', 403);
    }

    $id = $_GET['id'] ?? '';
    if (!$id) {
        sendError('ID is required', 400);
    }

    $db->query("DELETE FROM job_requisitions WHERE id = ?", [$id]);
    sendResponse(['message' => 'Job requisition deleted']);
}

// PATCH: Update status
if ($method === 'PATCH') {
    if (!canWrite($apiInfo)) {
        sendError('Write permission required', 403);
    }

    $id = $_GET['id'] ?? '';
    $data = getRequestData();

    if (!$id || empty($data['status'])) {
        sendError('ID and status are required', 400);
    }

    $db->query(
        "UPDATE job_requisitions SET status = ? WHERE id = ?",
        [$data['status'], $id]
    );

    sendResponse(['message' => 'Status updated']);
}