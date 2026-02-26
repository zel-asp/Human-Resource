<?php

use Core\Database;

$config = require base_path('config/config.php');
$db = new Database($config['database']);

$_SESSION['success'] ??= [];
$_SESSION['error'] ??= [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['applicant_id'])) {

    try {
        $applicantId = $_POST['applicant_id'];
        $employeeNumber = $_POST['employee_id'];  // This is EMP-031 from employees table
        $fullName = $_POST['full_name'];
        $email = $_POST['email'];
        $position = $_POST['position'];

        // generate username from email
        $username = explode('@', $email)[0];

        // use employee number as password (EMP-031)
        $password = $employeeNumber;
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // generate a unique employee_id for employee_accounts table
        $year = date('Y');
        $randomNum = rand(100, 999);
        $accountEmployeeId = "EMP-$year-$randomNum";

        // check if account already exists
        $existing = $db->query(
            "SELECT id FROM employee_accounts WHERE applicant_id = ?",
            [$applicantId]
        )->find();

        if ($existing) {
            $_SESSION['error'][] = 'An account already exists for this employee';
            header('Location: /main?tab=onboarding&modal=generateAccountModal');
            exit;
        }

        // check if employee number is unique in employee_accounts
        $existingEmpId = $db->query(
            "SELECT id FROM employee_accounts WHERE employee_id = ?",
            [$accountEmployeeId]
        )->find();

        // if not unique, generate another one
        while ($existingEmpId) {
            $randomNum = rand(100, 999);
            $accountEmployeeId = "EMP-$year-$randomNum";
            $existingEmpId = $db->query(
                "SELECT id FROM employee_accounts WHERE employee_id = ?",
                [$accountEmployeeId]
            )->find();
        }

        // insert new account
        $db->query(
            "INSERT INTO employee_accounts (applicant_id, employee_id, username, password, email) 
            VALUES (?, ?, ?, ?, ?)",
            [$applicantId, $accountEmployeeId, $username, $hashedPassword, $email]
        );

        $_SESSION['success'][] = 'Employee account generated successfully';
        $_SESSION['success'][] = "Username: $username, Password: $employeeNumber";

        header('Location: /main?tab=onboarding');
        exit;

    } catch (Exception $e) {
        // log error for debugging
        error_log('Account generation error: ' . $e->getMessage());

        $_SESSION['error'][] = 'Something went wrong while generating the account';
        header('Location: /main?tab=onboarding&modal=generateAccountModal');
        exit;
    }
}