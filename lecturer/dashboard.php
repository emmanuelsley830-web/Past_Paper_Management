<?php
require_once __DIR__ . '/../functions/actions.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') handle_paper_action('lecturer/dashboard.php');
require_role(['lecturer']);
$pageTitle = 'Lecturer Dashboard';
$courses = courses();
$mine = paper_query('p.uploaded_by=?', [current_user()['id']]);
include BASE_PATH . '/includes/page_start.php';
?>
<div class="row g-3">
  <div class="col-lg-4"><div class="small-box text-bg-primary"><div class="inner"><h3><?= count($mine) ?></h3><p>My Uploads</p></div><i class="small-box-icon fa-solid fa-file-arrow-up"></i></div></div>
  <div class="col-lg-4"><div class="small-box text-bg-success"><div class="inner"><h3><?= count_table('courses') ?></h3><p>Available Courses</p></div><i class="small-box-icon fa-solid fa-book"></i></div></div>
  <div class="col-lg-4"><div class="small-box text-bg-warning"><div class="inner"><h3><?= count_table('past_papers', 'uploaded_by=? AND YEAR(created_at)=YEAR(CURRENT_DATE())', [current_user()['id']]) ?></h3><p>This Year</p></div><i class="small-box-icon fa-solid fa-calendar"></i></div></div>
</div>
<div class="card content-card">
  <div class="card-header"><h3 class="card-title">Upload Past Paper</h3></div>
  <form method="post" enctype="multipart/form-data" class="card-body row g-3"><?= csrf_field() ?><input type="hidden" name="action" value="create">
    <?php $paper = ['title'=>'','course_id'=>'','year'=>date('Y'),'semester'=>'I','exam_type'=>'Final','file_path'=>'']; ?>
    <div class="col-md-6"><label class="form-label">Title</label><input name="title" class="form-control" required></div>
    <div class="col-md-3"><label class="form-label">Year</label><input name="year" type="number" class="form-control" value="<?= date('Y') ?>" required></div>
    <div class="col-md-3"><label class="form-label">Semester</label><select name="semester" class="form-select"><option>I</option><option>II</option><option>III</option></select></div>
    <div class="col-md-6"><label class="form-label">Course</label><select name="course_id" class="form-select"><?php foreach ($courses as $c): ?><option value="<?= (int)$c['id'] ?>"><?= e($c['course_code'] . ' - ' . $c['course_name']) ?></option><?php endforeach; ?></select></div>
    <div class="col-md-3"><label class="form-label">Exam type</label><select name="exam_type" class="form-select"><option>CAT</option><option>Midterm</option><option>Final</option><option>Supplementary</option><option>Other</option></select></div>
    <div class="col-md-3"><label class="form-label">PDF</label><input type="file" name="paper_file" class="form-control" accept="application/pdf" required></div>
    <div class="col-12"><button class="btn btn-primary"><i class="fa-solid fa-upload me-1"></i>Upload</button></div>
  </form>
</div>
<?php include BASE_PATH . '/includes/page_end.php'; ?>

