<?php
require_once __DIR__ . '/../functions/actions.php';
require_role(['student']);
$pageTitle = 'Student Dashboard';
$courses = courses();
$recent = paper_query();
$recent = array_slice($recent, 0, 8);
include BASE_PATH . '/includes/page_start.php';
?>
<div class="row g-3">
  <div class="col-md-4"><div class="small-box text-bg-primary"><div class="inner"><h3><?= count_table('past_papers') ?></h3><p>Available Papers</p></div><i class="small-box-icon fa-solid fa-file-pdf"></i></div></div>
  <div class="col-md-4"><div class="small-box text-bg-success"><div class="inner"><h3><?= count_table('courses') ?></h3><p>Courses</p></div><i class="small-box-icon fa-solid fa-book"></i></div></div>
  <div class="col-md-4"><div class="small-box text-bg-warning"><div class="inner"><h3><?= count_table('departments') ?></h3><p>Departments</p></div><i class="small-box-icon fa-solid fa-building-columns"></i></div></div>
</div>
<div class="card content-card">
  <div class="card-header"><h3 class="card-title">Find Past Papers</h3></div>
  <div class="card-body">
    <form action="<?= asset_url('student/papers.php') ?>" method="get" class="paper-toolbar">
      <input name="q" class="form-control" placeholder="Course, code, or title">
      <select name="course_id" class="form-select"><option value="">All courses</option><?php foreach ($courses as $c): ?><option value="<?= (int)$c['id'] ?>"><?= e($c['course_code']) ?></option><?php endforeach; ?></select>
      <input name="year" type="number" class="form-control" placeholder="Year">
      <select name="semester" class="form-select"><option value="">Semester</option><option>I</option><option>II</option><option>III</option></select>
      <button class="btn btn-primary"><i class="fa-solid fa-magnifying-glass me-1"></i>Search</button>
    </form>
  </div>
</div>
<div class="card content-card">
  <div class="card-header"><h3 class="card-title">Recent Papers</h3></div>
  <div class="card-body table-responsive">
    <table class="table table-hover"><thead><tr><th>Title</th><th>Course</th><th>Year</th><th>Download</th></tr></thead><tbody>
      <?php foreach ($recent as $paper): ?><tr><td><?= e($paper['title']) ?></td><td><?= e($paper['course_code']) ?></td><td><?= e($paper['year']) ?></td><td><a class="btn btn-success btn-sm" href="<?= asset_url('student/download.php?id=' . (int)$paper['id']) ?>"><i class="fa-solid fa-download me-1"></i>Download</a></td></tr><?php endforeach; ?>
    </tbody></table>
  </div>
</div>
<?php include BASE_PATH . '/includes/page_end.php'; ?>

