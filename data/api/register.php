<?php
require_once '../functions.php';

// Start the session only if one isn't already active
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

header('Content-Type: application/json');

$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';
$repassword = $_POST['repassword'] ?? '';
$email = trim($_POST['email'] ?? '');
$terms = $_POST['terms'] ?? '';

if (!$pdo) {
    echo json_encode(['success' => false, 'error' => 'Cannot register: database offline.']);
    exit;
}

if ($password !== $repassword) {
    echo json_encode(['success' => false, 'error' => 'Passwords do not match.']);
    exit;
}

if (!$terms) {
    echo json_encode(['success' => false, 'error' => 'You must accept the terms.']);
    exit;
}

// Register user
list($registerSuccess, $registerError) = register($pdo, $username, $password, $email);

if ($registerSuccess) {
    $_SESSION['user'] = $username;
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => $registerError]);
}
?>
