<?php
require_once __DIR__ . '/../includes/auth_check.php';
require_role(['student', 'admin', 'lecturer']);
$id = (int) ($_GET['id'] ?? 0);
$stmt = db()->prepare('SELECT file_path, title FROM past_papers WHERE id=?');
$stmt->execute([$id]);
$paper = $stmt->fetch();
if (!$paper) {
    http_response_code(404);
    exit('Paper not found.');
}
$file = BASE_PATH . '/' . $paper['file_path'];
if (!is_file($file)) {
    http_response_code(404);
    exit('File missing.');
}
log_activity(current_user()['id'], 'Downloaded paper #' . $id);
header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="' . preg_replace('/[^A-Za-z0-9_.-]/', '_', $paper['title']) . '.pdf"');
header('Content-Length: ' . filesize($file));
readfile($file);
exit;

