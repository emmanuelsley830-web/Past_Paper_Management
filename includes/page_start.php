<?php include BASE_PATH . '/includes/header.php'; ?>
<?php include BASE_PATH . '/includes/navbar.php'; ?>
<?php include BASE_PATH . '/includes/sidebar.php'; ?>
<main class="app-main">
  <div class="app-content-header premium-page-header">
    <div class="container-fluid">
      <div class="row align-items-center g-2">
        <div class="col-sm-7">
          <p class="page-kicker mb-1"><?= e(ucfirst(current_user()['role'] ?? 'Portal')) ?> Workspace</p>
          <h3 class="mb-0"><?= e($pageTitle ?? APP_NAME) ?></h3>
        </div>
        <div class="col-sm-5 text-sm-end">
          <span class="page-user-chip"><i class="fa-solid fa-circle-check me-1"></i><?= e(current_user()['fullname'] ?? '') ?></span>
        </div>
      </div>
    </div>
  </div>
  <div class="app-content">
    <div class="container-fluid">
