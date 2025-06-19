<div id="sectionDataPemohon">
    {{-- Form Pemohon --}}
    <div class="row">
        <div class="mb-3 col-md-6">
            <label for="{{ $prefix }}nama" class="form-label">Nama</label>
            <input type="text" name="nama" id="{{ $prefix }}nama" class="form-control" required placeholder="Masukkan nama lengkap">
        </div>
        <div class="mb-3 col-md-6">
            <label for="{{ $prefix }}nik" class="form-label">NIK</label>
            <input type="text" name="nik" id="{{ $prefix }}nik" class="form-control" required placeholder="Masukkan NIK 16 digit">
        </div>
    </div>

    <div class="row">
        <div class="mb-3 col-md-6">
            <label for="{{ $prefix }}jenis_kelamin" class="form-label">Jenis Kelamin</label>
            <select name="jenis_kelamin" id="{{ $prefix }}jenis_kelamin" class="form-select" required>
                <option value="">Jenis Kelamin</option>
                <option value="Laki-laki">Laki-laki</option>
                <option value="Perempuan">Perempuan</option>
            </select>
        </div>
        <div class="mb-3 col-md-6">
            <label for="{{ $prefix }}tempat_lahir" class="form-label">Tempat Lahir</label>
            <input type="text" name="tempat_lahir" id="{{ $prefix }}tempat_lahir" class="form-control" required placeholder="Masukkan tempat lahir">
        </div>
    </div>

    <div class="row">
        <div class="mb-3 col-md-6">
            <label for="{{ $prefix }}tanggal_lahir" class="form-label">Tanggal Lahir</label>
            <input type="date" name="tanggal_lahir" id="{{ $prefix }}tanggal_lahir" class="form-control" required>
        </div>
        <div class="mb-3 col-md-6">
            <label for="{{ $prefix }}agama" class="form-label">Agama</label>
            <input type="text" name="agama" id="{{ $prefix }}agama" class="form-control" required placeholder="Masukkan agama">
        </div>
    </div>

    <div class="row">
        <div class="mb-3 col-md-6">
            <label for="{{ $prefix }}pekerjaan" class="form-label">Pekerjaan</label>
            <input type="text" name="pekerjaan" id="{{ $prefix }}pekerjaan" class="form-control" required placeholder="Masukkan pekerjaan">
        </div>
        <div class="mb-3 col-md-6" id="formNamaPasangan" style="display: none;">
    <label for="{{ $prefix }}nama_pasangan" class="form-label">Nama Pasangan</label>
    <input type="text" name="nama_pasangan" id="{{ $prefix }}nama_pasangan" class="form-control" placeholder="Masukkan nama pasangan">
</div>

<div class="mb-3 col-md-6" id="formJenisKelaminPasangan" style="display: none;">
    <label for="{{ $prefix }}jenis_kelamin_pasangan" class="form-label">Jenis Kelamin Pasangan</label>
    <input type="text" id="{{ $prefix }}jenis_kelamin_pasangan" class="form-control" readonly>
</div>

    </div>

    <div class="row">
        <div class="mb-3 col-md-6">
            <label for="{{ $prefix }}alamat" class="form-label">Alamat</label>
            <input type="text" name="alamat" id="{{ $prefix }}alamat" class="form-control" required placeholder="Masukkan alamat tempat tinggal">
        </div>
        <div class="mb-3 col-md-6">
            <label for="{{ $prefix }}kewarganegaraan" class="form-label">Kewarganegaraan</label>
            <input type="text" name="kewarganegaraan" id="{{ $prefix }}kewarganegaraan" class="form-control" required placeholder="Contoh: Indonesia">
        </div>
    </div>

    <div class="row">
        <div class="mb-3 col-12">
            <label for="{{ $prefix }}keterangan" class="form-label">Keterangan</label>
            <textarea name="keterangan" id="{{ $prefix }}keterangan" class="form-control" rows="2" placeholder="Tambahkan keterangan jika diperlukan"></textarea>
        </div>
    </div>

    {{-- Upload File --}}
    <div class="row">
        @foreach (['ktp' => 'KTP', 'kk' => 'Kartu Keluarga', 'pengantar_rt_rw' => 'Surat Pengantar RT/RW', 'foto' => 'Foto'] as $name => $label)
            <div class="mb-3 col-md-6">
                <label for="{{ $prefix . $name }}" class="form-label">{{ $label }}</label>
                <input type="file" name="{{ $name }}" id="{{ $prefix . $name }}" class="form-control"
                    accept=".jpg,.jpeg,.png,.pdf" {{ $prefix == '' ? 'required' : '' }}>
            </div>
        @endforeach
    </div>
