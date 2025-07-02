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
            <li class="breadcrumb-item">
                <a href="{{ route('skp.index') }}" class="text-decoration-none text-dark d-inline-flex align-items-center">
                    <span>Surat Keterangan Pengantar Pernikahan</span>
                </a>
            </li>
            <li class="breadcrumb-item active d-inline-flex align-items-center text-success" aria-current="page">
                <span>Detail Pengajuan Surat</span>
            </li>
        </ul>




    </div>
    <div class="title">
        <h4>Detail Pengajuan Surat Keterangan Pengantar Pernikahan</h4>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <section class="detailPengajuan">
                    <div class="row">
                        <div class="header-tabs">
                            <button class="tab-button tab-active" id="btnDetail">Detail Pengajuan Surat</button>
                            <button class="tab-button tab-inactive" id="btnRiwayat">Riwayat Pengajuan Surat</button>
                        </div>
                    </div>

                    {{-- TAB: Detail Pengajuan --}}
                    <div id="tabContentDetail">
                        <div class="row mb-2">
                            <!-- Kolom Kiri -->
                            <div class="col-sm-6">
                                @php
                                    $tanggalLahir = \Carbon\Carbon::parse($skp->tanggal_lahir)->translatedFormat(
                                        'd F Y',
                                    );
                                    $tanggalPengajuan = \Carbon\Carbon::parse($skp->created_at)->translatedFormat(
                                        'd F Y',
                                    );
                                @endphp

                                <!-- DATA PEMOHON -->
                                <h5 class="fw-bold mb-3">Data Pemohon</h5>
                                @foreach ([
            'Nama Pemohon' => $skp->nama,
            'NIK' => $skp->nik,
            'Jenis Kelamin' => $skp->jenis_kelamin,
            'Tempat, Tanggal Lahir' => $skp->tempat_lahir . ', ' . $tanggalLahir,
            'Agama' => $skp->agama,
            'Alamat' => $skp->alamat,
            'Kewarganegaraan' => $skp->kewarganegaraan,
            'Pekerjaan' => $skp->pekerjaan,
            'Status Perkawinan' => $skp->status_perkawinan?->status_kawin,
            'Tanggal Pengajuan' => $tanggalPengajuan,
            'Status' => ucfirst($skp->status),
        ] as $label => $value)
                                    <div class="row mb-2">
                                        <div class="col-sm-4 fw-bold">{{ $label }}</div>
                                        <div class="col-sm-8">: {{ $value }}</div>
                                    </div>
                                @endforeach

                                @if (in_array($skp->status_perkawinan?->status_kawin, ['Cerai Hidup', 'Cerai Mati']))
                                    <div class="row mb-2">
                                        <div class="col-sm-4 fw-bold">Nama Pasangan Sebelumnya</div>
                                        <div class="col-sm-8">: {{ $skp->status_perkawinan->nama_pasangan_dulu ?? '-' }}
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-sm-4 fw-bold">Jenis Kelamin Pasangan Sebelumnya</div>
                                        <div class="col-sm-8">:
                                            {{ $skp->status_perkawinan->jenis_kelamin_psgn_dulu ?? '-' }}</div>
                                    </div>
                                @endif

                                <!-- PEMISAH -->
                                <br>
                                <h5 class="fw-bold mb-3">Data Orang Tua</h5>

                                <!-- DATA AYAH & IBU -->
                                @foreach ([
            'Nama Ayah' => $skp->orangTua->nama_ayah,
            'NIK Ayah' => $skp->orangTua->nik_ayah,
            'Agama Ayah' => $skp->orangTua->agama_ayah,
            'Kewarganegaraan Ayah' => $skp->orangTua->kewarganegaraan_ayah,
            'Pekerjaan Ayah' => $skp->orangTua->pekerjaan_ayah,
            'Alamat Ayah' => $skp->orangTua->alamat_ayah,
            'Nama Ibu' => $skp->orangTua->nama_ibu,
            'NIK Ibu' => $skp->orangTua->nik_ibu,
            'Agama Ibu' => $skp->orangTua->agama_ibu,
            'Kewarganegaraan Ibu' => $skp->orangTua->kewarganegaraan_ibu,
            'Pekerjaan Ibu' => $skp->orangTua->pekerjaan_ibu,
            'Alamat Ibu' => $skp->orangTua->alamat_ibu,
        ] as $label => $value)
                                    <div class="row mb-2">
                                        <div class="col-sm-4 fw-bold">{{ $label }}</div>
                                        <div class="col-sm-8">: {{ $value }}</div>
                                    </div>
                                @endforeach



                            </div>

                            <!-- Kolom Kanan (Dokumen) -->
                            <div class="col-sm-6">
                                @foreach ([
            'KTP' => $skp->ktp,
            'KK' => $skp->kk,
            'Surat Pengantar RT/RW' => $skp->pengantar_rt_rw,
            'Foto' => $skp->foto,
        ] as $label => $file)
                                    <div class="dokumen-item mb-3">
                                        <label>{{ $label }}</label>
                                        @if ($file)
                                            <a href="{{ asset('storage/' . $file) }}" target="_blank" class="lihat-box">
                                                <i class="bi bi-cloud-arrow-up"></i>
                                                <span>Lihat File</span>
                                            </a>
                                        @else
                                            <p class="text-muted">Tidak ada file</p>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- Tombol Verifikasi dan Cetak --}}
                        @if (auth()->check())
                            {{-- ADMIN & SEKRETARIS --}}
                            @if (in_array(auth()->user()->role, ['Admin', 'Sekretaris']))
                                @if ($skp->status === 'Diajukan')
                                    <form id="verifikasiFormAdmin" action="{{ route('skp.verifikasi', $skp->id) }}"
                                        method="POST" style="display:inline;">
                                        @csrf
                                        <button type="button" id="btnVerifikasiAdmin" class="btn btn-success"
                                            onclick="verifikasiAdminConfirm()">Verifikasi</button>
                                    </form>
                                @else
                                    <button class="btn btn-secondary" disabled>Sudah Diverifikasi</button>
                                @endif

                                {{-- LURAH --}}
                            @elseif (auth()->user()->role === 'Lurah')
                                @if ($skp->status === 'Diproses')
                                    <form id="verifikasiFormLurah" action="{{ route('skp.verifikasi', $skp->id) }}"
                                        method="POST" style="display:inline;">
                                        @csrf
                                        <button type="button" id="btnVerifikasiLurah" class="btn btn-success"
                                            onclick="verifikasiLurahConfirm()">Verifikasi</button>
                                    </form>
                                @elseif ($skp->status === 'Selesai')
                                    <button class="btn btn-secondary" disabled>Sudah Disahkan</button>
                                @endif
                            @endif
                        @endif

                        {{-- Tombol Cetak jika status selesai --}}
                        @if (auth()->check() && $skp->status === 'Selesai')
                            <a href="{{ route('skp.cetak', $skp->id) }}" target="_blank" class="btn btn-success">
                                <i class="bi bi-printer"></i> Cetak Surat
                            </a>
                        @endif
                    </div>

                    {{-- TAB: Riwayat Pengajuan --}}
                    <div class="card-body d-none" id="tabContentRiwayat">
                        <h5 class="fw-bold mb-4">Riwayat Pengajuan Surat</h5>
                        <ul class="timeline">
                            @forelse($skp->riwayat_skp->sortByDesc('tanggal')->sortByDesc('waktu') as $riwayat)
                                <li>
                                    <span class="time">
                                        {{ \Carbon\Carbon::parse($riwayat->tanggal)->format('d F Y') }}
                                        {{ \Carbon\Carbon::parse($riwayat->waktu)->format('H:i') }}
                                    </span>
                                    <div class="status"><strong>{{ $riwayat->status }}</strong></div>
                                    <div class="desc">
                                        {{ $riwayat->keterangan ?? 'Tidak ada keterangan' }}
                                    </div>
                                </li>
                            @empty
                                <li>
                                    <div class="desc text-muted">Belum ada riwayat pengajuan</div>
                                </li>
                            @endforelse
                        </ul>
                    </div>
                </section>
            </div>
        </div>
    </div>
