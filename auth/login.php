<?php
require_once __DIR__ . '/../includes/bootstrap.php';
if (current_user()) {
    redirect(current_user()['role'] . '/dashboard.php');
}
$pageTitle = 'Login';
include BASE_PATH . '/includes/header.php';
?>
<div class="login-box">
  <div class="card content-card">
    <div class="card-header text-center py-4">
      <h1 class="h4 mb-0 fw-bold"><?= e(APP_NAME) ?></h1>
      <p class="text-muted mb-0">Central academic paper archive</p>
    </div>
    <form action="<?= asset_url('auth/process_login.php') ?>" method="post" class="card-body needs-validation" novalidate>
      <?= csrf_field() ?>
      <div class="mb-3">
        <label class="form-label">Email address</label>
        <div class="input-group">
          <span class="input-group-text"><i class="fa-solid fa-envelope"></i></span>
          <input type="email" name="email" class="form-control" required autofocus>
        </div>
      </div>
      <div class="mb-3">
        <label class="form-label">Password</label>
        <div class="input-group">
          <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
          <input type="password" name="password" class="form-control" required>
        </div>
      </div>
      <button class="btn btn-primary w-100" type="submit"><i class="fa-solid fa-right-to-bracket me-2"></i>Login</button>
      <div class="text-center mt-3">
        <a href="<?= asset_url('student/register.php') ?>">Create student account</a>
      </div>
    </form>
  </div>
</div>
<?php include BASE_PATH . '/includes/footer.php'; ?>
