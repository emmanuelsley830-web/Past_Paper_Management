<?php
require_once __DIR__ . '/../functions/actions.php';
require_role(['student', 'admin', 'lecturer']);
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
header('Content-Type: application/json');
echo json_encode(['data' => paper_query($where, $params)]);

