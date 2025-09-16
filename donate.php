<?php
// Start the session only if one isn't already active
if ( session_status() === PHP_SESSION_NONE ) {
	session_start();
}

require_once( 'data/config.php' );
require_once( 'data/functions.php' );
$isLoggedIn = isset($_SESSION['user']);
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
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <form id="donateForm">
                                <h5 class="card-title mb-3">1. Select a Donation Amount</h5>
                                
                                <!-- Predefined Options -->
                                <div class="list-group mb-4">
                                    <label class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                        <div>
                                            <input class="form-check-input me-2" type="radio" name="donation_amount" value="10" checked>
                                            <strong>$10.00 USD</strong>
                                        </div>
                                        <span class="badge bg-warning text-dark rounded-pill">100 WCoins</span>
                                    </label>
                                    <label class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                        <div>
                                            <input class="form-check-input me-2" type="radio" name="donation_amount" value="15">
                                            <strong>$15.00 USD</strong>
                                        </div>
                                        <span class="badge bg-warning text-dark rounded-pill">150 WCoins</span>
                                    </label>
                                    <label class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                        <div>
                                            <input class="form-check-input me-2" type="radio" name="donation_amount" value="20">
                                            <strong>$20.00 USD</strong>
                                        </div>
                                        <span class="badge bg-warning text-dark rounded-pill">200 WCoins</span>
                                    </label>
                                    <label class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                        <div>
                                            <input class="form-check-input me-2" type="radio" name="donation_amount" value="custom">
                                            <strong>Custom Amount</strong>
                                        </div>
                                    </label>
                                </div>

                                <!-- Custom Amount Input -->
                                <div class="input-group mb-3" id="customAmountWrapper" style="display: none;">
                                    <span class="input-group-text">$</span>
                                    <input type="number" class="form-control" id="custom_amount" name="custom_amount" placeholder="e.g., 50" min="5" step="1">
                                    <span class="input-group-text">.00 USD</span>
                                </div>

                                <h5 class="card-title mt-4 mb-3">2. Select Payment Method</h5>

                                <!-- Payment Method -->
                                <div class="list-group mb-3">
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

                                <!-- Summary -->
                                <div class="text-center my-4">
                                    <h4>You will receive: <span id="wcoinResult" class="color-my-dark-accent">100 WCoins</span></h4>
                                </div>

                                <!-- Submit Button -->
                                <div class="d-grid">
                                    <?php if ($isLoggedIn): ?>
                                        <button type="submit" class="btn btn-action highlight d-flex align-items-center justify-content-center gap-3">
                                            <div class="mb-0 text-light">Proceed to Payment</div>
                                            <div class="icon-holder text-light"><?php include 'data/images/icons/donate.svg' ?></div>
                                        </button>
                                    <?php else: ?>
                                        <a href="/login/" class="btn btn-secondary btn-lg d-flex align-items-center justify-content-center gap-3">
                                            Login to Donate
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </form>
                        </div>
                    </div>

                    <?php if ($isLoggedIn): ?>
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
            const isLoggedIn = <?php echo json_encode($isLoggedIn); ?>;
            const form = document.getElementById('donateForm');
            const customAmountWrapper = document.getElementById('customAmountWrapper');
            const customAmountInput = document.getElementById('custom_amount');
            const wcoinResult = document.getElementById('wcoinResult');
            const baseRate = 10; // 10 WCoins per $1
            const cryptoBonus = 0.10; // 10% bonus

            function updateWCoins() {
                const selectedAmountOption = form.querySelector('input[name="donation_amount"]:checked').value;
                const selectedPaymentMethod = form.querySelector('input[name="payment_method"]:checked').value;
                let amount = 0;

                if (selectedAmountOption === 'custom') {
                    customAmountWrapper.style.display = 'flex';
                    amount = parseFloat(customAmountInput.value) || 0;
                } else {
                    customAmountWrapper.style.display = 'none';
                    amount = parseFloat(selectedAmountOption);
                }

                let wcoins = Math.floor(amount * baseRate);

                if (selectedPaymentMethod === 'crypto') {
                    wcoins += Math.floor(wcoins * cryptoBonus);
                }

                wcoinResult.textContent = wcoins.toLocaleString() + ' WCoins';
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
                    success: function(response) {
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
                    error: function() {
                        $('#donationHistoryContainer').html('<p class="text-center text-danger mb-0">Could not load donation history. Please try again later.</p>');
                    }
                });
            }
        });
    </script>
</body>

</html>