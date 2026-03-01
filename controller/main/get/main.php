<?php

use Core\Database;

$config = require base_path('config/config.php');
$db = new Database($config['database']);


try {
    $jobPostings = $db->query(
        "SELECT id, position, department, location, shift, salary, created_at 
        FROM job_postings ORDER BY created_at DESC"
    )->find();
} catch (\Throwable $th) {
    $jobPostings = [];
    error_log($th->getMessage());
}

try {
    $allApplicants = $db->query(
        "SELECT id, full_name, email, phone, position, experience, education, skills, resume_path, cover_note, status, hired_date, start_date, created_at 
        FROM applicants ORDER BY created_at DESC"
    )->find();
} catch (\Throwable $th) {
    $allApplicants = [];
    error_log($th->getMessage());
}

try {
    $recentApplicants = $db->query(
        "SELECT id, full_name, email, phone, position, experience, education, skills, resume_path, cover_note, status, created_at 
        FROM applicants ORDER BY created_at DESC LIMIT 5"
    )->find();
} catch (\Throwable $th) {
    $recentApplicants = [];
    error_log($th->getMessage());
}

try {
    $hiredEmployees = $db->query(
        "SELECT id, employee_number, full_name, position, department, hired_date, start_date
        FROM employees
        ORDER BY hired_date DESC"
    )->find();
} catch (\Throwable $th) {
    $hiredEmployees = [];
    error_log($th->getMessage());
}

// Get tasks with applicant details
try {
    $tasks = $db->query(
        "SELECT t.*, e.full_name, e.position, e.start_date, e.hired_date 
        FROM tasks t 
        JOIN employees e ON t.assigned_to = e.id
        ORDER BY 
            CASE 
                WHEN t.due_date < CURDATE() AND t.status != 'Completed' THEN 1
                WHEN t.status = 'Not Started' THEN 2
                WHEN t.status = 'Ongoing' THEN 3
                WHEN t.status = 'Completed' THEN 4
            END,
            t.due_date ASC"
    )->find();
} catch (\Throwable $th) {
    $tasks = [];
    error_log($th->getMessage());
}

// Onboarding Pagination
$obPage = isset($_GET['ob_page']) ? max(1, (int) $_GET['ob_page']) : 1;
$obPerPage = 5;
$obOffset = ($obPage - 1) * $obPerPage;

// Total onboarding employees
try {
    $totalOnboardingCount = $db->query(
        "SELECT COUNT(*) as count FROM employees"
    )->fetch_one()['count'] ?? 0;
} catch (\Throwable $th) {
    $totalOnboardingCount = 0;
}

// Paginated onboarding data
try {
    $onboardingTasks = $db->query(
        "SELECT 
            e.id AS employee_id,
            e.employee_number,
            e.full_name,
            e.position,
            e.department,
            e.hired_date,
            e.start_date,
            e.onboarding_status,
            COUNT(t.id) AS total_tasks,
            SUM(CASE WHEN t.status = 'Completed' THEN 1 ELSE 0 END) AS completed_tasks
        FROM employees e
        LEFT JOIN tasks t ON e.id = t.assigned_to
        GROUP BY e.id
        ORDER BY e.hired_date DESC
        LIMIT $obPerPage OFFSET $obOffset"
    )->find();
} catch (\Throwable $th) {
    $onboardingTasks = [];
}

$totalOnboardingPages = ceil($totalOnboardingCount / $obPerPage);

// Get tasks with status for each applicant
try {
    $applicantTasks = $db->query(
        "SELECT 
            t.*,
            e.full_name,
            e.position,
            DATEDIFF(t.due_date, CURDATE()) as days_difference,
            CASE 
                WHEN t.status = 'Completed' THEN 'completed'
                WHEN t.due_date < CURDATE() AND t.status != 'Completed' THEN 'overdue'
                WHEN t.status = 'Ongoing' THEN 'ongoing'
                ELSE 'not_started'
            END as task_status_display,
            CASE 
                WHEN t.due_date < CURDATE() AND t.status != 'Completed' THEN 1
                WHEN t.due_date = CURDATE() AND t.status != 'Completed' THEN 2
                WHEN t.due_date > CURDATE() AND t.due_date <= DATE_ADD(CURDATE(), INTERVAL 3 DAY) AND t.status != 'Completed' THEN 3
                ELSE 4
            END as urgency
        FROM tasks t
        JOIN employees e ON t.assigned_to = e.id
        ORDER BY urgency ASC, t.due_date ASC"
    )->find();
} catch (\Throwable $th) {
    $applicantTasks = [];
    error_log($th->getMessage());
}

// Get unique departments for onboarding filter
try {
    $departments = $db->query(
        "SELECT DISTINCT department
        FROM employees
        WHERE department IS NOT NULL
        AND department != ''
        ORDER BY department"
    )->find();
} catch (\Throwable $th) {
    $departments = [];
    error_log($th->getMessage());
}

