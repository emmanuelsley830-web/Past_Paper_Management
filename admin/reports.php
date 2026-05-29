<?php
require_once __DIR__ . '/../functions/actions.php';
require_role(['admin']);
$pageTitle = 'Reports';
$byCourse = db()->query('SELECT c.course_code, c.course_name, COUNT(p.id) total FROM courses c LEFT JOIN past_papers p ON p.course_id=c.id GROUP BY c.id ORDER BY total DESC')->fetchAll();
$byUser = db()->query("SELECT u.fullname, u.role, COUNT(p.id) total FROM users u LEFT JOIN past_papers p ON p.uploaded_by=u.id WHERE u.role IN ('admin','lecturer') GROUP BY u.id ORDER BY total DESC")->fetchAll();
$logs = db()->query('SELECT l.*, u.fullname FROM activity_logs l LEFT JOIN users u ON u.id=l.user_id ORDER BY l.created_at DESC LIMIT 50')->fetchAll();
include BASE_PATH . '/includes/page_start.php';
?>
<div class="row g-3">
  <div class="col-lg-6">
    <div class="card content-card"><div class="card-header"><h3 class="card-title">Papers by Course</h3></div><div class="card-body table-responsive"><table class="table table-striped datatable"><thead><tr><th>Course</th><th>Name</th><th>Total</th></tr></thead><tbody><?php foreach ($byCourse as $row): ?><tr><td><?= e($row['course_code']) ?></td><td><?= e($row['course_name']) ?></td><td><?= e($row['total']) ?></td></tr><?php endforeach; ?></tbody></table></div></div>
  </div>
  <div class="col-lg-6">
    <div class="card content-card"><div class="card-header"><h3 class="card-title">Uploads by Staff</h3></div><div class="card-body table-responsive"><table class="table table-striped datatable"><thead><tr><th>Name</th><th>Role</th><th>Total</th></tr></thead><tbody><?php foreach ($byUser as $row): ?><tr><td><?= e($row['fullname']) ?></td><td><?= e($row['role']) ?></td><td><?= e($row['total']) ?></td></tr><?php endforeach; ?></tbody></table></div></div>
  </div>
</div>
<div class="card content-card mt-3"><div class="card-header"><h3 class="card-title">Activity Logs</h3></div><div class="card-body table-responsive"><table class="table table-striped datatable"><thead><tr><th>User</th><th>Activity</th><th>Date</th></tr></thead><tbody><?php foreach ($logs as $log): ?><tr><td><?= e($log['fullname'] ?? 'System') ?></td><td><?= e($log['activity']) ?></td><td><?= e($log['created_at']) ?></td></tr><?php endforeach; ?></tbody></table></div></div>
<?php include BASE_PATH . '/includes/page_end.php'; ?>

