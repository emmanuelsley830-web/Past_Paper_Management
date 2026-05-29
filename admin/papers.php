<?php
require_once __DIR__ . '/../functions/actions.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') handle_paper_action('admin/papers.php');
require_role(['admin']);
$pageTitle = 'Papers';
$courses = courses();
$papers = paper_query();
include BASE_PATH . '/includes/page_start.php';
?>
<div class="card content-card">
  <div class="card-header d-flex align-items-center"><h3 class="card-title">Paper Management</h3><button class="btn btn-primary btn-sm ms-auto" data-bs-toggle="modal" data-bs-target="#createModal"><i class="fa-solid fa-upload me-1"></i>Upload Paper</button></div>
  <div class="card-body table-responsive">
    <table class="table table-striped datatable"><thead><tr><th>Title</th><th>Course</th><th>Year</th><th>Semester</th><th>Type</th><th>Uploader</th><th>Actions</th></tr></thead><tbody>
    <?php foreach ($papers as $paper): ?><tr><td><?= e($paper['title']) ?></td><td><?= e($paper['course_code']) ?></td><td><?= e($paper['year']) ?></td><td><?= e($paper['semester']) ?></td><td><?= e($paper['exam_type']) ?></td><td><?= e($paper['uploader'] ?? '-') ?></td><td>
      <a class="btn btn-outline-secondary btn-sm btn-icon" target="_blank" href="<?= asset_url('student/view.php?id=' . (int)$paper['id']) ?>"><i class="fa-solid fa-eye"></i></a>
      <a class="btn btn-outline-success btn-sm btn-icon" href="<?= asset_url('student/download.php?id=' . (int)$paper['id']) ?>"><i class="fa-solid fa-download"></i></a>
      <button class="btn btn-outline-primary btn-sm btn-icon" data-bs-toggle="modal" data-bs-target="#edit<?= (int)$paper['id'] ?>"><i class="fa-solid fa-pen"></i></button>
      <form method="post" class="d-inline" data-confirm="Delete this paper?"><?= csrf_field() ?><input type="hidden" name="action" value="delete"><input type="hidden" name="id" value="<?= (int)$paper['id'] ?>"><button class="btn btn-outline-danger btn-sm btn-icon"><i class="fa-solid fa-trash"></i></button></form>
    </td></tr>
    <div class="modal fade" id="edit<?= (int)$paper['id'] ?>" tabindex="-1"><div class="modal-dialog modal-lg"><form method="post" enctype="multipart/form-data" class="modal-content"><?= csrf_field() ?><input type="hidden" name="action" value="update"><input type="hidden" name="id" value="<?= (int)$paper['id'] ?>"><?php include BASE_PATH . '/includes/paper_form.php'; ?></form></div></div>
    <?php endforeach; ?></tbody></table>
  </div>
</div>
<?php $paper = ['title'=>'','course_id'=>'','year'=>date('Y'),'semester'=>'I','exam_type'=>'Final','file_path'=>'']; ?>
<div class="modal fade" id="createModal" tabindex="-1"><div class="modal-dialog modal-lg"><form method="post" enctype="multipart/form-data" class="modal-content"><?= csrf_field() ?><input type="hidden" name="action" value="create"><?php include BASE_PATH . '/includes/paper_form.php'; ?></form></div></div>
<?php include BASE_PATH . '/includes/page_end.php'; ?>

