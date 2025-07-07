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
                                @php
                                    $rtRw =
                                        $skp->rt && $skp->rw
                                            ? 'RT.' .
                                                str_pad($skp->rt, 3, '0', STR_PAD_LEFT) .
                                                ' / RW.' .
                                                str_pad($skp->rw, 3, '0', STR_PAD_LEFT)
                                            : '-';
                                @endphp
                                <!-- DATA PEMOHON -->
                                <h5 class="fw-bold mb-3">Data Pemohon</h5>
                                <br>
                               @foreach ([
    'Nama Pemohon' => $skp->nama,
    'NIK' => $skp->nik,
    'Jenis Kelamin' => $skp->jenis_kelamin,
    'Tempat, Tanggal Lahir' => $skp->tempat_lahir . ', ' . $tanggalLahir,
    'Agama' => $skp->agama,
    'Alamat' => $skp->alamat . ', ' . $rtRw,
    'Kewarganegaraan' => $skp->kewarganegaraan,
    'Pekerjaan' => $skp->pekerjaan,
    'Status Perkawinan' => $skp->statusPerkawinan?->status_kawin,
    '__PASANGAN__' => '', // placeholder
    'Keterangan' => $skp->keterangan,
    'Tanggal Pengajuan' => $tanggalPengajuan,
    'Status' => ucfirst($skp->status),
] as $label => $value)

    @if ($label === '__PASANGAN__' && in_array($skp->statusPerkawinan?->status_kawin, ['Cerai Hidup', 'Cerai Mati']))
        <div class="row mb-2">
            <div class="col-sm-5 fw-bold">Nama Pasangan Sebelumnya</div>
            <div class="col-sm-7">: {{ $skp->statusPerkawinan->nama_pasangan_dulu ?? '-' }}</div>
        </div>
        <div class="row mb-2">
            <div class="col-sm-5 fw-bold">Jenis Kelamin Pasangan Sebelumnya</div>
            <div class="col-sm-7">: {{ $skp->statusPerkawinan->jenis_kelamin_psgn_dulu ?? '-' }}</div>
        </div>
    @elseif($label !== '__PASANGAN__')
        <div class="row mb-2">
            <div class="col-sm-5 fw-bold">{{ $label }}</div>
            <div class="col-sm-7">: {{ $value }}</div>
        </div>
    @endif

@endforeach


                                <!-- PEMISAH -->
                                <br>
                                <h5 class="fw-bold mb-3">Data Orang Tua</h5>
                                <br>
                                @php
                                    $rtRw_ayah =
                                        $skp->orangTua->rt_ayah && $skp->orangTua->rw_ayah
                                            ? 'RT.' .
                                                str_pad($skp->orangTua->rt_ayah, 3, '0', STR_PAD_LEFT) .
                                                ' / RW.' .
                                                str_pad($skp->orangTua->rw_ayah, 3, '0', STR_PAD_LEFT)
                                            : '-';

                                    $rtRw_ibu =
                                        $skp->orangTua->rt_ibu && $skp->orangTua->rw_ibu
                                            ? 'RT.' .
                                                str_pad($skp->orangTua->rt_ibu, 3, '0', STR_PAD_LEFT) .
                                                ' / RW.' .
                                                str_pad($skp->orangTua->rw_ibu, 3, '0', STR_PAD_LEFT)
                                            : '-';
                                @endphp

                                <!-- DATA AYAH & IBU -->
                                @foreach ([
            'Nama Ayah' => $skp->orangTua->nama_ayah,
            'NIK Ayah' => $skp->orangTua->nik_ayah,
            'Agama Ayah' => $skp->orangTua->agama_ayah,
            'Kewarganegaraan Ayah' => $skp->orangTua->kewarganegaraan_ayah,
            'Pekerjaan Ayah' => $skp->orangTua->pekerjaan_ayah,
            'Alamat' => $skp->alamat . ', ' . $rtRw_ayah,
            'Nama Ibu' => $skp->orangTua->nama_ibu,
            'NIK Ibu' => $skp->orangTua->nik_ibu,
            'Agama Ibu' => $skp->orangTua->agama_ibu,
            'Kewarganegaraan Ibu' => $skp->orangTua->kewarganegaraan_ibu,
            'Pekerjaan Ibu' => $skp->orangTua->pekerjaan_ibu,
            'Alamat Ibu' => $skp->alamat . ', ' . $rtRw_ibu,
        ] as $label => $value)
                                    <div class="row mb-2">
                                        <div class="col-sm-5 fw-bold">{{ $label }}</div>
                                        <div class="col-sm-7">: {{ $value }}</div>
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
                                            <a href="{{ route('dokumen.show', ['folder' => 'skp', 'filename' => basename($file)]) }}"
                                                target="_blank" class="lihat-box">
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
                                    {{-- Tombol Tolak --}}
                                    <button id="btnTolak-{{ $skp->id }}" type="button" class="btn btn-danger"
                                        onclick="konfirmasiTolak('{{ $skp->id }}')">
                                        <i class="bi bi-x-circle"></i> Tolak
                                    </button>
                                    <form id="formTolak-{{ $skp->id }}" action="{{ route('skp.tolak', $skp->id) }}"
                                        method="POST" style="display: none;">
                                        @csrf
                                        <input type="hidden" name="status" value="Ditolak">
                                        <input type="hidden" name="alasan" id="inputAlasan-{{ $skp->id }}">
                                    </form>
                                @elseif ($skp->status === 'Ditolak')
                                    <button class="btn btn-secondary" disabled>Sudah Ditolak</button>
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
                                            onclick="verifikasiLurahConfirm()">
                                            Verifikasi
                                        </button>
                                    </form>
                                @elseif ($skp->status === 'Selesai')
                                    <button class="btn btn-secondary" disabled>Sudah Disahkan</button>
                                @elseif ($skp->status === 'Ditolak')
                                    <button class="btn btn-secondary" disabled>Surat Ditolak</button>
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
@php
    function formatRiwayatKeterangan($riwayat) {
        return match ($riwayat->status) {
            'Ditolak' => 'Alasan Penolakan: ' . ($riwayat->alasan ?? 'Tidak ada keterangan'),
            'Selesai' => 'Catatan Verifikasi: ' . ($riwayat->alasan ?? 'Tidak ada keterangan'),
            default => $riwayat->alasan ?? 'Tidak ada keterangan',
        };
    }
@endphp

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
    {{ formatRiwayatKeterangan($riwayat) }}
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
        function konfirmasiTolak(id) {
            Swal.fire({
                title: 'Tolak Pengajuan Surat',
                input: 'textarea',
                inputLabel: 'Alasan Penolakan',
                inputPlaceholder: 'Tulis alasan penolakan di sini...',
                inputAttributes: {
                    'aria-label': 'Alasan penolakan'
                },
                showCancelButton: true,
                confirmButtonText: 'Tolak',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                preConfirm: (alasan) => {
                    if (!alasan || alasan.trim() === '') {
                        Swal.showValidationMessage('Alasan penolakan wajib diisi!');
                    }
                    return alasan;
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const alasan = result.value;
                    document.getElementById('inputAlasan-' + id).value = alasan;
                    document.getElementById('btnTolak-' + id).disabled = true;
                    document.getElementById('btnTolak-' + id).innerText = 'Memproses...';
                    document.getElementById('formTolak-' + id).submit();
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
