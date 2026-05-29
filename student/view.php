<?php
require_once __DIR__ . '/../includes/auth_check.php';
require_role(['student', 'admin', 'lecturer']);
$id = (int) ($_GET['id'] ?? 0);
$stmt = db()->prepare('SELECT file_path FROM past_papers WHERE id=?');
$stmt->execute([$id]);
$paper = $stmt->fetch();
if (!$paper || !is_file(BASE_PATH . '/' . $paper['file_path'])) {
    http_response_code(404);
    exit('Paper not found.');
}
header('Content-Type: application/pdf');
readfile(BASE_PATH . '/' . $paper['file_path']);
exit;

