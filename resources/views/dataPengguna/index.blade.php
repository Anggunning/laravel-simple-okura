@extends('layouts.master')

@section('content')
    <div class="app-title">
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
            <li class="breadcrumb-item active"><a href="#">Data Pengguna</a></li>
        </ul>
    </div>
    <div class="title">
        {{-- <h4>Data Pengguna</h4> --}}
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">

                    <div class="mb-3 d-flex justify-content-between align-items-center">
                        {{-- <form method="GET" action="{{ route('dataPengguna.index') }}" class="mb-0">
                            <div class="dataTables_filter mb-0">
                                <label class="mb-0">
                                    Search:
                                    <input type="text" name="search" value="{{ request('search') }}"
                                        class="form-control" placeholder="Cari data pengguna...">
                                </label>
                            </div>
                        </form> --}}
                        {{-- <form method="GET" action="{{ route('dataPengguna.index') }}" class="mb-0">
    <div class="dataTables_filter mb-0 ">
        <label class="mb-0">
            Search:
            <input type="text" name="search" value="{{ request('search') }}"
                class="form-control" placeholder="Cari data pengguna...">
                
        </label>
    </div>
</form> --}}

                        <!-- Tombol Tambah di kanan -->
                        <a href="#" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#modalTambahPengguna">
                            <i class="bi bi-plus-circle"></i> Tambah Pengguna
                        </a>
                    </div>
                </div>

                <div class="table">
                    <div id="sampleTable_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                        <div class="row">

                        </div>
                        <div class="row dt-row">
                          <div class="col-sm-12">
    <div class="table-responsive">
        <div class="card-body">
        <table class="table table-hover table-bordered dataTable no-footer" id="sampleTable"
            aria-describedby="sampleTable_info">
                                    <thead>
                                        <tr>
                                            <th class="sorting sorting_asc" tabindex="0" aria-controls="sampleTable"
                                                rowspan="1" colspan="1" aria-sort="ascending"
                                                aria-label="Name: activate to sort column descending"
                                                style="width: 150.725px;">Username</th>
                                            <th class="sorting" tabindex="0" aria-controls="sampleTable" rowspan="1"
                                                colspan="1" aria-label="Position: activate to sort column ascending"
                                                style="width: 137.913px;">Email</th>
                                            <th class="sorting" tabindex="0" aria-controls="sampleTable" rowspan="1"
                                                colspan="1" aria-label="Office: activate to sort column ascending"
                                                style="width: 221.388px;">Password</th>
                                            <th class="sorting" tabindex="0" aria-controls="sampleTable" rowspan="1"
                                                colspan="1" aria-label="Age: activate to sort column ascending"
                                                style="width: 150.825px;">Role</th>
                                            <th class="sorting" tabindex="0" aria-controls="sampleTable" rowspan="1"
                                                colspan="1" aria-label="Start date: activate to sort column ascending"
                                                style="width: 200.775px;">Aksi</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($users as $user)
                                            <tr>
                                                <td>{{ $user->username }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td>******</td>
                                                <td>{{ $user->role }}</td>
                                                <td>
                                                    <div class="btn-group">
                                                        {{-- <a href="{{ route('data_pengguna.edit', $user->id) }}"
                                                           class="btn btn-white me-2"
                                                            style="color: #2E8B57;">
                                                            <i class="bi bi-pencil-square fs-5"></i>
                                                        </a> --}}
                                                        <a href="#" class="btn btn-white me-2 btn-edit"
                                                            style="color: #2E8B57;" data-id="{{ $user->id }}"
                                                            data-username="{{ $user->username }}"
                                                            data-email="{{ $user->email }}"
                                                            data-role="{{ $user->role }}">
                                                            <i class="bi bi-pencil-square fs-5"></i>
                                                        </a>


                                                        <form action="{{ route('data_pengguna.destroy', $user->id) }}"
                                                            method="POST" style="display:inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-white me-2"
                                                                style="color: #2E8B57;"
                                                                onclick="return confirm('Yakin hapus data?')">
                                                                <i class="bi bi-trash fs-5"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>

                                </table>
                            </div>
                        </div>
</div>
                      
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>

    <!-- Modal Tambah Pengguna -->
    <div class="modal fade" id="modalTambahPengguna" tabindex="-1" aria-labelledby="modalTambahPenggunaLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <form id="formTambahPengguna" method="POST" action="{{ route('dataPengguna.store') }}" >
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTambahPenggunaLabel">Tambah Pengguna</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    {{-- <div id="formErrorAlert" class="alert alert-danger d-none mx-3 mt-3">
                        <strong>Form belum lengkap!</strong> Mohon isi semua field.
                    </div> --}}
                    <div class="modal-body">
                        <div class="mb-3">
                            <label>Username</label>
                            <input type="text" class="form-control" name="username" required
                                placeholder="Masukkan nama anda"
                                 oninvalid="this.setCustomValidity('Silakan isi username')"
                        oninput="this.setCustomValidity('')">

                        </div>

                        <div class="mb-3">
                            <label>Email</label>
                            <input type="email" class="form-control" name="email" required
                                placeholder="Masuukkan email anda"
                                 oninvalid="this.setCustomValidity('Silakan isi email')"
                        oninput="this.setCustomValidity('')">

                        </div>
                        <div class="mb-3">
  <label class="form-label">PASSWORD</label>
  <div class="input-group">
    <input type="password"
           name="password"
           id="passwordInput"
           class="form-control @error('password') is-invalid @enderror"
           placeholder="Password"
           required
           autocomplete="new-password"
           pattern="^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$"
           oninvalid="this.setCustomValidity('Password minimal 8 karakter dan harus mengandung huruf & angka')"
           oninput="this.setCustomValidity('')">
    <button type="button" class="btn btn-outline-secondary" onclick="togglePassword()">
      <i class="bi bi-eye-slash" id="toggleIcon"></i>
    </button>
  </div>
  @error('password')
    <span class="invalid-feedback" role="alert">
      <strong>{{ $message }}</strong>
    </span>
  @enderror
