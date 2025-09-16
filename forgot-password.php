<!DOCTYPE html>
<html lang="en">
  <head>
    <?php include 'data/includes.php'; ?>
    <title>Forgot Password - HexMU Online Private Server</title>
    <meta name="description" content="Reset your HexMU account password">
    <meta name="keywords" content="HexMU, forgot password, reset password">
  </head>
  <body>
    <?php include 'data/nav.php'; ?>

    <div class="container d-flex justify-content-center align-items-center" id="forgot-password">
      <div class="card shadow-lg rounded-3" style="max-width: 450px; width: 100%;">
        <div class="card-body py-4" style="padding-left: 2rem; padding-right: 2rem;">
          <h3 class="text-center mb-4">Forgot Password</h3>
          <p class="text-center small mb-4">Enter your username and we will send a reset link to your registered email address.</p>
          <div id="forgotPasswordMessage" class="mb-3"></div>

          <form id="forgotPasswordForm" autocomplete="off">
            <!-- Username -->
            <div class="mb-3">
              <label for="username" class="form-label">Username</label>
              <input type="text" class="form-control" id="username" name="username" required minlength="3" maxlength="10">
            </div>

            <!-- Submit -->
            <div class="d-grid mb-3 mt-4">
              <button type="submit" id="resetBtn" class="btn btn-secondary btn-lg" disabled>Send Reset Link</button>
            </div>

            <!-- Links -->
            <div class="text-center">
              <a href="/login/">Remember your password? Login</a>
            </div>
          </form>
        </div>
      </div>
    </div>

    <script>
      const resetBtn = document.getElementById("resetBtn");
      const username = document.getElementById("username");

      username.addEventListener("input", () => {
        resetBtn.disabled = !username.validity.valid;
        resetBtn.classList.toggle('btn-warning', username.validity.valid);
      });
    </script>
  </body>
</html>