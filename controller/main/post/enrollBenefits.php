<?php

use Core\Database;

$config = require base_path('config/config.php');
$db = new Database($config['database']);

// CSRF check
if ($_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    $_SESSION['error'][] = 'Invalid CSRF token';
    header('Location: /main?tab=hmo');
    exit();
}

// Required fields validation
if (
    empty($_POST['employee_id']) || empty($_POST['benefit_type']) ||
    empty($_POST['provider_id']) || empty($_POST['effective_date'])
) {
    $_SESSION['error'][] = 'Please fill in all required fields';
    header('Location: /main?tab=hmo');
    exit();
}

try {
    // Sanitize input
    $employee_id = filter_var($_POST['employee_id'], FILTER_SANITIZE_NUMBER_INT);
    $benefit_type = filter_var($_POST['benefit_type'], FILTER_SANITIZE_STRING);
    $provider_id = filter_var($_POST['provider_id'], FILTER_SANITIZE_NUMBER_INT);
    $effective_date = $_POST['effective_date'];
    $expiry_date = !empty($_POST['expiry_date']) ? $_POST['expiry_date'] : null;

    $coverage_amount = !empty($_POST['coverage_amount'])
        ? preg_replace('/[^0-9.]/', '', $_POST['coverage_amount'])
        : null;

    $monthly_premium = !empty($_POST['monthly_premium'])
        ? preg_replace('/[^0-9.]/', '', $_POST['monthly_premium'])
        : null;

    $dependents = !empty($_POST['dependents'])
        ? filter_var($_POST['dependents'], FILTER_SANITIZE_STRING)
        : null;

    $db->beginTransaction();

    $db->query(
        "INSERT INTO employee_benefits 
        (employee_id, benefit_type, provider_id, effective_date, expiry_date, 
        coverage_amount, monthly_premium, dependents, created_at, updated_at) 
        VALUES 
        (:employee_id, :benefit_type, :provider_id, :effective_date, :expiry_date,
        :coverage_amount, :monthly_premium, :dependents, NOW(), NOW())",
        [
            'employee_id' => $employee_id,
            'benefit_type' => $benefit_type,
            'provider_id' => $provider_id,
            'effective_date' => $effective_date,
            'expiry_date' => $expiry_date,
            'coverage_amount' => $coverage_amount,
            'monthly_premium' => $monthly_premium,
            'dependents' => $dependents
        ]
    );

    $db->commit();
    $_SESSION['success'][] = 'Employee successfully enrolled in benefits';

} catch (PDOException $e) {
    if ($db->inTransaction())
        $db->rollBack();
    error_log("Benefit enrollment error: " . $e->getMessage());
    $_SESSION['error'][] = 'Failed to enroll employee in benefits. Please try again.';
}

header('Location: /main?tab=hmo');
exit();