</div>
                        <div class="mb-3">
                            <label>Role</label>
                            <select class="form-select" name="role" required
                            oninvalid="this.setCustomValidity('Silahkan pilih role')"
           oninput="this.setCustomValidity('')">
                                <option value="" disabled selected hidden>Pilih Role</option>
                                <option value="Admin">Admin</option>
                                <option value="Lurah">Lurah</option>
                                <option value="Sekretaris">Sekretaris</option>
                                <option value="Masyarakat">Masyarakat</option>
                            </select>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button class="btn btn-primary" type="submit">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Edit Pengguna -->
    <div class="modal fade" id="modalEditPengguna" tabindex="-1" aria-labelledby="modalEditPenggunaLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" id="formEditPengguna" novalidate>
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalEditPenggunaLabel">Edit Pengguna</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>


                    <div class="modal-body">
                        <input type="hidden" name="id" id="editUserId">

                        <div class="mb-3">
                            <label>Username</label>
                            <input type="text" class="form-control" name="username" id="editUsername" required
                             oninvalid="this.setCustomValidity('Silakan isi username')"
                        oninput="this.setCustomValidity('')">
                        </div>
                        <div class="mb-3">
                            <label>Email</label>
                            <input type="email" class="form-control" name="email" id="editEmail" required
                             oninvalid="this.setCustomValidity('Silakan isi email')"
                        oninput="this.setCustomValidity('')">
                        </div>
                        <div class="mb-3">
    <label>Password (kosongkan jika tidak diubah)</label>
    <div class="input-group">
        <input type="password" class="form-control" name="password" id="editPassword">
        <button type="button" class="btn btn-outline-secondary" onclick="toggleEditPassword()">
  <i class="bi bi-eye-slash" id="editToggleIcon"></i>
</button>

    </div>
