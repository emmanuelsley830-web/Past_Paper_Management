$(function () {
  function moveModalsToBody() {
    $('.modal').each(function () {
      if (this.parentNode !== document.body) {
        document.body.appendChild(this);
      }
    });
  }

  moveModalsToBody();

  $(document).on('show.bs.modal', '.modal', moveModalsToBody);

  $(document).on('pointerdown mousedown mouseup click', '.modal-dialog', function (event) {
    if (!$(event.target).closest('[data-bs-dismiss="modal"]').length) {
      event.stopPropagation();
    }
  });

  $('.datatable').DataTable({ responsive: true, pageLength: 10 });

  $(document).on('submit', 'form[data-confirm]', function (event) {
    event.preventDefault();
    const form = this;
    Swal.fire({
      title: form.dataset.confirm || 'Confirm this action?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#dc3545',
      confirmButtonText: 'Yes, continue'
    }).then((result) => {
      if (result.isConfirmed) form.submit();
    });
  });
});
