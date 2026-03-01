<?php

use Core\Database;

require base_path('core/middleware/employeeAuth.php');

$config = require base_path('config/config.php');
$db = new Database($config['database']);

// ========================
// ONLY ALLOW POST
// ========================
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['error'][] = "Invalid request method.";
    header('Location: /');
    exit();
}

// ========================
// CSRF CHECK
// ========================
if (
    !isset($_POST['csrf_token']) ||
    !isset($_SESSION['csrf_token']) ||
    $_POST['csrf_token'] !== $_SESSION['csrf_token']
) {
    $_SESSION['error'][] = "Invalid CSRF token. Please try again.";
    header('Location: /login');
    exit();
}

// ========================
// GET EMPLOYEE ID FROM SESSION
// ========================
// Get the employee_record_id from session (this is employees.id)
$employeeRecordId = $_POST['employee_record_id'] ?? $_SESSION['employee']['employee_record_id'] ?? null;

if (!$employeeRecordId) {
    // Fallback: try to get from employeeApplicantId
    $employeeData = $_SESSION['employee']['employeeApplicantId'] ?? null;

    if (is_array($employeeData) && isset($employeeData['id'])) {
        $employeeRecordId = $employeeData['id'];
    } else {
        $employeeRecordId = $employeeData;
    }
}

if (!$employeeRecordId) {
    $_SESSION['error'][] = "Employee not found. Please login again.";
    header('Location: /login');
    exit();
}

// Verify employee exists in database
$employee = $db->query(
    "SELECT id, employee_number, full_name, email FROM employees WHERE id = ?",
    [$employeeRecordId]
)->fetch_one();

if (!$employee) {
    $_SESSION['error'][] = "Employee record not found.";
    header('Location: /');
    exit();
}

// ========================
// VALIDATE FORM INPUTS
// ========================
$leaveType = $_POST['leave_type'] ?? '';
$startDate = $_POST['start_date'] ?? '';
$endDate = $_POST['end_date'] ?? '';
$reason = trim($_POST['reason'] ?? '');

// Validate leave type
$validLeaveTypes = ['Annual Leave', 'Sick Leave', 'Personal Day', 'Remote Work'];
if (!in_array($leaveType, $validLeaveTypes)) {
    $_SESSION['error'][] = "Invalid leave type selected.";
    header('Location: /');
    exit();
}

// Validate dates
if (empty($startDate) || empty($endDate)) {
    $_SESSION['error'][] = "Start date and end date are required.";
    header('Location: /');
    exit();
}

$startTimestamp = strtotime($startDate);
$endTimestamp = strtotime($endDate);

if ($startTimestamp === false || $endTimestamp === false) {
    $_SESSION['error'][] = "Invalid date format.";
    header('Location: /');
    exit();
}

if ($endTimestamp < $startTimestamp) {
    $_SESSION['error'][] = "End date cannot be before start date.";
    header('Location: /');
    exit();
}

// Calculate total days (excluding weekends? adjust as needed)
$totalDays = 0;
$current = $startTimestamp;
while ($current <= $endTimestamp) {
    // Optional: Skip weekends (Saturday and Sunday)
    // $dayOfWeek = date('N', $current);
    // if ($dayOfWeek < 6) { // 1-5 are Monday-Friday
    //     $totalDays++;
    // }
    $totalDays++;
    $current = strtotime('+1 day', $current);
}

if ($totalDays <= 0) {
    $_SESSION['error'][] = "Invalid date range.";
    header('Location: /');
    exit();
}

// ========================
// INSERT LEAVE REQUEST
// ========================
try {
    $db->beginTransaction();

    // Insert the leave request
    $db->query(
        "INSERT INTO leave_requests (
            employee_id, 
            leave_type, 
            start_date, 
            end_date, 
            total_days, 
            reason, 
            status, 
            created_at
        ) VALUES (?, ?, ?, ?, ?, ?, 'Pending', NOW())",
        [
            $employeeRecordId,  // This is employees.id
            $leaveType,
            $startDate,
            $endDate,
            $totalDays,
            $reason
        ]
    );

    $leaveRequestId = $db->lastInsertId();

    // Optional: Log the action
    error_log("Leave request #{$leaveRequestId} created for employee #{$employeeRecordId} ({$employee['full_name']})");

    $db->commit();

    $_SESSION['success'][] = "Leave request submitted successfully!";

} catch (Exception $e) {
    $db->rollBack();
    error_log("Error submitting leave request: " . $e->getMessage());
    $_SESSION['error'][] = "An error occurred while submitting your request. Please try again.";
}

// ========================
// REDIRECT BACK
// ========================
header('Location: /?tab=requests');
exit();