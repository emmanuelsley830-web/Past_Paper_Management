<nav class="app-header navbar navbar-expand bg-body premium-navbar">
  <div class="container-fluid">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link nav-icon-link" data-lte-toggle="sidebar" href="#" role="button"><i class="fa-solid fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-md-block"><a href="<?= asset_url('index.php') ?>" class="nav-link">Home</a></li>
    </ul>
    <ul class="navbar-nav ms-auto">
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle user-menu-link" data-bs-toggle="dropdown" href="#">
          <span class="user-avatar"><i class="fa-solid fa-user-shield"></i></span>
          <span class="d-none d-sm-inline"><?= e(current_user()['fullname'] ?? '') ?></span>
        </a>
        <div class="dropdown-menu dropdown-menu-end premium-dropdown">
          <span class="dropdown-item-text text-muted"><?= e(ucfirst(current_user()['role'] ?? '')) ?></span>
          <div class="dropdown-divider"></div>
          <a href="<?= asset_url('auth/logout.php') ?>" class="dropdown-item text-danger"><i class="fa-solid fa-right-from-bracket me-2"></i>Logout</a>
        </div>
      </li>
    </ul>
  </div>
</nav>
