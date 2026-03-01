<?php

use Core\Database;

// Turn off error display and turn on error logging
ini_set('display_errors', 0);
ini_set('log_errors', 1);
error_reporting(E_ALL);

// Clear any output buffers
while (ob_get_level()) {
    ob_end_clean();
}

// Set JSON header
header('Content-Type: application/json');

require base_path('core/middleware/employeeAuth.php');

$config = require base_path('config/config.php');
$db = new Database($config['database']);

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit();
}

// Get JSON input
$input = json_decode(file_get_contents('php://input'), true);

// Check if JSON is valid
if (json_last_error() !== JSON_ERROR_NONE) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid JSON input']);
    exit();
}

// Validate CSRF token
if (
    !isset($input['csrf_token']) ||
    !isset($_SESSION['csrf_token']) ||
    $input['csrf_token'] !== $_SESSION['csrf_token']
) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Invalid CSRF token']);
    exit();
}

// Get action and attendance_id from request
$action = $input['action'] ?? '';
$attendanceId = $input['attendance_id'] ?? null;

// Get employee ID from session
$employeeData = $_SESSION['employee']['employee_record_id'] ?? null;
if (is_array($employeeData) && isset($employeeData['id'])) {
    $employeeId = $employeeData['id'];
} else {
    $employeeId = $employeeData;
}

if (!$employeeId) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Employee not authenticated']);
    exit();
}

