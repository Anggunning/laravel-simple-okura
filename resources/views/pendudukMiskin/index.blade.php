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
                        <!-- Tombol Tambah di kanan -->
                        <a href="#" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#modalTambahPenduduk">
                            <i class="bi bi-plus-circle"></i> Tambah Data
                        </a>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover table-bordered" id="pendudukTable">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Alamat</th>
                                <th>Jumlah Anggota</th>
                                <th>Kelompok PKH</th>
                                <th>Foto Rumah</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($data as $item)
                                <tr>
                                    <td>{{ $item->nama }}</td>
                                    <td>{{ $item->alamat }}</td>
                                    <td>{{ $item->jml_agt_keluarga }} Orang</td>
                                    <td>{{ $item->kelompokPKH }}</td>
                                    <td>
                                        @if ($item->foto_rumah)
                                            <img src="{{ route('dokumen.show', ['folder' => 'pendudukMiskin', 'filename' => basename($item->foto_rumah)]) }}" alt="Foto Rumah"
                                                style="width: 80px; height: auto; border-radius: 5px;">
                                        @else
                                            <span class="text-muted">Tidak ada foto</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            @if (auth()->check() && in_array(auth()->user()->role, ['Admin']))
                                                <a href="#" class="btn btn-white me-2" style="color: #2E8B57;"
                                                    data-bs-toggle="modal" data-bs-target="#modalEditPenduduk"
                                                    data-id="{{ $item->id }}" data-nama="{{ $item->nama }}"
                                                    data-nama_kepala_keluarga="{{ $item->nama_kepala_keluarga }}"
                                                    data-alamat="{{ $item->alamat }}"
                                                    data-jml_agt_keluarga="{{ $item->jml_agt_keluarga }}"
                                                    data-kelompok="{{ $item->kelompokPKH }}"
                                                    data-foto_rumah="{{ $item->foto_rumah }}"
                                                    data-longitude="{{ $item->longitude }}"
                                                    data-latitude="{{ $item->latitude }}">
                                                    <i class="bi bi-pencil-square fs-5"></i>
                                                </a>

                                                <form id="formHapus-{{ $item->id }}"
                                                    action="{{ route('pendudukMiskin.destroy', $item->id) }}"
                                                    method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-white me-2"
                                                        id="btnHapus-{{ $item->id }}" style="color: #2E8B57;"
                                                        onclick="konfirmasiHapus('{{ $item->id }}')">
                                                        <i class="bi bi-trash fs-5"></i>
                                                    </button>
                                                </form>
                                            @endif

                                            <a class="btn btn-white me-2" style="color: #2E8B57;"
                                                href="{{ route('pendudukMiskin.show', $item->id) }}">
                                                <i class="bi bi-info-circle fs-5"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">Tidak ada data penduduk
                                        miskin.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>



            <!-- Modal Tambah Penduduk -->
            <div class="modal fade" id="modalTambahPenduduk" tabindex="-1" aria-labelledby="modalTambahLabel"
                aria-hidden="true">
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
                                <input type="text" name="nama" class="form-control" required
                                    placeholder="Masukkan Nama"
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
                                <input type="file" name="foto_rumah" class="form-control"
                                    accept=".jpg,.jpeg,.png,.pdf">
                                <small class="form-text text-muted">Tipe File : JPG,PNG,PDF | Ukuran Maksimal :
                                    2MB.</small>

                            </div>
                            <div class="mb-3">
                                <label class="form-label">Alamat <span class="text-danger">*</span></label>
                                <input type="text" name="alamat" class="form-control" required
                                    placeholder="Masukkan Alamat" oninvalid="this.setCustomValidity('Silakan isi alamat')"
                                    oninput="this.setCustomValidity('')">
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
        </div>
        <!-- Modal Edit Penduduk -->
        <div class="modal fade" id="modalEditPenduduk" tabindex="-1" aria-labelledby="modalEditLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <form id="formEditPenduduk" method="POST" enctype="multipart/form-data" class="modal-content">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalEditLabel">Edit Data Penduduk Miskin</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" id="edit_id">

                        <div class="mb-3">
                            <label class="form-label">Nama<span class="text-danger">*</span></label>
                            <input type="text" name="nama" id="edit_nama" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nama Kepala Keluarga<span class="text-danger">*</span></label>
                            <input type="text" name="nama_kepala_keluarga" id="edit_nama_kepala_keluarga"
                                class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Jumlah Anggota Keluarga<span class="text-danger">*</span></label>
                            <input type="number" name="jml_agt_keluarga" id="edit_jml_agt_keluarga"
                                class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Kelompok PKH<span class="text-danger">*</span></label>
                            <select name="kelompokPKH" id="edit_kelompokPKH" class="form-select" required>
                                <option value="">Pilih kelompok PKH</option>
                                <option value="Mawar">Mawar</option>
                                <option value="Karmi">Karmi</option>
                                <option value="Cahaya Ilahi">Cahaya Ilahi</option>
                                <option value="Wardini">Wardini</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Foto Rumah (Kosongkan jika tidak diubah) <span
                                    class="text-danger">*</span></label>
                            <input type="file" name="edit_foto_rumah" class="form-control"
                                accept=".jpg,.jpeg,.png,.pdf">
                            <small class="form-text text-muted">Tipe File : JPG,PNG,PDF | Ukuran Maksimal :
                                2MB.</small>
                            <div id="link_foto_rumah_lama" class="mt-2"></div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Alamat<span class="text-danger">*</span></label>
                            <input type="text" name="alamat" id="edit_alamat" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Pilih Lokasi Rumah <span class="text-danger">*</span></label>
                            <div id="mapEdit" style="height: 300px;"></div>

                        </div>
                        <div class="mb-3">
                            <label class="form-label">Latitude<span class="text-danger">*</span></label>
                            <input type="text" name="latitude" id="edit_latitude" class="form-control" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Longitude<span class="text-danger">*</span></label>
                            <input type="text" name="longitude" id="edit_longitude" class="form-control" readonly>
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
            let mapEdit;
            let markerEdit;

            document.getElementById('modalEditPenduduk').addEventListener('shown.bs.modal', function() {
                setTimeout(() => {
                    if (!mapEdit) {
                        mapEdit = L.map('mapEdit').setView([0.60, 101.50], 13);
                        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                            maxZoom: 19,
                            attribution: '&copy; OpenStreetMap contributors'
                        }).addTo(mapEdit);

                        mapEdit.on('click', function(e) {
                            const lat = e.latlng.lat.toFixed(6);
                            const lng = e.latlng.lng.toFixed(6);
                            if (markerEdit) {
                                markerEdit.setLatLng(e.latlng);
                            } else {
                                markerEdit = L.marker(e.latlng).addTo(mapEdit);
                            }
                            document.getElementById('latitude').value = lat;
                            document.getElementById('longitude').value = lng;
                        });
                    } else {
                        mapEdit.invalidateSize();
                    }

                    // Cek apakah sudah ada koordinat
                    const lat = document.getElementById('edit_latitude').value;
                    const lng = document.getElementById('edit_longitude').value;
                    if (lat && lng) {
                        const latLng = L.latLng(parseFloat(lat), parseFloat(lng));
                        if (markerEdit) {
                            markerEdit.setLatLng(latLng);
                        } else {
                            markerEdit = L.marker(latLng).addTo(mapEdit);
                        }
                        mapEdit.setView(latLng, 15);
                    }
                }, 700);
            });

            document.getElementById('modalEditPenduduk').addEventListener('hidden.bs.modal', function() {
                if (markerEdit) {
                    mapEdit.removeLayer(markerEdit);
                    markerEdit = null;
                }
            });
        </script>
        <script>
            $(document).ready(function() {
                $('#modalEditPenduduk').on('show.bs.modal', function(event) {
                    var button = $(event.relatedTarget); // <-- inisialisasi button di sini

                    // Sekarang aman untuk digunakan
                    $('#edit_id').val(button.data('id'));
                    $('#edit_nama').val(button.data('nama'));
                    $('#edit_nama_kepala_keluarga').val(button.data('nama_kepala_keluarga'));
                    $('#edit_alamat').val(button.data('alamat'));
                    $('#edit_jml_agt_keluarga').val(button.data('jml_agt_keluarga'));
                    $('#edit_kelompokPKH').val(button.data('kelompok'));
                    $('#edit_foto_rumah').val(button.data('foto_rumah'));
                    $('#edit_latitude').val(button.data('latitude'));
                    $('#edit_longitude').val(button.data('longitude'));


                    let newAction = "{{ route('pendudukMiskin.update', ':id') }}".replace(':id', button.data(
                        'id'));
                    $('#formEditPenduduk').attr('action', newAction);
                });
            });
        </script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
        @if ($data->count() > 0)
            <script>
                $(document).ready(function() {
                    $('#pendudukTable').DataTable({
    paging: true,
    pageLength: 6,
    ordering: false // ini akan menonaktifkan sorting DataTables
});

                    // Contoh: jika ingin debug, lakukan saat modal muncul
                    $('#modalEditPenduduk').on('show.bs.modal', function(event) {
                        var button = $(event.relatedTarget);
                        console.log(button.data()); // ✅ Aman digunakan di sini
                    });
                });
            </script>
        @endif
        <script>
            $('#modalEditPenduduk').on('show.bs.modal', function(event) {
                const button = $(event.relatedTarget);

               const fileUrl = button.data('foto_rumah');
if (fileUrl) {
    const fileName = fileUrl.split('/').pop();
    const folder = 'pendudukMiskin';

    const link = `<a href="/dokumen/${folder}/${fileName}" target="_blank" class="btn btn-sm btn-outline-primary">
                    Lihat File Sebelumnya
                </a>`;
    $('#link_foto_rumah_lama').html(link);
} else {
    $('#link_foto_rumah_lama').html('<span class="text-muted">Tidak ada file sebelumnya</span>');
}

            });
        </script>

    @endpush
