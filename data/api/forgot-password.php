<?php
header( 'Content-Type: application/json' );
require_once '../functions.php';

if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
	$username = trim( $_POST['username'] ?? '' );

	if ( ! $pdo ) {
		// We send a generic success response even on DB error to prevent info leaks.
		// You might want to log this error for administrative review.
		error_log( "Forgot Password API: Database connection failed." );
		echo json_encode( [ 'success' => true ] ); // Obfuscate DB status from user
		exit;
	}

	list( $success, $dataOrError ) = requestPasswordReset( $pdo, $username );

	if ( $success ) {
		if ( ! empty( $dataOrError['token'] ) && ! empty( $dataOrError['email'] ) ) {
			$token = $dataOrError['token'];
			$email = $dataOrError['email'];
			$resetLink = "https://hexmu.com/reset-password/?token=" . urlencode( $token );

			$subject = "Password Reset Request for HexMU";
			$message = "Hello {$username},

            A password reset was requested for your HexMU account.
            Click the link below to set a new password:
            $resetLink

            This link will expire in 1 hour. If you did not request this, please ignore this email.";

			// Use the new SMTP mail function
			sendSmtpMail( $email, $subject, $message );
		}
		// Always return a generic success message to prevent email enumeration.
		echo json_encode( [ 'success' => true ] );
	} else {
		// This case is for internal errors like token generation failure.
		// It's safer to also return a generic success message here and log the real error.
		error_log( "Forgot Password API Error: " . ( $dataOrError['error'] ?? 'Unknown error' ) );
		echo json_encode( [ 'success' => true ] ); // Obfuscate internal errors from user
	}
} else {
	http_response_code( 405 ); // Method Not Allowed
	echo json_encode( [ 'success' => false, 'error' => 'Invalid request method.' ] );
}
