<?php

use Core\Database;

$config = require base_path('config/config.php');
$db = new Database($config['database']);

$_SESSION['success'] ??= [];
$_SESSION['error'] ??= [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['applicant_id'])) {

    try {
        $applicantId = $_POST['applicant_id'];
        $employeeId = $_POST['employee_id'];
        $fullName = $_POST['full_name'];
        $email = $_POST['email'];
        $position = $_POST['position'];

        $username = explode('@', $email)[0];
        $password = $employeeId;
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $existing = $db->query(
            "SELECT id FROM employee_accounts WHERE applicant_id = ?",
            [$applicantId]
        )->find();

        if ($existing) {
            $_SESSION['error'][] = 'An account already exists for this employee';
            header('Location: /main?tab=onboarding&modal=generateAccountModal');
            exit;
        }

        $db->query(
            "INSERT INTO employee_accounts (applicant_id, employee_id, username, password, email) 
            VALUES (?, ?, ?, ?, ?)",
            [$applicantId, $employeeId, $username, $hashedPassword, $email]
        );

        $_SESSION['success'][] = 'Employee account generated successfully';

        header('Location: /main?tab=onboarding');
        exit;

    } catch (Exception $e) {

        $_SESSION['error'][] = 'Something went wrong while generating the account';
        header('Location: /main?tab=onboarding&modal=generateAccountModal');
        exit;
    }
}