</div>

                        <div class="mb-3">
                            <label>Role</label>
                            <select class="form-select" name="role" id="editRole" required 
                             oninvalid="this.setCustomValidity('Silakan pilih role')"
                        oninput="this.setCustomValidity('')">
                                <option value="" disabled selected hidden>Pilih Role</option>
                                <option value="Admin">Admin</option>
                                <option value="Lurah">Lurah</option>
                                <option value="Sekretaris">Sekretaris</option>
                                <option value="Masyarakat">Masyarakat</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button class="btn btn-primary" type="submit">Simpan Perubahan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    
 <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
   

    <script>
        $('.btn-edit').click(function(e) {
            e.preventDefault();

            let id = $(this).data('id');
            let username = $(this).data('username');
            let email = $(this).data('email');
            let role = $(this).data('role');

            $('#editUserId').val(id);
            $('#editUsername').val(username);
            $('#editEmail').val(email);
            $('#editPassword').val(''); // Jangan isi password dari data!
            $('#editRole').val(role);

            // Set action ke form edit
            let formAction = "{{ url('/data_pengguna') }}/" + id;
            $('#formEditPengguna').attr('action', formAction);

            let modalEdit = new bootstrap.Modal(document.getElementById('modalEditPengguna'));
            modalEdit.show();
        });
    </script>
    <script>
        $(document).ready(function() {
            // Inisialisasi DataTables
            var table = $('#sampleTable').DataTable({
                // paging: false,
                // ordering: false,
                // info: false,
                searching: true // WAJIB true agar .search() aktif
            });
        });
    </script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Tangkap semua form hapus
            const hapusButtons = document.querySelectorAll('.btn-hapus');

            hapusButtons.forEach(function(button) {
                button.addEventListener('click', function(event) {
                    event.preventDefault(); // hentikan submit dulu

                    const form = this.closest('form');
                    const nama = this.dataset.nama || 'data ini';

                    if (confirm(`Apakah Anda yakin ingin menghapus ${nama}?`)) {
                        form.submit(); // lanjutkan submit jika konfirmasi OK
                    }
                });
            });
        });
    </script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <script type="text/javascript">
      // register Page Flipbox control
      $('.register-content [data-toggle="flip"]').click(function() {
      	$('.register-box').toggleClass('flipped');
      	return false;
      });
    </script>
    <script>
    function toggleEditPassword() {
        const input = document.getElementById("editPassword");
        const icon = document.getElementById("editToggleIcon");
        const isHidden = input.type === "password";

        input.type = isHidden ? "text" : "password";
        icon.classList.toggle("bi-eye", isHidden);
        icon.classList.toggle("bi-eye-slash", !isHidden);
    }
</script>


    <script>
        function togglePassword() {
    const input = document.getElementById("passwordInput");
    const icon = document.getElementById("toggleIcon");
    const isHidden = input.type === "password";

    input.type = isHidden ? "text" : "password";
    icon.classList.toggle("bi-eye", isHidden);
    icon.classList.toggle("bi-eye-slash", !isHidden);
  }
    </script>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('formTambahPengguna');

        form.addEventListener('submit', function (e) {
            let valid = true;

            const username = form.querySelector('input[name="username"]');
            const email = form.querySelector('input[name="email"]');
            const password = form.querySelector('input[name="password"]');
            const role = form.querySelector('select[name="role"]');

            // Reset custom validity
            [username, email, password, role].forEach(input => {
                input.setCustomValidity('');
            });

            if (!username.value.trim()) {
                username.setCustomValidity('Silakan isi username');
                username.reportValidity();
                valid = false;
            } else if (!email.value.trim()) {
                email.setCustomValidity('Silakan isi email');
                email.reportValidity();
                valid = false;
            } else if (!password.value.trim()) {
                password.setCustomValidity('Silakan isi password');
                password.reportValidity();
                valid = false;
            } else if (!role.value.trim()) {
                role.setCustomValidity('Silakan pilih role');
                role.reportValidity();
                valid = false;
            }

            if (!valid) {
                e.preventDefault(); // stop form submit
            }
        });
    });
</script>

@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: '{{ session('success') }}',
        timer: 2500,
        showConfirmButton: false
    });
</script>
@endif

@if ($errors->any())
    @php
        $emailError = $errors->first('email');
    @endphp

    @if ($emailError)
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: '{{ $emailError }}',
                showConfirmButton: true
            });
        </script>
    @else
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                html: `{!! implode('<br>', $errors->all()) !!}`,
                showConfirmButton: true
            });
        </script>
    @endif
@endif




@endpush
