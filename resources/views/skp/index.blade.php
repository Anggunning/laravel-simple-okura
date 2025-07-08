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
                <span>Surat Keterangan Pengantar Perkawinan</span>
            </li>
        </ul>
    </div>
    <div class="title">
        <h4>Data Pengajuan Surat Keterangan Pengantar Perkawinan</h4>
    </div>
    <div class="row">
        <div class="col-md-12">
            <ul class="nav nav-tabs mb-3" id="skpTabs" role="tablist">
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
                                data-bs-target="#modalTambahSKP">
                                <i class="bi bi-plus-circle"></i> Tambah Pengajuan
                            </a>
                        @endif
                    </div>

                    {{-- Tab Contents --}}
                    <div class="tab-content" id="skpTabsContent">

                        {{-- TAB 1: Belum Selesai --}}
                        <div class="tab-pane fade show active" id="belum" role="tabpanel">
                            <div class="table-responsive">
                                <div class="card-body">
                                    <table class="table table-hover table-bordered" id="skpTableBelumSelesai">
                                        <thead>
                                            <tr>
                                                <th>No</th>

                                                <th>Nama Pemohon</th>
                                                <th>NIK Pemohon</th>
                                                <th>Alamat Pemohon</th>
                                                <th>Orang Tua Pemohon</th>
                                                <th>Tanggal Pengajuan</th>
                                                <th class="text-center align-middle">Status</th>
                                                <th class="text-center align-middle">Aksi</th>
                                            </tr>
                                        </thead>
                                        @php
                                            $user = auth()->user();
                                        @endphp
                                        <tbody>
                                            @forelse($skpBelumSelesai as $item)
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
                                                        <td>{{ $item->nik }}</td>
                                                        <td>{{ $item->alamat }}</td>
                                                        <td>{{ $item->orangTua->nama_ayah }} dan
                                                            {{ $item->orangTua->nama_ibu }}</td>
                                                        <td>
                                                            {{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y') }}
                                                        </td>

                                                        <td class="text-center align-middle">
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
                                                                    href="{{ route('skp.show', $item->id) }}">
                                                                    <i class="bi bi-info-circle fs-5"></i>
                                                                </a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endif
                                            @empty
                                                <tr>
                                                    <td colspan="8" class="text-center text-muted">Tidak ada data
                                                        pengajuan SKP.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        {{-- TAB 2: Selesai --}}
                        <div class="tab-pane fade show" id="selesai" role="tabpanel">
                            <div class="table-responsive">
                                <div class="card-body">
                                    <table class="table table-hover table-bordered" id="skpTableSelesai">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                
                                                <th>Nama Pemohon</th>
                                                <th>Alamat Pemohon</th>
                                                <th>Orang Tua Pemohon</th>
                                                <th>Keterangan</th>
                                                <th>Tanggal Pengajuan</th>
                                                <th class="text-center align-middle">Status</th>
                                                <th class="text-center align-middle">Aksi</th>
                                            </tr>
                                        </thead>
                                        @php
                                            $user = auth()->user();
                                        @endphp
                                        <tbody>
                                            @forelse($skpSelesai as $item)
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
                                                        <td>{{ $item->orangTua->nama_ayah }} dan
                                                            {{ $item->orangTua->nama_ibu }}</td>
                                                       
                                                        @php
                                                            $riwayatSelesai = $item->riwayat_skp
                                                                ->where('status', 'Selesai')
                                                                ->last();
                                                        @endphp
                                                        <td>{{ $riwayatSelesai?->alasan ?? '-' }}</td>
 <td>
                                                            {{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y') }}
                                                        </td>
                                                        <td class="text-center align-middle">
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
                                                                    href="{{ route('skp.show', $item->id) }}">
                                                                    <i class="bi bi-info-circle fs-5"></i>
                                                                </a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endif
                                            @empty
                                                <tr>
                                                    <td colspan="8" class="text-center text-muted">Tidak ada data
                                                        pengajuan SKP.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>


                        {{-- TAB 3: Ditolak --}}
                        <div class="tab-pane fade show" id="ditolak" role="tabpanel">
                            <div class="table-responsive">
                                <div class="card-body">
                                    <table class="table table-hover table-bordered" id="skpTableDitolak">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                
                                                <th>Nama Pemohon</th>
                                                <th>Alamat Pemohon</th>
                                                <th>Orang Tua Pemohon</th>
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
                                            @forelse($skpDitolak as $item)
                                                @if ($user->role !== 'Masyarakat' || $item->user_id === $user->id)
                                                    <tr>
                                                        <td></td>
                                                        
                                                        <td>{{ $item->nama }}</td>
                                                        <td>{{ $item->alamat }}</td>
                                                        <td>{{ $item->orangTua->nama_ayah }} dan
                                                            {{ $item->orangTua->nama_ibu }}</td>
                                                        @php
                                                            $riwayatDitolak = $item->riwayat_skp
                                                                ->where('status', 'Ditolak')
                                                                ->last();
                                                        @endphp
                                                        <td>{{ $riwayatDitolak?->alasan ?? '-' }}</td>
                                                        <td>
                                                            {{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y') }}
                                                        </td>
                                                        <td class="text-center align-middle">
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
                                                                    href="{{ route('skp.show', $item->id) }}">
                                                                    <i class="bi bi-info-circle fs-5"></i>
                                                                </a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endif
                                            @empty
                                                <tr>
                                                    <td colspan="8" class="text-center text-muted">Tidak ada data
                                                        pengajuan SKP.</td>
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


    <!-- Modal Tambah SKP -->
    <div class="modal fade" id="modalTambahSKP" tabindex="-1" aria-labelledby="modalTambahSKPLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

            <form id="formPengajuanSKP" action="{{ route('skp.store') }}" method="POST" enctype="multipart/form-data" class="modal-content">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahSKPLabel">Tambah Pengajuan SKP</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    {{-- Form isinya --}}
                    @include('skp._form', ['prefix' => '']) {{-- prefix kosong --}}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                     @if (auth()->user()->role === 'Masyarakat')
                            <button type="button" class="btn btn-warning" id="btnSimpanDraf">Simpan Sebagai
                                Draf</button>
                        @endif
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>

            </form>
        </div>
    </div>
    {{-- 
    <!-- Modal Edit SKP -->
    <div class="modal fade" id="modalEditSKP" tabindex="-1" aria-labelledby="modalEditSKPLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form method="POST" action="" enctype="multipart/form-data" class="modal-content" id="formEditSKP">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditSKPLabel">Edit Pengajuan SKP</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body row">
                    @include('skp._form', ['prefix' => 'edit_'])
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div> --}}
@endsection


@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

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
                    searchable: false,
                    
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
            inisialisasiDataTable('#skpTableBelumSelesai');
            inisialisasiDataTable('#skpTableSelesai');
            inisialisasiDataTable('#skpTableDitolak');
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
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#modalTambahSKP').on('shown.bs.modal', function () {
            $.get("{{ route('skp.getDraf') }}", function (data) {
                if (data) {
                    const form = $('#formPengajuanSKP');

                    // --- Data Pemohon ---
                    form.find('input[name="nama"]').val(data.nama);
                    form.find('input[name="nik"]').val(data.nik);
                    form.find('select[name="jenis_kelamin"]').val(data.jenis_kelamin);
                    form.find('input[name="tempat_lahir"]').val(data.tempat_lahir);
                    form.find('input[name="tanggal_lahir"]').val(data.tanggal_lahir);
                    form.find('input[name="kewarganegaraan"]').val(data.kewarganegaraan);
                    form.find('input[name="pekerjaan"]').val(data.pekerjaan);
                    form.find('select[name="agama"]').val(data.agama);
                    form.find('input[name="rt"]').val(data.rt);
                    form.find('input[name="rw"]').val(data.rw);
                    form.find('textarea[name="alamat"]').val(data.alamat);
                    form.find('textarea[name="keterangan"]').val(data.keterangan);
                    form.find('select[name="status_kawin"]').val(data.status_kawin);

                    // --- Data Ayah ---
                    form.find('input[name="nama_ayah"]').val(data.nama_ayah);
                    form.find('input[name="nik_ayah"]').val(data.nik_ayah);
                    form.find('input[name="tempat_lahir_ayah"]').val(data.tempat_lahir_ayah);
                    form.find('input[name="tanggal_lahir_ayah"]').val(data.tanggal_lahir_ayah);
                    form.find('input[name="kewarganegaraan_ayah"]').val(data.kewarganegaraan_ayah);
                    form.find('input[name="pekerjaan_ayah"]').val(data.pekerjaan_ayah);
                    form.find('select[name="agama_ayah"]').val(data.agama_ayah);
                    form.find('textarea[name="alamat_ayah"]').val(data.alamat_ayah);
                    form.find('input[name="rt_ayah"]').val(data.rt_ayah);
                    form.find('input[name="rw_ayah"]').val(data.rw_ayah);

                    // --- Data Ibu ---
                    form.find('input[name="nama_ibu"]').val(data.nama_ibu);
                    form.find('input[name="nik_ibu"]').val(data.nik_ibu);
                    form.find('input[name="tempat_lahir_ibu"]').val(data.tempat_lahir_ibu);
                    form.find('input[name="tanggal_lahir_ibu"]').val(data.tanggal_lahir_ibu);
                    form.find('input[name="kewarganegaraan_ibu"]').val(data.kewarganegaraan_ibu);
                    form.find('input[name="pekerjaan_ibu"]').val(data.pekerjaan_ibu);
                    form.find('select[name="agama_ibu"]').val(data.agama_ibu);
                    form.find('textarea[name="alamat_ibu"]').val(data.alamat_ibu);
                    form.find('input[name="rt_ibu"]').val(data.rt_ibu);
                    form.find('input[name="rw_ibu"]').val(data.rw_ibu);

                    // --- Preview file ---
                    ['ktp', 'kk', 'pengantar_rt_rw', 'foto'].forEach(function (field) {
                        if (data[field]) {
                            const preview = `<a href="/draf/preview/${field}" target="_blank" class="d-block mt-1 text-primary">Lihat File Lama</a>`;
                            form.find(`input[name="${field}"]`).after(preview);
                        }
                    });
                }
            }).fail(function () {
                console.warn("Tidak bisa ambil data draf SKP.");
            });
        });

        $('#btnSimpanDraf').on('click', function () {
            const form = $('#formPengajuanSKP');
const formData = new FormData();

// Ambil semua input, select, dan textarea (termasuk yang tersembunyi)
form.find('input, select, textarea').each(function () {
    const input = $(this);
    const name = input.attr('name');
    const type = input.attr('type');

    if (!name) return; // Lewati jika tidak punya name (tidak bisa dikirim)

    if (type === 'file') {
        const file = this.files[0];
        if (file) {
            formData.append(name, file);
        }
    } else {
        formData.append(name, input.val());
    }
});


            $.ajax({
                url: "{{ route('skp.storeDraf') }}",
                method: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function () {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Draf SKP berhasil disimpan.',
                        confirmButtonColor: '#3085d6',
                    }).then(() => {
                        $('#modalTambahSKP').modal('hide');
                        $('#modalTambahSKP').on('hidden.bs.modal', function () {
                            $('body').removeClass('modal-open').css('overflow', '');
                            $('.modal-backdrop').remove();
                        });
                    });
                },
                error: function (xhr) {
                    let msg = 'Gagal menyimpan draf.';
                    if (xhr.responseJSON?.error) {
                        msg += "\n" + xhr.responseJSON.error;
                    }
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops!',
                        text: msg,
                        confirmButtonColor: '#d33',
                    });
                    console.error(xhr.responseText);
                }
            });
        });
    });
