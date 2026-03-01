<?php

use Core\Database;

require base_path('core/middleware/employeeAuth.php');

$config = require base_path('config/config.php');
$db = new Database($config['database']);

// start session messages
$_SESSION['error'] ??= [];
$_SESSION['success'] ??= [];

// only allow post
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['error'][] = "Invalid request method.";
    header('Location: /?tab=tasks');
    exit();
}

// csrf check
if (
    !isset($_POST['csrf_token']) ||
    !isset($_SESSION['csrf_token']) ||
    $_POST['csrf_token'] !== $_SESSION['csrf_token']
) {
    $_SESSION['error'][] = "Invalid CSRF token. Please try again.";
    header('Location: /login');
    exit();
}

$taskId = $_POST['task_id'] ?? null;

if (!$taskId || !is_numeric($taskId)) {
    $_SESSION['error'][] = "Invalid task ID.";
    header('Location: /?tab=tasks');
    exit();
}

// get employee id from session
$employeeData = $_SESSION['employee']['employee_record_id'] ?? null;

if (is_array($employeeData) && isset($employeeData['id'])) {
    $employeeId = $employeeData['id'];
} else {
    $employeeId = $employeeData;
}

if (!$employeeId) {
    $_SESSION['error'][] = "Employee not found. Please login again.";
    header('Location: /login');
    exit();
}

// check if task belongs to employee
$task = $db->query(
    "SELECT id, status, task_description, assigned_to 
    FROM tasks 
    WHERE id = ? AND assigned_to = ?",
    [$taskId, $employeeId]
)->fetch_one();

if (!$task) {
    $_SESSION['error'][] = "Task not found or you don't have permission to update this task.";
    header('Location: /?tab=tasks');
    exit();
}

// check current status
if ($task['status'] === 'Ongoing') {
    $_SESSION['error'][] = "Task '" . htmlspecialchars($task['task_description']) . "' is already in progress.";
    header('Location: /?tab=tasks');
    exit();
}

if ($task['status'] === 'Completed') {
    $_SESSION['error'][] = "Task '" . htmlspecialchars($task['task_description']) . "' is already completed.";
    header('Location: /?tab=tasks');
    exit();
}

if ($task['status'] !== 'Not Started') {
    $_SESSION['error'][] = "Task cannot be started from current status.";
    header('Location: /?tab=tasks');
    exit();
}

// start the task
try {
    $db->beginTransaction();

    $db->query(
        "UPDATE tasks 
        SET status = 'Ongoing', updated_at = NOW() WHERE id = ? AND assigned_to = ? AND status = 'Not Started'",
        [$taskId, $employeeId]
    );

    if ($db->count() === 0) {
        throw new Exception("No rows were updated. Task may have been modified by another user.");
    }

    $db->commit();

    $_SESSION['success'][] = "Task '" . htmlspecialchars($task['task_description']) . "' has been started!";
    error_log("Task ID {$taskId} started by employee ID {$employeeId} at " . date('Y-m-d H:i:s'));

} catch (Exception $e) {
    $db->rollBack();
    error_log("Error starting task: " . $e->getMessage());
    $_SESSION['error'][] = "An error occurred while starting the task. Please try again.";
}

// redirect back
$redirect = $_POST['redirect'] ?? '/';
$redirect = strtok($redirect, '?');
$redirectUrl = $redirect . '?tab=tasks';

if (isset($_POST['modal'])) {
    $redirectUrl .= '&modal=' . urlencode($_POST['modal']);
}

header("Location: $redirectUrl");
exit();