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
                                                <th>Tanggal Pengajuan</th>
                                                <th>Nama Pemohon</th>
                                                <th>Alamat Pemohon</th>
                                                <th>Pekerjaan Pemohon</th>
                                                <th>Tujuan Pengajuan</th>
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
                                                        <td>
                                                            {{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y') }}
                                                        </td>
                                                        <td>{{ $item->nama }}</td>
                                                        <td>{{ $item->alamat }}</td>
                                                        <td>{{ $item->pekerjaan }}</td>
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
                                                <th>Tanggal Pengajuan</th>
                                                <th>Nama Pemohon</th>
                                                <th>Alamat Pemohon</th>
                                                <th>Tujuan Pengajuan</th>
                                                <th>Keterangan</th>
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
                                                        <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y') }}
                                                        </td>
                                                        <td>{{ $item->nama }}</td>
                                                        <td>{{ $item->alamat }}</td>
                                                        <td>{{ $item->tujuan }}</td>
                                                        @php
                                                            $riwayatSelesai = $item->riwayat_sktm
                                                                ->where('status', 'Selesai')
                                                                ->last();
                                                        @endphp
                                                        <td>{{ $riwayatSelesai?->alasan ?? '-' }}</td>
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

                        {{-- TAB 1: Ditolak --}}
                        <div class="tab-pane fade" id="ditolak" role="tabpanel">
                            <div class="table-responsive">
                                <div class="card-body">
                                    <table class="table table-hover table-bordered" id="sktmTableDitolak">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Tanggal Pengajuan</th>
                                                <th>Nama Pemohon</th>
                                                <th>Alamat Pemohon</th>
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

                                            @forelse($sktmDitolak as $item)
                                                @if ($user->role !== 'Masyarakat' || $item->user_id === $user->id)
                                                    <tr>
                                                        <td></td>
                                                        <td>
                                                            {{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y') }}
                                                        </td>
                                                        <td>{{ $item->nama }}</td>
                                                        <td>{{ $item->alamat }}</td>
                                                        <td>{{ $item->tujuan }}</td>
                                                        @php
                                                            $riwayatDitolak = $item->riwayat_sktm
                                                                ->where('status', 'Ditolak')
                                                                ->last();
                                                        @endphp
                                                        <td>{{ $riwayatDitolak?->alasan ?? '-' }}</td>

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
                                placeholder="Masukkan NIK" maxlength="16">
                        </div>

                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat <span class="text-danger">*</span></label>
                            <textarea name="alamat" class="form-control" rows="2" required placeholder="Masukkan Alamat"
                                oninvalid="this.setCustomValidity('Silakan isi alamat')" oninput="this.setCustomValidity('')"></textarea>
                        </div>

                        <input type="hidden" name="tanggal" id="tanggal">

                        <div class="mb-3">
                            <label for="keterangan" class="form-label">Keterangan </label>
                            <textarea name="keterangan" class="form-control" rows="3" required placeholder="Masukkan Keterangan(optional)">
                                </textarea>
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
                        <button type="button" class="btn btn-warning" id="btnSimpanDraf">Simpan
                            Draf</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>


                </form>
            </div>
        </div>
    </div>

@endsection


@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


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
            inisialisasiDataTable('#sktmTableBelumSelesai');
            inisialisasiDataTable('#sktmTableSelesai');
            inisialisasiDataTable('#sktmTableDitolak');
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
        const form = document.getElementById('formPengajuanSKTM');
        const modal = document.getElementById('modalTambahPengajuan');
        const storageKey = 'draft_pengajuan_sktm';

        // Simpan Draf ke LocalStorage (optional backup)
        function simpanDrafLocal() {
            const data = {};
            form.querySelectorAll('input, textarea, select').forEach(el => {
                if (el.type !== 'file') {
                    data[el.name] = el.value;
                }
            });
            localStorage.setItem(storageKey, JSON.stringify(data));
        }

        // Simpan Draf ke Server
        document.getElementById('btnSimpanDraf').addEventListener('click', function() {
            const formData = new FormData(form);
            console.log('Response dari server:', data); // Tambah ini

            fetch("{{ route('sktm.draf.store') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: formData
                })
                .then(res => {
                    if (!res.ok) throw new Error("HTTP status " + res.status);
                    return res.json();
                })
                .then(data => {
                    console.log('✅ Response dari server:', data); // pindahkan ke sini

                    if (data.success) {
                        alert('✅ Draf berhasil disimpan!');
                        localStorage.removeItem(storageKey);

                        // Tutup modal
                        const modalInstance = bootstrap.Modal.getInstance(modal);
                        modalInstance.hide();
                    } else {
                        alert('❌ Gagal menyimpan draf.');
                    }
                })
                .catch(err => {
                    console.error("❌ Error saat simpan draf:", err);
                    alert('⚠️ Terjadi kesalahan.');
                });


            // Muat Draf Saat Modal Dibuka
            modal.addEventListener('shown.bs.modal', function() {
                // Load dari server
                fetch("{{ route('sktm.draf.get') }}")
                    .then(res => res.json())
                    .then(data => {
                        if (data) {
                            for (const key in data) {
                                const el = form.querySelector(`[name="${key}"]`);
                                if (el && el.type !== 'file') {
                                    el.value = data[key];
                                }

                                // Tampilkan link file lama
                                if (['ktp', 'kk', 'pengantar_rt_rw', 'surat_pernyataan'].includes(
                                        key) && data[
                                        key]) {
                                    const fileInput = form.querySelector(`#${key}`);
                                    const container = fileInput?.parentElement;
                                    if (container && !container.querySelector('.preview-link')) {
                                        const link = document.createElement('p');
                                        link.className = 'preview-link mt-1';
                                        link.innerHTML =
                                            `File sebelumnya: <a href="/draf/preview/${key}" target="_blank">Lihat</a>`;
                                        container.appendChild(link);
                                    }
                                }
                            }
                        } else {
                            // fallback ke localStorage (jika ada)
                            const localData = JSON.parse(localStorage.getItem(storageKey));
                            if (localData) {
                                Object.keys(localData).forEach(name => {
                                    const el = form.querySelector(`[name="${name}"]`);
                                    if (el && el.type !== 'file') {
                                        el.value = localData[name];
                                    }
                                });
                            }
                        }
                    });
            });

            // Simpan draf lokal tiap input
            form.querySelectorAll('input, textarea, select').forEach(el => {
                el.addEventListener('input', simpanDrafLocal);
            });

            // Bersihkan draf lokal saat submit
            form.addEventListener('submit', function() {
                localStorage.removeItem(storageKey);
            });
        });
    </script>
@endpush
