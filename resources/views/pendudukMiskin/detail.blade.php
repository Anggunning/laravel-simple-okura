@extends('layouts.master')

@section('content')
<div class="app-title">
    <ul class="app-breadcrumb breadcrumb">
        <li><i class="bi bi-house-door me-2"></i></li>
        <li class="breadcrumb-item">
            <a href="{{ route('dashboard') }}" class="text-decoration-none text-dark d-inline-flex align-items-center">
                <span>Dashboard</span>
            </a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('pendudukMiskin.index') }}" class="text-decoration-none text-dark d-inline-flex align-items-center">
                <span>Data Penduduk Miskin</span>
            </a>
        </li>
        <li class="breadcrumb-item active d-inline-flex align-items-center text-success" aria-current="page">
            <span>Detail Penduduk Miskin</span>
        </li>
    </ul>
</div>

<div class="title">
    <h4>Detail Penduduk Miskin</h4>
</div>
<div class="d-flex justify-content mt-4">
    <div class="tile p-4 border rounded shadow w-auto">
        {{-- Foto Rumah --}}
        <div class="mb-4">
            <h6 class="fw-bold">Foto Rumah</h6>
            @if ($pendudukMiskin->foto_rumah)
                <img src="{{ route('dokumen.show', ['folder' => 'pendudukMiskin', 'filename' => basename($pendudukMiskin->foto_rumah)]) }}" 
                    alt="Foto Rumah" class="img-fluid rounded" style="max-height: 300px;">
            @else
                <div class="text-muted fst-italic">Tidak ada foto tersedia</div>
            @endif
        </div>

        {{-- Data Penduduk --}}
        <div>
            @foreach ([
                'Nama' => $pendudukMiskin->nama,
                'Alamat' => $pendudukMiskin->alamat,
                'Nama Kepala Keluarga' => $pendudukMiskin->nama_kepala_keluarga ?? 'Tidak punya kepala keluarga / cerai',
                'Jumlah Anggota Keluarga' => $pendudukMiskin->jml_agt_keluarga . ' Orang',
                'Kelompok PKH' => $pendudukMiskin->kelompokPKH,
                'Status Penduduk' => $pendudukMiskin->status,
            ] as $label => $value)
                <div class="d-flex mb-2">
                    <div class="fw-semibold" style="min-width: 180px;">{{ $label }}</div>
                    <div>: {{ $value }}</div>
                </div>
            @endforeach
        </div>
    </div>
</div>



@endsection