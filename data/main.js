$(document).ready(function() {
    $.getJSON('/data/api/online.php', function(data) {
        $('.online').each(function() {
            $(this).text(data.status);
            $(this).removeClass('bg-danger bg-success');
            if (data.status === 'Offline') {
                $(this).addClass('bg-danger');
            } else {
                $(this).addClass('bg-success');
            }
        });
    });

    $('#registerForm').on('submit', function(e) {
        e.preventDefault();
        $('#registerMessage').html('');
        $.ajax({
            url: '/data/api/register.php',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    $('#registerMessage').html('<div class="alert alert-success" role="alert">Registration successful! Redirecting...</div>');
                    $('#registerForm')[0].reset();
                    setTimeout(() => {
                        window.location.href = '/dashboard/';
                    }, 100);
                } else {
                    $('#registerMessage').html('<div class="alert alert-danger" role="alert">' + response.error + '</div>');
                }
            },
            error: function() {
                $('#registerMessage').html('<div class="alert alert-danger" role="alert">Registration failed. Please try again later.</div>');
            }
        });
    });

    $('#loginForm').on('submit', function(e) {
        e.preventDefault();
        $('#loginMessage').html('');
        $.ajax({
            url: '/data/api/login.php',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    $('#loginMessage').html('<div class="alert alert-success" role="alert">Login successful! Redirecting...</div>');
                    setTimeout(() => {
                        window.location.href = '/dashboard/';
                    }, 100);
                } else {
                    $('#loginMessage').html('<div class="alert alert-danger" role="alert">' + response.error + '</div>');
                }
            },
            error: function() {
                $('#loginMessage').html('<div class="alert alert-danger" role="alert">Login failed. Please try again later.</div>');
            }
        });
    });

    $('#forgotPasswordForm').on('submit', function(e) {
        e.preventDefault();
        $('#forgotPasswordMessage').html('');
        $('#resetBtn').prop('disabled', true).text('Sending...');

        $.ajax({
            url: '/data/api/forgot-password.php',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    $('#forgotPasswordMessage').html('<div class="alert alert-success" role="alert">If an account with that email exists, a password reset link has been sent.</div>');
                    $('#forgotPasswordForm')[0].reset();
                } else {
                    $('#forgotPasswordMessage').html('<div class="alert alert-danger" role="alert">' + (response.error || 'An unexpected error occurred.') + '</div>');
                }
            },
            error: function() {
                $('#forgotPasswordMessage').html('<div class="alert alert-danger" role="alert">Could not send reset link. Please try again later.</div>');
            },
            complete: function() {
                $('#resetBtn').prop('disabled', false).text('Send Reset Link');
                // Re-validate to set button state correctly after form reset
                const username = document.getElementById("username");
                const resetBtn = document.getElementById("resetBtn");
                resetBtn.disabled = !username.validity.valid;
                resetBtn.classList.toggle('btn-warning', username.validity.valid);
            }
        });
    });

    $('#resetPasswordForm').on('submit', function(e) {
        e.preventDefault();
        $('#resetPasswordMessage').html('');
        $('#updatePasswordBtn').prop('disabled', true).text('Updating...');

        $.ajax({
            url: '/data/api/reset-password.php',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    $('#resetPasswordMessage').html('<div class="alert alert-success" role="alert">' + response.message + '</div>');
                    $('#resetPasswordForm').hide();
                    // Optionally, add a link to the login page
                    $('#resetPasswordMessage').after('<div class="text-center mt-3"><a href="/login/" class="btn btn-primary">Go to Login</a></div>');
                } else {
                    $('#resetPasswordMessage').html('<div class="alert alert-danger" role="alert">' + (response.error || 'An unexpected error occurred.') + '</div>');
                }
            },
            error: function() {
                $('#resetPasswordMessage').html('<div class="alert alert-danger" role="alert">Could not update password. Please try again later.</div>');
            },
            complete: function() {
                // Don't re-enable the button on success, as the form is hidden
                if (!$('#resetPasswordForm').is(':hidden')) {
                    $('#updatePasswordBtn').prop('disabled', false).text('Update Password');
                }
            }
        });
    });

    //if loginMessage div is on page & logout parameter is set, show this message
    if ($('#loginMessage').length) {
        const params = new URLSearchParams(window.location.search);
        if (params.has('logout')) {
            $('#loginMessage').html(
                '<div class="alert alert-success" role="alert">You\'ve been successfully logged out.</div>'
            );
        }
    }

});