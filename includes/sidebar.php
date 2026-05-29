<?php
$role = current_user()['role'] ?? '';
$menus = [
    'admin' => [
        ['Dashboard', 'admin/dashboard.php', 'fa-gauge'],
        ['Users', 'admin/users.php', 'fa-users'],
        ['Departments', 'admin/departments.php', 'fa-building-columns'],
        ['Courses', 'admin/courses.php', 'fa-book'],
        ['Papers', 'admin/papers.php', 'fa-file-pdf'],
        ['Reports', 'admin/reports.php', 'fa-chart-line'],
    ],
    'lecturer' => [
        ['Dashboard', 'lecturer/dashboard.php', 'fa-gauge'],
        ['My Uploads', 'lecturer/papers.php', 'fa-file-arrow-up'],
    ],
    'student' => [
        ['Dashboard', 'student/dashboard.php', 'fa-gauge'],
        ['Search Papers', 'student/papers.php', 'fa-magnifying-glass'],
    ],
];
?>
<aside class="app-sidebar bg-dark shadow" data-bs-theme="dark">
  <div class="sidebar-brand">
    <a href="<?= asset_url('index.php') ?>" class="brand-link">
      <span class="brand-text fw-semibold">Past Papers</span>
    </a>
  </div>
  <div class="sidebar-wrapper">
    <nav class="mt-2">
      <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu">
        <?php foreach ($menus[$role] ?? [] as [$label, $url, $icon]): ?>
          <li class="nav-item">
            <a href="<?= asset_url($url) ?>" class="nav-link">
              <i class="nav-icon fa-solid <?= e($icon) ?>"></i>
              <p><?= e($label) ?></p>
            </a>
          </li>
        <?php endforeach; ?>
      </ul>
    </nav>
  </div>
</aside>

