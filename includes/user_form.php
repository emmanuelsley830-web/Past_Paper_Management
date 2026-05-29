<div class="modal-header"><h5 class="modal-title"><?= empty($u['id']) ? 'Add Lecturer' : 'Edit User' ?></h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
<div class="modal-body row g-3">
  <div class="col-md-6"><label class="form-label">Full name</label><input name="fullname" class="form-control" value="<?= e($u['fullname']) ?>" required></div>
  <div class="col-md-6"><label class="form-label">Email</label><input type="email" name="email" class="form-control" value="<?= e($u['email']) ?>" required></div>
  <?php if (empty($u['id'])): ?><div class="col-md-6"><label class="form-label">Password</label><input type="password" name="password" class="form-control" minlength="8" required></div><?php endif; ?>
  <?php if (empty($u['id'])): ?>
    <input type="hidden" name="role" value="lecturer">
  <?php else: ?>
    <div class="col-md-6"><label class="form-label">Role</label><select name="role" class="form-select" required><?php foreach (['admin','lecturer','student'] as $role): ?><option value="<?= e($role) ?>" <?= $u['role']===$role?'selected':'' ?>><?= e(ucfirst($role)) ?></option><?php endforeach; ?></select></div>
  <?php endif; ?>
  <div class="col-md-6"><label class="form-label">Department</label><select name="department_id" class="form-select"><option value="">None</option><?php foreach ($departments as $d): ?><option value="<?= (int)$d['id'] ?>" <?= (string)$u['department_id']===(string)$d['id']?'selected':'' ?>><?= e($d['department_name']) ?></option><?php endforeach; ?></select></div>
  <?php if (!empty($u['id']) && $u['role'] === 'student'): ?>
    <div class="col-md-6"><label class="form-label">Course</label><select name="course_id" class="form-select"><option value="">None</option><?php foreach ($courses as $c): ?><option value="<?= (int)$c['id'] ?>" <?= (string)($u['course_id'] ?? '')===(string)$c['id']?'selected':'' ?>><?= e($c['course_code'] . ' - ' . $c['course_name']) ?></option><?php endforeach; ?></select></div>
    <div class="col-md-6"><label class="form-label">Year</label><input type="number" name="academic_year" class="form-control" value="<?= e($u['academic_year'] ?? '') ?>"></div>
  <?php else: ?>
    <input type="hidden" name="course_id" value="<?= e($u['course_id'] ?? '') ?>">
    <input type="hidden" name="academic_year" value="<?= e($u['academic_year'] ?? '') ?>">
  <?php endif; ?>
  <div class="col-md-6"><label class="form-label">Status</label><select name="status" class="form-select"><?php foreach (['active','inactive'] as $status): ?><option value="<?= e($status) ?>" <?= $u['status']===$status?'selected':'' ?>><?= e(ucfirst($status)) ?></option><?php endforeach; ?></select></div>
</div>
<div class="modal-footer"><button class="btn btn-primary">Save User</button></div>
