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
            <li class="breadcrumb-item active d-inline-flex align-items-center text-success" aria-current="page">
                <span>Surat Keterangan Pengantar Perkawinan</span>
            </li>
        </ul>
    </div>
    <div class="title">
      <h4>Data Pengajuan Surat Keterangan Pengantar Perkawinan</h4>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                  
                  <div class="mb-3 d-flex justify-content-between align-items-center">
                <!-- Search di kiri -->
            

                {{-- Tombol Tambah Pengajuan --}}
                        @if (auth()->check() && in_array(auth()->user()->role, ['Masyarakat', 'Admin']))
                            <a href="#" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#modalTambahSKP">
                                <i class="bi bi-plus-circle"></i> Tambah Pengajuan
                            </a>
                        @endif
            </div>  
          </div>
         
                    <div class="table">
                        <div id="sampleTable_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                            <div class="row">
                                {{-- <div class="col-sm-12 col-md-6">
                                    <div class="dataTables_length" id="sampleTable_length">
                                        
                                    </div>
                                </div> --}}
                                
                            </div>
                            <div class="table-responsive">
    <table class="table table-hover table-bordered" id="skpTable">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Tanggal Lahir</th>
                <th>Alamat</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($skp as $item)
                <tr>
                    <td>{{ $item->nama }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal_lahir)->format('d/m/Y') }}</td>
                    <td>{{ $item->alamat }}</td>
                    <td>
                        @php
                            $badgeClass = match ($item->status) {
                                'Diajukan' => 'bg-secondary text-dark',
                                'Diproses' => 'bg-warning',
                                'Selesai' => 'bg-success',
                                default => 'bg-light text-dark',
                            };
                        @endphp
                        <span class="badge {{ $badgeClass }} fs-6 py-2 px-3 rounded-3">
                            {{ ucfirst($item->status) }}
                        </span>
                    </td>
                    <td>
                        <div class="btn-group">
                            @if (auth()->check() && in_array(auth()->user()->role, ['Masyarakat', 'Admin']))
                                @php
                                                    $isDisabled = in_array($item->status, ['Selesai']);
                                                @endphp

                                                <a href="#" class="btn btn-white me-2" style="color: #2E8B57;"
                                                    data-bs-toggle="{{ $isDisabled ? '' : 'modal' }}"
                                                    data-bs-target="{{ $isDisabled ? '' : '#modalEditPengajuan' }}"
                                                    data-bs-toggle="modal"
    data-bs-target="#modalTambahSKP"
    data-id="{{ $skp->id }}"
    data-nama="{{ $skp->nama }}"
    data-nik="{{ $skp->nik }}"
    data-jenis_kelamin="{{ $skp->jenis_kelamin }}"
    data-tempat_lahir="{{ $skp->tempat_lahir }}"
    data-tanggal_lahir="{{ $skp->tanggal_lahir }}"
    data-agama="{{ $skp->agama }}"
    data-pekerjaan="{{ $skp->pekerjaan }}"
    data-alamat="{{ $skp->alamat }}"
    data-kewarganegaraan="{{ $skp->kewarganegaraan }}"
    data-status_kawin="{{ $skp->status_kawin }}"
    data-nama_pasangan_dulu="{{ $skp->nama_pasangan_dulu }}"
                                                   onclick="{{ $isDisabled ? 'return false;' : '' }}">
                                                    <i class="bi bi-pencil-square fs-5"
                                                        style="color: {{ $isDisabled ? '#A9A9A9' : '#2E8B57' }}"></i>
                                                </a>
                                                
                                                <form id="formHapus-{{ $item->id }}"
                                                    action="{{ route('skp.destroy', $item->id) }}" method="POST"
                                                    style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-white me-2"
                                                        id="btnHapus-{{ $item->id }}" style="color: #2E8B57;"
                                                        onclick="konfirmasiHapus('{{ $item->id }}')">
                                                        <i class="bi bi-trash fs-5"></i>
                                                    </button>
                                                </form>
                            @endif

                            <a class="btn btn-white me-2" style="color: #2E8B57;" href="{{ route('skp.show', $item->id) }}">
                                <i class="bi bi-info-circle fs-5"></i>
                            </a>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Modal Tambah SKP -->
<div class="modal fade" id="modalTambahSKP" tabindex="-1" aria-labelledby="modalTambahSKPLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form action="{{ route('skp.store') }}" method="POST" enctype="multipart/form-data" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title" id="modalTambahSKPLabel">Tambah Pengajuan SKP</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body row">
                @include('skp._form', ['prefix' => '']) {{-- gunakan partial form jika ingin DRY --}}
            </div>
            

            
        </form>
    </div>
</div>


@endsection


@push('scripts')
   <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    @if ($skp->count() > 0)
            <script>
                $(document).ready(function() {
                    $('#skpTable').DataTable({
                        // paging: true,
                        // pageLength: 10
                    });
                });
            </script>
             <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const today = new Date();
                        const yyyy = today.getFullYear();
                        const mm = String(today.getMonth() + 1).padStart(2, '0'); // bulan dimulai dari 0
                        const dd = String(today.getDate()).padStart(2, '0');
                        const formattedToday = `${yyyy}-${mm}-${dd}`;

                        document.getElementById('tanggal').value = formattedToday;
                    });
                </script>
        @endif<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                    const nikInput = document.getElementById('nik');

                    nikInput.addEventListener('input', function() {
                        const val = this.value.trim();

                        if (val === '') {
                            this.setCustomValidity('Silakan isi NIK');
                        } else if (!/^\d{16}$/.test(val)) {
                            this.setCustomValidity('NIK harus terdiri dari 16 digit angka');
                        } else {
                            this.setCustomValidity('');
                        }
                    });

                    // Trigger validasi ulang saat blur (pindah fokus)
                    nikInput.addEventListener('blur', function() {
                        this.reportValidity();
                    });
                </script>


@endpush
