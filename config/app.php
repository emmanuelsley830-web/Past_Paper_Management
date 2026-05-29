<?php
$envFile = __DIR__ . '/env.php';
$config = file_exists($envFile) ? require $envFile : require __DIR__ . '/env.example.php';
define('APP_NAME', $config['app_name']);
define('APP_URL', rtrim($config['app_url'], '/'));
define('BASE_PATH', dirname(__DIR__));
define('UPLOAD_DIR', BASE_PATH . '/uploads/papers');
define('SESSION_TIMEOUT', (int) $config['session_timeout']);
define('MAX_UPLOAD_BYTES', (int) $config['max_upload_bytes']);
return $config;

