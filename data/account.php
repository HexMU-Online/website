<?php
$registerSuccess = false;
$registerError = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $email = trim($_POST['email'] ?? '');

    if (!$pdo) {
        $registerError = 'Cannot register: database offline.';
    } else {
        list($registerSuccess, $registerError) = register($pdo, $username, $password, $email);
    }
}
?>
<!-- Register Modal -->
<div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="post" action="">
        <div class="modal-header">
          <h5 class="modal-title" id="registerModalLabel">Register</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <?php if ($registerSuccess): ?>
            <div class="alert alert-success" role="alert">
              Registration successful! You can now log in.
            </div>
          <?php elseif ($registerError): ?>
            <div class="alert alert-danger" role="alert">
              <?php echo htmlspecialchars($registerError); ?>
            </div>
          <?php endif; ?>
          <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" name="username" maxlength="10" required value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>">
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" maxlength="10" required>
          </div>
          <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" required value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary w-100">Register</button>
        </div>
      </form>
    </div>
  </div>
</div>
<?php if ($registerError): ?>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    var registerModal = new bootstrap.Modal(document.getElementById('registerModal'));
    registerModal.show();
  });
</script>
<?php endif; ?>
