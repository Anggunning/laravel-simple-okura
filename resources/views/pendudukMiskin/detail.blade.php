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
<div class="row content-center">
    <div class="col-md-8">
        <div class="tile p-3">

            {{-- Foto Rumah di Atas --}}
            <div class="text-center mb-4">
                <h6>Foto Rumah</h6>
                @if ($pendudukMiskin->foto_rumah && Storage::disk('public')->exists($pendudukMiskin->foto_rumah))
                    <div class="d-inline-block shadow rounded overflow-hidden" style="max-width: 100%;">
                        <img src="{{ asset('storage/' . $pendudukMiskin->foto_rumah) }}"
                            alt="Foto Rumah"
                            class="img-fluid"
                            style="max-height: 400px; width: auto;">
                    </div>
                @else
                    <div class="text-muted fst-italic">Tidak ada foto tersedia</div>
                @endif
            </div>

          {{-- Data Detail (blok tengah, teks rata kiri) --}}
<div class="d-flex flex-column align-items-center">
    <div class="w-100" style="max-width: 600px;"> {{-- Blok center --}}
        @foreach ([
            'Nama' => $pendudukMiskin->nama,
            'Alamat' => $pendudukMiskin->alamat,
            'Nama Kepala Keluarga' => $pendudukMiskin->nama_kepala_keluarga ?? 'Tidak punya kepala keluarga / cerai',
            'Jumlah Anggota Keluarga' => $pendudukMiskin->jml_agt_keluarga . ' Orang',
            'Kelompok PKH' => $pendudukMiskin->kelompokPKH,
        ] as $label => $value)
            <div class="row mb-2 mx-auto">
                <div class="col-5 text-start fw-semibold">{{ $label }}</div>
                <div class="col-7 text-start">: {{ $value }}</div>
            </div>
        @endforeach
    </div>
</div>


        </div>
    </div>
</div>
@endsection