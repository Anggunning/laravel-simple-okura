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
            <ul class="nav nav-tabs mb-3" id="sktmTabs" role="tablist">
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

                    {{-- Tab Contents --}}
                    <div class="tab-content" id="sktmTabsContent">

                        {{-- TAB 1: Belum Selesai --}}
                        <div class="tab-pane fade show active" id="belum" role="tabpanel">
                            <div class="table-responsive">
                                <div class="card-body">
                                    <table class="table table-hover table-bordered" id="sktmTableBelumSelesai">
                                        <thead>
                                            <tr>
                                                <th>No</th>

                                                <th>Nama Pemohon</th>
                                                <th>Alamat Pemohon</th>
                                                <th>Pekerjaan Pemohon</th>
                                                <th>Tujuan Pengajuan</th>
                                                <th>Tanggal Pengajuan</th>
                                                <th class="text-center align-middle">Status</th>
                                                <th class="text-center align-middle">Aksi</th>
                                            </tr>
                                        </thead>
                                        @php
                                            $user = auth()->user();
                                        @endphp
                                        <tbody>

                                            @forelse($sktmBelumSelesai as $item)
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

                                                        <td>{{ $item->nama }}</td>
                                                        <td>{{ $item->alamat }}</td>
                                                        <td>{{ $item->pekerjaan }}</td>
                                                        <td>{{ $item->tujuan }}</td>
                                                        <td>
                                                            {{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y') }}
                                                        </td>
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
                                                            <span
                                                                class="badge {{ $badgeClass }} fs-6 py-2 px-3 rounded-3">
                                                                {{ ucfirst($item->status) }}
                                                            </span>
                                                        </td>
                                                        <td class="text-center align-middle">
                                                            <div class="btn-group">
                                                                <a class="btn btn-white me-2" style="color: #2E8B57;"
                                                                    href="{{ route('sktm.show', $item->id) }}">
                                                                    <i class="bi bi-info-circle fs-5"></i>
                                                                </a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endif
                                            @empty
                                                <tr>
                                                    <td colspan="8" class="text-center text-muted">Tidak ada data
                                                        pengajuan SKTM.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>


                        {{-- TAB 2: Selesai --}}
                        <div class="tab-pane fade" id="selesai" role="tabpanel">
                            <div class="table-responsive">
                                <div class="card-body">
                                    <table class="table table-hover table-bordered" id="sktmTableSelesai">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Pemohon</th>
                                                <th>Alamat Pemohon</th>
                                                <th>Tujuan Pengajuan</th>
                                                <th>Keterangan</th>
                                                <th>Tanggal Pengajuan</th>
                                                <th class="text-center align-middle">Status</th>
                                                <th class="text-center align-middle">Aksi</th>
                                            </tr>
                                            @php
                                                $user = auth()->user();
                                            @endphp
                                        <tbody>

                                            @forelse($sktmSelesai as $item)
                                                @if ($user->role !== 'Masyarakat' || $item->user_id === $user->id)
                                                    <tr>
                                                        <td></td>
                                                        <td>{{ $item->nama }}</td>
                                                        <td>{{ $item->alamat }}</td>
                                                        <td>{{ $item->tujuan }}</td>
                                                        @php
                                                            $riwayatSelesai = $item->riwayat_sktm
                                                                ->where('status', 'Selesai')
                                                                ->last();
                                                        @endphp
                                                        <td>{{ $riwayatSelesai?->alasan ?? '-' }}</td>
                                                        <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y') }}
                                                        </td>
                                                        <td class="text-center align-middle">
                                                            @php
                                                                $badgeClass = match ($item->status) {
                                                                    'Selesai' => 'bg-success',
                                                                };
                                                            @endphp
                                                            <span
                                                                class="badge {{ $badgeClass }} fs-6 py-2 px-3 rounded-3">
                                                                {{ ucfirst($item->status) }}
                                                            </span>
                                                        </td>
                                                        <td class="text-center align-middle">
                                                            <div class="btn-group">

                                                                <a class="btn btn-white me-2" style="color: #2E8B57;"
                                                                    href="{{ route('sktm.show', $item->id) }}">
                                                                    <i class="bi bi-info-circle fs-5"></i>
                                                                </a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endif
                                            @empty
                                                <tr>
                                                    <td colspan="8" class="text-center text-muted">Tidak ada data
                                                        selesai</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        {{-- TAB 3: Ditolak --}}
                        <div class="tab-pane fade" id="ditolak" role="tabpanel">
                            <div class="table-responsive">
                                <div class="card-body">
                                    <table class="table table-hover table-bordered" id="sktmTableDitolak">
                                        <thead>
                                            <tr>
                                                <th>No</th>

                                                <th>Nama Pemohon</th>
                                                <th>Alamat Pemohon</th>
                                                <th>Tujuan Pengajuan</th>
                                                <th>Alasan Penolakan</th>
                                                <th>Tanggal Pengajuan</th>
                                                <th class="text-center align-middle">Status</th>
                                                <th class="text-center align-middle">Aksi</th>
                                            </tr>
                                        </thead>
                                        @php
                                            $user = auth()->user();
                                        @endphp
                                        <tbody>

                                            @forelse($sktmDitolak as $item)
                                                @if ($user->role !== 'Masyarakat' || $item->user_id === $user->id)
                                                    <tr>
                                                        <td></td>

                                                        <td>{{ $item->nama }}</td>
                                                        <td>{{ $item->alamat }}</td>
                                                        <td>{{ $item->tujuan }}</td>
                                                        @php
                                                            $riwayatDitolak = $item->riwayat_sktm
                                                                ->where('status', 'Ditolak')
                                                                ->last();
                                                        @endphp
                                                        <td>{{ $riwayatDitolak?->alasan ?? '-' }}</td>
                                                        <td>
                                                            {{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y') }}
                                                        </td>

                                                        {{-- <td>{{ $item->riwayat_sktm->alasan}}</td> --}}
                                                        <td class="text-center align-middle">
                                                            @php
                                                                $badgeClass = match ($item->status) {
                                                                    'Ditolak' => 'bg-danger text-white',
                                                                };
                                                            @endphp
                                                            <span
                                                                class="badge {{ $badgeClass }} fs-6 py-2 px-3 rounded-3">
                                                                {{ ucfirst($item->status) }}
                                                            </span>
                                                        </td>
                                                        <td class="text-center align-middle">
                                                            <div class="btn-group">
                                                                <a class="btn btn-white me-2" style="color: #2E8B57;"
                                                                    href="{{ route('sktm.show', $item->id) }}">
                                                                    <i class="bi bi-info-circle fs-5"></i>
                                                                </a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endif
                                            @empty
                                                <tr>
                                                    <td colspan="8" class="text-center text-muted">Tidak ada data
                                                        ditolak</td>
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
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form id="formPengajuanSKTM" action="{{ route('sktm.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTambahLabel">Tambah Pengajuan Surat</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Pemohon <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="nama" class="form-control" required
                                placeholder="Masukkan Nama Lengkap"
                                oninvalid="this.setCustomValidity('Silakan isi nama lengkap')"
                                oninput="this.setCustomValidity('')">
                        </div>

                        <div class="mb-3">
                            <label for="tujuan" class="form-label">Tujuan <span class="text-danger">*</span></label>
                            <input type="text" name="tujuan" class="form-control" required
                                placeholder="Masukkan Tujuan"
                                oninvalid="this.setCustomValidity('Silakan isi tujuan pengajuan')"
                                oninput="this.setCustomValidity('')">
                        </div>
                        <div class="mb-3">
                            <label for="pekerjaan" class="form-label">Pekerjaan <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="pekerjaan" class="form-control" required
                                placeholder="Masukkan Pekerjaan"
                                oninvalid="this.setCustomValidity('Silakan isi pekerjaan pengajuan')"
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
                            <label for="tempatLahir" class="form-label">Tempat Lahir <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="tempatLahir" class="form-control" required
                                placeholder="Masukkan Tempat Lahir"
                                oninvalid="this.setCustomValidity('Silakan isi tempat lahir')"
                                oninput="this.setCustomValidity('')">
                        </div>

                        <div class="mb-3">
                            <label for="tanggalLahir" class="form-label">Tanggal Lahir <span
                                    class="text-danger">*</span></label>
                            <input type="date" name="tanggalLahir" class="form-control" required
                                oninvalid="this.setCustomValidity('Silakan pilih tanggal lahir')"
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
                            <label for="nik" class="form-label">NIK <span class="text-danger">*</span></label>
                            <input type="text" name="nik" id="nik" class="form-control" required
                                oninvalid="this.setCustomValidity('Silahkan isi nik')"
                                oninput="this.setCustomValidity('')" placeholder="Masukkan NIK" maxlength="16">
                        </div>

                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat <span class="text-danger">*</span></label>
                            <textarea name="alamat" class="form-control" rows="1" required placeholder="Masukkan Alamat"
                                oninvalid="this.setCustomValidity('Silakan isi alamat')" oninput="this.setCustomValidity('')"></textarea>
                        </div>
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label for="rt" class="form-label">RT <span class="text-danger">*</span></label>
                                <input type="text" name="rt" id="rt" class="form-control" required
                                    maxlength="3" pattern="^\d{3}$" placeholder="Contoh: 001"
                                    oninvalid="this.setCustomValidity('Isi 3 digit angka, contoh: 001')"
                                    oninput="this.setCustomValidity('')">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="rw" class="form-label">RW <span class="text-danger">*</span></label>
                                <input type="text" name="rw" id="rw" class="form-control" required
                                    maxlength="3" pattern="^\d{3}$" placeholder="Contoh: 002"
                                    oninvalid="this.setCustomValidity('Isi 3 digit angka, contoh: 002')"
                                    oninput="this.setCustomValidity('')">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="keterangan" class="form-label">Keterangan </label>
                            <textarea name="keterangan" class="form-control" rows="2" placeholder="Masukkan Keterangan (optional)"></textarea>
                        </div>

                        <!-- INPUT FILE -->
                        <div class="mb-3">
                            <label for="pengantar_rt_rw" class="form-label">Surat Pengantar RT/RW <span
                                    class="text-danger">*</span></label>
                            <input type="file" name="pengantar_rt_rw" id="pengantar_rt_rw" class="form-control"
                                accept=".jpg,.jpeg,.png,.pdf" required
                                oninvalid="this.setCustomValidity('Silakan unggah surat pengantar RT/RW')"
                                oninput="this.setCustomValidity('')">
                            <small class="form-text text-muted">Tipe File : JPG,PNG,PDF | Ukuran Maksimal :
                                2MB.</small>
                        </div>

                        <div class="mb-3">
                            <label for="kk" class="form-label">Kartu Keluarga <span
                                    class="text-danger">*</span></label>
                            <input type="file" name="kk" id="kk" class="form-control"
                                accept=".jpg,.jpeg,.png,.pdf" required
                                oninvalid="this.setCustomValidity('Silakan unggah file KK')"
                                oninput="this.setCustomValidity('')">
                            <small class="form-text text-muted">Tipe File : JPG,PNG,PDF | Ukuran Maksimal :
                                2MB.</small>
                        </div>

                        <div class="mb-3">
                            <label for="ktp" class="form-label">Kartu Tanda Penduduk <span
                                    class="text-danger">*</span></label>
                            <input type="file" name="ktp" id="ktp" class="form-control"
                                accept=".jpg,.jpeg,.png,.pdf" required
                                oninvalid="this.setCustomValidity('Silakan unggah file KTP')"
                                oninput="this.setCustomValidity('')">
                            <small class="form-text text-muted">Tipe File : JPG,PNG,PDF | Ukuran Maksimal :
                                2MB.</small>
                        </div>

                        <div class="mb-3">
                            <label for="surat_pernyataan" class="form-label">Surat Pernyataan <span
                                    class="text-danger">*</span></label>
                            <input type="file" name="surat_pernyataan" id="surat_pernyataan" class="form-control"
                                accept=".jpg,.jpeg,.png,.pdf" required
                                oninvalid="this.setCustomValidity('Silakan unggah surat pernyataan')"
                                oninput="this.setCustomValidity('')">
                            <small class="form-text text-muted">Tipe File : JPG,PNG,PDF | Ukuran Maksimal :
                                2MB.</small>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-warning" id="btnSimpanDraf">Simpan Sebagai Draf</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>


                </form>
            </div>
        </div>
    </div>

@endsection


@push('scripts')
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



    {{-- <script>
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
    console.log("Mulai inisialisasi DataTable");
    console.log("DataTable defined?", $.fn.dataTable); // Cek apakah DataTable sudah tersedia

    inisialisasiDataTable('#sktmTableBelumSelesai');
});


        $(document).ready(function() {
            inisialisasiDataTable('#sktmTableBelumSelesai');
            inisialisasiDataTable('#sktmTableSelesai');
            inisialisasiDataTable('#sktmTableDitolak');
        });
    </script> --}}

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('formPengajuanSKTM');

            form.addEventListener('submit', function(e) {
                e.preventDefault();

                Swal.fire({
                    title: 'Yakin mau menyimpan?',
                    text: 'Pastikan semua data sudah benar.',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Simpan',
                    cancelButtonText: 'Batal',
                    confirmButtonColor: '#d33', // warna merah (seperti tombol "Tolak")
                    cancelButtonColor: '#6c757d', // abu Bootstrap
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
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



    <script>
        function inisialisasiDataTable(idTabel) {
            if ($.fn.DataTable.isDataTable(idTabel)) {
                $(idTabel).DataTable().destroy();
            }

            $(idTabel + ' tbody tr').each(function(index, row) {
                const tdCount = $(row).find('td').length;
                const thCount = $(idTabel + ' thead th').length;
                if (tdCount !== thCount) {
                    console.warn(`⚠️ Jumlah kolom td (${tdCount}) ≠ th (${thCount})`);
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
            inisialisasiDataTable('#sktmTableBelumSelesai');
            inisialisasiDataTable('#sktmTableSelesai');
            inisialisasiDataTable('#sktmTableDitolak');
        });
    </script>

    <script>
    $(document).ready(function () {
        // Setup CSRF untuk semua request Ajax
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Ambil data draf ketika modal dibuka
        $('#modalTambahPengajuan').on('shown.bs.modal', function () {
            $.get("{{ route('sktm.getDraf') }}", function (data) {
                if (data) {
                    $('#formPengajuanSKTM input[name="nama"]').val(data.nama);
                    $('#formPengajuanSKTM input[name="tujuan"]').val(data.tujuan);
                    $('#formPengajuanSKTM input[name="pekerjaan"]').val(data.pekerjaan);
                    $('#formPengajuanSKTM select[name="jenis_kelamin"]').val(data.jenis_kelamin);
                    $('#formPengajuanSKTM input[name="tempatLahir"]').val(data.tempatLahir);
                    $('#formPengajuanSKTM input[name="tanggalLahir"]').val(data.tanggalLahir);
                    $('#formPengajuanSKTM select[name="agama"]').val(data.agama);
                    $('#formPengajuanSKTM input[name="nik"]').val(data.nik);
                    $('#formPengajuanSKTM textarea[name="alamat"]').val(data.alamat);
                    $('#formPengajuanSKTM input[name="rt"]').val(data.rt);
                    $('#formPengajuanSKTM input[name="rw"]').val(data.rw);
                    $('#formPengajuanSKTM textarea[name="keterangan"]').val(data.keterangan);

                    // Tampilkan preview file jika ada
                    ['ktp', 'kk', 'pengantar_rt_rw', 'surat_pernyataan'].forEach(function (field) {
                        if (data[field]) {
                            const filePreview = `<a href="/draf/preview/${field}" target="_blank" class="d-block mt-1 text-primary">Lihat File Lama</a>`;
                            $(`#formPengajuanSKTM input[name="${field}"]`).after(filePreview);
                        }
                    });
                }
            }).fail(function () {
                console.warn("Tidak bisa ambil data draf.");
            });
        });

        // Tombol Simpan Draf
        $('#btnSimpanDraf').on('click', function () {
    const form = $('#formPengajuanSKTM')[0];
    const formData = new FormData(form);

    $.ajax({
        url: "{{ route('sktm.storeDraf') }}",
        method: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function (res) {
            alert('✅ Draf berhasil disimpan!');
            
            $('#modalTambahPengajuan').modal('hide');
           $('#modalTambahPengajuan').on('hidden.bs.modal', function () {
    $('body').removeClass('modal-open').css('overflow', '');
    $('.modal-backdrop').remove();
});

        },
        error: function (xhr, status, err) {
            let msg = '❌ Gagal menyimpan draf.';
            if (xhr.responseJSON && xhr.responseJSON.error) {
                msg += "\n" + xhr.responseJSON.error;
            }
            alert(msg);
            console.error(xhr.responseText);
        }
    });
});
});
</script>

@if (isset($drafToLoad))
    <script>
        $(document).ready(function () {
            const draf = @json($drafToLoad);

            // Isi form
            $('#formPengajuanSKTM input[name="nama"]').val(draf.nama);
            $('#formPengajuanSKTM input[name="tujuan"]').val(draf.tujuan);
            $('#formPengajuanSKTM input[name="pekerjaan"]').val(draf.pekerjaan);
            $('#formPengajuanSKTM select[name="jenis_kelamin"]').val(draf.jenis_kelamin);
            $('#formPengajuanSKTM input[name="tempatLahir"]').val(draf.tempatLahir);
            $('#formPengajuanSKTM input[name="tanggalLahir"]').val(draf.tanggalLahir);
            $('#formPengajuanSKTM select[name="agama"]').val(draf.agama);
            $('#formPengajuanSKTM input[name="nik"]').val(draf.nik);
            $('#formPengajuanSKTM textarea[name="alamat"]').val(draf.alamat);
            $('#formPengajuanSKTM input[name="rt"]').val(draf.rt);
            $('#formPengajuanSKTM input[name="rw"]').val(draf.rw);
            $('#formPengajuanSKTM textarea[name="keterangan"]').val(draf.keterangan);

            // Tambahkan link preview jika ada file
            ['ktp', 'kk', 'pengantar_rt_rw', 'surat_pernyataan'].forEach(function (field) {
                if (draf[field]) {
                    const preview = `<a href="/draf/preview/${field}" target="_blank" class="d-block mt-1 text-primary">Lihat File Lama</a>`;
                    $(`#formPengajuanSKTM input[name="${field}"]`).after(preview);
                }
            });

            // Buka modal otomatis
            $('#modalTambahPengajuan').modal('show');
        });
    </script>
@endif



@endpush

{{-- @push('scripts')

@if (Route::currentRouteName() === 'sktm.index')
    <script>
        $(document).ready(function() {
            // Ambil data draf ketika modal dibuka
            $('#modalTambahPengajuan').on('shown.bs.modal', function() {
                $.get("{{ route('sktm.getDraf') }}", function(data) {
                    if (data) {
                        $('#formPengajuanSKTM input[name="nama"]').val(data.nama);
                        $('#formPengajuanSKTM input[name="tujuan"]').val(data.tujuan);
                        $('#formPengajuanSKTM input[name="pekerjaan"]').val(data.pekerjaan);
                        $('#formPengajuanSKTM select[name="jenis_kelamin"]').val(data
                        .jenis_kelamin);
                        $('#formPengajuanSKTM input[name="tempatLahir"]').val(data.tempatLahir);
                        $('#formPengajuanSKTM input[name="tanggalLahir"]').val(data.tanggalLahir);
                        $('#formPengajuanSKTM select[name="agama"]').val(data.agama);
                        $('#formPengajuanSKTM input[name="nik"]').val(data.nik);
                        $('#formPengajuanSKTM textarea[name="alamat"]').val(data.alamat);
                        $('#formPengajuanSKTM input[name="rt"]').val(data.rt);
                        $('#formPengajuanSKTM input[name="rw"]').val(data.rw);
                        $('#formPengajuanSKTM textarea[name="keterangan"]').val(data.keterangan);

                        // Tampilkan link preview jika file ada
                        ['ktp', 'kk', 'pengantar_rt_rw', 'surat_pernyataan'].forEach(function(
                        field) {
                            if (data[field]) {
                                const filePreview =
                                    `<a href="/sktm/draf/preview/${field}" target="_blank">Lihat File</a>`;
                                $(`#formPengajuanSKTM input[name="${field}"]`).after(
                                    filePreview);
                            }
                        });
                    }
                });
            });

            // Tombol Simpan Draf
            $('#btnSimpanDraf').on('click', function(e) {
                e.preventDefault(); // ⛔ Cegah submit default JS
                e.stopPropagation(); // ⛔ Cegah event bubbling (penting untuk konflik tombol lain)

                let formData = new FormData($('#formPengajuanSKTM')[0]);

                $.ajax({
                    url: "{{ route('sktm.storeDraf') }}",
                    method: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(res) {
                        alert('Draf berhasil disimpan!');
                        $('#modalTambahPengajuan').modal('hide');
                    },
                    error: function(err) {
                        alert('Gagal menyimpan draf.');
                    }
                });
            });

        });
    </script>
@endif
    
@endpush --}}
