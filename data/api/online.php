<?php
require_once '../functions.php';

header('Content-Type: application/json');

if ($pdo) {
    $count = get_online_users($pdo);
    $online = $count . ' Online';
    if ($count<10) {
        $online = 'Online';
    }
} else {
    $online = 'Offline';
}

echo json_encode(['status' => $online]);
?>