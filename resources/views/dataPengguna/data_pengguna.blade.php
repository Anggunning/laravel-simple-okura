@extends('layouts.master')

@section('content')
    <div class="app-title">
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
            <li class="breadcrumb-item active"><a href="#">Pengguna</a></li>
        </ul>
    </div>
    <div class="title">
        <h4>Data Pengguna</h4>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">

                    <div class="mb-3 d-flex justify-content-between align-items-center">
                        <!-- Search di kiri -->
                        <div id="sampleTable_filter" class="dataTables_filter mb-0">
                            <label class="mb-0">
                                Search:
                                <input type="search" class="form-control form-control-sm" placeholder=""
                                    aria-controls="sampleTable">
                            </label>
                        </div>

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

                                                        <a href="" class="btn btn-white me-2"
                                                            style="color: #2E8B57;">
                                                            <i class="bi bi-info-circle fs-5"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>

                                </table>
                            </div>
                        </div>

                        <div class="d-flex justify-content-center">
                            {{ $users->links() }}
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
            <form method="POST" action="{{ route('dataPengguna.store') }}">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTambahPenggunaLabel">Tambah Pengguna</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label>Username</label>
                            <input type="text" class="form-control" name="username" required>
                        </div>
                        <div class="mb-3">
                            <label>Email</label>
                            <input type="email" class="form-control" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label>Password</label>
                            <input type="password" class="form-control" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label>Role</label>
                            <select class="form-select" name="role" required>
                                <option value="">-- Pilih Role --</option>
                                <option value="Admin">Admin</option>
                                <option value="Lurah">Lurah</option>
                                <option value="Sekretaris Lurah">Sekretaris Lurah</option>
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
            <form method="POST" id="formEditPengguna">
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
                            <input type="text" class="form-control" name="username" id="editUsername" required>
                        </div>
                        <div class="mb-3">
                            <label>Email</label>
                            <input type="email" class="form-control" name="email" id="editEmail" required>
                        </div>
                        <div class="mb-3">
                            <label>Password (kosongkan jika tidak diubah)</label>
                            <input type="password" class="form-control" name="password" id="editPassword">
                        </div>
                        <div class="mb-3">
                            <label>Role</label>
                            <select class="form-select" name="role" id="editRole" required>
                                <option value="">-- Pilih Role --</option>
                                <option value="Admin">Admin</option>
                                <option value="Lurah">Lurah</option>
                                <option value="Sekretaris Lurah">Sekretaris Lurah</option>
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

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script type="text/javascript" src="{{ 'template/docs/js/plugins/jquery.dataTables.min.js' }}"></script>
    <script type="text/javascript" src="{{ 'template/docs/js/plugins/dataTables.bootstrap.min.js' }}"></script>
    <script>
        $('#sampleTable').DataTable();
    </script>

    <script>
        $(document).ready(function() {
            $('.btn-edit').click(function(e) {
                e.preventDefault();

                let id = $(this).data('id');
                let username = $(this).data('username');
                let email = $(this).data('email');
                let role = $(this).data('role');

                $('#editUserId').val(id);
                $('#editUsername').val(username);
                $('#editEmail').val(email);
                $('#editPassword').val('');
                $('#editRole').val(role);

                let modalEdit = new bootstrap.Modal(document.getElementById('modalEditPengguna'));
                modalEdit.show();
            });
        });
    </script>
@endsection
