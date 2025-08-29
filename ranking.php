<?php
require_once 'data/functions.php';

// Use $pdo, $serverOnline, $onlineUsers, $connectionError from functions.php
$topPlayers = [];
if ($pdo) {
    $topPlayers = get_top_players($pdo, 20);
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ranking - HexMU Online Private Server</title>
    <meta name="description" content="Testing stuff">
    <meta name="keywords" content="tag 1, tag 2">
    <meta name="author" content="Among Demons">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <link href="/data/main.css?v=2" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="icon" href="/hexmu.ico" type="image/x-icon">
  </head>
  <body>
    <?php include 'data/nav.php'; ?>
    <div class="row g-0">
      <!-- Main Content -->
      <div class="col-12 col-lg main-content">
        <main class="py-4 px-4" style="max-width:100%;">
          <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">Top Players</h2>
            <form class="d-flex" method="get" action="">
              <input class="form-control me-2" type="search" name="search" placeholder="Search player..." value="<?php echo htmlspecialchars($_GET['search'] ?? ''); ?>">
              <button class="btn btn-outline-primary" type="submit">Search</button>
            </form>
          </div>
          <div class="table-responsive">
            <table class="table table-striped table-bordered align-middle">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Name</th>
                  <th>Level</th>
                  <th>Resets</th>
                  <th>Class</th>
                  <th>Guild</th>
                </tr>
              </thead>
              <tbody>
                <?php if ($pdo && count($topPlayers) > 0): ?>
                  <?php foreach ($topPlayers as $i => $player): ?>
                    <tr>
                      <td><?php echo $i + 1; ?></td>
                      <td><?php echo htmlspecialchars($player['Name']); ?></td>
                      <td><?php echo (int)$player['cLevel']; ?></td>
                      <td><?php echo isset($player['ResetCount']) ? (int)$player['ResetCount'] : 0; ?></td>
                      <td data-class-id="<?php echo htmlspecialchars($player['Class']); ?>"><?php echo htmlspecialchars(class_id_to_name($player['Class'])); ?></td>
                      <td><?php echo htmlspecialchars($player['Guild'] ?? ''); ?></td>
                    </tr>
                  <?php endforeach; ?>
                <?php else: ?>
                  <tr>
                    <td colspan="6" class="text-center">No data available.</td>
                  </tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
          
          <?php if (!$pdo && $connectionError): ?>
            <div class="alert alert-danger" role="alert">
              <strong>Database connection failed:</strong> <?php echo htmlspecialchars($connectionError); ?>
            </div>
          <?php endif; ?>
        </main>
      </div>
    </div>
  </body>
</html>