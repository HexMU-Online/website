<?php
require_once '../functions.php';

header('Content-Type: application/json');

if ($pdo) {
    $online = get_online_users($pdo) . ' Online';
} else {
    $online = 'Offline';
}

echo json_encode(['status' => $online]);
?>