<?php
require_once __DIR__ . '/../functions/actions.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') handle_department_action();
require_role(['admin']);
$pageTitle = 'Departments';
$rows = departments();
include BASE_PATH . '/includes/page_start.php';
?>
<div class="card content-card">
  <div class="card-header d-flex justify-content-between align-items-center">
    <h3 class="card-title">Department Management</h3>
    <button class="btn btn-primary btn-sm ms-auto" data-bs-toggle="modal" data-bs-target="#createModal"><i class="fa-solid fa-plus me-1"></i>Add Department</button>
  </div>
  <div class="card-body table-responsive">
    <table class="table table-striped datatable"><thead><tr><th>Name</th><th>Created</th><th>Actions</th></tr></thead><tbody>
    <?php foreach ($rows as $row): ?><tr>
      <td><?= e($row['department_name']) ?></td><td><?= e($row['created_at']) ?></td>
      <td>
        <button class="btn btn-outline-primary btn-sm btn-icon" data-bs-toggle="modal" data-bs-target="#edit<?= (int)$row['id'] ?>"><i class="fa-solid fa-pen"></i></button>
        <form method="post" class="d-inline" data-confirm="Delete this department?"><?= csrf_field() ?><input type="hidden" name="action" value="delete"><input type="hidden" name="id" value="<?= (int)$row['id'] ?>"><button class="btn btn-outline-danger btn-sm btn-icon"><i class="fa-solid fa-trash"></i></button></form>
      </td>
    </tr>
    <div class="modal fade" id="edit<?= (int)$row['id'] ?>" tabindex="-1"><div class="modal-dialog"><form method="post" class="modal-content"><?= csrf_field() ?><input type="hidden" name="action" value="update"><input type="hidden" name="id" value="<?= (int)$row['id'] ?>"><div class="modal-header"><h5 class="modal-title">Edit Department</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div><div class="modal-body"><label class="form-label">Department name</label><input name="department_name" class="form-control" value="<?= e($row['department_name']) ?>" required></div><div class="modal-footer"><button class="btn btn-primary">Save</button></div></form></div></div>
    <?php endforeach; ?></tbody></table>
  </div>
</div>
<div class="modal fade" id="createModal" tabindex="-1"><div class="modal-dialog"><form method="post" class="modal-content"><?= csrf_field() ?><input type="hidden" name="action" value="create"><div class="modal-header"><h5 class="modal-title">Add Department</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div><div class="modal-body"><label class="form-label">Department name</label><input name="department_name" class="form-control" required></div><div class="modal-footer"><button class="btn btn-primary">Create</button></div></form></div></div>
<?php include BASE_PATH . '/includes/page_end.php'; ?>

