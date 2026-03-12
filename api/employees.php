<?php
// api/employees.php - No need to set headers, router handles that

require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/keys.php';

try {
    // Get API key from header
    $headers = getallheaders();
    $apiKey = $headers['X-API-Key'] ?? $_GET['X-API-Key'] ?? null;

    if (!$apiKey) {
        throw new Exception('API key is required');
    }

    // Simple validation
    $validKeys = [
        'hr_system_2026_secure_key_12345' => true
    ];

    if (!isset($validKeys[$apiKey])) {
        throw new Exception('Invalid API key');
    }

    // Get database connection
    $db = getDB();

    // Get department from query string
    $department = $_GET['department'] ?? '';

    if (empty($department)) {
        throw new Exception('Department parameter is required');
    }

    // Query employees
    $employees = $db->query(
        "SELECT e.id, e.employee_number, e.full_name, e.email, e.phone, 
                e.position, e.hourly_rate, e.department, e.start_date, e.status,
                e.role, e.gender, e.age,
                s.shift_name, s.start_time, s.end_time
         FROM employees e
         LEFT JOIN shifts s ON e.shift_id = s.id
         WHERE e.department = ? AND e.status != 'terminated'
         ORDER BY e.full_name",
        [$department]
    )->find();

    // Return JSON response
    echo json_encode([
        'success' => true,
        'data' => [
            'department' => $department,
            'total' => count($employees),
            'employees' => $employees
        ]
    ]);

} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}