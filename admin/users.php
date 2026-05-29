<?php
require_once __DIR__ . '/../functions/actions.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') handle_user_action();
require_role(['admin']);
$pageTitle = 'Users';
$departments = departments();
$courses = courses();
$users = db()->query('SELECT u.*, d.department_name, c.course_code FROM users u LEFT JOIN departments d ON d.id=u.department_id LEFT JOIN courses c ON c.id=u.course_id ORDER BY u.created_at DESC')->fetchAll();
include BASE_PATH . '/includes/page_start.php';
?>
<div class="card content-card">
  <div class="card-header d-flex align-items-center"><h3 class="card-title">User Management</h3><button class="btn btn-primary btn-sm ms-auto" data-bs-toggle="modal" data-bs-target="#createModal"><i class="fa-solid fa-user-plus me-1"></i>Add Lecturer</button></div>
  <div class="card-body table-responsive">
    <table class="table table-striped datatable"><thead><tr><th>Name</th><th>Email</th><th>Role</th><th>Department</th><th>Course</th><th>Year</th><th>Status</th><th>Actions</th></tr></thead><tbody>
    <?php foreach ($users as $u): ?><tr><td><?= e($u['fullname']) ?></td><td><?= e($u['email']) ?></td><td><span class="badge text-bg-info"><?= e($u['role']) ?></span></td><td><?= e($u['department_name'] ?? '-') ?></td><td><?= e($u['course_code'] ?? '-') ?></td><td><?= e($u['academic_year'] ?? '-') ?></td><td><?= e($u['status']) ?></td><td>
      <button class="btn btn-outline-primary btn-sm btn-icon" data-bs-toggle="modal" data-bs-target="#edit<?= (int)$u['id'] ?>"><i class="fa-solid fa-pen"></i></button>
      <button class="btn btn-outline-warning btn-sm btn-icon" data-bs-toggle="modal" data-bs-target="#reset<?= (int)$u['id'] ?>"><i class="fa-solid fa-key"></i></button>
      <form method="post" class="d-inline" data-confirm="Delete this user?"><?= csrf_field() ?><input type="hidden" name="action" value="delete"><input type="hidden" name="id" value="<?= (int)$u['id'] ?>"><button class="btn btn-outline-danger btn-sm btn-icon"><i class="fa-solid fa-trash"></i></button></form>
    </td></tr>
    <div class="modal fade" id="edit<?= (int)$u['id'] ?>" tabindex="-1"><div class="modal-dialog modal-lg"><form method="post" class="modal-content"><?= csrf_field() ?><input type="hidden" name="action" value="update"><input type="hidden" name="id" value="<?= (int)$u['id'] ?>"><?php include BASE_PATH . '/includes/user_form.php'; ?></form></div></div>
    <div class="modal fade" id="reset<?= (int)$u['id'] ?>" tabindex="-1"><div class="modal-dialog"><form method="post" class="modal-content"><?= csrf_field() ?><input type="hidden" name="action" value="reset_password"><input type="hidden" name="id" value="<?= (int)$u['id'] ?>"><div class="modal-header"><h5 class="modal-title">Reset Password</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div><div class="modal-body"><label class="form-label">New password</label><input type="password" name="new_password" class="form-control" minlength="8" required></div><div class="modal-footer"><button class="btn btn-warning">Reset</button></div></form></div></div>
    <?php endforeach; ?></tbody></table>
  </div>
</div>
<?php $u = ['fullname'=>'','email'=>'','role'=>'lecturer','department_id'=>'','course_id'=>'','academic_year'=>'','status'=>'active']; ?>
<div class="modal fade" id="createModal" tabindex="-1"><div class="modal-dialog modal-lg"><form method="post" class="modal-content"><?= csrf_field() ?><input type="hidden" name="action" value="create"><?php include BASE_PATH . '/includes/user_form.php'; ?></form></div></div>
<?php include BASE_PATH . '/includes/page_end.php'; ?>
