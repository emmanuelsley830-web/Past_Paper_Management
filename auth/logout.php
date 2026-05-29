<?php
require_once __DIR__ . '/../includes/bootstrap.php';
if (current_user()) {
    log_activity(current_user()['id'], 'Logged out');
}
session_destroy();
redirect('auth/login.php');

