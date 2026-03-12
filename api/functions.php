<?php
// NO EMPTY LINES BEFORE THIS
// Turn off error display to prevent HTML output
ini_set('display_errors', 0);
error_reporting(E_ALL);

function getDB()
{
    $config = require __DIR__ . '/../config.php';
    require_once __DIR__ . '/../core/Class/Database.php';
    return new Core\Database($config['database']);
}

function sendResponse($data, $statusCode = 200)
{
    // Clear any output buffers
    if (ob_get_level())
        ob_clean();

    http_response_code($statusCode);
    header('Content-Type: application/json');
    echo json_encode([
        'success' => true,
        'data' => $data,
        'timestamp' => date('Y-m-d H:i:s')
    ]);
    exit;
}

function sendError($message, $statusCode = 400)
{
    if (ob_get_level())
        ob_clean();

    http_response_code($statusCode);
    header('Content-Type: application/json');
    echo json_encode([
        'success' => false,
        'error' => $message,
        'timestamp' => date('Y-m-d H:i:s')
    ]);
    exit;
}

function getRequestData()
{
    return json_decode(file_get_contents('php://input'), true) ?? [];
}

function notifyEmployee($employeeId, $title, $message)
{
    $db = getDB();

    // Create notifications table if not exists
    $db->query("
        CREATE TABLE IF NOT EXISTS notifications (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            employee_id INT NOT NULL,
            title VARCHAR(255) NOT NULL,
            message TEXT NOT NULL,
            is_read TINYINT DEFAULT 0,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            INDEX (employee_id)
        )
    ");

    $sql = "INSERT INTO notifications (employee_id, title, message, created_at) 
            VALUES (?, ?, ?, NOW())";
    return $db->query($sql, [$employeeId, $title, $message]);
}