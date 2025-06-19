@extends('layouts.master')

{{-- @section('header')
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
@endsection --}}

@section('content')
    <div class="app-title">
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
            <li class="breadcrumb-item active"><a href="#">Penduduk Miskin</a></li>
        </ul>
    </div>
    <div class="title">
        <h4>Data Penduduk Miskin</h4>
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
                                <input type="search" class="form-control form-control-sm" placeholder=""
                                    aria-controls="sampleTable">
                            </label>
                        </div>

                        <!-- Tombol Tambah di kanan -->
                        <a href="#" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#modalTambahPenduduk">
                            <i class="bi bi-plus-circle"></i> Tambah Data
                        </a>
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
                        <div class="row dt-row">
                            <div class="col-sm-12">
                                <table class="table table-hover table-bordered dataTable no-footer" id="sampleTable"
                                    aria-describedby="sampleTable_info">
                                    <thead>
                                        <tr>
                                            <th class="sorting sorting_asc" tabindex="0" aria-controls="sampleTable"
                                                rowspan="1" colspan="1" aria-sort="ascending"
                                                aria-label="Name: activate to sort column descending"
                                                style="width: 150.725px;">Nama</th>
                                            <th class="sorting" tabindex="0" aria-controls="sampleTable" rowspan="1"
                                                colspan="1" aria-label="Position: activate to sort column ascending"
                                                style="width: 200.913px;">Alamat</th>
                                            <th class="sorting" tabindex="0" aria-controls="sampleTable" rowspan="1"
                                                colspan="1" aria-label="Office: activate to sort column ascending"
                                                style="width: 180.388px;">Jumlah Anggota Keluarga</th>
                                            <th class="sorting" tabindex="0" aria-controls="sampleTable" rowspan="1"
                                                colspan="1" aria-label="Age: activate to sort column ascending"
                                                style="width: 150.825px;">Kelompok PKH</th>
                                            <th class="sorting" tabindex="0" aria-controls="sampleTable" rowspan="1"
                                                colspan="1" aria-label="Start date: activate to sort column ascending"
                                                style="width: 200.775px;">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="odd">
                                            <td class="sorting_1">Airi Satou</td>
                                            <td>Jl. Bandes</td>
                                            <td>5 Orang</td>
                                            <td>Mawar</td>
                                            <td>
                                                <div class="btn-group">
                                                    <a class="btn btn-white me-2" style="color: #2E8B57;" href="#">
                                                        <i class="bi bi-pencil-square fs-5"></i>
                                                    </a>
                                                    <a class="btn btn-white me-2" style="color: #2E8B57;" href="#">
                                                        <i class="bi bi-trash fs-5"></i>
                                                    </a>
                                                    <a class="btn btn-white me-2" style="color: #2E8B57;" href="#">
                                                        <i class="bi bi-info-circle fs-5"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="even">
                                            <td class="sorting_1">Angelica Ramos</td>
                                            <td>Jl Raja panjang okura</td>
                                            <td>7 Orang</td>
                                            <td>Cahaya Ilahi</td>
                                            <td>
                                                <div class="btn-group">
                                                    <a class="btn btn-white me-2" style="color: #2E8B57;" href="#">
                                                        <i class="bi bi-pencil-square fs-5"></i>
                                                    </a>
                                                    <a class="btn btn-white me-2" style="color: #2E8B57;" href="#">
                                                        <i class="bi bi-trash fs-5"></i>
                                                    </a>
                                                    <a class="btn btn-white me-2" style="color: #2E8B57;" href="#">
                                                        <i class="bi bi-info-circle fs-5"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="odd">
                                            <td class="sorting_1">Ashton Cox</td>
                                            <td>Jl Raja panjang okura</td>
                                            <td>6 Orang</td>
                                            <td>Mawar</td>
                                            <td>
                                                <div class="btn-group">
                                                    <a class="btn btn-white me-2" style="color: #2E8B57;" href="#">
                                                        <i class="bi bi-pencil-square fs-5"></i>
                                                    </a>
                                                    <a class="btn btn-white me-2" style="color: #2E8B57;" href="#">
                                                        <i class="bi bi-trash fs-5"></i>
                                                    </a>
                                                    <a class="btn btn-white me-2" style="color: #2E8B57;" href="#">
                                                        <i class="bi bi-info-circle fs-5"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="even">
                                            <td class="sorting_1">Bradley Greer</td>
                                            <td>Jl perumahan 50</td>
                                            <td>7 Orang</td>
                                            <td>Mawar</td>
                                            <td>
                                                <div class="btn-group">
                                                    <a class="btn btn-white me-2" style="color: #2E8B57;" href="#">
                                                        <i class="bi bi-pencil-square fs-5"></i>
                                                    </a>
                                                    <a class="btn btn-white me-2" style="color: #2E8B57;" href="#">
                                                        <i class="bi bi-trash fs-5"></i>
                                                    </a>
                                                    <a class="btn btn-white me-2" style="color: #2E8B57;" href="#">
                                                        <i class="bi bi-info-circle fs-5"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="odd">
                                            <td class="sorting_1">Brenden Wagner</td>
                                            <td>Jl Raja panjang okura</td>
                                            <td>8 Orang</td>
                                            <td>Mawar</td>
                                            <td>
                                                <div class="btn-group">
                                                    <a class="btn btn-white me-2" style="color: #2E8B57;" href="#">
                                                        <i class="bi bi-pencil-square fs-5"></i>
                                                    </a>
                                                    <a class="btn btn-white me-2" style="color: #2E8B57;" href="#">
                                                        <i class="bi bi-trash fs-5"></i>
                                                    </a>
                                                    <a class="btn btn-white me-2" style="color: #2E8B57;" href="#">
                                                        <i class="bi bi-info-circle fs-5"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-12">
                            <div class="dataTables_paginate paging_simple_numbers" id="sampleTable_paginate">
                                <ul class="pagination justify-content-center">
                                    <li class="paginate_button page-item previous disabled" id="sampleTable_previous"><a
                                            aria-controls="sampleTable" aria-disabled="true" aria-role="link"
                                            data-dt-idx="previous" tabindex="0" class="page-link">Previous</a></li>
                                    <li class="paginate_button page-item active"><a href="#"
                                            aria-controls="sampleTable" aria-role="link" aria-current="page"
                                            data-dt-idx="0" tabindex="0" class="page-link">1</a></li>
                                    <li class="paginate_button page-item "><a href="#" aria-controls="sampleTable"
                                            aria-role="link" data-dt-idx="1" tabindex="0" class="page-link">2</a></li>
                                    <li class="paginate_button page-item "><a href="#" aria-controls="sampleTable"
                                            aria-role="link" data-dt-idx="2" tabindex="0" class="page-link">3</a></li>
                                    <li class="paginate_button page-item next" id="sampleTable_next"><a href="#"
                                            aria-controls="sampleTable" aria-role="link" data-dt-idx="next"
                                            tabindex="0" class="page-link">Next</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>


    <!-- Modal Tambah Pengajuan -->
    <div class="modal fade" id="modalTambahPenduduk" tabindex="-1" aria-labelledby="modalTambahLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="{{ route('pendudukMiskin.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTambahLabel">Tambah Pengajuan Surat</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" name="nama" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="tujuan" class="form-label">Alamat</label>
                            <input type="text" name="tujuan" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="agama" class="form-label">Nama Kepala Keluarga</label>
                            <input type="text" name="agama" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="nik" class="form-label">Jumlah Anggota Keluarga</label>
                            <input type="text" name="nik" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="nik" class="form-label">Kelompk PKH</label>
                            <input type="text" name="nik" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="Surat Pernyataan" class="form-label">Foto Rumah (gambar atau PDF)</label>
                            <input type="file" name="Surat Pernyataan" class="form-control"
                                accept=".jpg,.jpeg,.png,.pdf" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Pilih Lokasi Rumah</label>
                            <div id="map" style="height: 300px;"></div>
                        </div>

                        <input type="hidden" name="latitude" id="latitude">
                        <input type="hidden" name="longitude" id="longitude">


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                @endsection


@section('scripts')
  <script type="text/javascript" src="{{ 'template/docs/js/plugins/jquery.dataTables.min.js' }}"></script>
  <script type="text/javascript" src="{{ 'template/docs/js/plugins/dataTables.bootstrap.min.js' }}"></script>
  <script type="text/javascript">
      $('#sampleTable').DataTable();
  </script>
  {{-- <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script> --}}

  <script>
    let map = L.map('map').setView([-7.797068, 110.370529], 13); // Titik awal, contoh: Yogyakarta

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    let marker;

    map.on('click', function(e) {
        let lat = e.latlng.lat;
        let lng = e.latlng.lng;

        if (marker) {
            marker.setLatLng(e.latlng);
        } else {
            marker = L.marker(e.latlng).addTo(map);
        }

        // Set nilai ke input hidden
        document.getElementById('latitude').value = lat;
        document.getElementById('longitude').value = lng;
    });
</script>
@endsection
