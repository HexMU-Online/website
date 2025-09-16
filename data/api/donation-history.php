<?php
header('Content-Type: application/json');

// Start the session only if one isn't already active
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Ensure user is authenticated
if (!isset($_SESSION['user'])) {
    http_response_code(401); // Unauthorized
    echo json_encode(['success' => false, 'error' => 'Authentication required.']);
    exit;
}

require_once '../functions.php';

if (!$pdo) {
    http_response_code(503); // Service Unavailable
    echo json_encode(['success' => false, 'error' => 'Could not connect to the database.']);
    exit;
}

$donations = get_user_donations($pdo, $_SESSION['user']);
echo json_encode(['success' => true, 'donations' => $donations]);
