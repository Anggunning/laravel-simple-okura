@extends('layouts.master')

@section('content')
    <div class="app-title">
        <ul class="app-breadcrumb breadcrumb">
            <li>
                <i class="bi bi-house-door me-2"></i>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}" class="text-decoration-none text-dark d-inline-flex align-items-center">

                    <span>Dashboard</span>
                </a>
            </li>
            <li class="breadcrumb-item active d-inline-flex align-items-center text-success" aria-current="page">
                <span>Surat Keterangan Tidak Mampu</span>
            </li>
        </ul>


    </div>
    <div class="title">
        <h4>Data Pengajuan Surat Keterangan Tidak Mampu</h4>
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
                                    id="customSearchInput">
                            </label>
                        </div>

                        {{-- Tombol Tambah Pengajuan --}}
                        @if (auth()->check() && in_array(auth()->user()->role, ['Masyarakat', 'Admin']))
                            <a href="#" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#modalTambahPengajuan">
                                <i class="bi bi-plus-circle"></i> Tambah Pengajuan
                            </a>
                        @endif

                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover table-bordered" id="sktmTable">
                        <thead>
                            <tr>
                                <th>Nama Pemohon</th>
                                <th>Tanggal</th>
                                <th>Tujuan</th>
                                <th>Keterangan</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sktm as $item)
                                <tr>
                                    <td>{{ $item->nama }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y') }}</td>
                                    <td>{{ $item->tujuan }}</td>
                                    <td>{{ $item->keterangan }}</td>
                                    <td>
                                        @php
                                            $badgeClass = match ($item->status) {
                                                'Diajukan' => 'bg-secondary text-dark',
                                                'Diproses' => 'bg-warning',
                                                'Selesai' => 'bg-success',
                                                default => 'bg-light text-dark',
                                            };
                                        @endphp
                                        <span class="badge {{ $badgeClass }} fs-6 py-2 px-3 rounded-3">
                                            {{ ucfirst($item->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            @if (auth()->check() && in_array(auth()->user()->role, ['Masyarakat', 'Admin']))
                                                <a href="#" class="btn btn-white me-2" style="color: #2E8B57;"
                                                    data-bs-toggle="modal" data-bs-target="#modalEditPengajuan"
                                                    data-id="{{ $item->id }}" data-nama="{{ $item->nama }}"
                                                    data-tujuan="{{ $item->tujuan }}"
                                                    data-jenis_kelamin="{{ $item->jenis_kelamin }}"
                                                    data-tempat_lahir="{{ $item->tempatLahir }}"
                                                    data-tanggal_lahir="{{ \Carbon\Carbon::parse($item->tanggalLahir)->format('Y-m-d') }}"
                                                    data-agama="{{ $item->agama }}" data-nik="{{ $item->nik }}"
                                                    data-alamat="{{ $item->alamat }}"
                                                    data-keterangan="{{ e($item->keterangan) }}">
                                                    <i class="bi bi-pencil-square fs-5"></i>
                                                </a>
                                                <form action="{{ route('sktm.destroy', $item->id) }}" method="POST"
                                                    style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-white me-2"
                                                        style="color: #2E8B57;"
                                                        onclick="return confirm('Yakin hapus data?')">
                                                        <i class="bi bi-trash fs-5"></i>
                                                    </button>
                                                </form>
                                            @endif
                                            <a class="btn btn-white me-2" style="color: #2E8B57;"
                                                href="{{ route('sktm.show', $item->id) }}">
                                                <i class="bi bi-info-circle fs-5"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Paginate --}}
                <div class="d-flex justify-content-center mt-3">
                    {{ $sktm->links() }}
                </div>



                <!-- Modal Tambah Pengajuan -->
                <div class="modal fade" id="modalTambahPengajuan" tabindex="-1" aria-labelledby="modalTambahLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <form action="{{ route('sktm.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalTambahLabel">Tambah Pengajuan Surat</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>

                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="nama" class="form-label">Nama Pemohon</label>
                                        <input type="text" name="nama" class="form-control" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="tujuan" class="form-label">Tujuan</label>
                                        <input type="text" name="tujuan" class="form-control" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                                        <select name="jenis_kelamin" class="form-select" required>
                                            <option value="">-- Pilih --</option>
                                            <option value="Laki-laki">Laki-laki</option>
                                            <option value="Perempuan">Perempuan</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="tempatLahir" class="form-label">Tempat Lahir</label>
                                        <input type="text" name="tempatLahir" class="form-control" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="tanggalLahir" class="form-label">Tanggal Lahir</label>
                                        <input type="date" name="tanggalLahir" class="form-control" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="agama" class="form-label">Agama</label>
                                        <input type="text" name="agama" class="form-control" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="nik" class="form-label">NIK</label>
                                        <input type="text" name="nik" class="form-control" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="alamat" class="form-label">Alamat</label>
                                        <textarea name="alamat" class="form-control" rows="2" required></textarea>
                                    </div>

                                    <input type="hidden" name="tanggal" id="tanggal">

                                    <div class="mb-3">
                                        <label for="keterangan" class="form-label">Keterangan</label>
                                        <textarea name="keterangan" class="form-control" rows="3" required></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="pengantar_rt_rw" class="form-label">Surat Pengantar RT/RW
                                            (gambar atau PDF)</label>
                                        <input type="file" name="pengantar_rt_rw" class="form-control"
                                            accept=".jpg,.jpeg,.png,.pdf" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="kk" class="form-label">Kartu Keluarga(gambar atau
                                            PDF)</label>
                                        <input type="file" name="kk" class="form-control"
                                            accept=".jpg,.jpeg,.png,.pdf" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="ktp" class="form-label">Kartu Tanda Penduduk (gambar atau
                                            PDF)</label>
                                        <input type="file" name="ktp" class="form-control"
                                            accept=".jpg,.jpeg,.png,.pdf" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="surat_pernyataan" class="form-label">Surat Pernyataan (gambar
                                            atau PDF)</label>
                                        <input type="file" name="surat_pernyataan" class="form-control"
                                            accept=".jpg,.jpeg,.png,.pdf" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Modal Edit Pengajuan -->
                <div class="modal fade" id="modalEditPengajuan" tabindex="-1" aria-labelledby="modalEditLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <form id="formEditPengajuan" action="" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <input type="hidden" name="id" id="edit-id">

                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalEditLabel">Edit Pengajuan Surat</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>

                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="edit-nama" class="form-label">Nama Pemohon</label>
                                        <input type="text" name="nama" id="edit-nama" class="form-control"
                                            required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="edit-tujuan" class="form-label">Tujuan</label>
                                        <input type="text" name="tujuan" id="edit-tujuan" class="form-control"
                                            required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="edit-jenis_kelamin" class="form-label">Jenis Kelamin</label>
                                        <select name="jenis_kelamin" id="edit-jenis_kelamin" class="form-select"
                                            required>
                                            <option value="">-- Pilih --</option>
                                            <option value="Laki-laki">Laki-laki</option>
                                            <option value="Perempuan">Perempuan</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="edit-tempatLahir" class="form-label">Tempat Lahir</label>
                                        <input type="text" name="tempatLahir" id="edit-tempatLahir"
                                            class="form-control" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="edit-tanggalLahir" class="form-label">Tanggal Lahir</label>
                                        <input type="date" name="tanggalLahir" id="edit-tanggalLahir"
                                            class="form-control" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="edit-agama" class="form-label">Agama</label>
                                        <input type="text" name="agama" id="edit-agama" class="form-control"
                                            required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="edit-nik" class="form-label">NIK</label>
                                        <input type="text" name="nik" id="edit-nik" class="form-control"
                                            required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="edit-alamat" class="form-label">Alamat</label>
                                        <textarea name="alamat" id="edit-alamat" class="form-control" rows="2" required></textarea>
                                    </div>

                                    <div class="mb-3">
                                        <label for="edit-keterangan" class="form-label">Keterangan</label>
                                        <textarea name="keterangan" id="edit-keterangan" class="form-control" rows="3" required></textarea>
                                    </div>

                                    <div class="mb-3">
                                        <label for="edit-pengantar_rt_rw" class="form-label">Surat Pengantar RT/RW
                                            (gambar atau PDF)</label>

                                        <input type="file" name="pengantar_rt_rw" id="edit-pengantar_rt_rw"
                                            class="form-control" accept=".jpg,.jpeg,.png,.pdf">
                                    </div>
                                    <div class="mb-3">
                                        <label for="edit-kk" class="form-label">Kartu Keluarga
                                            (gambar atau PDF)</label>
                                        <div class="mb-2" id="preview-edit-kk"></div>

                                        <input type="file" name="kk" id="edit-kk" class="form-control"
                                            accept=".jpg,.jpeg,.png,.pdf">
                                    </div>
                                    <div class="mb-3">
                                        <label for="edit-ktp" class="form-label">Kartu Tanda Penduduk
                                            (gambar atau PDF)</label>
                                        <input type="file" name="ktp" id="edit-ktp" class="form-control"
                                            accept=".jpg,.jpeg,.png,.pdf">
                                    </div>
                                    <div class="mb-3">
                                        <label for="edit-surat_pernyataan" class="form-label">Surat Pernyataan
                                            (gambar atau PDF)</label>
                                        <input type="file" name="surat_pernyataan" id="edit-surat_pernyataan"
                                            class="form-control" accept=".jpg,.jpeg,.png,.pdf">
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            @endsection


            @section('scripts')
                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
                <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

                <script>
                    $(document).ready(function() {
                        $('#sampleTable').DataTable();
                    });
                    $('#customSearchInput').on('keyup', function() {
                        table.search(this.value).draw();
                    });
                </script>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const today = new Date();
                        const yyyy = today.getFullYear();
                        const mm = String(today.getMonth() + 1).padStart(2, '0'); // bulan dimulai dari 0
                        const dd = String(today.getDate()).padStart(2, '0');
                        const formattedToday = `${yyyy}-${mm}-${dd}`;

                        document.getElementById('tanggal').value = formattedToday;
                    });
                </script>


                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        var modal = document.getElementById('modalEditPengajuan');
                        modal.addEventListener('show.bs.modal', function(event) {
                            var button = event.relatedTarget;

                            // Ambil data dari tombol edit
                            var id = button.getAttribute('data-id');
                            var nama = button.getAttribute('data-nama');
                            var tujuan = button.getAttribute('data-tujuan');
                            var jenisKelamin = button.getAttribute('data-jenis_kelamin');
                            var tempatLahir = button.getAttribute('data-tempat_lahir');
                            var tanggalLahir = button.getAttribute('data-tanggal_lahir');
                            var agama = button.getAttribute('data-agama');
                            var nik = button.getAttribute('data-nik');
                            var alamat = button.getAttribute('data-alamat');
                            var keterangan = button.getAttribute('data-keterangan');

                            // Set value ke form
                            modal.querySelector('#edit-id').value = id;
                            modal.querySelector('#edit-nama').value = nama;
                            modal.querySelector('#edit-tujuan').value = tujuan;
                            modal.querySelector('#edit-jenis_kelamin').value = jenisKelamin;
                            modal.querySelector('#edit-tempatLahir').value = tempatLahir;
                            modal.querySelector('#edit-tanggalLahir').value = tanggalLahir;
                            modal.querySelector('#edit-agama').value = agama;
                            modal.querySelector('#edit-nik').value = nik;
                            modal.querySelector('#edit-alamat').value = alamat;
                            modal.querySelector('#edit-keterangan').value = keterangan;


                            // Update action form supaya submit ke route yang sesuai id
                            var form = modal.querySelector('#formEditPengajuan');
                            form.action = "{{ route('sktm.update', ['id' => 'REPLACE_ID']) }}".replace('REPLACE_ID',
                                id);

                        });
                    });
                </script>
            @endsection
