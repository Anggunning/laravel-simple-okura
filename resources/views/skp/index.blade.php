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
                <span>Surat Keterangan Pengantar Perkawinana</span>
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
                <div id="sampleTable_filter" class="dataTables_filter mb-0">
                    <label class="mb-0">
                        Search:
                        <input type="search" class="form-control form-control-sm"
                              placeholder="" aria-controls="sampleTable">
                    </label>
                </div>

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
                                <a href="#" class="btn btn-white me-2" style="color: #2E8B57;"
                                    data-bs-toggle="modal" data-bs-target="#modalEditSkp"
                                    data-id="{{ $item->id }}"
                                    data-nama="{{ $item->nama }}"
                                    data-nik="{{ $item->nik }}"
                                    data-jenis_kelamin="{{ $item->jenis_kelamin }}"
                                    data-tempat_lahir="{{ $item->tempat_lahir }}"
                                    data-tanggal_lahir="{{ \Carbon\Carbon::parse($item->tanggal_lahir)->format('Y-m-d') }}"
                                    data-kewarganegaraan="{{ $item->kewarganegaraan }}"
                                    data-pekerjaan="{{ $item->pekerjaan }}"
                                    data-agama="{{ $item->agama }}"
                                    data-alamat="{{ $item->alamat }}"
                                    data-status_kawin="{{ $item->status_kawin }}"
                                    data-status_perkawinan_id="{{ $item->status_perkawinan_id }}">
                                    <i class="bi bi-pencil-square fs-5"></i>
                                </a>

                                <form action="{{ route('skp.destroy', $item->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-white me-2"
                                        style="color: #2E8B57;"
                                        onclick="return confirm('Yakin hapus data?')">
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

{{-- Paginate --}}
<div class="d-flex justify-content-center mt-3">
    {{ $skp->links() }}
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
            

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>


@endsection


@section('scripts')
    <script type="text/javascript" src="{{ 'template/docs/js/plugins/jquery.dataTables.min.js' }}"></script>
    <script type="text/javascript" src="{{ 'template/docs/js/plugins/dataTables.bootstrap.min.js' }}"></script>
    <script type="text/javascript">
        $('#sampleTable').DataTable();
    </script>
@endsection
