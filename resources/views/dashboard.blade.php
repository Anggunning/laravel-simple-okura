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
        <div class="col-md-6 col-lg-3">
            <div class="widget-small primary coloured-icon"><i class="icon bi bi-people fs-1"></i>
                <div class="info">
                    <h4>Pengguna</h4>
                    <p><b>{{ $jumlahPengguna }}</b></p>

                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="widget-small info coloured-icon"><i class="icon bi bi-heart fs-1"></i>
                <div class="info">
                    <h4>Penduduk Miskin</h4>
                     <p><b>{{ $jumlahPendudukMiskin}}</b></p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="widget-small warning coloured-icon"><i class="icon bi bi-folder2 fs-1"></i>
                <div class="info">
                    <h4>Pengajuan</h4>
                     <p><b>{{ $totalPengajuan }}</b></p>
                </div>
            </div>
        </div>
    </div>


    <div class="cards">
        <!-- Card 1 -->
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
@endsection
