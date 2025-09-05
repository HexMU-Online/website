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
                    $('#registerMessage').html('<div class="alert alert-success" role="alert">Registration successful! You can now log in.</div>');
                    $('#registerForm')[0].reset();
                } else {
                    $('#registerMessage').html('<div class="alert alert-danger" role="alert">' + response.error + '</div>');
                }
            },
            error: function() {
                $('#registerMessage').html('<div class="alert alert-danger" role="alert">Registration failed. Please try again later.</div>');
            }
        });
    });
});