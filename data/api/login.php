<?php
require_once '../functions.php';

header('Content-Type: application/json');

$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

if (!$pdo) {
    echo json_encode(['success' => false, 'error' => 'Cannot login: database offline.']);
    exit;
}

// Authenticate user
list($loginSuccess, $loginError) = login($pdo, $username, $password);

if ($loginSuccess) {
    // Example: start session
    session_start();
    $_SESSION['user'] = $username;

    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => $loginError]);
}
?>