</div>

<div id="sectionDataOrangtua" style="display: none;">
    <h5 class="fw-bold mb-3">Data Orang Tua</h5>

    {{-- Ayah --}}
    <h6 class="fw-semibold mt-2 mb-3">Data Ayah</h6>
    <div class="row">
        <div class="mb-3 col-md-6">
            <label for="{{ $prefix }}nama_ayah" class="form-label">Nama Ayah</label>
            <input type="text" name="nama_ayah" id="{{ $prefix }}nama_ayah" class="form-control" required required placeholder="Masukkan nama ayah">
        </div>
        <div class="mb-3 col-md-6">
            <label for="{{ $prefix }}nik_ayah" class="form-label">NIK Ayah</label>
            <input type="text" name="nik_ayah" id="{{ $prefix }}nik_ayah" class="form-control" required required placeholder="Masukkan NIK ayah">
        </div>
    </div>

    <div class="row">
        <div class="mb-3 col-md-6">
            <label for="{{ $prefix }}agama_ayah" class="form-label">Agama Ayah</label>
            <input type="text" name="agama_ayah" id="{{ $prefix }}agama_ayah" class="form-control" required required placeholder="Masukkan agama ayah">
        </div>
        <div class="mb-3 col-md-6">
            <label for="{{ $prefix }}kewarganegaraan_ayah" class="form-label">Kewarganegaraan Ayah</label>
            <input type="text" name="kewarganegaraan_ayah" id="{{ $prefix }}kewarganegaraan_ayah" class="form-control" required required placeholder="Masukkan kewarganegaraan ayah">
        </div>
    </div>

    <div class="row">
        <div class="mb-3 col-md-6">
            <label for="{{ $prefix }}pekerjaan_ayah" class="form-label">Pekerjaan Ayah</label>
            <input type="text" name="pekerjaan_ayah" id="{{ $prefix }}pekerjaan_ayah" class="form-control" required required placeholder="Masukkan pekerjaan ayah">
        </div>
        <div class="mb-3 col-md-6">
            <label for="{{ $prefix }}alamat_ayah" class="form-label">Alamat Ayah</label>
            <input type="text" name="alamat_ayah" id="{{ $prefix }}alamat_ayah" class="form-control" required required placeholder="Masukkan alamat ayah">
        </div>
    </div>

    {{-- Ibu --}}
    <h6 class="fw-semibold mt-4 mb-3">Data Ibu</h6>
    <div class="row">
        <div class="mb-3 col-md-6">
            <label for="{{ $prefix }}nama_ibu" class="form-label">Nama Ibu</label>
            <input type="text" name="nama_ibu" id="{{ $prefix }}nama_ibu" class="form-control" required required placeholder="Masukkan nama ibu">
        </div>
        <div class="mb-3 col-md-6">
            <label for="{{ $prefix }}nik_ibu" class="form-label">NIK Ibu</label>
            <input type="text" name="nik_ibu" id="{{ $prefix }}nik_ibu" class="form-control" required placeholder="Masukkan NIK ibu">
        </div>
    </div>

    <div class="row">
        <div class="mb-3 col-md-6">
            <label for="{{ $prefix }}agama_ibu" class="form-label">Agama Ibu</label>
            <input type="text" name="agama_ibu" id="{{ $prefix }}agama_ibu" class="form-control" required placeholder="Masukkan agama ibu">
        </div>
        <div class="mb-3 col-md-6">
            <label for="{{ $prefix }}kewarganegaraan_ibu" class="form-label">Kewarganegaraan Ibu</label>
            <input type="text" name="kewarganegaraan_ibu" id="{{ $prefix }}kewarganegaraan_ibu" class="form-control" required placeholder="Masukkan kewarganegaraan ibu">
        </div>
    </div>

    <div class="row">
        <div class="mb-3 col-md-6">
            <label for="{{ $prefix }}pekerjaan_ibu" class="form-label">Pekerjaan Ibu</label>
            <input type="text" name="pekerjaan_ibu" id="{{ $prefix }}pekerjaan_ibu" class="form-control" required placeholder="Masukkan pekerjaan ibu">
        </div>
        <div class="mb-3 col-md-6">
            <label for="{{ $prefix }}alamat_ibu" class="form-label">Alamat Ibu</label>
            <input type="text" name="alamat_ibu" id="{{ $prefix }}alamat_ibu" class="form-control" required placeholder="Masukkan alamat ibu">
        </div>
    </div>
