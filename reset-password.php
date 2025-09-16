<?php
$token = isset($_GET['token']) ? htmlspecialchars($_GET['token']) : '';
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <?php include 'data/includes.php'; ?>
    <title>Reset Password - HexMU Online Private Server</title>
    <meta name="description" content="Set a new password for your HexMU account.">
    <meta name="keywords" content="HexMU, reset password, new password">
  </head>
  <body>
    <?php include 'data/nav.php'; ?>

    <div class="container d-flex justify-content-center align-items-center" id="reset-password">
      <div class="card shadow-lg rounded-3" style="max-width: 450px; width: 100%;">
        <div class="card-body py-4" style="padding-left: 2rem; padding-right: 2rem;">
          <h3 class="text-center mb-4">Reset Your Password</h3>
          <p class="text-center small mb-4">Enter and confirm your new password below.</p>
          <div id="resetPasswordMessage" class="mb-3"></div>

          <form id="resetPasswordForm" autocomplete="off">
            <input type="hidden" name="token" value="<?php echo $token; ?>">

            <!-- New Password -->
            <div class="mb-3">
              <label for="password" class="form-label">New Password</label>
              <input type="password" class="form-control" id="password" name="password" required minlength="3" maxlength="10">
            </div>

            <!-- Confirm Password -->
            <div class="mb-3">
              <label for="confirm_password" class="form-label">Confirm New Password</label>
              <input type="password" class="form-control" id="confirm_password" name="confirm_password" required minlength="3" maxlength="10">
            </div>

            <!-- Submit -->
            <div class="d-grid mb-3 mt-4">
              <button type="submit" id="updatePasswordBtn" class="btn btn-secondary btn-lg" disabled>Update Password</button>
            </div>

             <!-- Links -->
            <div class="text-center">
              <a href="/forgot-password/">Your token expired? Resend a new token.</a>
            </div>
          </form>
        </div>
      </div>
    </div>

    <script>
      const password = document.getElementById("password");
      const confirm_password = document.getElementById("confirm_password");
      const updatePasswordBtn = document.getElementById("updatePasswordBtn");

      function validatePasswords() {
        const passwordsMatch = password.value === confirm_password.value;
        const passwordsValid = password.validity.valid && confirm_password.validity.valid;
        const canSubmit = passwordsMatch && passwordsValid;

        updatePasswordBtn.disabled = !canSubmit;
        updatePasswordBtn.classList.toggle('btn-warning', canSubmit);
      }

      password.addEventListener("input", validatePasswords);
      confirm_password.addEventListener("input", validatePasswords);
    </script>
  </body>
</html>