@endsection


@push('scripts')
    <script src="{{ asset('js/jquery-3.7.0.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>

    {{-- JS Verifikasi --}}
    <script>
        function verifikasiAdminConfirm() {
            Swal.fire({
                title: 'Yakin ingin memproses surat?',
                text: "Surat akan diverifikasi dan diteruskan ke Lurah.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Proses!'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('btnVerifikasiAdmin').disabled = true;
                    document.getElementById('btnVerifikasiAdmin').innerText = 'Memproses...';
                    document.getElementById('verifikasiFormAdmin').submit();
                }
            });
        }

        function verifikasiLurahConfirm() {
            Swal.fire({
                title: 'Yakin ingin mengesahkan surat?',
                text: "Surat akan disahkan dan siap dicetak.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Sahkan!'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('btnVerifikasiLurah').disabled = true;
                    document.getElementById('btnVerifikasiLurah').innerText = 'Mengesahkan...';
                    document.getElementById('verifikasiFormLurah').submit();
                }
            });
        }
    </script>



    <script>
        $(document).ready(function() {
            $('#btnDetail').on('click', function() {

                console.log('Riwayat diklik');

                $('#tabContentDetail').removeClass('d-none');
                $('#tabContentRiwayat').addClass('d-none');

                $('#btnDetail').addClass('tab-active').removeClass('tab-inactive');
                $('#btnRiwayat').addClass('tab-inactive').removeClass('tab-active');
            });

            $('#btnRiwayat').on('click', function() {
                $('#tabContentRiwayat').removeClass('d-none');
                $('#tabContentDetail').addClass('d-none');

                $('#btnRiwayat').addClass('tab-active').removeClass('tab-inactive');
                $('#btnDetail').addClass('tab-inactive').removeClass('tab-active');
            });
        });
    </script>
@endpush
