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
                <a href="{{ route('sku.index') }}" class="text-decoration-none text-dark d-inline-flex align-items-center">
                    <span>Surat Keterangan Usaha</span>
                </a>
            </li>
            <li class="breadcrumb-item active d-inline-flex align-items-center text-success" aria-current="page">
                <span>Detail Pengajuan Surat</span>
            </li>
        </ul>
    </div>
    <div class="title">
        <h4>Detail Pengajuan Surat Keterangan Usaha</h4>
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
                                    $tanggalLahir = \Carbon\Carbon::parse($sku->tanggalLahir)->translatedFormat(
                                        'd F Y',
                                    );
                                    $tanggalPengajuan = \Carbon\Carbon::parse($sku->tanggal)->translatedFormat('d F Y');
                                @endphp

                                @foreach ([
            'Nama Pemohon' => $sku->nama,
            'Jenis Kelamin' => $sku->jenis_kelamin,
            'Tempat, Tanggal Lahir' => $sku->tempatLahir . ', ' . $tanggalLahir,
            'Agama' => $sku->agama,
            'NIK' => $sku->nik,
            'Alamat' => $sku->alamat,
            'Jenis Usaha' => $sku->jenis_usaha,
            'Tempat Usaha' => $sku->tempat_usaha,
            'Kelurahan' => $sku->kelurahan,
            'Kecamatan' => $sku->kecamatan,
            'Kota' => $sku->kota,
            'Keterangan' => $sku->keterangan,
            'Tanggal Pengajuan' => $tanggalPengajuan,
            'Status' => ucfirst($sku->status),
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
            'Foto Usaha' => $sku->foto_usaha,
            'Surat Pengantar RT/RW' => $sku['pengantar_rt/rw'],
            'Kartu Keluarga' => $sku->kk,
            'KTP' => $sku->ktp,
            'Surat Pernyataan' => $sku->pernyataan,
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

                        {{-- Tombol Verifikasi --}}
                        @if (auth()->check())
                            {{-- ADMIN & SEKRETARIS --}}
                            @if (in_array(auth()->user()->role, ['Admin', 'Sekretaris']))
                                @if ($sku->status === 'Diajukan')
                                    <form id="verifikasiFormAdmin" action="{{ route('sku.verifikasi', $sku->id) }}"
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
                                @if ($sku->status === 'Diproses')
                                    <form id="verifikasiFormLurah" action="{{ route('sku.verifikasi', $sku->id) }}"
                                        method="POST" style="display:inline;">
                                        @csrf
                                        <button type="button" id="btnVerifikasiLurah" class="btn btn-success"
                                            onclick="verifikasiLurahConfirm()">Verifikasi</button>
                                    </form>
                                @elseif ($sku->status === 'Selesai')
                                    <button class="btn btn-secondary" disabled>Sudah Disahkan</button>
                                @endif
                            @endif
                        @endif

                        {{-- Tombol Cetak jika status selesai --}}
                        @if (auth()->check() && $sku->status === 'Selesai')
                            <a href="{{ route('sku.cetak', $sku->id) }}" target="_blank" class="btn btn-success">
                                <i class="bi bi-printer"></i> Cetak Surat
                            </a>
                        @endif

                    </div>


                    {{-- TAB: Riwayat Pengajuan --}}
                    <div class="card-body d-none" id="tabContentRiwayat">
                        <h5 class="fw-bold mb-4">Riwayat Pengajuan Surat</h5>
                        <ul class="timeline">
                            @forelse($sku->riwayat_sku->sortByDesc('tanggal')->sortByDesc('waktu') as $riwayat)
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
@endpush
