<?php
function db(): PDO
{
    static $pdo = null;
    if ($pdo === null) {
        $pdo = require BASE_PATH . '/config/database.php';
    }
    return $pdo;
}

function e(?string $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function redirect(string $path): never
{
    header('Location: /' . ltrim($path, '/'));
    exit;
}

function asset_url(string $path): string
{
    return '/' . ltrim($path, '/');
}

function current_user(): ?array
{
    return $_SESSION['user'] ?? null;
}

function is_role(string $role): bool
{
    return (current_user()['role'] ?? null) === $role;
}

function flash(string $type, string $message): void
{
    $_SESSION['flash'] = ['type' => $type, 'message' => $message];
}

function old(string $key, string $default = ''): string
{
    return e($_SESSION['old'][$key] ?? $default);
}

function log_activity(?int $userId, string $activity): void
{
    $stmt = db()->prepare('INSERT INTO activity_logs (user_id, activity) VALUES (?, ?)');
    $stmt->execute([$userId, $activity]);
}

function count_table(string $table, string $where = '1=1', array $params = []): int
{
    $allowed = ['users', 'departments', 'courses', 'past_papers', 'activity_logs'];
    if (!in_array($table, $allowed, true)) {
        throw new InvalidArgumentException('Invalid table.');
    }
    $stmt = db()->prepare("SELECT COUNT(*) FROM {$table} WHERE {$where}");
    $stmt->execute($params);
    return (int) $stmt->fetchColumn();
}
