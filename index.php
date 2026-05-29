<?php
require_once __DIR__ . '/includes/bootstrap.php';
if (!current_user()) {
    redirect('auth/login.php');
}
redirect(current_user()['role'] . '/dashboard.php');

