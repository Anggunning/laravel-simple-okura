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
    {{-- <div class="title"></div> --}}

    <div class="row">
        <div class="col-md-12">
            <ul class="nav nav-tabs mb-3" id="pendudukTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="miskin-tab" data-bs-toggle="tab" data-bs-target="#miskin"
                        type="button" role="tab">
                        Penduduk Miskin
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="menengah-tab" data-bs-toggle="tab" data-bs-target="#menengah"
                        type="button" role="tab">
                        Penduduk Menengah
                    </button>
                </li>
            </ul>
            <div class="tile">
                <div class="tile-body">
                    <div class="mb-3 d-flex justify-content-between align-items-center">
                        <!-- Tombol Tambah di kanan -->
                        @if (auth()->check() && in_array(auth()->user()->role, ['Admin','Sekretaris']))
                        <a href="#" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#modalTambahPenduduk">
                            <i class="bi bi-plus-circle"></i> Tambah Data
                        </a>
                        @endif
                    </div>

                    <!-- Konten Tab -->
                    <div class="tab-content" id="pendudukTabsContent">
                        <!-- Tab Miskin -->
                        <div class="tab-pane fade show active" id="miskin" role="tabpanel" aria-labelledby="miskin-tab">
                            <div class="table-responsive">
                                <div class="card-body">
                                    <table class="table table-hover table-bordered" id="pendudukMiskin">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Penduduk</th>
                                                <th>Alamat Penduduk</th>
                                                <th>Jumlah Anggota Keluarga</th>
                                                <th>Kelompok PKH</th>
                                                <th>Status</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $no = 1; @endphp
                                            @foreach ($dataMiskin->where('status', 'Miskin') as $item)
                                                <tr>
                                                    <td>{{ $no++ }}</td>
                                                    <td>{{ $item->nama }}</td>
                                                    <td>{{ $item->alamat }}</td>
                                                    <td>{{ $item->jml_agt_keluarga }} Orang</td>
                                                    <td>{{ $item->kelompokPKH }}</td>
                                                    <td>{{ $item->status }}</td>
                                                    
                                                    <td>
                                                        <div class="btn-group">
                                                            @if (auth()->check() && in_array(auth()->user()->role, ['Admin']))
                                                                <a href="#" class="btn btn-white me-2"
                                                                    style="color: #2E8B57;" data-bs-toggle="modal"
                                                                    data-bs-target="#modalEditPenduduk"
                                                                    data-id="{{ $item->id }}"
                                                                    data-status="{{ $item->status }}">
                                                                    <i class="bi bi-pencil-square fs-5"></i>
                                                                </a>
                                                                 @endif
                                                                <a class="btn btn-white me-2" style="color: #2E8B57;"
                                                                    href="{{ route('pendudukMiskin.show', $item->id) }}">
                                                                    <i class="bi bi-info-circle fs-5"></i>
                                                                </a>
                                                           
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- Tab Menenagah -->
                        <div class="tab-pane fade show" id="menengah" role="tabpanel"
                            aria-labelledby="menengah-tab">
                            <div class="table-responsive">
                                <div class="card-body">
                                    <table class="table table-hover table-bordered" id="pendudukMenengah">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Nama Penduduk</th>
                                                <th>Alamat Penduduk</th>
                                                <th>Jumlah Anggota Keluarga</th>
                                                <th>Kelompok PKH</th>
                                                <th>Status</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $no = 1; @endphp
                                            @foreach ($dataMenengah->where('status', 'Menengah') as $item)
                                                <tr>
                                                    <td>{{ $no++ }}</td>
                                                    <td>{{ $item->nama }}</td>
                                                    <td>{{ $item->alamat }}</td>
                                                    <td>{{ $item->jml_agt_keluarga }} Orang</td>
                                                    <td>{{ $item->kelompokPKH }}</td>
                                                    <td>{{ $item->status }}</td>
                                                    {{-- <td>
                                                        @if ($item->foto_rumah)
                                                            <img src="{{ route('dokumen.show', ['folder' => 'pendudukMiskin', 'filename' => basename($item->foto_rumah)]) }}"
                                                                alt="Foto Rumah"
                                                                style="width: 80px; height: auto; border-radius: 5px;">
                                                        @else
                                                            <span class="text-muted">Tidak ada foto</span>
                                                        @endif
                                                    </td> --}}
                                                    <td>
                                                        <div class="btn-group">
                                                            @if (auth()->check() && in_array(auth()->user()->role, ['Admin']))
                                                                <a href="#" class="btn btn-white me-2"
                                                                    style="color: #2E8B57;" data-bs-toggle="modal"
                                                                    data-bs-target="#modalEditPenduduk"
                                                                    data-id="{{ $item->id }}"
                                                                    data-status="{{ $item->status }}">
                                                                    <i class="bi bi-pencil-square fs-5"></i>
                                                                </a>
                                                                 @endif
                                                                <a class="btn btn-white me-2" style="color: #2E8B57;"
                                                                    href="{{ route('pendudukMiskin.show', $item->id) }}">
                                                                    <i class="bi bi-info-circle fs-5"></i>
                                                                </a>
                                                            
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Tambah Penduduk -->
    <div class="modal fade" id="modalTambahPenduduk" tabindex="-1" aria-labelledby="modalTambahLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form action="{{ route('pendudukMiskin.store') }}" method="POST" enctype="multipart/form-data"
                class="modal-content">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahLabel">Tambah Data Penduduk Miskin</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <!-- Input Form -->
                    <div class="mb-3">
                        <label class="form-label">Nama<span class="text-danger">*</span></label>
                        <input type="text" name="nama" class="form-control" required placeholder="Masukkan Nama"
                            oninvalid="this.setCustomValidity('Silakan isi nama penduduk')"
                            oninput="this.setCustomValidity('')">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nama Kepala Keluarga <span class="text-danger">*</span></label>
                        <input type="text" name="nama_kepala_keluarga" class="form-control"
                            placeholder="Masukkan Nama Kepala Keluarga">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jumlah Anggota Keluarga <span class="text-danger">*</span></label>
                        <input type="number" name="jml_agt_keluarga" class="form-control" required
                            placeholder="Masukkan Jumlah Anggota Keluarga"
                            oninvalid="this.setCustomValidity('Silakan isi jumlah anggota keluarga')"
                            oninput="this.setCustomValidity('')">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kelompok PKH <span class="text-danger">*</span></label>
                        <select name="kelompokPKH" class="form-select" required
                            oninvalid="this.setCustomValidity('Silakan pilih Kelompok PKH')"
                            oninput="this.setCustomValidity('')">
                            <option value="" disabled selected hidden>Pilih kelompok PKH</option>
                            <option value="Mawar">Mawar</option>
                            <option value="Karmi">Karmi</option>
                            <option value="Cahaya Ilahi">Cahaya Ilahi</option>
                            <option value="Wardini">Wardini</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Foto Rumah (Kosongkan jika tidak diubah) <span
                                class="text-danger">*</span></label>
                        <input type="file" name="foto_rumah" class="form-control" accept=".jpg,.jpeg,.png,.pdf">
                        <small class="form-text text-muted">Tipe File : JPG,PNG,PDF | Ukuran Maksimal :
                            2MB.</small>

                    </div>
                    <div class="mb-3">
                        <label class="form-label">Alamat <span class="text-danger">*</span></label>
                        <input type="text" name="alamat" class="form-control" required placeholder="Masukkan Alamat"
                            oninvalid="this.setCustomValidity('Silakan isi alamat')" oninput="this.setCustomValidity('')">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Pilih Lokasi Rumah <span class="text-danger">*</span></label>
                        <div id="map" style="height: 300px;"></div>

                    </div>
                    <div class="mb-3">
                        <label class="form-label">Latitude<span class="text-danger">*</span></label>
                        <input type="text" name="latitude" id="latitude" class="form-control" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Longitude<span class="text-danger">*</span></label>
                        <input type="text" name="longitude" id="longitude" class="form-control" readonly>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
            </form>
        </div>
    </div>

    <!-- Modal Edit Penduduk -->
    <div class="modal fade" id="modalEditPenduduk" tabindex="-1" aria-labelledby="modalEditLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form id="formEditPenduduk" method="POST" enctype="multipart/form-data" class="modal-content">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditLabel">Edit Status Penduduk Miskin</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">

                    <div class="mb-3">
                        <label for="edit_status_penduduk" class="form-label">Status Penduduk</label>
                        <select name="status" id="edit_status_penduduk" class="form-select" required>
                            <option value="Miskin">Miskin</option>
                            <option value="Menengah">Menengah</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


    <!-- Leaflet -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        let map;
        let marker;

        document.getElementById('modalTambahPenduduk').addEventListener('shown.bs.modal', function() {
            setTimeout(() => {
                if (!map) {
                    map = L.map('map').setView([0.60, 101.50], 13);

                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        maxZoom: 19,
                        attribution: '&copy; OpenStreetMap contributors'
                    }).addTo(map);

                    map.on('click', function(e) {
                        const lat = e.latlng.lat.toFixed(6);
                        const lng = e.latlng.lng.toFixed(6);

                        if (marker) {
                            marker.setLatLng(e.latlng);
                        } else {
                            marker = L.marker(e.latlng).addTo(map);
                        }

                        document.getElementById('latitude').value = lat;
                        document.getElementById('longitude').value = lng;
                    });
                } else {
                    map.invalidateSize();
                }

                // Jika koordinat sudah ada
                const lat = document.getElementById('latitude').value;
                const lng = document.getElementById('longitude').value;
                if (lat && lng) {
                    const latLng = L.latLng(parseFloat(lat), parseFloat(lng));
                    if (marker) {
                        marker.setLatLng(latLng);
                    } else {
                        marker = L.marker(latLng).addTo(map);
                    }
                    map.setView(latLng, 15);
                }
            }, 700);
        });

        document.getElementById('modalTambahPenduduk').addEventListener('hidden.bs.modal', function() {
            if (marker) {
                map.removeLayer(marker);
                marker = null;
            }
            document.getElementById('latitude').value = '';
            document.getElementById('longitude').value = '';
        });
    </script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('modalEditPenduduk');
            modal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;

                // Ambil data dari atribut data-*
                const id = button.getAttribute('data-id');
                const status = button.getAttribute('data-status');

                // Isi form action
                const form = modal.querySelector('#formEditPenduduk');
                form.action = `/pendudukMiskin/update/${id}`;

                // Isi select status
                const statusSelect = modal.querySelector('#edit_status_penduduk');
                if (statusSelect) {
                    statusSelect.value = status;
                }
            });
        });
    </script>

    <script>
        function inisialisasiDataTable(idTabel) {
            if ($.fn.DataTable.isDataTable(idTabel)) {
                $(idTabel).DataTable().destroy();
            }

            // Debug: cek jumlah kolom per baris
            $(idTabel + ' tbody tr').each(function(index, row) {
                const tdCount = $(row).find('td').length;
                const thCount = $(idTabel + ' thead th').length;
                if (tdCount !== thCount) {
                    console.warn(
                        `⚠️ Jumlah kolom td (${tdCount}) ≠ th (${thCount}) di tabel ${idTabel} baris ke-${index + 1}`
                    );
                }
            });

            let table = $(idTabel).DataTable({
                columnDefs: [{
                    targets: 0,
                    orderable: false,
                    searchable: false
                }],
            });

            table.on('order.dt search.dt', function() {
                table.column(0, {
                    search: 'applied',
                    order: 'applied'
                }).nodes().each(function(cell, i) {
                    cell.innerHTML = i + 1;
                });
            }).draw();
        }

        $(document).ready(function() {
            inisialisasiDataTable('#pendudukMiskin');
            inisialisasiDataTable('#pendudukMenengah');
        });
    </script>
@endpush
