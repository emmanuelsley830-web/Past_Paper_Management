<?php
require_once __DIR__ . '/../functions/actions.php';
if (current_user()) {
    redirect(current_user()['role'] . '/dashboard.php');
}
$pageTitle = 'Student Registration';
$courses = courses();
include BASE_PATH . '/includes/header.php';
?>
<div class="login-box">
  <div class="card content-card">
    <div class="card-header text-center py-4">
      <h1 class="h4 mb-0 fw-bold">Student Registration</h1>
      <p class="text-muted mb-0">Create your paper archive account</p>
    </div>
    <form action="<?= asset_url('auth/register_process.php') ?>" method="post" class="card-body">
      <?= csrf_field() ?>
      <div class="mb-3"><label class="form-label">Full name</label><input name="fullname" class="form-control" required></div>
      <div class="mb-3"><label class="form-label">Course</label><select name="course_id" class="form-select" required><option value="">Select course</option><?php foreach ($courses as $course): ?><option value="<?= (int)$course['id'] ?>"><?= e($course['course_code'] . ' - ' . $course['course_name']) ?></option><?php endforeach; ?></select></div>
      <div class="mb-3"><label class="form-label">Year</label><input type="number" name="academic_year" min="1990" max="<?= (int)date('Y') + 1 ?>" class="form-control" required></div>
      <div class="mb-3"><label class="form-label">Email</label><input type="email" name="email" class="form-control" required></div>
      <div class="mb-3"><label class="form-label">Password</label><input type="password" name="password" class="form-control" minlength="8" required></div>
      <div class="mb-3"><label class="form-label">Confirm password</label><input type="password" name="confirm_password" class="form-control" minlength="8" required></div>
      <button class="btn btn-primary w-100" type="submit"><i class="fa-solid fa-user-plus me-2"></i>Register</button>
      <div class="text-center mt-3"><a href="<?= asset_url('auth/login.php') ?>">Back to login</a></div>
    </form>
  </div>
</div>
<?php include BASE_PATH . '/includes/footer.php'; ?>
