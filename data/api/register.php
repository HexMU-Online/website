<?php
require_once '../functions.php';

header('Content-Type: application/json');

$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';
$email = trim($_POST['email'] ?? '');

if (!$pdo) {
    echo json_encode(['success' => false, 'error' => 'Cannot register: database offline.']);
    exit;
}

list($registerSuccess, $registerError) = register($pdo, $username, $password, $email);

if ($registerSuccess) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => $registerError]);
}
?>
