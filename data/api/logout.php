<?php
// Initialize the session.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Unset all of the session variables.
$_SESSION = [];

// Destroy the session.
session_destroy();

// Redirect to the homepage.
header("Location: /login.php?logout=1");
exit;
?>
