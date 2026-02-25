<?php

use Core\Database;

$config = require base_path('config/config.php');
$db = new Database($config['database']);

$_SESSION['success'] ??= [];
$_SESSION['error'] ??= [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // CSRF check
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $_SESSION['error'][] = 'Invalid CSRF token.';
    } else {

        // Sanitize inputs
        $assigned_to = filter_var($_POST['assigned_to'], FILTER_VALIDATE_INT);
        $task_type = trim($_POST['task_type']);
        $task_description = trim($_POST['task_description']);
        $due_date = $_POST['due_date'];
        $priority = ucfirst(strtolower(trim($_POST['priority'])));
        $assigned_staff = trim($_POST['assigned_staff']);

        // Validation
        if (!$assigned_to)
            $_SESSION['error'][] = 'Invalid applicant selected.';
        if (empty($task_type))
            $_SESSION['error'][] = 'Task type is required.';
        if (empty($task_description))
            $_SESSION['error'][] = 'Task description is required.';
        if (empty($due_date) || !date_create($due_date))
            $_SESSION['error'][] = 'Invalid due date.';
        if (!in_array($priority, ['Low', 'Medium', 'High', 'Urgent']))
            $priority = 'Medium';
        if (empty($assigned_staff))
            $_SESSION['error'][] = 'Assigned staff is required.';

        if (empty($_SESSION['error'])) {
            try {
                // Insert new task as a separate row
                $db->query("
                    INSERT INTO tasks (assigned_to, task_type, task_description, due_date, priority, assigned_staff)
                    VALUES (:assigned_to, :task_type, :task_description, :due_date, :priority, :assigned_staff)
                ", [
                    ':assigned_to' => $assigned_to,
                    ':task_type' => $task_type,
                    ':task_description' => $task_description,
                    ':due_date' => $due_date,
                    ':priority' => $priority,
                    ':assigned_staff' => $assigned_staff
                ]);

                $_SESSION['success'][] = 'Task assigned successfully!';

            } catch (PDOException $e) {
                $_SESSION['error'][] = 'Database error: ' . $e->getMessage();
            }
        }
    }

    // Redirect back
    header('Location: /main?tab=learning');
    exit;
}