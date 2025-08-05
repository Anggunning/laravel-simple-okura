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
        </ul>
    </div>
    <div class="title">

    </div>
    @if (auth()->user()->role !== 'Masyarakat')
        <div class="row justify-content-start">

            <div class="col-sm-6 col-md-4 col-lg-2 mb-3">
                <div class="card shadow-sm border-warning">
                    <div class="card-body d-flex align-items-center">
                        <i class="bi bi-folder2 text-warning me-2 fs-5"></i>
                        <div>
                            <h6 class="mb-1">Total Pengajuan Surat Keterangan Tidak Mampu</h6>
                            <p class="mb-0">{{ $sktm['total'] }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-4 col-lg-2 mb-3">
                <div class="card shadow-sm border-info">
                    <div class="card-body d-flex align-items-center">
                        <i class="bi bi-folder2 text-info me-2 fs-5"></i>
                        <div>
                            <h6 class="mb-1">Total Pengajuan Surat Keterangan Usaha</h6>
                            <p class="mb-0">{{ $sku['total'] }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-4 col-lg-2 mb-3">
                <div class="card shadow-sm border-primary">
                    <div class="card-body d-flex align-items-center">
                        <i class="bi bi-folder2 text-primary me-2 fs-5"></i>
                        <div>
                            <h6 class="mb-1">Total Pengajuan Surat Pengantar Perkawinan</h6>
                            <p class="mb-0">{{ $skp['total'] }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-4 col-lg-2 mb-3">
                <div class="card shadow-sm border-info">
                    <div class="card-body d-flex align-items-center">
                        <i class="bi bi-people text-primary me-2 fs-5"></i>
                        <div>
                            <h6 class="mb-1">Total Penduduk Miskin</h6>
                            <p class="mb-0">{{ $jumlahPendudukMiskin }}</p>
                        </div>
                    </div>
                </div>
            </div>
            @if (auth()->user()->role == 'Admin')
                <div class="col-sm-6 col-md-4 col-lg-2 mb-3">
                    <div class="card shadow-sm border-primary">
                        <div class="card-body d-flex align-items-center">
                            <i class="bi bi-person text-primary me-2 fs-5"></i>
                            <div>
                                <h6 class="mb-1">Total Pengguna</h6>
                                <p class="mb-0">{{ $jumlahPengguna }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    @endif

    <div class="row mt-4">
        <div class="col-12">
            <div class="d-flex flex-wrap gap-4">
                {{-- SKTM --}}
                <div class="card shadow-sm border rounded flex-fill" style="min-width: 320px; max-width: 360px;">
                    <div class="card-header bg-primary text-white fw-semibold py-2 fs-6">
                        Surat Keterangan Tidak Mampu
                    </div>
                    <div class="card-body small">
                        <p class="mb-1 fw-semibold">Dokumen Persyaratan Pengajuan:</p>
                        <ul class="ps-3 mb-2">
                            <li>Fotokopi KTP</li>
                            <li>Fotokopi KK</li>
                            <li>Surat pengantar RT/RW</li>
                            <li>
                                Surat pernyataan <br>
                                <span class="text-muted">(ditandatangani di atas materai 10.000)</span><br>
                                <a href="{{ asset('contoh/Format_Surat_Pernyataan.docx') }}"
                                    class="fw-bold text-decoration-none small" style="color: #093FB4;" download>
                                    <i class="bi bi-file-earmark-text"></i> Format Surat Pernyataan
                                </a>
                            </li>
                        </ul>
                        <hr>
                        <p class="mb-1 fw-semibold">Alur Pengajuan:</p>
                        <ol class="ps-3 mb-2">
                            <li>Isi formulir dan unggah dokumen</li>
                            <li>Petugas kelurahan akan memverifikasi</li>
                            <li>Surat dapat diambil jika sudah disetujui</li>
                        </ol>
                        <p class="mb-0 text-muted"><i class="bi bi-clock"></i> Estimasi proses: 1–3 hari kerja</p>
                    </div>
                </div>
                {{-- SKU --}}
                <div class="card shadow-sm border rounded flex-fill" style="min-width: 320px; max-width: 360px;">
                    <div class="card-header bg-primary text-white fw-semibold py-2 fs-6">
                        Surat Keterangan Usaha
                    </div>
                    <div class="card-body small">
                        <p class="mb-1 fw-semibold">Dokumen Persyaratan Pengajuan:</p>
                        <ul class="ps-3 mb-2">
                            <li>Fotokopi KTP</li>
                            <li>Fotokopi KK</li>
                            <li>Foto usaha</li>
                            <li>Surat pengantar RT/RW</li>
                            <li>
                                Surat pernyataan usaha <br>
                                <span class="text-muted">(ditandatangani di atas materai 10.000)</span><br>
                                <a href="{{ asset('contoh/Format_Surat_Pernyataan_Usaha.docx') }}"
                                    class="fw-bold text-decoration-none small" style="color: #093FB4;" download>
                                    <i class="bi bi-file-earmark-text"></i> Format Surat Pernyataan
                                </a>
                            </li>
                            
                        </ul>
                        <hr>
                        <p class="mb-1 fw-semibold">Alur Pengajuan:</p>
                        <ol class="ps-3 mb-2">
                            <li>Isi formulir dan unggah dokumen</li>
                            <li>Petugas akan melakukan verifikasi lapangan jika perlu</li>
                            <li>Surat dapat diambil jika sudah disetujui</li>
                        </ol>
                        <p class="mb-0 text-muted"><i class="bi bi-clock"></i> Estimasi proses: 1–3 hari kerja</p>
                    </div>
                </div>

                {{-- SKP --}}
                <div class="card shadow-sm border rounded flex-fill" style="min-width: 320px; max-width: 360px;">
                    <div class="card-header bg-primary text-white fw-semibold py-2 fs-6">
                        Surat Pengantar Perkawinan
                    </div>
                    <div class="card-body small">
                        <p class="mb-1 fw-semibold">Dokumen Persyaratan Pengajuan:</p>
                        <ul class="ps-3 mb-2">
                            <li>Fotokopi KK</li>
                            <li>Fotokopi KTP</li>
                            <li>Surat pengantar RT/RW</li>
                            <li>Pas foto latar biru 3x4</li>

                        </ul>
                        <hr>
                        <p class="mb-1 fw-semibold">Alur Pengajuan:</p>
                        <ol class="ps-3 mb-2">
                            <li>Lengkapi formulir dan dokumen</li>
                            <li>Verifikasi oleh petugas</li>
                            <li>Surat dapat diambil jika sudah disetujui</li>
                        </ol>
                        <p class="mb-0 text-muted"><i class="bi bi-clock"></i> Estimasi proses: 1–3 hari kerja</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 1 -->
    @if (auth()->user()->role !== 'Masyarakat')
        <div class="row mt-4">
            <div class="col-12">
                <div class="d-flex flex-wrap gap-4">

                    {{-- SKTM --}}
                    <a href="{{ route('sktm.index') }}" class="text-decoration-none text-dark flex-fill"
                        style="min-width: 320px; max-width: 360px;">
                        <div class="card shadow-sm border rounded h-100">
                            <div class="card-header bg-primary text-white fw-semibold py-2 fs-6">
                                Surat Keterangan Tidak Mampu
                            </div>
                            <div class="card-body small">
                                <p class="mb-1 fw-semibold">Rekap Total Pengajuan:</p>
                                <div class="d-flex justify-content-between">
                                    <span>Diajukan</span>
                                    <span class="badge bg-secondary">{{ $sktm['diajukan'] }}</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span>Diproses</span>
                                    <span class="badge bg-warning text-dark">{{ $sktm['diproses'] }}</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span>Selesai</span>
                                    <span class="badge bg-success">{{ $sktm['selesai'] }}</span>
                                </div>
                                <p class="mt-3 text-muted small"><i class="bi bi-clock"></i> Dari Pengajuan di tahun ini</p>
                            </div>
                        </div>
                    </a>

                    {{-- SKU --}}
                    <a href="{{ route('sku.index') }}" class="text-decoration-none text-dark flex-fill"
                        style="min-width: 320px; max-width: 360px;">
                        <div class="card shadow-sm border rounded h-100">
                            <div class="card-header bg-primary text-white fw-semibold py-2 fs-6">
                                Surat Keterangan Usaha
                            </div>
                            <div class="card-body small">
                                <p class="mb-1 fw-semibold">Rekap Total Pengajuan:</p>
                                <div class="d-flex justify-content-between">
                                    <span>Diajukan</span>
                                    <span class="badge bg-secondary">{{ $sku['diajukan'] }}</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span>Diproses</span>
                                    <span class="badge bg-warning text-dark">{{ $sku['diproses'] }}</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span>Selesai</span>
                                    <span class="badge bg-success">{{ $sku['selesai'] }}</span>
                                </div>
                                <p class="mt-3 text-muted small"><i class="bi bi-clock"></i> Dari Pengajuan di tahun ini
                                </p>
                            </div>
                        </div>
                    </a>

                    {{-- SKP --}}
                    <a href="{{ route('skp.index') }}" class="text-decoration-none text-dark flex-fill"
                        style="min-width: 320px; max-width: 360px;">
                        <div class="card shadow-sm border rounded h-100">
                            <div class="card-header bg-primary text-white fw-semibold py-2 fs-6">
                                Surat Pengantar Perkawinan
                            </div>
                            <div class="card-body small">
                                <p class="mb-1 fw-semibold">Rekap Total Pengajuan:</p>
                                <div class="d-flex justify-content-between">
                                    <span>Diajukan</span>
                                    <span class="badge bg-secondary">{{ $skp['diajukan'] }}</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span>Diproses</span>
                                    <span class="badge bg-warning text-dark">{{ $skp['diproses'] }}</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span>Selesai</span>
                                    <span class="badge bg-success">{{ $skp['selesai'] }}</span>
                                </div>
                                <p class="mt-3 text-muted small"><i class="bi bi-clock"></i> Dari Pengajuan di tahun ini
                                </p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    @endif

    @if (auth()->user()->role == 'Masyarakat')
        <div class="row mt-4">
            <div class="col-12">
                <div class="d-flex flex-wrap gap-4">
                    {{-- Draf SKTM --}}
                    <div class="card shadow-sm border rounded flex-fill" style="min-width: 320px; max-width: 360px;">
                        <div class="card-header bg-primary text-white fw-semibold py-2 fs-6">
                            Draf Surat Keterangan Tidak Mampu
                        </div>
                        <div class="card-body p-3">
                            @if ($drafSktm->count())
                                <div class="table-responsive small">
                                    <table class="table table-bordered table-sm mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Nama</th>
                                                <th>Tujuan</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($drafSktm as $item)
                                                <tr>
                                                    <td>{{ $item->nama }}</td>
                                                    <td>{{ $item->tujuan }}</td>
                                                    <td class="nowrap">
                                                        <a href="{{ route('sktm.index', ['draf' => $item->id]) }}"
                                                            class="btn btn-sm btn-info text-white">Lanjut</a>
                                                        <form action="{{ route('sktm.destroy', $item->id) }}"
                                                            method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="button" class="btn btn-sm btn-danger"
                                                                onclick="konfirmasiHapus('{{ $item->id }}')">
                                                                Hapus
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <p class="text-muted small mb-0">Tidak ada draf SKTM.</p>
                            @endif
                        </div>
                    </div>

                    {{-- Draf SKU --}}
                    <div class="card shadow-sm border rounded flex-fill" style="min-width: 320px; max-width: 360px;">
                        <div class="card-header bg-primary text-white fw-semibold py-2 fs-6">
                            Draf Surat Keterangan Usaha
                        </div>
                        <div class="card-body p-3">
                            @if ($drafSku->count())
                                <div class="table-responsive small">
                                    <table class="table table-bordered table-sm mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Nama</th>
                                                <th>Tujuan</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($drafSku as $item)
                                                <tr>
                                                    <td>{{ $item->nama }}</td>
                                                    <td>{{ $item->tujuan }}</td>
                                                    <td class="nowrap">
                                                        <div class="d-flex gap-1">
                                                            <a href="{{ route('sku.index', ['draf' => $item->id]) }}"
                                                                class="btn btn-sm btn-info text-white">Lanjut</a>
                                                            <form action="{{ route('sku.destroy', $item->id) }}"
                                                                method="POST" class="d-inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="button" class="btn btn-sm btn-danger"
                                                                    onclick="konfirmasiHapus('{{ $item->id }}')">Hapus</button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <p class="text-muted small mb-0">Tidak ada draf SKU.</p>
                            @endif
                        </div>
                    </div>

                    {{-- Draf SKP --}}
                    <div class="card shadow-sm border rounded flex-fill" style="min-width: 320px; max-width: 360px;">
                        <div class="card-header bg-primary text-white fw-semibold py-2 fs-6">
                            Draf Surat Pengantar Perkawinan
                        </div>
                        <div class="card-body p-3">
                            @if ($drafSkp->count())
                                <div class="table-responsive small">
                                    <table class="table table-bordered table-sm mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Nama</th>
                                                <th>Tujuan</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($drafSkp as $item)
                                                <tr>
                                                    <td>{{ $item->nama }}</td>
                                                    <td>Pengantar Pernikahan</td>
                                                    <td class="nowrap">
                                                        <a href="{{ route('skp.index', ['draf' => $item->id]) }}"
                                                            class="btn btn-sm btn-info text-white">Lanjut</a>
                                                        <form id="formHapus-{{ $item->id }}"
                                                            action="{{ route('skp.destroy', $item->id) }}" method="POST"
                                                            class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button id="btnHapus-{{ $item->id }}" type="button"
                                                                class="btn btn-sm btn-danger"
                                                                onclick="konfirmasiHapus('{{ $item->id }}')">
                                                                Hapus
                                                            </button>
                                                        </form>

                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <p class="text-muted small mb-0">Tidak ada draf SKP.</p>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>
    @endif
    @if (auth()->user()->role == 'Masyarakat')
        <div class="row mt-4">
            <div class="col-12">
                <div class="card-header bg-primary text-white rounded-top-2">
                    <h6 class="mb-0">Riwayat Pengajuan Surat Selesai</h6>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Jenis Surat</th>
                                <th>Tujuan Surat</th>
                                <th>Keterangan</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($riwayat->whereIn('status', ['Selesai', 'Ditolak'])->sortByDesc('created_at')->take(8) as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item['jenis'] }}</td>
                                    <td>{{ $item['tujuan'] }}</td>
                                    <td>
                                        @if ($item['status'] === 'Selesai')
                                            {{ $item['alasan'] ?? '-' }}
                                        @elseif ($item['status'] === 'Ditolak')
                                            <span class="text-danger">{{ $item['alasan'] ?? '-' }}</span>
                                        @else
                                            -
                                        @endif
                                    </td>

                                    <td>
                                        <span
                                            class="badge 
                    @if ($item['status'] == 'Selesai') bg-success
                    @elseif($item['status'] == 'Ditolak') bg-danger
                    @else bg-dark @endif">
                                            <span class="badge rounded-3">
                                                {{ ucfirst($item['status']) }}
                                            </span>
                                    </td>
                                    <td>
                                        <div class="button-group d-flex">
                                            <a href="{{ $item['link_detail'] }}"
                                                class="btn btn-sm btn-info text-white me-1">
                                                Detail <i class="bi bi-info-circle"></i>
                                            </a>
                                            @if ($item['link_download'])
                                                <a href="{{ $item['link_download'] }}"
                                                    class="btn btn-sm btn-primary text-white">
                                                    Unduh <i class="bi bi-printer"></i>
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">Belum ada pengajuan yang selesai
                                        atau
                                        ditolak.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif

@endsection
@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

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
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil Login!',
                text: '{{ session('success') }}',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK'
            });
        @endif
    </script>
@endpush
