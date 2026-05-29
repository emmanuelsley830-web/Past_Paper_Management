<?php
require_once __DIR__ . '/../config/app.php';
require_once BASE_PATH . '/functions/security.php';
start_secure_session();
require_once BASE_PATH . '/functions/helpers.php';
require_once BASE_PATH . '/functions/validation.php';
require_once BASE_PATH . '/functions/upload.php';
enforce_session_timeout();

