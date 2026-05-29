<?php if (current_user()): ?>
  <footer class="app-footer">
    <strong><?= e(APP_NAME) ?></strong>
    <span class="float-end d-none d-sm-inline">Secure academic archive</span>
  </footer>
</div>
<?php endif; ?>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@4.0.0-rc4/dist/js/adminlte.min.js"></script>
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="<?= asset_url('assets/js/app.js') ?>"></script>
<?php include BASE_PATH . '/includes/flash.php'; ?>
</body>
</html>

