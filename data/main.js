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