<?php
header('Content-Type: application/json');
require_once '../functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = trim($_POST['token'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    if (empty($token) || empty($password) || $password !== $confirm_password) {
        echo json_encode(['success' => false, 'error' => 'Invalid data provided. Please check your input.']);
        exit;
    }

    if (!$pdo) {
        echo json_encode(['success' => false, 'error' => 'Could not connect to the server. Please try again later.']);
        exit;
    }

    list($success, $message) = resetPassword($pdo, $token, $password);

    if ($success) {
        echo json_encode(['success' => true, 'message' => $message]);
    } else {
        echo json_encode(['success' => false, 'error' => $message]);
    }
} else {
    http_response_code(405); // Method Not Allowed
    echo json_encode(['success' => false, 'error' => 'Invalid request method.']);
}
