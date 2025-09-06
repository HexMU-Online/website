<!DOCTYPE html>
<html lang="en">
  <head>
    <?php include 'data/includes.php'; ?>
    <title>Login - HexMU Online Private Server</title>
    <meta name="description" content="Login to your HexMU account">
    <meta name="keywords" content="HexMU, login, account">
  </head>
  <body>
    <?php include 'data/nav.php'; ?>

    <div class="container d-flex justify-content-center align-items-center" id="login">
      <div class="card shadow-lg rounded-3" style="max-width: 450px; width: 100%;">
        <div class="card-body py-4" style="padding-left: 2rem; padding-right: 2rem;">
          <h3 class="text-center mb-4">Login to HexMU</h3>
          <div id="loginMessage" class="mb-3"></div>

          <form id="loginForm" autocomplete="off">
            <!-- Username -->
            <div class="mb-3">
              <label for="username" class="form-label">Username</label>
              <input type="text" class="form-control" id="username" name="username" required>
            </div>

            <!-- Password -->
            <div class="mb-3">
              <label for="password" class="form-label">Password</label>
              <input type="password" class="form-control" id="password" name="password" required>
            </div>

            <!-- Submit -->
            <div class="d-grid mb-3 mt-5">
              <button type="submit" id="loginBtn" class="btn btn-secondary btn-lg">Login</button>
            </div>

            <!-- Links -->
            <div class="text-center">
              <a href="/register/">Don't have an account? Register</a><br>
              <a href="/forgot-password/">Forgot your password?</a>
            </div>
          </form>
        </div>
      </div>
    </div>

    <script>
      const loginBtn = document.getElementById("loginBtn");
      const username = document.getElementById("username");
      const password = document.getElementById("password");

      function validateLoginForm() {
        const userOk = username.value.length >= 3;
        const passOk = password.value.length >= 3;
        const formValid = userOk && passOk;
        loginBtn.disabled = !formValid;
        loginBtn.classList.toggle('btn-warning', formValid);
      }

      username.addEventListener("input", validateLoginForm);
      password.addEventListener("input", validateLoginForm);
    </script>
  </body>
</html>
