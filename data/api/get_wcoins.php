<?php
require_once '../functions.php';

// Start the session only if one isn't already active
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

header('Content-Type: application/json');

if (!isset($_SESSION['user'])) {
    echo json_encode(['success' => false, 'error' => 'User not authenticated.']);
    exit;
}

if (!$pdo) {
    echo json_encode(['success' => false, 'error' => 'Database connection failed.']);
    exit;
}

$wcoins = get_user_wcoins($pdo, $_SESSION['user']);
echo json_encode(['success' => true, 'wcoins' => $wcoins]);
