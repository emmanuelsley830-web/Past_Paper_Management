<?php
require_once __DIR__ . '/../functions/actions.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('student/register.php');
}

handle_student_registration();
