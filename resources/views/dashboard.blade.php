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
    <div class="row">
        @if (auth()->user()->role !== 'Masyarakat')
            @if (auth()->user()->role == 'Admin')
                <div class="col-md-6 col-lg-3">
                    <div class="widget-small primary coloured-icon"><i class="icon bi bi-person fs-1"></i>
                        <div class="info">
                            <h4>Pengguna</h4>
                            <p><b>{{ $jumlahPengguna }}</b></p>
                        </div>
                    </div>
                </div>
            @endif
            <div class="col-md-6 col-lg-3">
                <div class="widget-small info coloured-icon"><i class="icon bi bi-people fs-1"></i>
                    <div class="info">
                        <h4>Penduduk Miskin</h4>
                        <p><b>{{ $jumlahPendudukMiskin }}</b></p>
                    </div>
                </div>
            </div>
        @endif
        <div class="col-md-6 col-lg-3">
            <div class="widget-small warning coloured-icon"><i class="icon bi bi-folder2 fs-1"></i>
                <div class="info">
                    <h4>SKTM</h4>
                    <p><b>{{ $sktm['total'] }}</b></p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="widget-small info coloured-icon"><i class="icon bi bi-folder2 fs-1"></i>
                <div class="info">
                    <h4>SKU</h4>

                    <p><b>{{ $sku['total'] }}</b></p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="widget-small primary coloured-icon"><i class="icon bi bi-folder2 fs-1"></i>
                <div class="info">
                    <h4>SKP</h4>
                    <p><b>{{ $skp['total'] }}</b></p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="cards">
            <!-- Card 1 -->
            @if (auth()->user()->role !== 'Masyarakat')
                <div class="cards d-flex gap-3 mt-4" style="flex-wrap: wrap;">
                    <a href="{{ route('sktm.index') }}" class="card card-yellow text-decoration-none text-dark"
                        style="cursor:pointer; width: 300px; flex-shrink: 0;">
                        <div class="card-header">Surat Keterangan Tidak Mampu</div>
                        <div class="card-body">
                            <div class="card-title">Rekap Total Pengajuan:</div>
                            <div class="card-row d-flex justify-content-between">
                                <span>Diajukan</span>
                                <span class="badge gray">{{ $sktm['diajukan'] }}</span>
                            </div>
                            <div class="card-row d-flex justify-content-between">
                                <span>Diproses</span>
                                <span class="badge yellow">{{ $sktm['diproses'] }}</span>
                            </div>
                            <div class="card-row d-flex justify-content-between">
                                <span>Selesai</span>
                                <span class="badge green">{{ $sktm['selesai'] }}</span>
                            </div>
                            <div class="card-footer mt-3 text-muted">Dari Pengajuan di tahun ini</div>
                        </div>
                    </a>

                    <a href="{{ route('sku.index') }}" class="card card-blue text-decoration-none text-dark"
                        style="cursor:pointer; width: 300px; flex-shrink: 0;">
                        <div class="card-header">Surat Keterangan Usaha</div>
                        <div class="card-body">
                            <div class="card-title">Rekap Total Pengajuan:</div>
                            <div class="card-row d-flex justify-content-between">
                                <span>Diajukan</span>
                                <span class="badge gray">{{ $sku['diajukan'] }}</span>
                            </div>
                            <div class="card-row d-flex justify-content-between">
                                <span>Diproses</span>
                                <span class="badge yellow">{{ $sku['diproses'] }}</span>
                            </div>
                            <div class="card-row d-flex justify-content-between">
                                <span>Selesai</span>
                                <span class="badge green">{{ $sku['selesai'] }}</span>
                            </div>
                            <div class="card-footer mt-3 text-muted">Dari Pengajuan di tahun ini</div>
                        </div>
                    </a>

                    <a href="{{ route('skp.index') }}" class="card card-green-light text-decoration-none text-dark"
                        style="cursor:pointer; width: 300px; flex-shrink: 0;">
                        <div class="card-header">Surat Pengantar Perkawinan</div>
                        <div class="card-body">
                            <div class="card-title">Rekap Total Pengajuan:</div>
                            <div class="card-row d-flex justify-content-between">
                                <span>Diajukan</span>
                                <span class="badge gray">{{ $skp['diajukan'] }}</span>
                            </div>
                            <div class="card-row d-flex justify-content-between">
                                <span>Diproses</span>
                                <span class="badge yellow">{{ $skp['diproses'] }}</span>
                            </div>
                            <div class="card-row d-flex justify-content-between">
                                <span>Selesai</span>
                                <span class="badge green">{{ $skp['selesai'] }}</span>
                            </div>
                            <div class="card-footer mt-3 text-muted">Dari Pengajuan di tahun ini</div>
                        </div>
                    </a>
                </div>
        </div>
    </div>
    @endif
    @if (auth()->user()->role == 'Masyarakat')
        <div class="row">
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
                                    <td colspan="6" class="text-center text-muted">Belum ada pengajuan yang selesai atau
                                        ditolak.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
    </div>
    </div>

    @if (auth()->user()->role == 'Masyarakat' && 'Admin')
    <div class="row mt-4">

        {{-- Draf SKTM --}}
        <div class="col-md-4 mb-3">
            <div class="card border rounded shadow-sm h-100">
                <div class="card-header bg-primary text-light rounded-top-2">
                    <h6 class="mb-0">Draf SKTM</h6>
                </div>
                <div class="card-body p-0">
                    @if ($drafSktm->count())
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped mb-0">
                                <thead class="table-light">
                                    <tr>
                                        
                                        <th>Nama Pemohon</th>
                                        <th>Tujuan Pengajuan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($drafSktm as $i => $item)
                                        <tr>
                                            
                                            <td>{{ $item->nama }}</td>
                                            <td>{{ $item->tujuan }}</td>
                                            <td>
                                                <a href="{{ route('sktm.index', ['draf' => $item->id]) }}" class="btn btn-sm btn-info text-white">Lanjut</a>
                                                <form action="{{ route('sktm.destroy', $item->id) }}" method="POST" id="formHapus-{{ $item->id }}" style="display:inline;">
    @csrf
    @method('DELETE')
    <button type="button" class="btn btn-sm btn-danger" id="btnHapus-{{ $item->id }}" onclick="konfirmasiHapus('{{ $item->id }}')">
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
                        <div class="p-3">
                            <p class="text-muted mb-0">Tidak ada draf SKTM.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Draf SKU --}}
        <div class="col-md-4 mb-3">
            <div class="card border rounded shadow-sm h-100">
                <div class="card-header bg-info text-white rounded-top-2">
                    <h6 class="mb-0">Draf SKU</h6>
                </div>
                <div class="card-body p-0">
                    @if ($drafSku->count())
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped mb-0">
                                <thead class="table-light">
                                    <tr>
                                        
                                        <th>Nama Pemohon</th>
                                        <th>Tujuan Pengajuan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($drafSku as $i => $item)
                                        <tr>
                                            
                                            <td>{{ $item->nama }}</td>
                                            <td>{{ $item->tujuan }}</td>
                                            <td>
                                               <a href="{{ route('sku.index', ['draf' => $item->id]) }}" class="btn btn-sm btn-info text-white">Lanjut</a>
                                                 <form action="{{ route('sku.destroy', $item->id) }}" method="POST" id="formHapus-{{ $item->id }}" style="display:inline;">
    @csrf
    @method('DELETE')
    <button type="button" class="btn btn-sm btn-danger" id="btnHapus-{{ $item->id }}" onclick="konfirmasiHapus('{{ $item->id }}')">
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
                        <div class="p-3">
                            <p class="text-muted mb-0">Tidak ada draf SKU.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Draf SKP --}}
        <div class="col-md-4 mb-3">
            <div class="card border rounded shadow-sm h-100">
                <div class="card-header bg-warning text-white rounded-top-2">
                    <h6 class="mb-0">Draf SKP</h6>
                </div>
                <div class="card-body p-0">
                    @if ($drafSkp->count())
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Nama Pemohon</th>
                                        <th>Tujuan Pengajuan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                    @foreach ($drafSkp as $i => $item)
                                        <tr>
                                            
                                            <td>{{ $item->nama }}</td>
                                            <td>Pengantar Perkawinan</td>
                                            <td>
                                                <a href="{{ route('skp.index', ['draf' => $item->id]) }}" class="btn btn-sm btn-info text-white">Lanjut</a>
                                                <form action="{{ route('skp.destroy', $item->id) }}" method="POST" id="formHapus-{{ $item->id }}" style="display:inline;">
    @csrf
    @method('DELETE')
    <button type="button" class="btn btn-sm btn-danger" id="btnHapus-{{ $item->id }}" onclick="konfirmasiHapus('{{ $item->id }}')">
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
                        <div class="p-3">
                            <p class="text-muted mb-0">Tidak ada draf SKP.</p>
                        </div>
                    @endif
                </div>
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

