<?php if (!empty($_SESSION['flash'])): $flash = $_SESSION['flash']; unset($_SESSION['flash']); ?>
<script>
Swal.fire({
  toast: true,
  position: 'top-end',
  timer: 3200,
  showConfirmButton: false,
  icon: '<?= e($flash['type']) ?>',
  title: '<?= e($flash['message']) ?>'
});
</script>
<?php endif; ?>

