<div class="modal-header"><h5 class="modal-title"><?= empty($paper['id']) ? 'Add Paper' : 'Edit Paper' ?></h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
<div class="modal-body row g-3">
  <div class="col-md-8"><label class="form-label">Title</label><input name="title" class="form-control" value="<?= e($paper['title'] ?? '') ?>" required></div>
  <div class="col-md-4"><label class="form-label">Academic year</label><input type="number" name="year" min="1990" max="<?= (int)date('Y') + 1 ?>" class="form-control" value="<?= e($paper['year'] ?? date('Y')) ?>" required></div>
  <div class="col-md-6"><label class="form-label">Course</label><select name="course_id" class="form-select" required><?php foreach ($courses as $c): ?><option value="<?= (int)$c['id'] ?>" <?= (string)($paper['course_id'] ?? '')===(string)$c['id']?'selected':'' ?>><?= e($c['course_code'] . ' - ' . $c['course_name']) ?></option><?php endforeach; ?></select></div>
  <div class="col-md-3"><label class="form-label">Semester</label><select name="semester" class="form-select" required><?php foreach (['I','II','III'] as $sem): ?><option value="<?= e($sem) ?>" <?= ($paper['semester'] ?? '')===$sem?'selected':'' ?>><?= e($sem) ?></option><?php endforeach; ?></select></div>
  <div class="col-md-3"><label class="form-label">Exam type</label><select name="exam_type" class="form-select" required><?php foreach (['CAT','Midterm','Final','Supplementary','Other'] as $type): ?><option value="<?= e($type) ?>" <?= ($paper['exam_type'] ?? '')===$type?'selected':'' ?>><?= e($type) ?></option><?php endforeach; ?></select></div>
  <div class="col-12"><label class="form-label">PDF file <?= empty($paper['id']) ? '' : '(leave blank to keep current)' ?></label><input type="file" name="paper_file" class="form-control" accept="application/pdf" <?= empty($paper['id']) ? 'required' : '' ?>><input type="hidden" name="existing_file" value="<?= e($paper['file_path'] ?? '') ?>"></div>
</div>
<div class="modal-footer"><button class="btn btn-primary"><i class="fa-solid fa-floppy-disk me-1"></i>Save Paper</button></div>