// Get employee's shift information
$employeeShift = $db->query("
    SELECT s.*, e.shift_id 
    FROM employees e
    LEFT JOIN shifts s ON e.shift_id = s.id
    WHERE e.id = ?
", [$employeeId])->fetch_one();

$today = date('Y-m-d');
$now = date('Y-m-d H:i:s');
$currentTime = date('H:i:s');

try {
    $db->beginTransaction();

    switch ($action) {
        case 'clock_in':
            // Check if already clocked in today
            $existing = $db->query(
                "SELECT id FROM attendance 
                 WHERE employee_id = ? AND date = ? AND status != 'clocked_out'",
                [$employeeId, $today]
            )->fetch_one();

            if ($existing) {
                throw new Exception('You are already clocked in');
            }

            // Calculate late minutes based on shift
            $lateMinutes = 0;
            $lateStatus = 'on_time';

            if ($employeeShift && $employeeShift['start_time']) {
                $shiftStart = strtotime($today . ' ' . $employeeShift['start_time']);
                $clockInTime = strtotime($now);
                $gracePeriod = $employeeShift['grace_period_minutes'] ?? 15;

                $lateMinutes = max(0, floor(($clockInTime - $shiftStart) / 60));

                if ($lateMinutes > $gracePeriod) {
                    $lateStatus = 'late';
                } elseif ($lateMinutes > 0) {
                    $lateStatus = 'grace_period';
                }
            }

            // Create new attendance record
            $db->query(
                "INSERT INTO attendance (
                    employee_id, shift_id, clock_in, status, date, 
                    late_minutes, late_status, created_at
                ) VALUES (?, ?, ?, 'clocked_in', ?, ?, ?, NOW())",
                [
                    $employeeId,
                    $employeeShift['shift_id'] ?? null,
                    $now,
                    $today,
                    $lateMinutes,
                    $lateStatus
                ]
            );

            $newAttendanceId = $db->lastInsertId();

            $db->commit();

            echo json_encode([
                'success' => true,
                'message' => $lateMinutes > 0 ? 'Clocked in ' . $lateMinutes . ' minutes late' : 'Clocked in on time',
                'attendance_id' => $newAttendanceId,
                'status' => 'clocked_in',
                'elapsed_seconds' => 0,
                'pause_total' => 0,
                'late_minutes' => $lateMinutes,
                'late_status' => $lateStatus
            ]);
            break;

        case 'pause':
            if (!$attendanceId) {
                throw new Exception('No active attendance record');
            }

            // Verify attendance belongs to employee and is clocked in
            $attendance = $db->query(
                "SELECT id FROM attendance 
                 WHERE id = ? AND employee_id = ? AND status = 'clocked_in'",
                [$attendanceId, $employeeId]
            )->fetch_one();

            if (!$attendance) {
                throw new Exception('Cannot pause - no active shift found');
            }

            // Update to paused status
            $db->query(
                "UPDATE attendance 
                 SET pause_start = ?, status = 'paused', updated_at = NOW() 
                 WHERE id = ? AND employee_id = ?",
                [$now, $attendanceId, $employeeId]
            );

            // Get elapsed time so far
            $currentAttendance = $db->query(
                "SELECT 
                    TIMESTAMPDIFF(SECOND, clock_in, ?) - (pause_total * 60) as elapsed,
                    pause_total
                 FROM attendance 
                 WHERE id = ?",
                [$now, $attendanceId]
            )->fetch_one();

            $db->commit();

            echo json_encode([
                'success' => true,
                'message' => 'Shift paused',
                'status' => 'paused',
                'elapsed_seconds' => $currentAttendance['elapsed'] ?? 0,
                'pause_total' => $currentAttendance['pause_total'] ?? 0,
                'attendance_id' => $attendanceId
            ]);
            break;

        case 'resume':
            if (!$attendanceId) {
                throw new Exception('No active attendance record');
            }

            // Get pause start time
            $attendance = $db->query(
                "SELECT pause_start, pause_total FROM attendance 
                 WHERE id = ? AND employee_id = ? AND status = 'paused'",
                [$attendanceId, $employeeId]
            )->fetch_one();

            if (!$attendance || !$attendance['pause_start']) {
                throw new Exception('Cannot resume - no paused shift found');
            }

            // Calculate pause duration in minutes
            $pauseMinutes = round((strtotime($now) - strtotime($attendance['pause_start'])) / 60);

            // Update record - add pause minutes and set status back to clocked_in
            $db->query(
                "UPDATE attendance 
                 SET pause_total = pause_total + ?, 
                     pause_start = NULL, 
                     status = 'clocked_in',
                     updated_at = NOW()
                 WHERE id = ? AND employee_id = ?",
                [$pauseMinutes, $attendanceId, $employeeId]
            );

            // Get updated elapsed time
            $currentAttendance = $db->query(
                "SELECT 
                    TIMESTAMPDIFF(SECOND, clock_in, ?) - ((pause_total + ?) * 60) as elapsed,
                    pause_total + ? as new_pause_total
                 FROM attendance 
                 WHERE id = ?",
                [$now, $pauseMinutes, $pauseMinutes, $attendanceId]
            )->fetch_one();

            $db->commit();

            echo json_encode([
                'success' => true,
                'message' => 'Shift resumed',
                'status' => 'clocked_in',
                'elapsed_seconds' => $currentAttendance['elapsed'] ?? 0,
                'pause_total' => $currentAttendance['new_pause_total'] ?? 0,
                'attendance_id' => $attendanceId
            ]);
            break;

        case 'clock_out':
            if (!$attendanceId) {
                throw new Exception('No active attendance record');
            }

            // Get attendance record
            $attendance = $db->query(
                "SELECT clock_in, pause_total, late_minutes, shift_id FROM attendance 
                 WHERE id = ? AND employee_id = ? AND status != 'clocked_out'",
                [$attendanceId, $employeeId]
            )->fetch_one();

            if (!$attendance) {
                throw new Exception('No active shift found');
            }

            // Calculate total worked time
            $clockIn = strtotime($attendance['clock_in']);
            $clockOut = strtotime($now);
            $pauseMinutes = $attendance['pause_total'] ?? 0;

            // Total seconds worked (excluding pauses)
            $totalSeconds = $clockOut - $clockIn - ($pauseMinutes * 60);
            $totalHours = $totalSeconds / 3600;

            // Regular hours (max 8) and overtime
            $regularHours = min($totalHours, 8);
            $overtimeHours = max($totalHours - 8, 0);

            // Check if early clock-out (if shift has end time)
            $earlyDeparture = 0;
            if ($attendance['shift_id']) {
                $shift = $db->query("SELECT end_time FROM shifts WHERE id = ?", [$attendance['shift_id']])->fetch_one();
                if ($shift && $shift['end_time']) {
                    $shiftEnd = strtotime($today . ' ' . $shift['end_time']);
                    if ($clockOut < $shiftEnd) {
                        $earlyDeparture = floor(($shiftEnd - $clockOut) / 60);
                    }
                }
            }

            // Update attendance record
            $db->query(
                "UPDATE attendance 
                 SET clock_out = ?,
                     regular_hours = ?,
                     overtime_hours = ?,
                     early_departure_minutes = ?,
                     status = 'clocked_out',
                     updated_at = NOW()
                 WHERE id = ? AND employee_id = ?",
                [$now, $regularHours, $overtimeHours, $earlyDeparture, $attendanceId, $employeeId]
            );

            // Update 15-day summary with late minutes
            updateAttendanceSummary($db, $employeeId, $regularHours, $overtimeHours, $attendance['late_minutes'] ?? 0);

            $db->commit();

            $message = 'Clocked out successfully';
            if ($earlyDeparture > 0) {
                $message .= ' (' . $earlyDeparture . ' minutes early)';
            }

            echo json_encode([
                'success' => true,
                'message' => $message,
                'status' => 'clocked_out',
                'regular_hours' => $regularHours,
                'overtime_hours' => $overtimeHours,
                'early_departure' => $earlyDeparture
            ]);
            break;

        default:
            throw new Exception('Invalid action');
    }

} catch (Exception $e) {
    if ($db->inTransaction()) {
        $db->rollBack();
    }
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
} catch (Error $e) {
    // Catch PHP errors
    if (isset($db) && $db->inTransaction()) {
        $db->rollBack();
    }
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Server error: ' . $e->getMessage()
    ]);
}

