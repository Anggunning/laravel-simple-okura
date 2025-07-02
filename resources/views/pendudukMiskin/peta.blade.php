@extends('layouts.master')

@push('styles')
    {{-- Leaflet CSS --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
@endpush

@section('content')
<div class="app-title"> 
    <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
        <li class="breadcrumb-item active"><a href="#">Persebaran Penduduk Miskin</a></li>
    </ul>
</div> 

<div class="title">
    <h4>Peta Persebaran Penduduk Miskin</h4>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <div class="tile-body">
               <div style="position: absolute; top: 10px; right: 10px; z-index: 1000;  background: white; padding: 10px; border-radius: 6px; box-shadow: 0 2px 6px rgba(0,0,0,0.2);">
                    <label for="filterKelompok" class="form-label mb-1"><strong>Filter Kelompok PKH:</strong></label>
                    <select id="filterKelompok" class="form-control form-control-sm" style="min-width: 200px;">
                        <option value="all">Tampilkan Semua</option>
                        @foreach ($kelompokList as $kelompok)
                            <option value="{{ $kelompok }}">{{ $kelompok }}</option>
                        @endforeach
                    </select>
                </div>
                <div id="map" style="height: 600px;"></div>
            </div>
        </div>
    </div>
</div>
@endsection

    {{-- Leaflet JS --}}
    @push('scripts')
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const map = L.map('map').setView([0.60, 101.50], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap',
            maxZoom: 18,
        }).addTo(map);

        // Warna marker per kelompok
        const kelompokColors = {
            'Cahaya Ilahi': 'red',
            'Mawar': 'blue',
            'Wardini': 'green',
            'Karmi': 'orange',
            'default': 'gray'
        };

        const data = @json($data);

        let markers = [];

        function createMarkers(filteredKelompok = 'all') {
            // Hapus marker sebelumnya
            markers.forEach(marker => map.removeLayer(marker));
            markers = [];

            data.forEach(item => {
                if (item.latitude && item.longitude) {
                    if (filteredKelompok === 'all' || item.kelompokPKH === filteredKelompok) {
                        const color = kelompokColors[item.kelompokPKH] || kelompokColors['default'];

                        const icon = L.icon({
                            iconUrl: `https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-${color}.png`,
                            iconSize: [25, 41],
                            iconAnchor: [12, 41],
                            popupAnchor: [1, -34],
                            shadowUrl: 'https://unpkg.com/leaflet@1.9.3/dist/images/marker-shadow.png',
                            shadowSize: [41, 41]
                        });

                        const marker = L.marker([item.latitude, item.longitude], { icon })
                            .bindPopup(`
    <div style="width: 250px; font-size: 14px;">
        <strong style="font-size: 16px;">${item.nama}</strong><br>
        <img src="/storage/${item.foto_rumah}" alt="Foto Rumah" style="width: 100%; height: auto; margin: 6px 0; border-radius: 8px; box-shadow: 0 0 4px rgba(0,0,0,0.3);">
        <p style="margin: 0;"><strong>Alamat:</strong> ${item.alamat}</p>
        <p style="margin: 0;"><strong>Kepala Keluarga:</strong> ${item.nama_kepala_keluarga}</p>
        <p style="margin: 0;"><strong>Jumlah Anggota Keluarga:</strong> ${item.jml_agt_keluarga}</p>
        <p style="margin: 0;"><strong>Kelompok:</strong> ${item.kelompokPKH}</p>
    </div>
`);

                        
                        marker.addTo(map);
                        markers.push(marker);
                    }
                }
            });
        }

        // Tampilkan semua marker awal
        createMarkers();

        // Filter dropdown
        document.getElementById("filterKelompok").addEventListener("change", function () {
            createMarkers(this.value);
        });
    });
</script>
@endpush
