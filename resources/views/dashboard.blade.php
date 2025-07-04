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
        <h4>Dashboard</h4>
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
                <h6 class="mb-0">Riwayat Pengajuan</h6>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-striped mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>                   
                            <th>Jenis Surat</th>
                             <th>Tujuan Surat</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($riwayat as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item['tanggal'] }}
                                    <br><small class="text-muted">{{ $item['waktu'] }}</small>
                                </td>
                                <td>{{ $item['jenis'] }}</td>
                                <td>{{ $item['tujuan'] }}</td>
                                
                                <td>
                                    <span
                                        class="badge 
                @if ($item['status'] == 'Diajukan') bg-secondary text-dark
                @elseif($item['status'] == 'Diproses') bg-warning
                @elseif($item['status'] == 'Selesai') bg-success
                @elseif($item['status'] == 'Ditolak') bg-danger
                @else bg-dark @endif">
                                        <span class="badge rounded-3">
                                            {{ ucfirst($item['status']) }}
                                        </span>

                                </td>
                                <td>
                                    <div class="button-group d-flex">
                                        <a href="{{ $item['link_detail'] }}" class="btn btn-sm btn-info text-white me-1">
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
                                <td colspan="6" class="text-center text-muted">Belum ada pengajuan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif
@endsection
