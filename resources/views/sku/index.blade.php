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
                <span>Surat Keterangan Usaha</span>
            </li>
        </ul>
    </div>
    <div class="title">
        <h4>Data Pengajuan Surat Keterangan Usaha</h4>
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
                            data-bs-target="#modalTambahPengajuan">
                            <i class="bi bi-plus-circle"></i> Tambah Pengajuan
                        </a>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover table-bordered" id="sampleTable">
                        <thead>
                            <tr>
                                <th>Nama Pemohon</th>
                                <th>Tanggal Lahir</th>
                                <th>Jenis Usaha</th>
                                <th>Tempat Usaha</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($sku as $item)
                                <tr>
                                    <td>{{ $item->nama }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->tanggalLahir)->format('d/m/Y') }}</td>
                                    <td>{{ $item->jenis_usaha }}</td>
                                    <td>{{ $item->tempat_usaha }}</td>
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

                                            <a href="#" class="btn btn-white me-2" style="color: #2E8B57;"
    data-bs-toggle="modal" data-bs-target="#modalEditSku"
    data-id="{{ $item->id }}"
    data-nama="{{ e($item->nama) }}"
    data-tujuan="{{ e($item->tujuan) }}"
    data-jenis_kelamin="{{ e($item->jenis_kelamin) }}"
    data-tempat_lahir="{{ e($item->tempatLahir) }}"
    data-tanggal_lahir="{{ \Carbon\Carbon::parse($item->tanggalLahir)->format('Y-m-d') }}"
    data-agama="{{ e($item->agama) }}"
    data-nik="{{ e($item->nik) }}"
    data-alamat="{{ e($item->alamat) }}"
    data-pekerjaan="{{ e($item->pekerjaan) }}"
    data-jenis_usaha="{{ e($item->jenis_usaha) }}"
    data-tempat_usaha="{{ e($item->tempat_usaha) }}"
    data-kelurahan="{{ e($item->kelurahan) }}"
    data-kecamatan="{{ e($item->kecamatan) }}"
    data-kota="{{ e($item->kota) }}"
    data-keterangan="{{ e($item->keterangan) }}">
    <i class="bi bi-pencil-square fs-5"></i>
