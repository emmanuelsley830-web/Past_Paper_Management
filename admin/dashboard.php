<?php
require_once __DIR__ . '/../functions/actions.php';
require_role(['admin']);
$pageTitle = 'Admin Dashboard';
$recent = array_slice(paper_query(), 0, 8);
$logs = db()->query('SELECT l.*, u.fullname FROM activity_logs l LEFT JOIN users u ON u.id=l.user_id ORDER BY l.created_at DESC LIMIT 8')->fetchAll();
include BASE_PATH . '/includes/page_start.php';
?>
<div class="row g-3">
  <?php foreach ([
      ['Total Users', count_table('users'), 'fa-users', 'text-bg-primary'],
      ['Students', count_table('users', 'role=?', ['student']), 'fa-user-graduate', 'text-bg-success'],
      ['Lecturers', count_table('users', 'role=?', ['lecturer']), 'fa-chalkboard-user', 'text-bg-warning'],
      ['Papers', count_table('past_papers'), 'fa-file-pdf', 'text-bg-danger'],
  ] as [$label, $count, $icon, $class]): ?>
  <div class="col-12 col-sm-6 col-xl-3">
    <div class="small-box <?= e($class) ?>">
      <div class="inner"><h3><?= e((string)$count) ?></h3><p><?= e($label) ?></p></div>
      <i class="small-box-icon fa-solid <?= e($icon) ?>"></i>
    </div>
  </div>
  <?php endforeach; ?>
</div>
<div class="row g-3">
  <div class="col-lg-8">
    <div class="card content-card">
      <div class="card-header"><h3 class="card-title">Recent Uploads</h3></div>
      <div class="card-body table-responsive">
        <table class="table table-hover">
          <thead><tr><th>Title</th><th>Course</th><th>Year</th><th>Uploader</th></tr></thead>
          <tbody><?php foreach ($recent as $paper): ?><tr><td><?= e($paper['title']) ?></td><td><?= e($paper['course_code']) ?></td><td><?= e($paper['year']) ?></td><td><?= e($paper['uploader'] ?? 'System') ?></td></tr><?php endforeach; ?></tbody>
        </table>
      </div>
    </div>
  </div>
  <div class="col-lg-4">
    <div class="card content-card">
      <div class="card-header"><h3 class="card-title">Activity Overview</h3></div>
      <div class="list-group list-group-flush">
        <?php foreach ($logs as $log): ?><div class="list-group-item"><strong><?= e($log['fullname'] ?? 'System') ?></strong><br><span class="text-muted"><?= e($log['activity']) ?></span></div><?php endforeach; ?>
      </div>
    </div>
  </div>
</div>
<?php include BASE_PATH . '/includes/page_end.php'; ?>
