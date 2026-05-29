<?php
require_once __DIR__ . '/../functions/actions.php';
require_role(['student', 'admin', 'lecturer']);
$pageTitle = 'Search Papers';
$courses = courses();
$where = '1=1';
$params = [];
foreach (['course_id' => 'p.course_id', 'year' => 'p.year', 'semester' => 'p.semester', 'exam_type' => 'p.exam_type'] as $key => $column) {
    if (!empty($_GET[$key])) {
        $where .= " AND {$column} = ?";
        $params[] = $_GET[$key];
    }
}
if (!empty($_GET['q'])) {
    $where .= ' AND (p.title LIKE ? OR c.course_name LIKE ? OR c.course_code LIKE ?)';
    $like = '%' . $_GET['q'] . '%';
    array_push($params, $like, $like, $like);
}
$papers = paper_query($where, $params);
include BASE_PATH . '/includes/page_start.php';
?>
<div class="card content-card mb-3">
  <div class="card-header"><h3 class="card-title">Filters</h3></div>
  <div class="card-body">
    <form method="get" class="paper-toolbar">
      <input name="q" class="form-control" value="<?= e($_GET['q'] ?? '') ?>" placeholder="Course, code, or title">
      <select name="course_id" class="form-select"><option value="">All courses</option><?php foreach ($courses as $c): ?><option value="<?= (int)$c['id'] ?>" <?= (string)($_GET['course_id'] ?? '')===(string)$c['id']?'selected':'' ?>><?= e($c['course_code']) ?></option><?php endforeach; ?></select>
      <input name="year" type="number" class="form-control" value="<?= e($_GET['year'] ?? '') ?>" placeholder="Year">
      <select name="semester" class="form-select"><option value="">Semester</option><?php foreach (['I','II','III'] as $sem): ?><option <?= ($_GET['semester'] ?? '')===$sem?'selected':'' ?>><?= e($sem) ?></option><?php endforeach; ?></select>
      <select name="exam_type" class="form-select"><option value="">Exam type</option><?php foreach (['CAT','Midterm','Final','Supplementary','Other'] as $type): ?><option <?= ($_GET['exam_type'] ?? '')===$type?'selected':'' ?>><?= e($type) ?></option><?php endforeach; ?></select>
      <button class="btn btn-primary"><i class="fa-solid fa-filter me-1"></i>Apply</button>
    </form>
  </div>
</div>
<div class="card content-card">
  <div class="card-header"><h3 class="card-title">Paper Catalog</h3></div>
  <div class="card-body table-responsive">
    <table class="table table-striped datatable"><thead><tr><th>Title</th><th>Course</th><th>Department</th><th>Year</th><th>Semester</th><th>Type</th><th>Actions</th></tr></thead><tbody>
      <?php foreach ($papers as $paper): ?><tr><td><?= e($paper['title']) ?></td><td><?= e($paper['course_code'] . ' - ' . $paper['course_name']) ?></td><td><?= e($paper['department_name']) ?></td><td><?= e($paper['year']) ?></td><td><?= e($paper['semester']) ?></td><td><?= e($paper['exam_type']) ?></td><td><a target="_blank" class="btn btn-outline-secondary btn-sm" href="<?= asset_url('student/view.php?id=' . (int)$paper['id']) ?>"><i class="fa-solid fa-eye"></i></a> <a class="btn btn-success btn-sm" href="<?= asset_url('student/download.php?id=' . (int)$paper['id']) ?>"><i class="fa-solid fa-download"></i></a></td></tr><?php endforeach; ?>
    </tbody></table>
  </div>
</div>
<?php include BASE_PATH . '/includes/page_end.php'; ?>

