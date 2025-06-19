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
                <a href="{{ route('sktm.index') }}" class="text-decoration-none text-dark d-inline-flex align-items-center">
                    <span>Surat Keterangan Tidak Mampu</span>
                </a>
            </li>
            <li class="breadcrumb-item active d-inline-flex align-items-center text-success" aria-current="page">
                <span>Detail Pengajuan Surat</span>
            </li>
        </ul>




    </div>
    <div class="title">
        <h4>Detail Pengajuan Surat Keterangan Tidak Mampu</h4>
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
                                @php $tanggalLahir = \Carbon\Carbon::parse($sktm->tanggalLahir)->translatedFormat('d F Y'); @endphp
                                @php $tanggalPengajuan = \Carbon\Carbon::parse($sktm->tanggal)->translatedFormat('d F Y'); @endphp

                                @foreach ([
            'Nama Pemohon' => $sktm->nama,
            'Jenis Kelamin' => $sktm->jenis_kelamin,
            'Tempat, Tanggal Lahir' => $sktm->tempatLahir . ', ' . $tanggalLahir,
            'Agama' => $sktm->agama,
            'NIK' => $sktm->nik,
            'Alamat' => $sktm->alamat,
            'Tujuan' => $sktm->tujuan,
            'Keterangan' => $sktm->keterangan,
            'Tanggal Pengajuan' => $tanggalPengajuan,
            'Status' => ucfirst($sktm->status),
            // 'Nomor Berkas' => $sktm->nomor_berkas,
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
            'Surat Pengantar RT/RW' => $sktm->pengantar_rt_rw,
            'Kartu Keluarga' => $sktm->kk,
            'Kartu Tanda Penduduk' => $sktm->ktp,
            'Surat Pernyataan' => $sktm->surat_pernyataan,
        ] as $label => $file)
                                    <div class="dokumen-item mb-3">
                                        <label>{{ $label }} <span class="wajib">*</span></label>
                                        <a href="{{ asset('storage/' . $file) }}" target="_blank" class="lihat-box">
                                            <i class="bi bi-cloud-arrow-up"></i>
                                            <span>Lihat File/Foto</span>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        {{-- tombol verifikasi --}}
                        {{-- @if (auth()->check() && auth()->user()->role === 'Lurah')
                            @if ($sktm->status === 'Diproses')
                                <button class="btn btn-secondary" disabled>Sudah Diverifikasi</button>
                            @else
                                <form id="verifikasiForm" action="{{ route('sktm.verifikasi', $sktm->id) }}" method="POST"
                                    style="display: inline;">
                                    @csrf
                                    <button type="button" class="btn btn-success"
                                        onclick="verifikasiConfirm()">Verifikasi</button>
                                </form>
                            @endif
                        @endif --}}

                        {{-- Tombol Verifikasi --}}
                        @if (auth()->check())
                            {{-- ADMIN & SEKRETARIS --}}
                            @if (in_array(auth()->user()->role, ['Admin', 'Sekretaris']))
                                @if ($sktm->status === 'Diajukan')
                                    <form id="verifikasiFormAdmin" action="{{ route('sktm.verifikasi', $sktm->id) }}"
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
                                @if ($sktm->status === 'Diproses')
                                    <form id="verifikasiFormLurah" action="{{ route('sktm.verifikasi', $sktm->id) }}"
                                        method="POST" style="display:inline;">
                                        @csrf
                                        <button type="button" id="btnVerifikasiLurah" class="btn btn-success"
                                            onclick="verifikasiLurahConfirm()">Verifikasi</button>
                                    </form>
                                @elseif ($sktm->status === 'Selesai')
                                    <button class="btn btn-secondary" disabled>Sudah Disahkan</button>
                                @endif
                            @endif
                        @endif

                        {{-- Tombol Cetak jika status selesai --}}
                        @if (auth()->check() && $sktm->status === 'Selesai')
                            <a href="{{ route('sktm.cetak', $sktm->id) }}" target="_blank" class="btn btn-success">
                                <i class="bi bi-printer"></i> Cetak Surat
                            </a>
                        @endif
                    </div>

                    {{-- TAB: Riwayat Pengajuan --}}
                    <div class="card-body d-none" id="tabContentRiwayat">
                        <h5 class="fw-bold mb-4">Riwayat Pengajuan Surat</h5>
                        <ul class="timeline">
                            @forelse($sktm->riwayat_sktm->sortByDesc('tanggal')->sortByDesc('waktu') as $riwayat)
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

@section('scripts')
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



    <!-- Google analytics script-->
    <script type="text/javascript">
        if (document.location.hostname == 'pratikborsadiya.in') {
            (function(i, s, o, g, r, a, m) {
                i['GoogleAnalyticsObject'] = r;
                i[r] = i[r] || function() {
                    (i[r].q = i[r].q || []).push(arguments)
                }, i[r].l = 1 * new Date();
                a = s.createElement(o),
                    m = s.getElementsByTagName(o)[0];
                a.async = 1;
                a.src = g;
                m.parentNode.insertBefore(a, m)
            })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');
            ga('create', 'UA-72504830-1', 'auto');
            ga('send', 'pageview');
        }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const btnDetail = document.getElementById('btnDetail');
            const btnRiwayat = document.getElementById('btnRiwayat');
            const tabContentDetail = document.getElementById('tabContentDetail');
            const tabContentRiwayat = document.getElementById('tabContentRiwayat');

            btnDetail.addEventListener('click', () => {
                tabContentDetail.classList.remove('d-none');
                tabContentRiwayat.classList.add('d-none');

                btnDetail.classList.add('tab-active');
                btnDetail.classList.remove('tab-inactive');

                btnRiwayat.classList.add('tab-inactive');
                btnRiwayat.classList.remove('tab-active');
            });

            btnRiwayat.addEventListener('click', () => {
                tabContentRiwayat.classList.remove('d-none');
                tabContentDetail.classList.add('d-none');

                btnRiwayat.classList.add('tab-active');
                btnRiwayat.classList.remove('tab-inactive');

                btnDetail.classList.add('tab-inactive');
                btnDetail.classList.remove('tab-active');
            });
        });
    </script>
@endsection
