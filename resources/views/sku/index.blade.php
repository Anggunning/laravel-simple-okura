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
            <ul class="nav nav-tabs mb-3" id="skuTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="belum-tab" data-bs-toggle="tab" data-bs-target="#belum"
                        type="button" role="tab">
                        Belum Selesai
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="selesai-tab" data-bs-toggle="tab" data-bs-target="#selesai" type="button"
                        role="tab">
                        Selesai
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="ditolak-tab" data-bs-toggle="tab" data-bs-target="#ditolak" type="button"
                        role="tab">
                        Ditolak
                    </button>
                </li>
            </ul>
            <div class="tile">
                <div class="tile-body">
                    <div class="mb-3 d-flex justify-content-end">
                        {{-- Tombol Tambah Pengajuan --}}
                        @if (auth()->check() && in_array(auth()->user()->role, ['Masyarakat', 'Admin']))
                            <a href="#" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#modalTambahPengajuan">
                                <i class="bi bi-plus-circle"></i> Tambah Pengajuan
                            </a>
                        @endif
                    </div>

                    <div class="tab-content" id="skuTabsContent">
                        {{-- tab belum selesai --}}
                        <div class="tab-pane fade show active" id="belum" role="tabpanel">
                            <div class="table-responsive">
                                <div class="card-body">
                                    <table class="table table-hover table-bordered" id="skuTableBelumSelesai">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Tanggal Pengajuan</th>
                                                <th>Nama Pemohon</th>
                                                <th>Jenis Usaha</th>
                                                <th>Alamat Usaha</th>
                                                <th>Tujuan Pengajuan</th>
                                                <th class="text-center align-middle">Status</th>
                                                <th class="text-center align-middle">Aksi</th>
                                            </tr>
                                        </thead>
                                        @php
                                            $user = auth()->user();
                                        @endphp
                                        <tbody>
                                            @forelse($skuBelumSelesai as $item)
                                            @if ($user->role !== 'Masyarakat' || $item->user_id === $user->id)
                                                @php
                                                        $lebihDari3Hari = \Carbon\Carbon::parse($item->created_at)->lt(
                                                            now()->subDays(3),
                                                        );
                                                        $highlightMerah =
                                                            $lebihDari3Hari && $item->status === 'Diajukan';
                                                    @endphp
                                                    <tr class="{{ $highlightMerah ? 'table-danger' : '' }}">
                                                    <td></td>
                                                    <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y') }}</td>
                                                    <td>{{ $item->nama }}</td>
                                                    <td>{{ $item->jenis_usaha }}</td>
                                                    <td>{{ $item->tempat_usaha }}</td>
                                                    <td>{{ $item->tujuan }}</td>
                                                    <td>
                                                        @php
                                                            $badgeClass = match ($item->status) {
                                                                'Diajukan' => 'bg-secondary text-dark',
                                                                'Diproses' => 'bg-warning',
                                                                'Ditolak' => 'bg-danger',
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
                                                            <a class="btn btn-white me-2" style="color: #2E8B57;"
                                                                href="{{ route('sku.show', $item->id) }}">
                                                                <i class="bi bi-info-circle fs-5"></i>
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @endif
                                            @empty
                                                <tr>
                                                    <td colspan="6" class="text-center text-muted">Tidak ada data
                                                        pengajuan SKU.
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        {{-- tab selesai --}}
                        <div class="tab-pane fade show" id="selesai" role="tabpanel">
                            <div class="table-responsive">
                                <div class="card-body">
                                    <table class="table table-hover table-bordered" id="skuTableSelesai">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Tanggal Pengajuan</th>
                                                <th>Nama Pemohon</th>
                                                <th>Jenis Usaha</th>
                                                <th>Tujuan Pengajuan</th>
                                                <th>Keterangan</th>
                                                <th class="text-center align-middle">Status</th>
                                                <th class="text-center align-middle">Aksi</th>
                                            </tr>
                                        </thead>
                                        @php
                                            $user = auth()->user();
                                        @endphp
                                        @forelse($skuSelesai as $item)
                                            @if ($user->role !== 'Masyarakat' || $item->user_id === $user->id)
                                                @php
                                                    $lebihDari3Hari = \Carbon\Carbon::parse($item->created_at)->lt(
                                                        now()->subDays(3),
                                                    );
                                                    $highlightMerah = $lebihDari3Hari && $item->status === 'Diajukan';

                                                @endphp
                                                <tr class="{{ $highlightMerah ? 'baris-lewat' : '' }}">

                                                    <td></td>
                                                    <td>
                                                        {{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y') }}
                                                    </td>
                                                    <td>{{ $item->nama }}</td>
                                                    <td>{{ $item->jenis_usaha }}</td>
                                                    <td>{{ $item->tujuan }}</td>
                                                    @php
                                                        $riwayatSelesai = $item->riwayat_sku
                                                            ->where('status', 'Selesai')
                                                            ->last();
                                                    @endphp
                                                    <td>{{ $riwayatSelesai?->alasan ?? '-' }}</td>
                                                    <td>
                                                        @php
                                                            $badgeClass = match ($item->status) {
                                                                'Diajukan' => 'bg-secondary text-dark',
                                                                'Diproses' => 'bg-warning',
                                                                'Ditolak' => 'bg-danger',
                                                                'Selesai' => 'bg-success',
                                                                default => 'bg-light text-dark',
                                                            };
                                                        @endphp
                                                        <span class="badge {{ $badgeClass }} fs-6 py-2 px-3 rounded-3">
                                                            {{ ucfirst($item->status) }}
                                                        </span>
                                                    </td>
                                                    <td class="text-center align-middle">
                                                        <div class="btn-group">
                                                            <a class="btn btn-white me-2" style="color: #2E8B57;"
                                                                href="{{ route('sku.show', $item->id) }}">
                                                                <i class="bi bi-info-circle fs-5"></i>
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endif
                                        @empty
                                            <tr>
                                                <td colspan="8" class="text-center text-muted">Tidak ada data
                                                    pengajuan sku.</td>
                                            </tr>
                                        @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        

                        {{-- tab ditolak --}}
                        <div class="tab-pane fade show" id="ditolak" role="tabpanel">
                            <div class="table-responsive">
                                <div class="card-body">
                                    <table class="table table-hover table-bordered" id="skuTableDitolak">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Tanggal Pengajuan</th>
                                                <th>Nama Pemohon</th>
                                                <th>Jenis Usaha</th>
                                                <th>Tujuan Pengajuan</th>
                                                <th>Alasan Penolakan</th>
                                                <th class="text-center align-middle">Status</th>
                                                <th class="text-center align-middle">Aksi</th>
                                            </tr>
                                        </thead>
                                        @php
                                            $user = auth()->user();
                                        @endphp
                                        <tbody>
                                            @forelse($skuDitolak as $item)
                                            @if ($user->role !== 'Masyarakat' || $item->user_id === $user->id)
                                                <tr>
                                                    <td></td>
                                                    <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y') }}
                                                    </td>
                                                    <td>{{ $item->nama }}</td>
                                                    <td>{{ $item->jenis_usaha }}</td>
                                                    <td>{{ $item->tujuan }}</td>
                                                    @php
                                                        $riwayatDitolak = $item->riwayat_sku
                                                            ->where('status', 'Ditolak')
                                                            ->last();
                                                        @endphp
                                                        <td>{{ $riwayatDitolak?->alasan ?? '-' }}</td>
                                                    <td>
                                                        @php
                                                            $badgeClass = match ($item->status) {
                                                                'Diajukan' => 'bg-secondary text-dark',
                                                                'Diproses' => 'bg-warning',
                                                                'Selesai' => 'bg-success',
                                                                'Ditolak' => 'bg-danger',
                                                                default => 'bg-light text-dark',
                                                            };
                                                        @endphp
                                                        <span class="badge {{ $badgeClass }} fs-6 py-2 px-3 rounded-3">
                                                            {{ ucfirst($item->status) }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <div class="btn-group">
                                                            <a class="btn btn-white me-2" style="color: #2E8B57;"
                                                                href="{{ route('sku.show', $item->id) }}">
                                                                <i class="bi bi-info-circle fs-5"></i>
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @endif
                                            @empty
                                                <tr>
                                                    <td colspan="8" class="text-center text-muted">Tidak ada data
                                                        pengajuan SKU.
                                                    </td>
                                                </tr>
                                            @endforelse
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
                            <label for="nama" class="form-label">Nama Pemohon<span
                                    class="text-danger">*</span></label>
                            <input type="text" name="nama" class="form-control" required
                                placeholder="Masukkan Nama Lengkap"
                                oninvalid="this.setCustomValidity('Silakan isi nama lengkap')"
                                oninput="this.setCustomValidity('')">
                        </div>
                        <div class="mb-3">
                            <label for="tujuan" class="form-label">Tujuan
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="tujuan" class="form-control" required
                                placeholder="Masukkan Tujuan" oninvalid="this.setCustomValidity('Silakan isi tujuan')"
                                oninput="this.setCustomValidity('')">
                        </div>
                        <div class="mb-3">
                            <label for="jenis_kelamin" class="form-label">Jenis Kelamin <span
                                    class="text-danger">*</span></label>
                            <select name="jenis_kelamin" class="form-select" required
                                oninvalid="this.setCustomValidity('Silakan pilih jenis kelamin')"
                                oninput="this.setCustomValidity('')">
                                <option value="" disabled selected hidden>Jenis Kelamin</option>
                                <option value="Laki-laki">Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="tempatLahir" class="form-label">Tempat Lahir
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="tempatLahir" class="form-control" required
                                placeholder="Masukkan Tempat Lahir"
                                oninvalid="this.setCustomValidity('Silakan isi tempat lahir')"
                                oninput="this.setCustomValidity('')">
                        </div>
                        <div class="mb-3">
                            <label for="tanggalLahir" class="form-label">Tanggal Lahir
                                <span class="text-danger">*</span>
                            </label>
                            <input type="date" name="tanggalLahir" class="form-control" required
                                placeholder="Masukkan Tanggal Lahir"
                                oninvalid="this.setCustomValidity('Silakan isi tanggal lahir')"
                                oninput="this.setCustomValidity('')">
                        </div>
                         <div class="mb-3">
                            <label for="agama" class="form-label">Agama<span class="text-danger">*</span></label>
                            <select name="agama" class="form-select" required
                                oninvalid="this.setCustomValidity('Silakan pilih agama')"
                                oninput="this.setCustomValidity('')">
                                <option value="" disabled selected hidden>Agama</option>
                                <option value="Islam">Islam</option>
                                <option value="Kristen Protestan">Kristen Protestan</option>
                                <option value="Katolik">Katolik</option>
                                <option value="Hindu">Hindu</option>
                                <option value="Buddha">Buddha</option>
                                <option value="Konghuchu">Konghuchu</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="nik" class="form-label">NIK
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="nik" class="form-control" required
                                placeholder="Masukkan NIK" oninvalid="this.setCustomValidity('Silakan isi NIK')"
                                oninput="this.setCustomValidity('')">
                        </div>
                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat
                                <span class="text-danger">*</span>
                            </label>
                            <textarea name="alamat" class="form-control" rows="2" required placeholder="Masukkan Alamat"
                                oninvalid="this.setCustomValidity('Silakan isi alamat')" oninput="this.setCustomValidity('')"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="pekerjaan" class="form-label">Pekerjaan
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="pekerjaan" class="form-control" required
                                placeholder="Masukkan Pekerjaan"
                                oninvalid="this.setCustomValidity('Silakan isi pekerjaan')"
                                oninput="this.setCustomValidity('')">
                        </div>
                        <div class="mb-3">
                            <label for="jenis_usaha" class="form-label">Jenis Usaha
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="jenis_usaha" class="form-control" required
                                placeholder="Masukkan Jenis Usaha"
                                oninvalid="this.setCustomValidity('Silakan isi jenis usaha')"
                                oninput="this.setCustomValidity('')">
                        </div>
                        <div class="mb-3">
                            <label for="tempat_usaha" class="form-label">Tempat Usaha
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="tempat_usaha" class="form-control" required
                                placeholder="Masukkan Tempat Usaha"
                                oninvalid="this.setCustomValidity('Silakan isi tempat usaha')"
                                oninput="this.setCustomValidity('')">
                        </div>
                        <div class="mb-3">
                            <label for="kelurahan" class="form-label">Kelurahan
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="kelurahan" class="form-control" required
                                placeholder="Masukkan Kelurahan"
                                oninvalid="this.setCustomValidity('Silakan isi kelurahan')"
                                oninput="this.setCustomValidity('')">
                        </div>
                        
                        
                        <div class="mb-3">
                            <label for="kecamatan" class="form-label">Kecamatan
                                <span class="text-danger">*</span></label>
                            </label>
                            <input type="text" name="kecamatan" class="form-control" required
                                placeholder="Masukkan Kecamatan"
                                oninvalid="this.setCustomValidity('Silakan isi kecamatan')"
                                oninput="this.setCustomValidity('')">
                        </div>
                        <div class="mb-3">
                            <label for="kota" class="form-label">Kota
                                <span class="text-danger">*</span></label>
                            </label>
                            <input type="text" name="kota" class="form-control" required
                                placeholder="Masukkan Kota" oninvalid="this.setCustomValidity('Silakan isi kota')"
                                oninput="this.setCustomValidity('')">
                        </div>
                        <div class="mb-3">
                            <label for="keterangan" class="form-label">Keterangan</label></label>
                            <textarea name="keterangan" class="form-control" rows="3" required placeholder="Masukkan Keterangan(optional)">
                            </textarea>
                        </div>
                        <div class="mb-3">
                            <label for="foto_usaha" class="form-label">Foto Usaha <span
                                    class="text-danger">*</span></label></label>
                            <input type="file" name="foto_usaha" class="form-control" accept=".jpg,.jpeg,.png"
                                required oninvalid="this.setCustomValidity('Silakan unggah foto usaha')"
                                oninput="this.setCustomValidity('')">
                            <small class="form-text text-muted">Tipe File : JPG,PNG,PDF | Ukuran
                                Maksimal :
                                2MB.</small>
                        </div>
                        <div class="mb-3">
                            <label for="pengantar_rt_rw" class="form-label">Surat Pengantar RT/RW
                                <span class="text-danger">*</span></label>
                            <input type="file" name="pengantar_rt_rw" id="pengantar_rt_rw" class="form-control"
                                accept=".jpg,.jpeg,.png,.pdf" required
                                oninvalid="this.setCustomValidity('Silakan unggah surat pengantar RT/RW')"
                                oninput="this.setCustomValidity('')">
                            <small class="form-text text-muted">Tipe File : JPG,PNG,PDF | Ukuran
                                Maksimal :
                                2MB.</small>
                        </div>
                        <div class="mb-3">
                            <label for="kk" class="form-label">Kartu Keluarga <span
                                    class="text-danger">*</span></label>
                            <input type="file" name="kk" id="kk" class="form-control"
                                accept=".jpg,.jpeg,.png,.pdf" required
                                oninvalid="this.setCustomValidity('Silakan unggah file KK')"
                                oninput="this.setCustomValidity('')">
                            <small class="form-text text-muted">Tipe File : JPG,PNG,PDF | Ukuran
                                Maksimal :
                                2MB.</small>
                        </div>
                        <div class="mb-3">
                            <label for="ktp" class="form-label">Kartu Tanda Penduduk <span
                                    class="text-danger">*</span></label>
                            <input type="file" name="ktp" id="ktp" class="form-control"
                                accept=".jpg,.jpeg,.png,.pdf" required
                                oninvalid="this.setCustomValidity('Silakan unggah file KTP')"
                                oninput="this.setCustomValidity('')">
                            <small class="form-text text-muted">Tipe File : JPG,PNG,PDF | Ukuran
                                Maksimal :
                                2MB.</small>
                        </div>
                        <div class="mb-3">
                            <label for="surat_pernyataan" class="form-label">Surat Pernyataan <span
                                    class="text-danger">*</span></label>
                            <input type="file" name="surat_pernyataan" id="surat_pernyataan" class="form-control"
                                accept=".jpg,.jpeg,.png,.pdf" required
                                oninvalid="this.setCustomValidity('Silakan unggah surat pernyataan')"
                                oninput="this.setCustomValidity('')">
                            <small class="form-text text-muted">Tipe File : JPG,PNG,PDF | Ukuran
                                Maksimal :
                                2MB.</small>
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

@endsection


@push('scripts')
    <!-- Pastikan urutan script -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            const today = new Date();
            const yyyy = today.getFullYear();
            const mm = String(today.getMonth() + 1).padStart(2, '0'); // bulan dimulai dari 0
            const dd = String(today.getDate()).padStart(2, '0');
            const formattedToday = `${yyyy}-${mm}-${dd}`;

            document.getElementById('tanggal').value = formattedToday;
        });
    </script> --}}

    <script>
        function inisialisasiDataTable(idTabel) {
            if ($.fn.DataTable.isDataTable(idTabel)) {
                $(idTabel).DataTable().destroy();
            }

            // Debug: cek jumlah kolom per baris
            $(idTabel + ' tbody tr').each(function(index, row) {
                const tdCount = $(row).find('td').length;
                const thCount = $(idTabel + ' thead th').length;
                if (tdCount !== thCount) {
                    console.warn(
                        `⚠️ Jumlah kolom td (${tdCount}) ≠ th (${thCount}) di tabel ${idTabel} baris ke-${index + 1}`
                    );
                }
            });

            let table = $(idTabel).DataTable({
                columnDefs: [{
                    targets: 0,
                    orderable: false,
                    searchable: false
                }],
            });

            table.on('order.dt search.dt', function() {
                table.column(0, {
                    search: 'applied',
                    order: 'applied'
                }).nodes().each(function(cell, i) {
                    cell.innerHTML = i + 1;
                });
            }).draw();
        }

        $(document).ready(function() {
            inisialisasiDataTable('#skuTableBelumSelesai');
            inisialisasiDataTable('#skuTableSelesai');
            inisialisasiDataTable('#skuTableDitolak');
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function konfirmasiHapus(id) {
            Swal.fire({
                title: 'Yakin ingin menghapus data?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    const btn = document.getElementById('btnHapus-' + id);
                    const form = document.getElementById('formHapus-' + id);

                    if (!btn || !form) {
                        console.error("❌ Tidak ditemukan: btnHapus-" + id + " atau formHapus-" + id);
                        return;
                    }

                    btn.disabled = true;
                    btn.innerText = 'Menghapus...';
                    form.submit();
                }
            });
        }
    </script>



    <script>
        const nikInput = document.getElementById('nik');

        nikInput.addEventListener('input', function() {
            const val = this.value.trim();

            if (val === '') {
                this.setCustomValidity('Silakan isi NIK');
            } else if (!/^\d{16}$/.test(val)) {
                this.setCustomValidity('NIK harus terdiri dari 16 digit angka');
            } else {
                this.setCustomValidity('');
            }
        });

        // Trigger validasi ulang saat blur (pindah fokus)
        nikInput.addEventListener('blur', function() {
            this.reportValidity();
        });
    </script>
@endpush
