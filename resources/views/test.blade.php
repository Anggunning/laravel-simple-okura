<!DOCTYPE html>
<html>
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<button id="showModal" class="btn btn-primary">Tampilkan Modal</button>

<!-- Modal -->
<div class="modal fade" id="modalEditPengguna" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Modal Edit</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">Halo ini modal edit</div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.getElementById('showModal').addEventListener('click', function () {
        let modal = new bootstrap.Modal(document.getElementById('modalEditPengguna'));
        modal.show();
    });
</script>

</body>
</html>
