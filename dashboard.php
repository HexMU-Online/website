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

$wcoins = 0; // Initial value, will be updated by AJAX
$characters = []; // Initial value, will be updated by AJAX
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
			<main class="content-container" style="max-width:100%;">
				<section>
					<div class="section-header section-header--spacing-small">
						<h2 class="heading">Account Dashboard</h2>
						<p class="subheading">Welcome to your account dashboard. Here you can manage your account settings, view your characters, and check your activity.</p>
					</div>


					<div class="row account-standing">
						<!-- Account Balance -->
						<div class="col account-standing-box h-100">
							<div class="card h-100">
								<div class="card-body bg-my-secondary">
									<div class="row no-gutters align-items-center">
										<div class="col mr-2">
											<div class="account-standing--title color-my-dark-secondary">Account Balance</div>
											<div id="wcoins-balance" class="account-standing--subtitle color-my-dark">... WCoins</div>
										</div>
										<div class="col-auto">
											<div class="icon-holder color-my-dark-secondary">
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

						<!-- Donation Plan Promo -->
						<div class="col-xl-2 col-md-3 account-standing-box donation-promo h-100">
							<a href="/donate" class="card h-100">
								<div class="card-body bg-white">
									<div class="row no-gutters align-items-center">
										<div class="col mr-2">
											<div class="account-standing--title color-my-dark-secondary"> NEED MORE WCoins?</div>
											<div class="account-standing--subtitle color-my-dark"> Donate for WC</div>
										</div>
										<div class="col-auto">
											<div class="icon-holder color-my-dark-secondary">
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
				</section>
				<section>
					<div class="section-header">
						<h2 class="heading">Your Characters</h2>
						<p class="subheading">View your active characters, stats and preview links.</p>
					</div>


					<div id="character-list" class="row row-cols-1 row-cols-md-2 row-cols-xl-4 g-4">
						<!-- Character cards will be loaded here by AJAX -->
						<?php for ($i = 0; $i < 4; $i++) : ?>
						<div class="col placeholder-glow character-card-placeholder">
							<div class="placeholder-card h-100">
								<div class="placeholder-item card-img-top"></div>
								<div class="card-body d-flex flex-column">
									<div class="placeholder-item" style="height: 24px; width: 70%; margin: 0 auto 1rem auto;"></div>
									<ul class="list-unstyled mt-2 mb-3 flex-grow-1">
										<li class="d-flex justify-content-between"><div class="placeholder-item" style="height: 16px; width: 40%;"></div><div class="placeholder-item" style="height: 16px; width: 50%;"></div></li>
										<li class="d-flex justify-content-between"><div class="placeholder-item" style="height: 16px; width: 40%;"></div><div class="placeholder-item" style="height: 16px; width: 20%;"></div></li>
										<li class="d-flex justify-content-between"><div class="placeholder-item" style="height: 16px; width: 40%;"></div><div class="placeholder-item" style="height: 16px; width: 15%;"></div></li>
									</ul>
									<div class="placeholder-item" style="height: 31px; width: 100%;"></div>
								</div>
							</div>
						</div>
						<?php endfor; ?>
					</div>
				</section>
				<section>
					<div class="section-header">
						<h2 class="heading">Account Actions</h2>
						<p class="subheading">Manage your account settings, get more WC or log out.</p>
					</div>
					<div class="action-row d-flex flex-wrap gap-3">
						<a href="/donate" class="btn btn-action highlight d-flex align-items-center gap-3">
							<div class="mb-0 text-light">GET MORE WCOINS</div>
							<div class="icon-holder text-light"><?php include 'data/images/icons/donate.svg' ?></div>
						</a>

						<a href="/dashboard/settings" class="btn btn-action d-flex align-items-center gap-3">
							<div class="mb-0 text-light">ACCOUNT SETTINGS</div>
							<div class="icon-holder text-light"><?php include 'data/images/icons/account.svg' ?></div>
						</a>

						<a href="/logout" class="btn btn-action d-flex align-items-center gap-3">
							<div class="mb-0 text-light">LOG OUT</div>
							<div class="icon-holder text-light"><?php include 'data/images/icons/logout.svg' ?></div>
						</a>
					</div>
				</section>
			</main>
		</div>
	</div>
	<script>
	$(document).ready(function() {
		// Fetch WCoins
		$.ajax({
			url: '/data/api/get_wcoins.php',
			type: 'GET',
			dataType: 'json',
			success: function(response) {
				if (response.success) {
					const wcoins = parseInt(response.wcoins, 10);
					$('#wcoins-balance').text(wcoins.toLocaleString() + ' WCoins');
				} else {
					$('#wcoins-balance').text('Error');
				}
			},
			error: function() {
				$('#wcoins-balance').text('Error loading balance');
			}
		});

		// Fetch Characters
		$.ajax({
			url: '/data/api/get_characters.php',
			type: 'GET',
			dataType: 'json',
			success: function(response) {
				const characterList = $('#character-list');
				characterList.empty(); // Clear loading message

				if (response.success && response.characters.length > 0) {
					const classNames = <?php
						// This is a safe way to pass PHP array to JS
						$classes = [0=>'Dark Wizard',1=>'Soul Master',2=>'Grand Master',16=>'Dark Knight',17=>'Blade Knight',18=>'Blade Master',32=>'Fairy Elf',33=>'Muse Elf',34=>'High Elf',48=>'Magic Gladiator',49=>'Duel Master',64=>'Dark Lord',66=>'Lord Emperor',80=>'Summoner',81=>'Bloody Summoner',82=>'Dimension Master',96=>'Rage Fighter',97=>'Fist Master'];
						echo json_encode($classes);
					?>;

					function getClassName(classId) {
						return classNames[classId] || 'Unknown';
					}

					response.characters.forEach(function(char) {
						const className = getClassName(char.Class);
						const characterCard = `
							<div class="col">
								<div class="card h-100 character-card">
									<img src="/data/images/classes/${char.Class}.jpg" class="card-img-top" alt="${className}">
									<div class="card-body d-flex flex-column">
										<h5 class="card-title text-center fw-bold">${char.Name}</h5>
										<ul class="list-unstyled mt-2 mb-3 flex-grow-1">
											<li class="d-flex justify-content-between"><strong>Class:</strong> <span>${className}</span></li>
											<li class="d-flex justify-content-between"><strong>Level:</strong> <span>${char.cLevel}</span></li>
											<li class="d-flex justify-content-between"><strong>Resets:</strong> <span>${char.ResetCount}</span></li>
										</ul>
										<a href="/character/${char.Name}" class="btn btn-sm btn-primary mt-auto">View Details</a>
									</div>
								</div>
							</div>`;
						characterList.append(characterCard);
					});
				} else {
					characterList.html('<div class="col-12"><div class="alert alert-info">You have not created any characters yet.</div></div>');
				}
			},
			error: function() {
				const characterList = $('#character-list');
				characterList.html('<div class="col-12"><div class="alert alert-danger">Error loading characters. Please try again later.</div></div>');
			}
		});
	});
	</script>
</body>

</html>