/**
 * Update or create attendance summary for periods ending on 5th and 20th of each month
 */
function updateAttendanceSummary($db, $employeeId, $regularHours, $overtimeHours, $lateMinutes = 0)
{
    $today = date('Y-m-d');
    $currentDay = (int) date('j');
    $currentMonth = date('m');
    $currentYear = date('Y');

    // Determine which pay period this belongs to (5th or 20th)
    if ($currentDay <= 5) {
        // Period from 21st of previous month to 5th of current month
        $periodEnd = "$currentYear-$currentMonth-05";
        $periodStart = date('Y-m-d', strtotime('first day of previous month')) . '-21';

        // Adjust for January
        if ($currentMonth == '01') {
            $periodStart = ($currentYear - 1) . '-12-21';
        }
    } elseif ($currentDay <= 20) {
        // Period from 6th to 20th of current month
        $periodStart = "$currentYear-$currentMonth-06";
        $periodEnd = "$currentYear-$currentMonth-20";
    } else {
        // Period from 21st to end of month
        $nextMonth = $currentMonth + 1;
        $nextYear = $currentYear;
        if ($nextMonth > 12) {
            $nextMonth = 1;
            $nextYear++;
        }
        $periodEnd = "$nextYear-" . str_pad($nextMonth, 2, '0', STR_PAD_LEFT) . "-05";
        $periodStart = "$currentYear-$currentMonth-21";
    }

    if (!isset($periodStart) || !isset($periodEnd)) {
        error_log("Could not determine period for date: $today");
        return;
    }

    // Check if summary exists for this period
    $summary = $db->query(
        "SELECT id, total_regular_hours, total_overtime_hours, total_late_minutes 
         FROM attendance_summary 
         WHERE employee_id = ? AND period_start = ? AND period_end = ?",
        [$employeeId, $periodStart, $periodEnd]
    )->fetch_one();

    if ($summary) {
        // Update existing summary
        $db->query(
            "UPDATE attendance_summary 
             SET total_regular_hours = total_regular_hours + ?,
                 total_overtime_hours = total_overtime_hours + ?,
                 total_late_minutes = total_late_minutes + ?,
                 updated_at = NOW()
             WHERE id = ?",
            [$regularHours, $overtimeHours, $lateMinutes, $summary['id']]
        );
        error_log("Updated summary ID {$summary['id']}: +{$regularHours} reg, +{$overtimeHours} OT, +{$lateMinutes} late");
    } else {
        // Create new summary
        $db->query(
            "INSERT INTO attendance_summary 
             (employee_id, period_start, period_end, total_regular_hours, total_overtime_hours, total_late_minutes, created_at, updated_at)
             VALUES (?, ?, ?, ?, ?, ?, NOW(), NOW())",
            [$employeeId, $periodStart, $periodEnd, $regularHours, $overtimeHours, $lateMinutes]
        );
        $newId = $db->lastInsertId();
        error_log("Created new summary ID $newId for period $periodStart to $periodEnd");
    }
}