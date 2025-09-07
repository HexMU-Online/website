<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: /login/');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <?php include 'data/includes.php'; ?>
    <title>Dashboard - HexMU Online Private Server</title>
    <meta name="description" content="Testing stuff">
    <meta name="keywords" content="tag 1, tag 2">
  </head>
  <body>
    <?php include 'data/nav.php'; ?>
    <div class="row g-0">
      <!-- Main Content -->
      <div class="col-12 col-lg main-content">
        <main class="py-4 px-4" style="max-width:100%;">
          <h2 class="mb-4">Account Dashboard</h2>
          <p>Welcome to your account dashboard. Here you can manage your account settings, view your characters, and check your activity.</p>
          <!-- Additional account-related content can be added here -->
        </main>
      </div>
    </div>
  </body>
</html>