</script>


    @if (request()->has('draf') && isset($drafToLoad))
        <script>
            $(document).ready(function() {
                const draf = @json($drafToLoad);

                 const form = $('#formPengajuanSKP');

                    // --- Data Pemohon ---
                    form.find('input[name="nama"]').val(draf.nama);
                    form.find('input[name="nik"]').val(draf.nik);
                    form.find('select[name="jenis_kelamin"]').val(draf.jenis_kelamin);
                    form.find('input[name="tempat_lahir"]').val(draf.tempat_lahir);
                    form.find('input[name="tanggal_lahir"]').val(draf.tanggal_lahir);
                    form.find('input[name="kewarganegaraan"]').val(draf.kewarganegaraan);
                    form.find('input[name="pekerjaan"]').val(draf.pekerjaan);
                    form.find('select[name="agama"]').val(draf.agama);
                    form.find('input[name="rt"]').val(draf.rt);
                    form.find('input[name="rw"]').val(draf.rw);
                    form.find('textarea[name="alamat"]').val(draf.alamat);
                    form.find('textarea[name="keterangan"]').val(draf.keterangan);
                    form.find('select[name="status_kawin"]').val(draf.status_kawin);

                    // --- draf Ayah ---
                    form.find('input[name="nama_ayah"]').val(draf.nama_ayah);
                    form.find('input[name="nik_ayah"]').val(draf.nik_ayah);
                    form.find('input[name="tempat_lahir_ayah"]').val(draf.tempat_lahir_ayah);
                    form.find('input[name="tanggal_lahir_ayah"]').val(draf.tanggal_lahir_ayah);
                    form.find('input[name="kewarganegaraan_ayah"]').val(draf.kewarganegaraan_ayah);
                    form.find('input[name="pekerjaan_ayah"]').val(draf.pekerjaan_ayah);
                    form.find('select[name="agama_ayah"]').val(draf.agama_ayah);
                    form.find('textarea[name="alamat_ayah"]').val(draf.alamat_ayah);
                    form.find('input[name="rt_ayah"]').val(draf.rt_ayah);
                    form.find('input[name="rw_ayah"]').val(draf.rw_ayah);

                    // --- draf Ibu ---
                    form.find('input[name="nama_ibu"]').val(draf.nama_ibu);
                    form.find('input[name="nik_ibu"]').val(draf.nik_ibu);
                    form.find('input[name="tempat_lahir_ibu"]').val(draf.tempat_lahir_ibu);
                    form.find('input[name="tanggal_lahir_ibu"]').val(draf.tanggal_lahir_ibu);
                    form.find('input[name="kewarganegaraan_ibu"]').val(draf.kewarganegaraan_ibu);
                    form.find('input[name="pekerjaan_ibu"]').val(draf.pekerjaan_ibu);
                    form.find('select[name="agama_ibu"]').val(draf.agama_ibu);
                    form.find('textarea[name="alamat_ibu"]').val(draf.alamat_ibu);
                    form.find('input[name="rt_ibu"]').val(draf.rt_ibu);
                    form.find('input[name="rw_ibu"]').val(draf.rw_ibu);

                    // --- Preview file ---
                     ['ktp', 'kk', 'pengantar_rt_rw', 'foto'].forEach(function(field) {
                    if (draf[field]) {
                        const preview =
                            `<a href="/draf/preview/${field}" target="_blank" class="d-block mt-1 text-primary">Lihat File Lama</a>`;
                        $(`#formPengajuanSKP input[name="${field}"]`).after(preview);
                    }
                });
        
                // Buka modal otomatis
                $('#modalTambahSKP').modal('show');
            });
        </script>
    @endif

     {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('formPengajuanSKP');

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
                        form.requestSubmit();

                    }
                });
            });
        });
    </script> --}}




@endpush
