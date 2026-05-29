<?php
require_once __DIR__ . '/../includes/bootstrap.php';
verify_csrf();
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$stmt = db()->prepare('SELECT u.*, d.department_name FROM users u LEFT JOIN departments d ON d.id = u.department_id WHERE email=? LIMIT 1');
$stmt->execute([$email]);
$user = $stmt->fetch();
if (!$user || $user['status'] !== 'active' || !password_verify($password, $user['password'])) {
    flash('error', 'Invalid credentials or inactive account.');
    redirect('auth/login.php');
}
session_regenerate_id(true);
unset($user['password']);
$_SESSION['user'] = $user;
$_SESSION['last_activity'] = time();
log_activity((int) $user['id'], 'Logged in');
redirect($user['role'] . '/dashboard.php');

