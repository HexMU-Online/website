<?php
// Start the session only if one isn't already active
if ( session_status() === PHP_SESSION_NONE ) {
	session_start();
}

require_once( 'data/config.php' );
require_once( 'data/functions.php' );
$isLoggedIn = isset( $_SESSION['user'] );
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
						<h2 class="heading">Donate for Wcoins</h2>
						<p class="subheading">Support the server and get rewarded with WCoins. The standard rate is 10 WCoins for every $1 you donate.</p>
					</div>
					<div class="card shadow-sm donate-card">
						<div class="card-body">
							<form id="donateForm">
								<h5 class="card-title mb-3">1. Select a Donation Amount</h5>

								<!-- Predefined Options -->
								<div class="list-group mb-4 amount-options">
									<label class="list-group-item list-group-item-action">
										<div class="amount-label justify-content-center">
											<input class="form-check-input" type="radio" name="donation_amount" value="10" checked>
											<strong>$10.00 USD</strong>
										</div>
										<div class="wc-amount">100 <span>WCoins</span></div>
									</label>
									<label class="list-group-item list-group-item-action">
										<div class="amount-label justify-content-center">
											<input class="form-check-input" type="radio" name="donation_amount" value="15">
											<strong>$15.00 USD</strong>
										</div>
										<div class="wc-amount">150 <span>WCoins</span></div>
									</label>
									<label class="list-group-item list-group-item-action">
										<div class="amount-label justify-content-center">
											<input class="form-check-input" type="radio" name="donation_amount" value="20">
											<strong>$20.00 USD</strong>
										</div>
										<div class="wc-amount">200 <span>WCoins</span></div>
									</label>
									<label class="list-group-item list-group-item-action">
										<div class="amount-label justify-content-center">
											<input class="form-check-input" type="radio" name="donation_amount" value="custom">
											<strong>Custom Amount</strong>
										</div>
                                        <!-- Custom Amount Input -->
										<div class="input-group mb-3" id="customAmountWrapper" style="display: none;">
											<span class="input-group-text">$</span>
											<input type="number" class="form-control" id="custom_amount" name="custom_amount" placeholder="e.g., 50" min="25" step="5" value="25">
											<span class="input-group-text">.00 USD</span>
										</div>
										<div class="wc-amount custom-amount">250 <span>WCoins</span></div>
										
									</label>
								</div>



								<h5 class="card-title mt-4 mb-3">2. Select Payment Method</h5>

								<!-- Payment Method -->
								<div class="list-group mb-3 payment-methods">
									<label class="list-group-item list-group-item-action">
										<input class="form-check-input me-2" type="radio" name="payment_method" value="paypal" checked>
										PayPal
									</label>
									<label class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
										<div>
											<input class="form-check-input me-2" type="radio" name="payment_method" value="crypto">
											Cryptocurrency
										</div>
										<span class="badge bg-success rounded-pill">+10% Bonus WCoins</span>
									</label>
								</div>

								<!-- Donation Summary -->
								<div class="donation-summary my-4 p-3 rounded" style="background-color: #333;">
									<h4 class="text-center mb-3">Donation Summary</h4>
									<div class="h5 d-flex justify-content-between">
										<span>Amount:</span>
										<strong id="summaryAmount">$10.00 USD</strong>
									</div>
									<hr class="my-2">
									<h5 class="d-flex justify-content-between mb-0"><span>You will receive:</span> <strong id="wcoinResult" class="color-my-dark-accent">100 WCoins</strong></h5>
								</div>

								<!-- Submit Button -->
								<div class="d-grid">
									<?php if ( $isLoggedIn ) : ?>
										<button type="submit" class="btn btn-action highlight d-flex align-items-center justify-content-center gap-3">
											<div class="mb-0 text-light">Proceed to Payment</div>
											<div class="icon-holder text-light"><?php include 'data/images/icons/donate.svg' ?></div>
										</button>
									<?php else : ?>
										<a href="/login/" class="btn btn-secondary btn-lg d-flex align-items-center justify-content-center gap-3">
											Login to Donate
										</a>
									<?php endif; ?>
								</div>
							</form>
						</div>
					</div>

					<?php if ( $isLoggedIn ) : ?>
						<!-- Donation History -->
						<div class="section-header">
							<h2 class="heading">Donation History</h2>
						</div>
						<div class="card shadow-sm">
							<div class="card-body">
								<div id="donationHistoryContainer">
									<div class="text-center">
										<div class="spinner-border text-warning" role="status">
											<span class="visually-hidden">Loading...</span>
										</div>
										<p class="mt-2 text-muted">Loading donation history...</p>
									</div>
								</div>
							</div>
						</div>
					<?php endif; ?>
				</section>

			</main>
		</div>
	</div>

	<script>
		document.addEventListener('DOMContentLoaded', function () {
			const isLoggedIn = <?php echo json_encode( $isLoggedIn ); ?>;
			const form = document.getElementById('donateForm');
			const customAmountWrapper = document.getElementById('customAmountWrapper');
			const customAmountInput = document.getElementById('custom_amount');
			const customAmountDisplay = document.querySelector('.wc-amount.custom-amount');
			const wcoinResult = document.getElementById('wcoinResult');
			const summaryAmount = document.getElementById('summaryAmount');
			const baseRate = 10; // 10 WCoins per $1
			const cryptoBonus = 0.10; // 10% bonus

			function updateWCoins() {
				const selectedAmountRadio = form.querySelector('input[name="donation_amount"]:checked');
				const selectedAmountOption = selectedAmountRadio.value;
				const selectedPaymentMethodRadio = form.querySelector('input[name="payment_method"]:checked');
				const selectedPaymentMethod = selectedPaymentMethodRadio.value;
				let amount = 25;

				// Remove 'active' class from all amount options
				document.querySelectorAll('.amount-options .list-group-item').forEach(item => {
					item.classList.remove('active');
				});
				// Add 'active' class to the selected one
				selectedAmountRadio.closest('.list-group-item').classList.add('active');

				// Remove 'active' class from all payment options
				document.querySelectorAll('.payment-methods .list-group-item').forEach(item => {
					item.classList.remove('active');
				});
				// Add 'active' class to the selected one
				selectedPaymentMethodRadio.closest('.list-group-item').classList.add('active');

				// Update WCoin display for predefined amounts based on payment method
				document.querySelectorAll('.amount-options .list-group-item:not(:last-child)').forEach(item => {
					const radio = item.querySelector('input[type="radio"]');
					const wcAmountDiv = item.querySelector('.wc-amount');
					const baseAmount = parseFloat(radio.value);
					let displayWCoins = baseAmount * baseRate;

					if (selectedPaymentMethod === 'crypto') {
						displayWCoins += Math.floor(displayWCoins * cryptoBonus);
					}
					wcAmountDiv.innerHTML = displayWCoins.toLocaleString() + ' <span>WCoins</span>';
				});

				if (selectedAmountOption === 'custom') {
					customAmountWrapper.style.display = 'flex';
					amount = parseFloat(customAmountInput.value) || 25;
                    let customWCoins = amount * baseRate;
                    if (selectedPaymentMethod === 'crypto') {
                        customWCoins += Math.floor(customWCoins * cryptoBonus);
                    }
					customAmountDisplay.innerHTML = customWCoins.toLocaleString() + ' <span>WCoins</span>';
				} else {
					const twentyDollarWCoins = document.querySelector('input[name="donation_amount"][value="20"]').closest('.list-group-item').querySelector('.wc-amount').textContent.replace(' WCoins', '');
					customAmountWrapper.style.display = 'none';
					customAmountDisplay.innerHTML = '<span>more than</span> ' + twentyDollarWCoins + ' <span>WCoins</span>';
					amount = parseFloat(selectedAmountOption);
				}

				let wcoins = Math.floor(amount * baseRate);
				let finalAmount = amount;

				if (selectedPaymentMethod === 'crypto') {
					wcoins += Math.floor(wcoins * cryptoBonus);
				}

				wcoinResult.textContent = wcoins.toLocaleString() + ' WCoins';
				summaryAmount.textContent = '$' + finalAmount.toFixed(2) + ' USD';
			}

			form.addEventListener('change', updateWCoins);
			customAmountInput.addEventListener('input', updateWCoins);

			// Initial calculation on page load
			updateWCoins();

			if (isLoggedIn) {
				// Fetch and render donation history
				$.ajax({
					url: '/data/api/donation-history.php',
					type: 'GET',
					dataType: 'json',
					success: function (response) {
						const container = $('#donationHistoryContainer');
						if (response.success && response.donations.length > 0) {
							let tableHtml = `
								<div class="table-responsive">
									<table class="table table-striped table-hover">
										<thead>
											<tr>
												<th>Date</th>
												<th>Amount (USD)</th>
												<th>WCoins Received</th>
												<th>Method</th>
											</tr>
										</thead>
										<tbody>`;

							response.donations.forEach(donation => {
								const date = new Date(donation.created_at).toISOString().slice(0, 16).replace('T', ' ');
								const amount = parseFloat(donation.amount_usd).toFixed(2);
								const wcoins = parseInt(donation.wcoins_received).toLocaleString();
								const method = donation.payment_method.charAt(0).toUpperCase() + donation.payment_method.slice(1);

								tableHtml += `
									<tr>
										<td>${date}</td>
										<td>$${amount}</td>
										<td>${wcoins}</td>
										<td>${method}</td>
									</tr>`;
							});

							tableHtml += `</tbody></table></div>`;
							container.html(tableHtml);
						} else {
							container.html('<p class="text-center text-muted mb-0">You have no donation history.</p>');
						}
					},
					error: function () {
						$('#donationHistoryContainer').html('<p class="text-center text-danger mb-0">Could not load donation history. Please try again later.</p>');
					}
				});
			}
		});
	</script>
</body>

</html>