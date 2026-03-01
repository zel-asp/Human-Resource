<?php

use Core\Database;

require base_path('core/middleware/employeeAuth.php');

$config = require base_path('config/config.php');
$db = new Database($config['database']);

$employeeData = $_SESSION['employee']['employee_record_id'] ?? null;

if (is_array($employeeData) && isset($employeeData['id'])) {
    $employeeId = $employeeData['id'];
} else {
    $employeeId = $employeeData;
}

if (!$employeeId) {
    error_log('no employee id found in session');
    $_SESSION['error'][] = "employee not found";
    header('Location: /login');
    exit();
}

$employeeInfo = $db->query("
    SELECT 
        e.*,
        a.full_name as applicant_name,
        a.email as applicant_email,
        a.phone as applicant_phone,
        a.position as applied_position,
        a.experience,
        a.education,
        a.skills,
        a.status as applicant_status,
        a.hired_date,
        a.start_date,
        a.resume_path,
        a.created_at as applicant_created_at
    FROM employees e
    LEFT JOIN applicants a ON e.applicant_id = a.id
    WHERE e.id = ?
", [$employeeId])->fetch_one();

// Debug: Check what's returned
error_log('Employee Info: ' . print_r($employeeInfo, true));

if (!$employeeInfo) {
    error_log('No employee found with ID: ' . $employeeId);

    // Debug: Check what employees exist
    $allEmployees = $db->query("SELECT id, applicant_id, full_name FROM employees")->find();
    error_log('All employees: ' . print_r($allEmployees, true));

    $_SESSION['error'][] = "Employee information not found";
    header('Location: /login');
    exit();
}

// FIXED: Get employee account information
// First get the applicant_id from the employee
$applicantId = $employeeInfo['applicant_id'] ?? null;

if ($applicantId) {
    $employeeAccount = $db->query("
        SELECT 
            ea.*
        FROM employee_accounts ea
        WHERE ea.applicant_id = ?
    ", [$applicantId])->fetch_one();
} else {
    $employeeAccount = null;
    error_log('No applicant_id found for employee ID: ' . $employeeId);
}

// If no account found, try alternative query using employee_id from session
if (!$employeeAccount) {
    // Try to find by employee_id string (EMP-XXX format)
    $employeeAccount = $db->query("
        SELECT 
            ea.*
        FROM employee_accounts ea
        WHERE ea.employee_id = ?
    ", [$employeeInfo['employee_number'] ?? ''])->fetch_one();
}

// Handle case when no account found
if (!$employeeAccount) {
    $employeeAccount = []; // Set to empty array to avoid errors
    error_log('No account found for employee ID: ' . $employeeId . ' with applicant_id: ' . ($applicantId ?? 'null'));
}

// Get employee benefits if any
$employeeBenefits = $db->query("
    SELECT 
        eb.*,
        bp.provider_name,
        bp.contact_info as provider_contact
    FROM employee_benefits eb
    LEFT JOIN benefit_providers bp ON eb.provider_id = bp.id
    WHERE eb.employee_id = ?
", [$employeeId])->find();

if (!$employeeBenefits) {
    $employeeBenefits = [];
}

// For initial tasks (limited to 5)
$limitedTasks = $db->query("
    SELECT 
        t.id,
        t.task_type,
        t.task_description,
        t.due_date,
        t.priority,
        t.assigned_staff,
        t.status,
        e.full_name as employee_name
    FROM tasks t
    INNER JOIN employees e ON t.assigned_to = e.id
    WHERE t.assigned_to = ?
    ORDER BY 
        CASE t.status
            WHEN 'Not Started' THEN 1
            WHEN 'Ongoing' THEN 2
            WHEN 'Completed' THEN 3
        END,
        CASE t.priority
            WHEN 'urgent' THEN 1
            WHEN 'high' THEN 2
            WHEN 'medium' THEN 3
            WHEN 'low' THEN 4
        END,
        t.due_date ASC
    LIMIT 5
", [$employeeId])->find();

if (!$limitedTasks) {
    $limitedTasks = [];
}

// For all tasks
$allTasks = $db->query("
    SELECT 
        t.id,
        t.task_type,
        t.task_description,
        t.due_date,
        t.priority,
        t.assigned_staff,
        t.status,
        e.full_name as employee_name
    FROM tasks t
    INNER JOIN employees e ON t.assigned_to = e.id
    WHERE t.assigned_to = ?
    ORDER BY 
        CASE t.status
            WHEN 'Not Started' THEN 1
            WHEN 'Ongoing' THEN 2
            WHEN 'Completed' THEN 3
        END,
        CASE t.priority
            WHEN 'urgent' THEN 1
            WHEN 'high' THEN 2
            WHEN 'medium' THEN 3
            WHEN 'low' THEN 4
        END,
        t.due_date ASC
", [$employeeId])->find();

if (!$allTasks) {
    $allTasks = [];
}

// Get task statistics
$taskStats = $db->query("
    SELECT 
        COUNT(*) as total_tasks,
        SUM(CASE WHEN status = 'Not Started' THEN 1 ELSE 0 END) as not_started_count,
        SUM(CASE WHEN status = 'Ongoing' THEN 1 ELSE 0 END) as ongoing_count,
        SUM(CASE WHEN status = 'Completed' THEN 1 ELSE 0 END) as completed_count,
        SUM(CASE WHEN priority = 'urgent' AND status != 'Completed' THEN 1 ELSE 0 END) as urgent_count
    FROM tasks
    WHERE assigned_to = ?
", [$employeeId])->fetch_one();

if (!$taskStats) {
    $taskStats = [
        'total_tasks' => 0,
        'not_started_count' => 0,
        'ongoing_count' => 0,
        'completed_count' => 0,
        'urgent_count' => 0
    ];
}

// Get upcoming tasks (due soon)
$upcomingTasks = $db->query("
    SELECT 
        t.id,
        t.task_description,
        t.due_date,
        t.priority,
        t.status
    FROM tasks t
    WHERE t.assigned_to = ? 
        AND t.status != 'Completed' 
        AND t.due_date BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 7 DAY)
    ORDER BY t.due_date ASC
", [$employeeId])->find();

if (!$upcomingTasks) {
    $upcomingTasks = [];
}

// ADDED: Get leave requests based on employee_record_id

// Get recent leave requests (for dashboard display - limited to 5)
$recentLeaveRequests = $db->query("
    SELECT 
        lr.*,
        e.full_name as employee_name,
        e.employee_number,
        DATEDIFF(lr.end_date, lr.start_date) + 1 as calculated_days
    FROM leave_requests lr
    INNER JOIN employees e ON lr.employee_id = e.id
    WHERE lr.employee_id = ?
    ORDER BY 
        CASE lr.status
            WHEN 'Pending' THEN 1
            WHEN 'Approved' THEN 2
            WHEN 'Rejected' THEN 3
            WHEN 'Cancelled' THEN 4
        END,
        lr.created_at DESC
    LIMIT 5
", [$employeeId])->find();

if (!$recentLeaveRequests) {
    $recentLeaveRequests = [];
}

// Get all leave requests (for "View All" modal)
$allLeaveRequests = $db->query("
    SELECT 
        lr.*,
        e.full_name as employee_name,
        e.employee_number,
        DATEDIFF(lr.end_date, lr.start_date) + 1 as calculated_days
    FROM leave_requests lr
    INNER JOIN employees e ON lr.employee_id = e.id
    WHERE lr.employee_id = ?
    ORDER BY 
        CASE lr.status
            WHEN 'Pending' THEN 1
            WHEN 'Approved' THEN 2
            WHEN 'Rejected' THEN 3
            WHEN 'Cancelled' THEN 4
        END,
        lr.created_at DESC
", [$employeeId])->find();

if (!$allLeaveRequests) {
    $allLeaveRequests = [];
}

// Get leave request statistics
$leaveStats = $db->query("
    SELECT 
        COUNT(*) as total_requests,
        SUM(CASE WHEN status = 'Pending' THEN 1 ELSE 0 END) as pending_count,
        SUM(CASE WHEN status = 'Approved' THEN 1 ELSE 0 END) as approved_count,
        SUM(CASE WHEN status = 'Rejected' THEN 1 ELSE 0 END) as rejected_count,
        SUM(CASE WHEN status = 'Cancelled' THEN 1 ELSE 0 END) as cancelled_count,
        SUM(CASE WHEN leave_type = 'Annual Leave' AND status = 'Approved' THEN total_days ELSE 0 END) as annual_leave_used,
        SUM(CASE WHEN leave_type = 'Sick Leave' AND status = 'Approved' THEN total_days ELSE 0 END) as sick_leave_used
    FROM leave_requests
    WHERE employee_id = ?
", [$employeeId])->fetch_one();

if (!$leaveStats) {
    $leaveStats = [
        'total_requests' => 0,
        'pending_count' => 0,
        'approved_count' => 0,
        'rejected_count' => 0,
        'cancelled_count' => 0,
        'annual_leave_used' => 0,
        'sick_leave_used' => 0
    ];
}

$annualLeaveTotal = 18;
$sickLeaveTotal = 12;

$leaveBalances = [
    'annual' => [
        'total' => $annualLeaveTotal,
        'used' => (int) ($leaveStats['annual_leave_used'] ?? 0),
        'remaining' => $annualLeaveTotal - (int) ($leaveStats['annual_leave_used'] ?? 0)
    ],
    'sick' => [
        'total' => $sickLeaveTotal,
        'used' => (int) ($leaveStats['sick_leave_used'] ?? 0),
        'remaining' => $sickLeaveTotal - (int) ($leaveStats['sick_leave_used'] ?? 0)
    ]
];



// ATTENDANCE QUERIES

// Get current date info
$today = date('Y-m-d');
$currentMonth = date('Y-m');
$currentMonthName = date('F Y');
$currentDay = (int) date('j');

// Get employee's shift information
$employeeShift = $db->query("
    SELECT s.*, e.shift_id 
    FROM employees e
    LEFT JOIN shifts s ON e.shift_id = s.id
    WHERE e.id = ?
", [$employeeId])->fetch_one();

// Get current attendance status
$currentAttendance = $db->query("
    SELECT * FROM attendance 
    WHERE employee_id = ? AND date = ? AND status != 'clocked_out' 
    ORDER BY id DESC LIMIT 1
", [$employeeId, $today])->fetch_one();

$attendanceStatus = 'clocked_out';
$elapsedSeconds = 0;
$pauseTotal = 0;

if ($currentAttendance) {
    $attendanceStatus = $currentAttendance['status'];

    if ($attendanceStatus == 'clocked_in') {
        $elapsedSeconds = time() - strtotime($currentAttendance['clock_in']) - ($currentAttendance['pause_total'] * 60);
    } elseif ($attendanceStatus == 'paused') {
        $elapsedSeconds = strtotime($currentAttendance['pause_start']) - strtotime($currentAttendance['clock_in']) - ($currentAttendance['pause_total'] * 60);
    }

    $pauseTotal = $currentAttendance['pause_total'] ?? 0;
}

$showClockIn = ($attendanceStatus == 'clocked_out');

// Get current pay period
if ($currentDay <= 5) {
    $periodStart = date('Y-m-d', strtotime('first day of previous month')) . '-21';
    $periodEnd = date('Y-m-05');
    $periodName = 'Pay Period: 21st - 5th';
} elseif ($currentDay <= 20) {
    $periodStart = date('Y-m-06');
    $periodEnd = date('Y-m-20');
    $periodName = 'Pay Period: 6th - 20th';
} else {
    $periodStart = date('Y-m-21');
    $periodEnd = date('Y-m-t');
    $periodName = 'Pay Period: 21st - ' . date('t') . 'th';
}

// Get current period summary
$currentPeriod = $db->query("
    SELECT 
        COALESCE(total_regular_hours, 0) as regular_hours,
        COALESCE(total_overtime_hours, 0) as overtime_hours,
        COALESCE(total_late_minutes, 0) as late_minutes
    FROM attendance_summary 
    WHERE employee_id = ? AND period_start = ? AND period_end = ?
", [$employeeId, $periodStart, $periodEnd])->fetch_one();

if (!$currentPeriod) {
    $currentPeriod = ['regular_hours' => 0, 'overtime_hours' => 0, 'late_minutes' => 0];
}

// Get this week's attendance
$weekStart = date('Y-m-d', strtotime('monday this week'));
$weekEnd = date('Y-m-d', strtotime('sunday this week'));

$weekStats = $db->query("
    SELECT 
        COALESCE(SUM(regular_hours), 0) as week_regular,
        COALESCE(SUM(overtime_hours), 0) as week_overtime,
        COUNT(CASE WHEN clock_in IS NOT NULL THEN 1 END) as days_worked,
        COALESCE(SUM(late_minutes), 0) as total_late_minutes
    FROM attendance 
    WHERE employee_id = ? AND date BETWEEN ? AND ? AND status = 'clocked_out'
", [$employeeId, $weekStart, $weekEnd])->fetch_one();

if (!$weekStats) {
    $weekStats = ['week_regular' => 0, 'week_overtime' => 0, 'days_worked' => 0, 'total_late_minutes' => 0];
}

// Get this month's attendance
$monthStart = date('Y-m-01');
$monthEnd = date('Y-m-t');

$monthStats = $db->query("
    SELECT 
        COALESCE(SUM(regular_hours), 0) as month_regular,
        COALESCE(SUM(overtime_hours), 0) as month_overtime,
        COUNT(CASE WHEN clock_in IS NOT NULL THEN 1 END) as days_worked,
        COALESCE(SUM(late_minutes), 0) as total_late_minutes,
        SUM(CASE WHEN late_status = 'late' THEN 1 ELSE 0 END) as late_days,
        SUM(CASE WHEN late_status = 'grace_period' THEN 1 ELSE 0 END) as grace_days,
        SUM(CASE WHEN early_departure_minutes > 0 THEN 1 ELSE 0 END) as early_departure_days,
        COALESCE(SUM(early_departure_minutes), 0) as total_early_minutes
    FROM attendance 
    WHERE employee_id = ? AND date BETWEEN ? AND ? AND status = 'clocked_out'
", [$employeeId, $monthStart, $monthEnd])->fetch_one();

if (!$monthStats) {
    $monthStats = [
        'month_regular' => 0,
        'month_overtime' => 0,
        'days_worked' => 0,
        'total_late_minutes' => 0,
        'late_days' => 0,
        'grace_days' => 0,
        'early_departure_days' => 0,
        'total_early_minutes' => 0
    ];
}

// Calculate expected work days (weekdays only)
$expectedWorkDays = 0;
$currentDate = strtotime($monthStart);
$endDate = strtotime($monthEnd);
while ($currentDate <= $endDate) {
    $dayOfWeek = date('N', $currentDate);
    if ($dayOfWeek < 6) { // Monday to Friday
        $expectedWorkDays++;
    }
    $currentDate = strtotime('+1 day', $currentDate);
}

$absences = max(0, $expectedWorkDays - $monthStats['days_worked']);

// Get recent attendance records
$recentAttendance = $db->query("
    SELECT 
        date, 
        clock_in, 
        clock_out, 
        regular_hours, 
        overtime_hours,
        late_minutes,
        late_status,
        early_departure_minutes,
        TIME_FORMAT(clock_in, '%h:%i %p') as clock_in_formatted,
        TIME_FORMAT(clock_out, '%h:%i %p') as clock_out_formatted
    FROM attendance 
    WHERE employee_id = ? AND status = 'clocked_out'
    ORDER BY date DESC
    LIMIT 10
", [$employeeId])->find();

if (!$recentAttendance) {
    $recentAttendance = [];
}

// Get daily breakdown for the month
$dailyBreakdown = $db->query("
    SELECT 
        date,
        DAYNAME(date) as day_name,
        regular_hours,
        overtime_hours,
        late_minutes,
        late_status,
        early_departure_minutes,
        TIME_FORMAT(clock_in, '%h:%i %p') as clock_in_time,
        TIME_FORMAT(clock_out, '%h:%i %p') as clock_out_time
    FROM attendance 
    WHERE employee_id = ? AND date BETWEEN ? AND ? AND status = 'clocked_out'
    ORDER BY date DESC
", [$employeeId, $monthStart, $monthEnd])->find();

if (!$dailyBreakdown) {
    $dailyBreakdown = [];
}

// Calculate totals for display
$weekTotal = $weekStats['week_regular'] + $weekStats['week_overtime'];
$monthTotal = $monthStats['month_regular'] + $monthStats['month_overtime'];

// Helper function to format hours and minutes
function formatHoursMinutes($decimalHours)
{
    $hours = floor($decimalHours);
    $minutes = round(($decimalHours - $hours) * 60);
    return $hours . 'h ' . str_pad($minutes, 2, '0', STR_PAD_LEFT) . 'm';
}

// Helper function to format minutes
function formatMinutes($minutes)
{
    $h = floor($minutes / 60);
    $m = $minutes % 60;
    if ($h > 0) {
        return $h . 'h ' . $m . 'm';
    }
    return $m . 'm';
}

// ALL-TIME ATTENDANCE STATISTICS

// Get all-time attendance statistics
$allTimeStats = $db->query("
    SELECT 
        COUNT(DISTINCT date) as total_days_worked,
        COALESCE(SUM(regular_hours), 0) as total_regular_hours,
        COALESCE(SUM(overtime_hours), 0) as total_overtime_hours,
        COALESCE(SUM(late_minutes), 0) as total_late_minutes,
        SUM(CASE WHEN late_status = 'late' THEN 1 ELSE 0 END) as total_late_days,
        SUM(CASE WHEN late_status = 'grace_period' THEN 1 ELSE 0 END) as total_grace_days,
        SUM(CASE WHEN early_departure_minutes > 0 THEN 1 ELSE 0 END) as total_early_days,
        COALESCE(SUM(early_departure_minutes), 0) as total_early_minutes,
        MIN(date) as first_work_date,
        MAX(date) as last_work_date
    FROM attendance 
    WHERE employee_id = ? AND status = 'clocked_out'
", [$employeeId])->fetch_one();

if (!$allTimeStats) {
    $allTimeStats = [
        'total_days_worked' => 0,
        'total_regular_hours' => 0,
        'total_overtime_hours' => 0,
        'total_late_minutes' => 0,
        'total_late_days' => 0,
        'total_grace_days' => 0,
        'total_early_days' => 0,
        'total_early_minutes' => 0,
        'first_work_date' => null,
        'last_work_date' => null
    ];
}

// Get attendance by month (for chart/trends)
$attendanceByMonth = $db->query("
    SELECT 
        DATE_FORMAT(date, '%Y-%m') as month,
        DATE_FORMAT(date, '%M %Y') as month_name,
        COUNT(*) as days_worked,
        COALESCE(SUM(regular_hours), 0) as total_regular,
        COALESCE(SUM(overtime_hours), 0) as total_overtime,
        COALESCE(SUM(late_minutes), 0) as total_late,
        SUM(CASE WHEN late_status = 'late' THEN 1 ELSE 0 END) as late_days
    FROM attendance 
    WHERE employee_id = ? AND status = 'clocked_out'
    GROUP BY DATE_FORMAT(date, '%Y-%m')
    ORDER BY month DESC
    LIMIT 12
", [$employeeId])->find();

if (!$attendanceByMonth) {
    $attendanceByMonth = [];
}

// Get all attendance records (paginated) - FIXED VERSION
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$perPage = 3;
$offset = ($page - 1) * $perPage;

// Ensure they are integers
$perPage = (int) $perPage;
$offset = (int) $offset;

$totalRecords = $db->query("
    SELECT COUNT(*) as count 
    FROM attendance 
    WHERE employee_id = ? AND status = 'clocked_out'
", [$employeeId])->fetch_one();

$totalPages = ceil($totalRecords['count'] / $perPage);

// FIX: Use the integer values directly in the query
$allAttendanceRecords = $db->query("
    SELECT 
        id,
        date,
        DAYNAME(date) as day_name,
        DATE_FORMAT(clock_in, '%h:%i %p') as clock_in_time,
        DATE_FORMAT(clock_out, '%h:%i %p') as clock_out_time,
        regular_hours,
        overtime_hours,
        late_minutes,
        late_status,
        early_departure_minutes,
        TIMEDIFF(clock_out, clock_in) as total_duration,
        created_at
    FROM attendance 
    WHERE employee_id = ? AND status = 'clocked_out'
    ORDER BY date DESC
    LIMIT $perPage OFFSET $offset
", [$employeeId])->find();

if (!$allAttendanceRecords) {
    $allAttendanceRecords = [];
}

// Calculate attendance rate
$earliestDate = $allTimeStats['first_work_date'] ? strtotime($allTimeStats['first_work_date']) : time();
$daysSince = ceil((time() - $earliestDate) / (60 * 60 * 24));
$workingDaysSince = 0;

// Count working days since first work date (approximate)
$tempDate = $earliestDate;
while ($tempDate <= time()) {
    $dayOfWeek = date('N', $tempDate);
    if ($dayOfWeek < 6) { // Monday to Friday
        $workingDaysSince++;
    }
    $tempDate = strtotime('+1 day', $tempDate);
}

$attendanceRate = $workingDaysSince > 0
    ? round(($allTimeStats['total_days_worked'] / $workingDaysSince) * 100, 1)
    : 0;


// Add all variables to view
view_path('ess', 'index', [
    'tasks' => $limitedTasks,
    'allTasks' => $allTasks,
    'employeeInfo' => $employeeInfo,
    'employeeAccount' => $employeeAccount,
    'employeeBenefits' => $employeeBenefits,
    'taskStats' => $taskStats,
    'upcomingTasks' => $upcomingTasks,
    'recentLeaveRequests' => $recentLeaveRequests,
    'allLeaveRequests' => $allLeaveRequests,
    'leaveStats' => $leaveStats,
    'leaveBalances' => $leaveBalances,
    // Attendance variables
    'attendanceStatus' => $attendanceStatus,
    'elapsedSeconds' => $elapsedSeconds,
    'pauseTotal' => $pauseTotal,
    'showClockIn' => $showClockIn,
    'currentAttendance' => $currentAttendance,
    'employeeShift' => $employeeShift,
    'periodName' => $periodName,
    'currentPeriod' => $currentPeriod,
    'weekStats' => $weekStats,
    'monthStats' => $monthStats,
    'absences' => $absences,
    'weekTotal' => $weekTotal,
    'monthTotal' => $monthTotal,
    'currentMonthName' => $currentMonthName,
    'recentAttendance' => $recentAttendance,
    'dailyBreakdown' => $dailyBreakdown,
    'expectedWorkDays' => $expectedWorkDays,
    'formatHoursMinutes' => 'formatHoursMinutes',
    'formatMinutes' => 'formatMinutes',

    'allTimeStats' => $allTimeStats,
    'attendanceByMonth' => $attendanceByMonth,
    'allAttendanceRecords' => $allAttendanceRecords,
    'totalPages' => $totalPages,
    'currentPage' => $page,
    'attendanceRate' => $attendanceRate,
    'workingDaysSince' => $workingDaysSince
]);