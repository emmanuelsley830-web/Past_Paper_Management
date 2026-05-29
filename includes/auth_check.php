<?php
require_once __DIR__ . '/bootstrap.php';

function require_login(): void
{
    if (!current_user()) {
        redirect('auth/login.php');
    }
}

function require_role(array $roles): void
{
    require_login();
    if (!in_array(current_user()['role'], $roles, true)) {
        http_response_code(403);
        exit('Access denied.');
    }
}

