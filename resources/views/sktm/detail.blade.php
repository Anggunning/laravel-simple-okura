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
            'Pekerjaan' => $sktm->pekerjaan,
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
                                @if ($sktm->status === 'Ditolak')
                                    @php
                                        $riwayatDitolak = $sktm->riwayat_sktm->where('status', 'Ditolak')->last();
                                    @endphp
                                    @if ($riwayatDitolak)
                                        <div class="row mb-2">
                                            <div class="col-sm-4 fw-bold">Alasan Penolakan</div>
                                            <div class="col-sm-8">: {{ $riwayatDitolak->alasan ?? '-' }}</div>
                                        </div>
                                    @endif
                                @endif
                                @if ($sktm->status === 'Selesai')
                                    @php
                                        $riwayatSelesai = $sktm->riwayat_sktm->where('status', 'Selesai')->last();
                                    @endphp
                                    @if ($riwayatSelesai)
                                        <div class="row mb-2">
                                            <div class="col-sm-4 fw-bold">Keterangan</div>
                                            <div class="col-sm-8">: {{ $riwayatSelesai->alasan ?? '-' }}</div>
                                        </div>
                                    @endif
                                @endif
                            </div>

                            <!-- Kolom Kanan (Dokumen) -->
                            <div class="col-sm-6">
                                @foreach ([
            'Surat Pengantar RT/RW' => $sktm->pengantar_rt_rw,
            'Kartu Keluarga' => $sktm->kk,
            'KTP' => $sktm->ktp,
            'Surat Pernyataan' => $sktm->surat_pernyataan,
        ] as $label => $file)
                                    <div class="dokumen-item mb-3">
                                        <label>{{ $label }} <span class="wajib">*</span></label>
                                        <a href="{{ route('dokumen.show', ['folder' => 'sktm', 'filename' => basename($file)]) }}"target="_blank"
                                            class="lihat-box">
                                            <i class="bi bi-cloud-arrow-up"></i>
                                            <span>Lihat File/Foto</span>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- Tombol Aksi --}}
                        @if (auth()->check())
                            {{-- ADMIN & SEKRETARIS --}}
                            @if (in_array(auth()->user()->role, ['Admin', 'Sekretaris']))
                                @if ($sktm->status === 'Diajukan')
                                    {{-- Tombol Verifikasi --}}
                                    <form id="verifikasiFormAdmin" action="{{ route('sktm.verifikasi', $sktm->id) }}"
                                        method="POST" style="display:inline;">
                                        @csrf
                                        <button type="button" id="btnVerifikasiAdmin" class="btn btn-success"
                                            onclick="verifikasiAdminConfirm()">
                                            Verifikasi
                                        </button>
                                    </form>

                                    {{-- Tombol Tolak --}}
                                    <button id="btnTolak-{{ $sktm->id }}" type="button" class="btn btn-danger"
                                        onclick="konfirmasiTolak('{{ $sktm->id }}')">
                                        <i class="bi bi-x-circle"></i> Tolak
                                    </button>
                                    <form id="formTolak-{{ $sktm->id }}" action="{{ route('sktm.tolak', $sktm->id) }}"
                                        method="POST" style="display: none;">
                                        @csrf
                                        <input type="hidden" name="status" value="Ditolak">
                                        <input type="hidden" name="alasan" id="inputAlasan-{{ $sktm->id }}">
                                    </form>
                                @elseif ($sktm->status === 'Ditolak')
                                    <button class="btn btn-secondary" disabled>Sudah Ditolak</button>
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
                                            onclick="verifikasiLurahConfirm()">
                                            Verifikasi
                                        </button>
                                    </form>
                                @elseif ($sktm->status === 'Selesai')
                                    <button class="btn btn-secondary" disabled>Sudah Disahkan</button>
                                @elseif ($sktm->status === 'Ditolak')
                                    <button class="btn btn-secondary" disabled>Surat Ditolak</button>
                                @endif
                            @endif
                        @endif

                        {{-- Tombol Cetak (hanya jika status selesai) --}}
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

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
