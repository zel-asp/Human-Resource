<?php
require_once 'api/keys.php';
require_once 'api/functions.php';

$apiInfo = validateApiKey();
$db = getDB();
$method = $_SERVER['REQUEST_METHOD'];

if ($method !== 'GET') {
    sendError('Method not allowed', 405);
}

$department = $_GET['department'] ?? '';

if (empty($department)) {
    sendError('Department parameter is required', 400);
}

$applicants = $db->query(
    "SELECT id, full_name, email, phone, position, department, 
            rate_per_hour, status, experience, education, skills,
            created_at, age, gender, shift
     FROM applicants 
     WHERE department = ? 
     ORDER BY created_at DESC",
    [$department]
)->find();

sendResponse([
    'department' => $department,
    'total' => count($applicants),
    'applicants' => $applicants
]);