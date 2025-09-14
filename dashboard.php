<?php
// Start the session only if one isn't already active
if ( session_status() === PHP_SESSION_NONE ) {
	session_start();
}

// Redirect to login if user is not authenticated
if ( ! isset( $_SESSION['user'] ) ) {
	header( 'Location: /login/' );
	exit;
}

require_once( 'data/config.php' );
require_once( 'data/functions.php' );

$wcoins = get_user_wcoins($pdo, $_SESSION['user']);
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

				<div class="row">
					<!-- Account Balance -->
					<div class="col-xl-4 col-md-6 mb-4">
						<div class="card border-left-warning shadow h-100 py-2">
							<div class="card-body">
								<div class="row no-gutters align-items-center">
									<div class="col mr-2">
										<div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Account Balance</div>
										<div class="h5 mb-0 font-weight-bold text-gray-800"><?= number_format($wcoins); ?> WCoins</div>
									</div>
									<div class="col-auto">
										<div class="icon-holder text-light">
											<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="64" height="64" fill="none">
												<ellipse cx="15.5" cy="11" rx="6.5" ry="2" stroke="currentColor" stroke-width="1.5"></ellipse>
												<path d="M22 15.5C22 16.6046 19.0899 17.5 15.5 17.5C11.9101 17.5 9 16.6046 9 15.5" stroke="currentColor" stroke-width="1.5"></path>
												<path d="M22 11V19.8C22 21.015 19.0899 22 15.5 22C11.9101 22 9 21.015 9 19.8V11" stroke="currentColor" stroke-width="1.5"></path>
												<ellipse cx="8.5" cy="4" rx="6.5" ry="2" stroke="currentColor" stroke-width="1.5"></ellipse>
												<path d="M6 11C4.10819 10.7698 2.36991 10.1745 2 9M6 16C4.10819 15.7698 2.36991 15.1745 2 14" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
												<path d="M6 21C4.10819 20.7698 2.36991 20.1745 2 19L2 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
												<path d="M15 6V4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
											</svg>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<!-- Subscription Plan -->
					<div class="col-xl-4 col-md-6 mb-4">
						<a href="#" class="card border-left-success shadow h-100 py-2">
							<div class="card-body">
								<div class="row no-gutters align-items-center">
									<div class="col mr-2">
										<div class="text-xs font-weight-bold text-success text-uppercase mb-1"> NEED MORE WCoins?</div>
										<div class="h5 mb-0 font-weight-bold text-gray-800"> Make a Donation</div>
									</div>
									<div class="col-auto">
										<div class="icon-holder text-light">
											<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="64" height="64" fill="none">
												<path d="M13 5C17.9706 5 22 8.35786 22 12.5C22 14.5586 21.0047 16.4235 19.3933 17.7787C19.1517 17.9819 19 18.2762 19 18.5919V21H17L16.2062 19.8674C16.083 19.6916 15.8616 19.6153 15.6537 19.6687C13.9248 20.1132 12.0752 20.1132 10.3463 19.6687C10.1384 19.6153 9.91703 19.6916 9.79384 19.8674L9 21H7V18.6154C7 18.2866 6.83835 17.9788 6.56764 17.7922C5.49285 17.0511 2 15.6014 2 14.0582V12.5C2 11.9083 2.44771 11.4286 3 11.4286C3.60665 11.4286 4.10188 11.1929 4.30205 10.5661C5.32552 7.36121 8.83187 5 13 5Z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"></path>
												<path d="M14.5 8C13.868 7.67502 13.1963 7.5 12.5 7.5C11.8037 7.5 11.132 7.67502 10.5 8" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
												<path d="M7.49981 11H7.50879" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
												<path d="M21 8.5C21.5 8 22 7.06296 22 5.83053C22 4.26727 20.6569 3 19 3C18.6494 3 18.3128 3.05676 18 3.16106" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
											</svg>
										</div>
									</div>
								</div>
							</div>
						</a>
					</div>
				</div>

				<h3 class="mt-4 mb-3">Manage Your Account</h3>

				<div class="row row-cols-2 row-cols-md-4 g-4">

					<!-- Characters -->
					<div class="col">
						<a href="/dashboard/characters.php" class="card h-100 text-decoration-none shadow-sm hover-shadow">
							<div class="card-body d-flex align-items-center">
								<svg xmlns="http://www.w3.org/2000/svg" width="42" height="42" fill="currentColor" class="me-3 text-primary" viewBox="0 0 16 16">
									<path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3Zm5-6a3 3 0 1 0-0.001-6.001A3 3 0 0 0 8 8Z" />
								</svg>
								<h5 class="mb-0 text-light">View Characters</h5>
							</div>
						</a>
					</div>

					<!-- Subscription -->
					<div class="col">
						<a href="/dashboard/subscription.php" class="card h-100 text-decoration-none shadow-sm">
							<div class="card-body d-flex align-items-center">
								<svg xmlns="http://www.w3.org/2000/svg" width="42" height="42" fill="currentColor" class="me-3 text-success" viewBox="0 0 16 16">
									<path d="M0 4a2 2 0 0 1 2-2h1v2H2v8h1v2H2a2 2 0 0 1-2-2V4zM15 4a2 2 0 0 0-2-2h-1v2h1v8h-1v2h1a2 2 0 0 0 2-2V4z" />
								</svg>
								<h5 class="mb-0 text-light">Manage Funds</h5>
							</div>
						</a>
					</div>

					<!-- Settings -->
					<div class="col">
						<a href="/dashboard/settings.php" class="card h-100 text-decoration-none shadow-sm">
							<div class="card-body d-flex align-items-center">
								<svg xmlns="http://www.w3.org/2000/svg" width="42" height="42" fill="currentColor" class="me-3 text-secondary" viewBox="0 0 16 16">
									<path d="M9.405 1.05c-.413-1.23-2.397-1.23-2.81 0l-.25.75a1.87 1.87 0 0 1-1.087 1.17l-.67.27c-1.184.475-1.184 2.117 0 2.592l.67.27c.47.192.845.58 1.087 1.17l.25.75c.413 1.23 2.397 1.23 2.81 0l.25-.75a1.87 1.87 0 0 1 1.087-1.17l.67-.27c1.184-.475 1.184-2.117 0-2.592l-.67-.27a1.87 1.87 0 0 1-1.087-1.17l-.25-.75z" />
								</svg>
								<h5 class="mb-0 text-light">Account Settings</h5>
							</div>
						</a>
					</div>

					<!-- Change Password -->
					<div class="col">
						<a href="/dashboard/changepass.php" class="card h-100 text-decoration-none shadow-sm">
							<div class="card-body d-flex align-items-center">
								<svg xmlns="http://www.w3.org/2000/svg" width="42" height="42" fill="currentColor" class="me-3 text-warning" viewBox="0 0 16 16">
									<path d="M8 5a3 3 0 0 0-3 3v2h6V8a3 3 0 0 0-3-3z" />
									<path d="M3 8a5 5 0 1 1 10 0v2H3V8z" />
								</svg>
								<h5 class="mb-0 text-light">Change Password</h5>
							</div>
						</a>
					</div>
				</div>



			</main>
		</div>
	</div>
</body>

</html>