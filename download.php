<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <?php include 'data/includes.php'; ?>
    <title>Download Game - HexMU Online Private Server</title>
    <meta name="description" content="Download HexMU Online game client from multiple sources.">
    <meta name="keywords" content="HexMU, MU Online, private server, download">
    <style>
    </style>
  </head>
  <body>
    <?php include 'data/nav.php'; ?>
    <div class="row g-0">
      <!-- Main Content -->
      <div class="col-12 col-lg main-content">
        <div class="container py-5">
            <h1 class="mb-4 text-center">Download Game</h1>
            <p class="text-center mb-5">Choose your preferred download source for the <span class="text-warning fw-bold">HexMU Online</span> game client:</p>
            <div class="row g-4 justify-content-center">
                <!-- MediaFire -->
                <div class="col-12 col-md-6 col-lg-3">
                <div class="card shadow-sm h-100 text-center">
                    <div class="card-body">
                    <img src="/data/images/download/mediafire.png" alt="MediaFire Logo" class="download-logo">
                    <h5 class="card-title">MediaFire</h5>
                    <p class="card-text">Fast and reliable hosting for the client</p>
                    <a href="#" class="btn btn-primary w-100">Download</a>
                    </div>
                </div>
                </div>
                <!-- Google Drive -->
                <div class="col-12 col-md-6 col-lg-3">
                <div class="card shadow-sm h-100 text-center">
                    <div class="card-body">
                    <img src="/data/images/download/googledrive.png" alt="Google Drive Logo" class="download-logo">
                    <h5 class="card-title">Google Drive</h5>
                    <p class="card-text">Secure download from Google servers</p>
                    <a href="#" class="btn btn-primary w-100">Download</a>
                    </div>
                </div>
                </div>
                <!-- 4Shared -->
                <div class="col-12 col-md-6 col-lg-3">
                <div class="card shadow-sm h-100 text-center">
                    <div class="card-body">
                    <img src="/data/images/download/4shared.png" alt="4Shared Logo" class="download-logo">
                    <h5 class="card-title">4Shared</h5>
                    <p class="card-text">Alternative source for the game client</p>
                    <a href="#" class="btn btn-primary w-100">Download</a>
                    </div>
                </div>
                </div>
                <!-- Mega -->
                <div class="col-12 col-md-6 col-lg-3">
                <div class="card shadow-sm h-100 text-center">
                    <div class="card-body">
                    <img src="/data/images/download/mega.png" alt="Mega Logo" class="download-logo">
                    <h5 class="card-title">Mega</h5>
                    <p class="card-text">High-speed cloud storage</p>
                    <a href="#" class="btn btn-primary w-100">Download</a>
                    </div>
                </div>
                </div>
            </div>
            <div class="text-center mt-5 small">
                Please run <code>update.exe</code> before launching the game to ensure you have the latest patch.
            </div>
            </div>
        </div>
    </div>
  </body>
</html>