</a>


                                            <form action="{{ route('sku.destroy', $item->id) }}" method="POST"
                                                onsubmit="return confirm('Yakin ingin menghapus data ini?')"
                                                style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-white me-2" style="color: #2E8B57;">
                                                    <i class="bi bi-trash fs-5"></i>
                                                </button>
                                            </form>
                                            <a class="btn btn-white me-2" style="color: #2E8B57;"
                                                href="{{ route('sku.show', $item->id) }}">
                                                <i class="bi bi-info-circle fs-5"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">Tidak ada data pengajuan SKU.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                {{-- Paginate --}}
                <div class="d-flex justify-content-center mt-3">
                    {{ $sku->links() }}
                </div>
            </div>
        </div>

        <!-- Modal Tambah Pengajuan -->
        <div class="modal fade" id="modalTambahPengajuan" tabindex="-1" aria-labelledby="modalTambahLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form action="{{ route('sku.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalTambahLabel">Tambah Pengajuan Surat</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                            <div class="mb-3">
                                <label for="pekerjaan" class="form-label">Pekerjaan</label>
                                <input type="text" name="pekerjaan" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="jenis_usaha" class="form-label">Jenis Usaha</label>
                                <input type="text" name="jenis_usaha" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="tempat_usaha" class="form-label">Tempat Usaha</label>
                                <input type="text" name="tempat_usaha" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="kelurahan" class="form-label">Kelurahan</label>
                                <input type="text" name="kelurahan" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="kecamatan" class="form-label">Kecamatan</label>
                                <input type="text" name="kecamatan" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="kota" class="form-label">Kota</label>
                                <input type="text" name="kota" class="form-control" required>
                            </div>


                            <div class="mb-3">
                                <label for="keterangan" class="form-label">Keterangan</label>
                                <textarea name="keterangan" class="form-control" rows="3" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="foto_usaha" class="form-label">Foto Usaha (gambar)</label>
                                <input type="file" name="foto_usaha" class="form-control" accept=".jpg,.jpeg,.png"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="pengantar RT/RW" class="form-label">Surat Pengantar RT/RW (gambar atau
                                    PDF)</label>
                                <input type="file" name="pengantar_rt_rw" class="form-control"
                                    accept=".jpg,.jpeg,.png,.pdf" required>
                            </div>
                            <div class="mb-3">
                                <label for="KK" class="form-label">Kartu Keluarga(gambar atau PDF)</label>
                                <input type="file" name="kk" class="form-control" accept=".jpg,.jpeg,.png,.pdf"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="KTP" class="form-label">Kartu Tanda Penduduk (gambar atau PDF)</label>
                                <input type="file" name="ktp" class="form-control" accept=".jpg,.jpeg,.png,.pdf"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="Surat Pernyataan" class="form-label">Surat Pernyataan (gambar atau
                                    PDF)</label>
                                <input type="file" name="surat_pernyataan" class="form-control"
                                    accept=".jpg,.jpeg,.png,.pdf" required>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <!-- Modal Edit SKU -->
        <div class="modal fade" id="modalEditSku" tabindex="-1" aria-labelledby="modalEditSkuLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form id="formEditSku" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Pengajuan SKU</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" id="edit_id">

                            <div class="mb-3">
                                <label for="edit_nama" class="form-label">Nama Pemohon</label>
                                <input type="text" name="nama" id="edit_nama" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="edit_tujuan" class="form-label">Tujuan</label>
                                <input type="text" name="tujuan" id="edit_tujuan" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="edit_jenis_kelamin" class="form-label">Jenis Kelamin</label>
                                <select name="jenis_kelamin" id="edit_jenis_kelamin" class="form-select" required>
                                    <option value="">-- Pilih --</option>
                                    <option value="Laki-laki">Laki-laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="edit_tempatLahir" class="form-label">Tempat Lahir</label>
                                <input type="text" name="tempatLahir" id="edit_tempatLahir" class="form-control"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label for="edit_tanggalLahir" class="form-label">Tanggal Lahir</label>
                                <input type="date" name="tanggalLahir" id="edit_tanggalLahir" class="form-control"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label for="edit_agama" class="form-label">Agama</label>
                                <input type="text" name="agama" id="edit_agama" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="edit_nik" class="form-label">NIK</label>
                                <input type="text" name="nik" id="edit_nik" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="edit_alamat" class="form-label">Alamat</label>
                                <textarea name="alamat" id="edit_alamat" class="form-control" rows="2" required></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="edit_pekerjaan" class="form-label">Pekerjaan</label>
                                <input type="text" name="pekerjaan" id="edit_pekerjaan" class="form-control"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label for="edit_jenis_usaha" class="form-label">Jenis Usaha</label>
                                <input type="text" name="jenis_usaha" id="edit_jenis_usaha" class="form-control"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label for="edit_tempat_usaha" class="form-label">Tempat Usaha</label>
                                <input type="text" name="tempat_usaha" id="edit_tempat_usaha" class="form-control"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label for="edit_kelurahan" class="form-label">Kelurahan</label>
                                <input type="text" name="kelurahan" id="edit_kelurahan" class="form-control"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label for="edit_kecamatan" class="form-label">Kecamatan</label>
                                <input type="text" name="kecamatan" id="edit_kecamatan" class="form-control"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label for="edit_kota" class="form-label">Kota</label>
                                <input type="text" name="kota" id="edit_kota" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="edit_keterangan" class="form-label">Keterangan</label>
                                <textarea name="keterangan" id="edit_keterangan" class="form-control" rows="3" required></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="edit_foto_usaha" class="form-label">Foto Usaha (gambar)</label>
                                <input type="file" name="foto_usaha" id="edit_foto_usaha" class="form-control"
                                    accept=".jpg,.jpeg,.png">
                            </div>

                            <div class="mb-3">
                                <label for="edit_pengantar_rt_rw" class="form-label">Surat Pengantar RT/RW
                                    (gambar/pdf)</label>
                                <input type="file" name="pengantar_rt_rw" id="edit_pengantar_rt_rw"
                                    class="form-control" accept=".jpg,.jpeg,.png,.pdf">
                            </div>

                            <div class="mb-3">
                                <label for="edit_kk" class="form-label">Kartu Keluarga (gambar/pdf)</label>
                                <input type="file" name="kk" id="edit_kk" class="form-control"
                                    accept=".jpg,.jpeg,.png,.pdf">
                            </div>

                            <div class="mb-3">
                                <label for="edit_ktp" class="form-label">Kartu Tanda Penduduk (gambar/pdf)</label>
                                <input type="file" name="ktp" id="edit_ktp" class="form-control"
                                    accept=".jpg,.jpeg,.png,.pdf">
                            </div>

                            <div class="mb-3">
                                <label for="edit_surat_pernyataan" class="form-label">Surat Pernyataan
                                    (gambar/pdf)</label>
                                <input type="file" name="surat_pernyataan" id="edit_surat_pernyataan"
                                    class="form-control" accept=".jpg,.jpeg,.png,.pdf">
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endsection


    @section('scripts')
        <!-- Pastikan urutan script -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

        <script>
    document.addEventListener('DOMContentLoaded', function () {
        var modal = document.getElementById('modalEditSku');

        if (modal) {
            modal.addEventListener('show.bs.modal', function (event) {
                var button = event.relatedTarget;

                // Ambil data dari atribut tombol edit
                var id = button.getAttribute('data-id');
                var nama = button.getAttribute('data-nama');
                var tujuan = button.getAttribute('data-tujuan');
                var jenisKelamin = button.getAttribute('data-jenis_kelamin');
                var tempatLahir = button.getAttribute('data-tempat_lahir');
                var tanggalLahir = button.getAttribute('data-tanggal_lahir');
                var agama = button.getAttribute('data-agama');
                var nik = button.getAttribute('data-nik');
                var alamat = button.getAttribute('data-alamat');
                var pekerjaan = button.getAttribute('data-pekerjaan');
                var jenisUsaha = button.getAttribute('data-jenis_usaha');
                var tempatUsaha = button.getAttribute('data-tempat_usaha');
                var kelurahan = button.getAttribute('data-kelurahan');
                var kecamatan = button.getAttribute('data-kecamatan');
                var kota = button.getAttribute('data-kota');
                var keterangan = button.getAttribute('data-keterangan');

                // Set nilai ke form modal
                modal.querySelector('#edit_id').value = id;
                modal.querySelector('#edit_nama').value = nama;
                modal.querySelector('#edit_tujuan').value = tujuan;
                modal.querySelector('#edit_jenis_kelamin').value = jenisKelamin;
                modal.querySelector('#edit_tempatLahir').value = tempatLahir;
                modal.querySelector('#edit_tanggalLahir').value = tanggalLahir;
                modal.querySelector('#edit_agama').value = agama;
                modal.querySelector('#edit_nik').value = nik;
                modal.querySelector('#edit_alamat').value = alamat;
                modal.querySelector('#edit_pekerjaan').value = pekerjaan;
                modal.querySelector('#edit_jenis_usaha').value = jenisUsaha;
                modal.querySelector('#edit_tempat_usaha').value = tempatUsaha;
                modal.querySelector('#edit_kelurahan').value = kelurahan;
                modal.querySelector('#edit_kecamatan').value = kecamatan;
                modal.querySelector('#edit_kota').value = kota;
                modal.querySelector('#edit_keterangan').value = keterangan;

                // Set action form dengan ID dinamis
                var form = modal.querySelector('#formEditSku');
                form.action = "{{ route('sku.update', ['id' => 'REPLACE_ID']) }}".replace('REPLACE_ID', id);
            });
        }
    });
</script>

    @endsection
