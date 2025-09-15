<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <?php include 'data/includes.php'; ?>
    <title>HexMU Online Private Server</title>
    <meta name="description" content="Testing stuff">
    <meta name="keywords" content="tag 1, tag 2">    
  </head>
  <body>
    <?php include 'data/nav.php'; ?>
    <div class="row g-0">
      <div class="col-12 col-lg main-content p-0">
        <main style="max-width:100%;padding:0;">
          <!-- Hero Section -->
          <section class="hero-section position-relative">
            <div class="hero-overlay"></div>
            <div class="container hero-content">
              <img src="/data/images/hexmu_logo_notext.png" alt="HexMU Logo" class="hero-logo rounded shadow">
              <h1 class="hero-title mb-3">HexMU Online</h1>
              <div class="hero-subtitle mb-4">
                Relive the classic <span class="fw-bold text-warning">MU Online</span> experience <br/>
                with modern features, balanced gameplay, and a vibrant community.
              </div>
              <a href="/register/" class="btn btn-warning btn-lg hero-btn">Register</a>
              <a href="/download/" class="btn btn-outline-light btn-lg hero-btn">Download</a>
            </div>
          </section>

          <!-- Features Section -->
          <section class="features-section">
            <div class="container">
              <div class="row text-center mb-4">
                <div class="col">
                  <h2 class="fw-bold">Server Features</h2>
                  <p class="text-secondary">HexMU Online - 25 EXP - Low Drop</p>
                </div>
              </div>
              <div class="row g-4">
                <div class="col-md-6 col-lg-4">
                  <div class="card bg-dark text-white h-100 shadow-sm border-0">
                    <img src="/data/images/features/daily-rewards.jpg" class="card-img-top" alt="Daily Rewards">
                    <div class="card-body text-center">
                      <span class="feature-icon"><i class="bi bi-calendar2-check"></i></span>
                      <h6 class="fw-bold">Daily Rewards</h6>
                      <p>Log in every day for exclusive bonuses and gifts.</p>
                    </div>
                  </div>
                </div>
                <div class="col-md-6 col-lg-4">
                  <div class="card bg-dark text-white h-100 shadow-sm border-0">
                    <img src="/data/images/features/custom-quests.jpg" class="card-img-top" alt="Custom Quests">
                    <div class="card-body text-center">
                      <span class="feature-icon"><i class="bi bi-list-task"></i></span>
                      <h6 class="fw-bold">Custom Quests</h6>
                      <p>Engage in unique quests for extra challenges and rewards.</p>
                    </div>
                  </div>
                </div>
                <div class="col-md-6 col-lg-4">
                  <div class="card bg-dark text-white h-100 shadow-sm border-0">
                    <img src="/data/images/features/battle-pass.jpg" class="card-img-top" alt="Battle Pass">
                    <div class="card-body text-center">
                      <span class="feature-icon"><i class="bi bi-award"></i></span>
                      <h6 class="fw-bold">Battle Pass</h6>
                      <p>Progress through the Battle Pass and unlock premium prizes.</p>
                    </div>
                  </div>
                </div>
                <div class="col-md-6 col-lg-4">
                  <div class="card bg-dark text-white h-100 shadow-sm border-0">
                    <img src="/data/images/features/modern-ui.jpg" class="card-img-top" alt="Modern UI">
                    <div class="card-body text-center">
                      <span class="feature-icon"><i class="bi bi-display"></i></span>
                      <h6 class="fw-bold">Modern UI</h6>
                      <p>Enjoy a sleek, modern interface for the best experience.</p>
                    </div>
                  </div>
                </div>
                <div class="col-md-6 col-lg-4">
                  <div class="card bg-dark text-white h-100 shadow-sm border-0">
                    <img src="/data/images/features/master-level.jpg" class="card-img-top" alt="Master Level">
                    <div class="card-body text-center">
                      <span class="feature-icon"><i class="bi bi-graph-up-arrow"></i></span>
                      <h6 class="fw-bold">Master Level</h6>
                      <p>Advance beyond the basics with Master Level progression.</p>
                    </div>
                  </div>
                </div>
                <div class="col-md-6 col-lg-4">
                  <div class="card bg-dark text-white h-100 shadow-sm border-0">
                    <img src="/data/images/features/sockets.jpg" class="card-img-top" alt="Sockets">
                    <div class="card-body text-center">
                      <span class="feature-icon"><i class="bi bi-gem"></i></span>
                      <h6 class="fw-bold">Sockets</h6>
                      <p>Enhance your gear with powerful socket options.</p>
                    </div>
                  </div>
                </div>
                <div class="col-md-6 col-lg-4">
                  <div class="card bg-dark text-white h-100 shadow-sm border-0">
                    <img src="/data/images/features/characters.jpg" class="card-img-top" alt="Multiple Characters">
                    <div class="card-body text-center">
                      <span class="feature-icon"><i class="bi bi-person-badge"></i></span>
                      <h6 class="fw-bold">Multiple Characters</h6>
                      <p>Play with X character classes, each with unique skills.</p>
                    </div>
                  </div>
                </div>
                <div class="col-md-6 col-lg-4">
                  <div class="card bg-dark text-white h-100 shadow-sm border-0">
                    <img src="/data/images/features/events.jpg" class="card-img-top" alt="Events & Invasions">
                    <div class="card-body text-center">
                      <span class="feature-icon"><i class="bi bi-trophy"></i></span>
                      <h6 class="fw-bold">Events & Invasions</h6>
                      <p>Participate in X events and X invasions for epic loot.</p>
                    </div>
                  </div>
                </div>
                <div class="col-md-6 col-lg-4">
                  <div class="card bg-dark text-white h-100 shadow-sm border-0">
                    <!-- Example YouTube video embed for Discord Bot -->
                    <div class="ratio ratio-16x9">
                      <!-- <iframe src="https://www.youtube.com/embed/VIDEO_ID" title="Discord Bot" allowfullscreen></iframe>-->
                    </div>
                    <div class="card-body text-center">
                      <span class="feature-icon"><i class="bi bi-discord"></i></span>
                      <h6 class="fw-bold">Discord Bot</h6>
                      <p>Stay connected and get updates directly on Discord.</p>
                    </div>
                  </div>
                </div>
                <div class="col-md-6 col-lg-4">
                  <div class="card bg-dark text-white h-100 shadow-sm border-0">
                    <img src="/data/images/features/offattack.jpg" class="card-img-top" alt="OffAttack">
                    <div class="card-body text-center">
                      <span class="feature-icon"><i class="bi bi-cpu"></i></span>
                      <h6 class="fw-bold">OffAttack</h6>
                      <p>Train and farm even while offline with OffAttack mode.</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </section>

          <!-- How to Start Section -->
          <section class="start-section">
            <div class="container">
              <div class="row text-center mb-4">
                <div class="col">
                  <h2 class="fw-bold">How to Start</h2>
                  <p class="text-secondary">Begin your adventure in just a few steps</p>
                </div>
              </div>
              <div class="row justify-content-center">
                <div class="col-md-4">
                  <div class="start-step">
                    <div class="start-step-number">1</div>
                    <h5 class="fw-bold">Register Account</h5>
                    <p>Create your free account to join the server.</p>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="start-step">
                    <div class="start-step-number">2</div>
                    <h5 class="fw-bold">Download Client</h5>
                    <p>Get our custom game client and install it.</p>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="start-step">
                    <div class="start-step-number">3</div>
                    <h5 class="fw-bold">Start Playing</h5>
                    <p>Log in, create your character, and begin your journey!</p>
                  </div>
                </div>
              </div>
            </div>
          </section>
          
          <?php if (!$pdo && $connectionError): ?>
            <div class="alert alert-danger" role="alert">
              <strong>Database connection failed:</strong> <?php echo htmlspecialchars($connectionError); ?>
            </div>
          <?php endif; ?>
        </main>
      </div>
    </div>
    <!-- Bootstrap Icons CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
  </body>
</html>