</div>


{{-- Tombol Navigasi --}}
<div class="row ">
    <div class="col-7  text-end">
        <button type="button" class="btn btn-primary" id="btnNextOrtu">Selanjutnya &raquo;</button>
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        const btnNext = document.getElementById('btnNextOrtu');
        const sectionPemohon = document.getElementById('sectionDataPemohon');
        const sectionOrangtua = document.getElementById('sectionDataOrangtua');
        const modalTambah = document.getElementById('modalTambah'); // ganti sesuai ID modal tambah kamu

        let onOrangtua = false;

        btnNext.addEventListener('click', function () {
            if (!onOrangtua) {
                sectionPemohon.style.display = 'none';
                sectionOrangtua.style.display = 'block';
                btnNext.innerHTML = '&laquo; Sebelumnya';
                onOrangtua = true;
            } else {
                sectionPemohon.style.display = 'block';
                sectionOrangtua.style.display = 'none';
                btnNext.innerHTML = 'Selanjutnya &raquo;';
                onOrangtua = false;
            }
        });

        // RESET KE PEMOHON SAAT MODAL DIBUKA
        modalTambah.addEventListener('show.bs.modal', function () {
            sectionPemohon.style.display = 'block';
            sectionOrangtua.style.display = 'none';
            btnNext.innerHTML = 'Selanjutnya &raquo;';
            onOrangtua = false;
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const statusKawinSelect = document.getElementById('{{ $prefix }}status_kawin');
        const jenisKelaminSelect = document.getElementById('{{ $prefix }}jenis_kelamin');
        const formNamaPasangan = document.getElementById('formNamaPasangan');
        const formJKPasangan = document.getElementById('formJenisKelaminPasangan');
        const inputJKPasangan = document.getElementById('{{ $prefix }}jenis_kelamin_pasangan');

        function updateFormPasangan() {
            const status = statusKawinSelect.value;
            const jk = jenisKelaminSelect.value;

            if (status === 'Cerai Hidup' || status === 'Cerai Mati') {
                formNamaPasangan.style.display = 'block';
                formJKPasangan.style.display = 'block';

                // Atur jenis kelamin pasangan kebalikan dari pemohon
                if (jk === 'Laki-laki') {
                    inputJKPasangan.value = 'Perempuan';
                } else if (jk === 'Perempuan') {
                    inputJKPasangan.value = 'Laki-laki';
                } else {
                    inputJKPasangan.value = '';
                }
            } else {
                formNamaPasangan.style.display = 'none';
                formJKPasangan.style.display = 'none';
                inputJKPasangan.value = '';
            }
        }

        statusKawinSelect.addEventListener('change', updateFormPasangan);
        jenisKelaminSelect.addEventListener('change', updateFormPasangan);

        // Panggil saat pertama kali (jika form edit)
        updateFormPasangan();
    });
</script>