try {
    $staffMembers = $db->query(
        "SELECT DISTINCT assigned_staff 
        FROM tasks 
        WHERE assigned_staff IS NOT NULL AND assigned_staff != ''
        UNION
        SELECT 'Sarah Reyes' as assigned_staff
        UNION
        SELECT 'Mike Dela Cruz'
        UNION
        SELECT 'Lisa Martinez'
        ORDER BY assigned_staff"
    )->find();
} catch (\Throwable $th) {
    $staffMembers = [
        ['assigned_staff' => 'Sarah Reyes'],
        ['assigned_staff' => 'Mike Dela Cruz'],
        ['assigned_staff' => 'Lisa Martinez']
    ];
    error_log($th->getMessage());
}

// Fetch hired applicants (probationary employees) for the dropdown and table
try {
    $probationaryEmployees = $db->query(
        "SELECT e.id, e.full_name, e.email, e.position, e.hired_date, e.start_date, e.status 
    FROM employees e
    WHERE e.evaluation_status = 'Pending' 
    ORDER BY e.hired_date DESC"
    )->find();
} catch (\Throwable $th) {
    $probationaryEmployees = [];
    error_log($th->getMessage());
}

// Fetch hired applicants WITHOUT existing employee account
try {
    $availableEmployees = $db->query(
        "SELECT a.id, a.full_name, a.email, a.position, a.hired_date, a.start_date, a.department
        FROM applicants a
        WHERE a.status = 'Hired'
        AND NOT EXISTS (
            SELECT 1 
            FROM employee_accounts ea 
        WHERE ea.applicant_id = a.id
        )
        ORDER BY a.hired_date DESC"
    )->find();
} catch (\Throwable $th) {
    $availableEmployees = [];
    error_log($th->getMessage());
}

// Pagination for Generated Accounts
$page = isset($_GET['page']) ? max(1, (int) $_GET['page']) : 1;
$perPage = 5;
$offset = ($page - 1) * $perPage;

// Total accounts
try {
    $totalAccountsCount = $db->query("SELECT COUNT(*) as count FROM employee_accounts")->fetch_one()['count'] ?? 0;
} catch (\Throwable $th) {
    $totalAccountsCount = 0;
    error_log($th->getMessage());
}

// Accounts for current page
try {
    $generatedAccounts = $db->query(
        "SELECT ea.*, a.full_name, a.position 
        FROM employee_accounts ea
        JOIN applicants a ON ea.applicant_id = a.id
        ORDER BY ea.generated_date DESC
        LIMIT $perPage OFFSET $offset"
    )->find();
} catch (\Throwable $th) {
    $generatedAccounts = [];
    error_log($th->getMessage());
}

// Total pages for pagination
$totalPages = ceil($totalAccountsCount / $perPage);

try {
    // Total accounts generated
    $totalAccounts = $db->query("SELECT COUNT(*) as count FROM employee_accounts")->fetch_one();
} catch (\Throwable $th) {
    $totalAccounts = ['count' => 0];
    error_log($th->getMessage());
}

try {
    $totalHired = $db->query("SELECT COUNT(*) as count FROM employees WHERE status = 'Active'")->fetch_one();
} catch (\Throwable $th) {
    $totalHired = ['count' => 0];
}

try {
    $totalOnboarded = $db->query(
        "SELECT COUNT(*) as count 
        FROM employees WHERE onboarding_status = 'Onboarded'"
    )->fetch_one();
} catch (\Throwable $th) {
    $totalOnboarded = ['count' => 0];
}


try {
    $totalInProgress = $db->query(
        "SELECT COUNT(*) as count FROM employees WHERE onboarding_status = 'In Progress'"
    )->fetch_one();
} catch (\Throwable $th) {
    $totalInProgress = ['count' => 0];
}



try {
    $totalPending = $db->query(
        "SELECT COUNT(*) as count 
        FROM employees WHERE onboarding_status = 'Onboarding'"
    )->fetch_one();
} catch (\Throwable $th) {
    $totalPending = ['count' => 0];
}

$nhPage = isset($_GET['nh_page']) ? max(1, (int) $_GET['nh_page']) : 1;
$nhPerPage = 10;
$nhOffset = ($nhPage - 1) * $nhPerPage;

// Total new hires
try {
    $totalNewHires = $db->query("SELECT COUNT(*) as count FROM employees")->fetch_one()['count'] ?? 0;
} catch (\Throwable $th) {
    $totalNewHires = 0;
}

// Paginated new hires
try {
    $paginatedNewHires = $db->query(
        "SELECT id,employee_number, full_name, position, hired_date, start_date, onboarding_status, department
        FROM employees ORDER BY hired_date DESC LIMIT $nhPerPage OFFSET $nhOffset"
    )->find();
} catch (\Throwable $th) {
    $paginatedNewHires = [];
}


// Total pages
$totalNewHirePages = ceil($totalNewHires / $nhPerPage);

