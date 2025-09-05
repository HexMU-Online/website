<!DOCTYPE html>
<html lang="en">
  <head>
    <?php include 'data/includes.php'; ?>
    <title>Create Account - HexMU Online Private Server</title>
    <meta name="description" content="Testing stuff">
    <meta name="keywords" content="tag 1, tag 2">
  </head>
  <body>
    <?php include 'data/nav.php'; ?>

    <div class="container d-flex justify-content-center align-items-center" id="register">
      <div class="card shadow-lg rounded-3" style="max-width: 450px; width: 100%;">
        <div class="card-body py-4" style="padding-left: 2rem; padding-right: 2rem;">
          <h3 class="text-center mb-4">Create HexMU Account</h3>
          <div id="registerMessage" class="mb-3"></div>

          <form id="registerForm" autocomplete="off">
            <!-- Username -->
            <div class="mb-3">
              <label for="username" class="form-label">Username</label>
              <input type="text" class="form-control" id="username" name="username" maxlength="10" required>
            </div>

            <!-- Password -->
            <div class="mb-3">
              <label for="password" class="form-label">Password</label>
              <input type="password" class="form-control" id="password" name="password" required>
            </div>

            <!-- Retype Password -->
            <div class="mb-3">
              <label for="repassword" class="form-label">Retype Password</label>
              <input type="password" class="form-control" id="repassword" name="repassword" required>
              <div id="matchText" class="small mt-1"></div>
            </div>

            <!-- Email -->
            <div class="mb-3">
              <label for="email" class="form-label">Email Address</label>
              <input type="email" class="form-control" id="email" name="email" required>
            </div>

            <!-- Terms -->
            <div class="form-check mb-3">
              <input class="form-check-input" type="checkbox" id="terms" name="terms" required>
              <label class="form-check-label" for="terms">
                I agree to the <a href="#">Terms & Conditions</a>
              </label>
            </div>

            <!-- Submit -->
            <div class="d-grid mb-3">
              <button type="submit" id="registerBtn" class="btn btn-secondary btn-lg" disabled>Register</button>
            </div>

            <!-- Links -->
            <div class="text-center">
              <a href="/login/">Already have an account? Login</a>
            </div>
          </form>
        </div>
      </div>
    </div>

    <script>
      const password = document.getElementById("password");
      const repassword = document.getElementById("repassword");
      const matchText = document.getElementById("matchText");
      const registerBtn = document.getElementById("registerBtn");
      const terms = document.getElementById("terms");
      const email = document.getElementById("email");
      const username = document.getElementById("username");

      function checkMatch() {
        if (repassword.value && repassword.value === password.value) {
          matchText.textContent = "✅ Passwords match";
          matchText.className = "small text-success mt-1";
          return true;
        } else if (repassword.value) {
          matchText.textContent = "❌ Passwords do not match";
          matchText.className = "small text-danger mt-1";
          return false;
        } else {
          matchText.textContent = "";
          return false;
        }
      }

      function validateForm() {
        const matchOk = checkMatch();
        const termsOk = terms.checked;
        const emailOk = email.validity.valid;
        const userOk = username.value.length >= 3;
        const passOk = password.value.length >= 3;

        const formValid = matchOk && termsOk && emailOk && userOk && passOk;
        registerBtn.disabled = !formValid;
        registerBtn.classList.toggle('btn-warning', formValid);
      }

      password.addEventListener("input", validateForm);
      repassword.addEventListener("input", validateForm);
      terms.addEventListener("change", validateForm);
      email.addEventListener("input", validateForm);
      username.addEventListener("input", validateForm);
    </script>
  </body>
</html>
