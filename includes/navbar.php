<nav class="app-header navbar navbar-expand bg-body">
  <div class="container-fluid">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button"><i class="fa-solid fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-md-block"><a href="<?= asset_url('index.php') ?>" class="nav-link">Home</a></li>
    </ul>
    <ul class="navbar-nav ms-auto">
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#">
          <i class="fa-solid fa-user-shield me-1"></i><?= e(current_user()['fullname'] ?? '') ?>
        </a>
        <div class="dropdown-menu dropdown-menu-end">
          <span class="dropdown-item-text text-muted"><?= e(ucfirst(current_user()['role'] ?? '')) ?></span>
          <div class="dropdown-divider"></div>
          <a href="<?= asset_url('auth/logout.php') ?>" class="dropdown-item text-danger"><i class="fa-solid fa-right-from-bracket me-2"></i>Logout</a>
        </div>
      </li>
    </ul>
  </div>
</nav>