// Fetch recent evaluations with employee details
try {
    $recentEvaluations = $db->query("
    SELECT 
        pe.id as evaluation_id,
        pe.overall_score,
        pe.interpretation,
        pe.review_period_end,
        pe.created_at,
        e.id as employee_id,
        e.full_name,
        e.position,
        e.hired_date,
        e.start_date,
        e.status,
        pip.id as pip_id,
        pip.improvement_areas,
        pip.goal1,
        pip.goal2,
        pip.goal3,
        pip.pip_start_date,
        pip.pip_end_date,
        -- Get criteria scores
        MAX(CASE WHEN pcs.criteria_number = 1 THEN pcs.score END) as criteria_1_score,
        MAX(CASE WHEN pcs.criteria_number = 2 THEN pcs.score END) as criteria_2_score,
        MAX(CASE WHEN pcs.criteria_number = 3 THEN pcs.score END) as criteria_3_score,
        MAX(CASE WHEN pcs.criteria_number = 4 THEN pcs.score END) as criteria_4_score,
        MAX(CASE WHEN pcs.criteria_number = 5 THEN pcs.score END) as criteria_5_score,
        -- Determine if improvement needed based on overall score
        CASE 
            WHEN pe.overall_score < 3.0 THEN 'Improvement'
            ELSE 'Meet'
        END as improvement_status
    FROM performance_evaluations pe
    JOIN employees e ON pe.employee_id = e.id
    LEFT JOIN performance_improvement_plans pip 
        ON pip.evaluation_id = pe.id
    LEFT JOIN performance_criteria_scores pcs 
        ON pcs.evaluation_id = pe.id
    GROUP BY pe.id
    ORDER BY pe.created_at DESC
    LIMIT 10
")->find();
} catch (\Throwable $th) {
    $recentEvaluations = [];
    error_log($th->getMessage());
}

$pendingCount = $db->query("
    SELECT COUNT(*) AS count
    FROM employees
    WHERE evaluation_status = 'Pending'
")->fetch_one();

// Get ready for regular count (employees with good evaluations)
$needImprovement = $db->query("
    SELECT COUNT(*) AS count
    FROM performance_evaluations
    WHERE overall_score < 3.5
")->fetch_one();

$highScoreCount = $db->query("
    SELECT COUNT(*) AS count
    FROM performance_evaluations
    WHERE overall_score > 3.5
")->fetch_one();

// Get active PIP count
$activePipCount = $db->query("
    SELECT COUNT(*) AS count
    FROM performance_improvement_plans
")->fetch_one();



// hr4:
try {
    $employeesForBenefits = $db->query(
        "SELECT id, full_name, employee_number, position, department, status
        FROM employees 
        WHERE status = 'Active' OR status = 'Onboarding' OR status = 'Probationary'
        ORDER BY full_name ASC"
    )->find(); // Use findAll() to get all records
} catch (\Throwable $th) {
    $employeesForBenefits = [];
    error_log("Error fetching employees for benefits: " . $th->getMessage());
}

try {
    $benefitProviders = $db->query(
        "SELECT id, provider_name, contact_info
        FROM benefit_providers 
        ORDER BY provider_name ASC"
    )->find();
} catch (\Throwable $th) {
    $benefitProviders = [];
    error_log("Error fetching benefit providers: " . $th->getMessage());
}

view_path('main', 'index', [
    'jobPostings' => $jobPostings,
    'applicants' => $allApplicants,
    'recentApplicants' => $recentApplicants,
    'hiredEmployees' => $hiredEmployees,
    'tasks' => $tasks,
    'onboardingTasks' => $onboardingTasks,
    'obPage' => $obPage,
    'totalOnboardingPages' => $totalOnboardingPages,
    'applicantTasks' => $applicantTasks,
    'staffMembers' => $staffMembers,
    'departments' => $departments,
    'probationaryEmployees' => $probationaryEmployees,
    'availableEmployees' => $availableEmployees,
    'generatedAccounts' => $generatedAccounts,
    'totalPages' => $totalPages,
    'paginatedNewHires' => $paginatedNewHires,
    'nhPage' => $nhPage,
    'totalNewHirePages' => $totalNewHirePages,
    'recentEvaluations' => $recentEvaluations,
    'pendingCount' => $pendingCount,
    'needImprovement' => $needImprovement,
    'activePipCount' => $activePipCount,
    'highScoreCount' => $highScoreCount,
    'stats' => [
        'totalAccounts' => $totalAccounts['count'] ?? 0,
        'totalHired' => $totalHired['count'] ?? 0,
        'onboarded' => $totalOnboarded['count'] ?? 0,
        'inProgress' => $totalInProgress['count'] ?? 0,
        'pending' => $totalPending['count'] ?? 0,
    ],


    //hr4:
    'employeesForBenefits' => $employeesForBenefits,
    'benefitProviders' => $benefitProviders
]);