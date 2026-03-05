<?php

use Core\Database;

require base_path('core/middleware/employeeAuth.php');

$config = require base_path('config/config.php');
$db = new Database($config['database']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $_SESSION['error'][] = 'Invalid CSRF token';
        header('Location: /?tab=claims');
        exit();
    }

    $required = ['employeeId', 'expense_date', 'category', 'merchant', 'amount'];
    foreach ($required as $field) {
        if (!isset($_POST[$field]) || trim($_POST[$field]) === '') {
            $_SESSION['error'][] = 'All required fields must be filled';
            header('Location: /?tab=claims');
            exit();
        }
    }

    $employeeId = filter_input(INPUT_POST, 'employeeId', FILTER_VALIDATE_INT);
    $expenseDate = filter_input(INPUT_POST, 'expense_date', FILTER_SANITIZE_SPECIAL_CHARS);
    $category = filter_input(INPUT_POST, 'category', FILTER_SANITIZE_SPECIAL_CHARS);
    $merchant = filter_input(INPUT_POST, 'merchant', FILTER_SANITIZE_SPECIAL_CHARS);
    $amount = filter_input(INPUT_POST, 'amount', FILTER_VALIDATE_FLOAT);
    $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_SPECIAL_CHARS);
    $receiptUrl = filter_input(INPUT_POST, 'receipt_url', FILTER_SANITIZE_URL);

    if (!$employeeId || $employeeId <= 0) {
        $_SESSION['error'][] = 'Invalid employee ID';
        header('Location: /?tab=claims');
        exit();
    }

    $checkSql = "SELECT id FROM employees WHERE id = :id";
    $employee = $db->query($checkSql, ['id' => $employeeId])->find();

    if (!$employee) {
        $_SESSION['error'][] = 'Employee not found';
        header('Location: /?tab=claims');
        exit();
    }

    $dateRegex = '/^\d{4}-\d{2}-\d{2}$/';
    if (!preg_match($dateRegex, $expenseDate)) {
        $_SESSION['error'][] = 'Invalid date format';
        header('Location: /?tab=claims');
        exit();
    }

    $dateParts = explode('-', $expenseDate);
    if (!checkdate($dateParts[1], $dateParts[2], $dateParts[0])) {
        $_SESSION['error'][] = 'Invalid date';
        header('Location: /?tab=claims');
        exit();
    }

    $allowedCategories = ['Travel', 'Meals', 'Transportation', 'Office Supplies', 'Training', 'Equipment', 'Communication', 'Other'];
    if (!in_array($category, $allowedCategories)) {
        $_SESSION['error'][] = 'Invalid category';
        header('Location: /?tab=claims');
        exit();
    }

    if (strlen($merchant) > 255) {
        $merchant = substr($merchant, 0, 255);
    }

    if (!$amount || $amount <= 0 || $amount > 999999.99) {
        $_SESSION['error'][] = 'Invalid amount';
        header('Location: /?tab=claims');
        exit();
    }

    $amount = round($amount, 2);

    if ($description && strlen($description) > 65535) {
        $description = substr($description, 0, 65535);
    }

    if (!filter_var($receiptUrl, FILTER_VALIDATE_URL) && !empty($receiptUrl)) {
        $receiptUrl = preg_replace('/[^a-zA-Z0-9\/\._-]/', '', $receiptUrl);
    }

    $sql = "INSERT INTO expense_claims (
        employee_id, 
        expense_date, 
        category, 
        merchant, 
        amount, 
        description, 
        receipt_path, 
        status,
        created_at,
        updated_at
    ) VALUES (
        :employee_id, 
        :expense_date, 
        :category, 
        :merchant, 
        :amount, 
        :description, 
        :receipt_path, 
        'Pending',
        NOW(),
        NOW()
    )";

    try {
        $result = $db->query($sql, [
            'employee_id' => $employeeId,
            'expense_date' => $expenseDate,
            'category' => $category,
            'merchant' => $merchant,
            'amount' => $amount,
            'description' => $description,
            'receipt_path' => $receiptUrl
        ]);

        if ($result) {
            $_SESSION['success'][] = 'Expense claim submitted successfully';
            header('Location: /?tab=claims');
            exit();
        } else {
            $_SESSION['error'][] = 'Failed to submit expense claim';
            header('Location: /?tab=claims');
            exit();
        }
    } catch (PDOException $e) {
        error_log('Database error: ' . $e->getMessage());
        $_SESSION['error'][] = 'An error occurred while submitting your claim';
        header('Location: /?tab=claims');
        exit();
    }
}