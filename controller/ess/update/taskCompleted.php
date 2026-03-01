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
    header('Location: /?tab=tasks#tasksPanel');
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

// get task data
$taskId = $_POST['task_id'] ?? null;
$action = $_POST['action'] ?? 'complete';

if (!$taskId || !is_numeric($taskId)) {
    $_SESSION['error'][] = "Invalid task ID.";
    // header('Location: /?tab=tasks#tasksPanel');
    exit();
}

// get employee id from session
$employeeData = $_SESSION['employee']['employee_record_id'] ?? null; // Use the correct key

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

// verify task ownership
$task = $db->query(
    "SELECT id, status, task_description FROM tasks WHERE id = ? AND assigned_to = ?",
    [$taskId, $employeeId]
)->fetch_one();

if (!$task) {
    $_SESSION['error'][] = "Task not found or you don't have permission to update this task.";
    header('Location: /?tab=tasks#tasksPanel');
    exit();
}

// prevent double completion
if ($task['status'] === 'Completed') {
    $_SESSION['error'][] = "Task '" . htmlspecialchars($task['task_description']) . "' is already completed.";
    header('Location: /?tab=tasks#tasksPanel');
    exit();
}

// update task
try {
    // determine new status
    $newStatus = 'Completed';

    if ($action === 'start' && $task['status'] === 'Not Started') {
        $newStatus = 'Ongoing';
    }

    $db->query(
        "UPDATE tasks 
        SET status = ?, updated_at = NOW() 
        WHERE id = ? AND assigned_to = ?",
        [$newStatus, $taskId, $employeeId]
    );

    if ($db->count() > 0) {
        $statusMessage = $newStatus === 'Completed' ? 'completed' : 'started';
        $_SESSION['success'][] = "Task '" . htmlspecialchars($task['task_description']) . "' marked as " . $statusMessage . "!";
        error_log("Task ID {$taskId} marked as {$newStatus} by employee ID {$employeeId}");
    } else {
        $_SESSION['error'][] = "No changes were made to the task.";
    }

} catch (\Exception $e) {
    error_log("Error updating task: " . $e->getMessage());
    $_SESSION['error'][] = "An error occurred while updating the task. Please try again.";
}

// redirect back
$redirect = $_POST['redirect'] ?? '/';
$redirectUrl = $redirect . (strpos($redirect, '?') === false ? '?' : '&') . 'tab=tasks&modal=viewAllTasksModal';
header("Location: $redirectUrl");
exit();