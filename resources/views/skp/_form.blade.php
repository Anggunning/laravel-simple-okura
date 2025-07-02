<div id="sectionDataPemohon">
    {{-- Form Pemohon --}}
    <div class="row">
        <div class="mb-3 col-md-6">
            <label for="{{ $prefix }}nama" class="form-label">Nama
                <span class="text-danger">*</span>
            </label>
            <input type="text" name="nama" id="{{ $prefix }}nama" class="form-control" required placeholder="Masukkan nama lengkap"
            oninvalid="this.setCustomValidity('Silakan isi nama lengkap')"
                                            oninput="this.setCustomValidity('')">
        </div>
        <div class="mb-3 col-md-6">
            <label for="{{ $prefix }}nik" class="form-label">NIK</label>
            <input type="text" name="nik" id="{{ $prefix }}nik" class="form-control" required placeholder="Masukkan NIK 16 digit"
            oninvalid="this.setCustomValidity('Silakan isi nik')"
                                            oninput="this.setCustomValidity('')">
        </div>
    </div>

    <div class="row">
        <div class="mb-3 col-md-6">
            <label for="{{ $prefix }}jenis_kelamin" class="form-label">Jenis Kelamin
                <span class="text-danger">*</span>
            </label>
            <select name="jenis_kelamin" id="{{ $prefix }}jenis_kelamin" class="form-select" required
            oninvalid="this.setCustomValidity('Silakan isi jenis kelamin')"
                                            oninput="this.setCustomValidity('')">
                <option value="">Jenis Kelamin</option>
                <option value="Laki-laki">Laki-laki</option>
                <option value="Perempuan">Perempuan</option>
            </select>
            
        </div>
        <div class="mb-3 col-md-6">
            <label for="{{ $prefix }}tempat_lahir" class="form-label">Tempat Lahir
                <span class="text-danger">*</span>
            </label>
            <input type="text" name="tempat_lahir" id="{{ $prefix }}tempat_lahir" class="form-control" required 
            oninvalid="this.setCustomValidity('Silakan isi tempat lahir')"
                                            oninput="this.setCustomValidity('')" placeholder="Masukkan tempat lahir">
        </div>
    </div>

    <div class="row">
        <div class="mb-3 col-md-6">
            <label for="{{ $prefix }}tanggal_lahir" class="form-label">Tanggal Lahir
                <span class="text-danger">*</span>
            </label>
            <input type="date" name="tanggal_lahir" id="{{ $prefix }}tanggal_lahir" class="form-control" required
            oninvalid="this.setCustomValidity('Silakan isi tanggal lahir')"
                                            oninput="this.setCustomValidity('')">
        </div>
        <div class="mb-3 col-md-6">
            <label for="{{ $prefix }}agama" class="form-label">Agama
                <span class="text-danger">*</span>
            </label>
            <input type="text" name="agama" id="{{ $prefix }}agama" class="form-control" required 
            oninvalid="this.setCustomValidity('Silakan isi agama')"
                                            oninput="this.setCustomValidity('')" placeholder="Masukkan agama">
        </div>
    </div>

    <div class="row">
        <div class="mb-3 col-md-6">
            <label for="{{ $prefix }}pekerjaan" class="form-label">Pekerjaan
                <span class="text-danger">*</span>
            </label>
            <input type="text" name="pekerjaan" id="{{ $prefix }}pekerjaan" class="form-control" required 
            oninvalid="this.setCustomValidity('Silakan isi pekerjaan')"
                                            oninput="this.setCustomValidity('')" placeholder="Masukkan pekerjaan">
        </div>
        <div class="mb-3 col-md-6" id="formNamaPasangan" style="display: none;">
    <label for="{{ $prefix }}nama_pasangan_dulu" class="form-label">Nama Pasangan Dulu
        <span class="text-danger">*</span>
    </label>
    <input type="text" name="nama_pasangan_dulu" id="{{ $prefix }}nama_pasangan_dulu" class="form-control" 
    oninvalid="this.setCustomValidity('Silakan isi nama pasangan dulu')"
                                            oninput="this.setCustomValidity('')" placeholder="Masukkan nama pasangan">
</div>
<div class="mb-3 col-md-6">
    <label for="{{ $prefix }}status_kawin" class="form-label">Status Perkawinan
        <span class="text-danger">*</span>
    </label>
    <select name="status_kawin" id="{{ $prefix }}status_kawin" class="form-select" required
    oninvalid="this.setCustomValidity('Silakan isi status kawin')"
                                            oninput="this.setCustomValidity('')">
        <option value="">Pilih Status</option>
        <option value="Belum Menikah">Belum Menikah</option>
        <option value="Cerai Hidup">Cerai Hidup</option>
        <option value="Cerai Mati">Cerai Mati</option>
    </select>
</div>


<div class="mb-3 col-md-6" id="formJenisKelaminPasanganDulu" style="display: none;">
    <label for="{{ $prefix }}jenis_kelamin_psgn_dulu" class="form-label">Jenis Kelamin Pasangan
        <span class="text-danger">*</span>
    </label>
    <input type="text" id="{{ $prefix }}jenis_kelamin_psgn_dulu" class="form-control" readonly >
</div>

    </div>

    <div class="row">
        <div class="mb-3 col-md-6">
            <label for="{{ $prefix }}alamat" class="form-label">Alamat
                <span class="text-danger">*</span>
            </label>
            <input type="text" name="alamat" id="{{ $prefix }}alamat" class="form-control" required 
            oninvalid="this.setCustomValidity('Silakan isi alamat')"
                                            oninput="this.setCustomValidity('')"placeholder="Masukkan alamat tempat tinggal">
        </div>
        <div class="mb-3 col-md-6">
            <label for="{{ $prefix }}kewarganegaraan" class="form-label">Kewarganegaraan
                <span class="text-danger">*</span>
            </label>
            <input type="text" name="kewarganegaraan" id="{{ $prefix }}kewarganegaraan" class="form-control" required 
            oninvalid="this.setCustomValidity('Silakan isi kewarganegaraan')"
                                            oninput="this.setCustomValidity('')" placeholder="Contoh: Indonesia">
        </div>
    </div>

    <div class="row">
        <div class="mb-3 col-12">
            <label for="{{ $prefix }}keterangan" class="form-label">Keterangan
                <span class="text-danger">*</span>
            </label>
            <textarea name="keterangan" id="{{ $prefix }}keterangan" class="form-control" rows="2" 
            oninvalid="this.setCustomValidity('Silakan isi kewarganegaraan')"
            oninput="this.setCustomValidity('')" placeholder="Tambahkan keterangan jika diperlukan"></textarea>
        </div>
    </div>

    {{-- Upload File --}}
    <div class="row">
        @foreach (['ktp' => 'KTP', 'kk' => 'Kartu Keluarga', 'pengantar_rt_rw' => 'Surat Pengantar RT/RW', 'foto' => 'Foto'] as $name => $label)
            <div class="mb-3 col-md-6">
                <label for="{{ $prefix . $name }}" class="form-label">{{ $label }}<span class="text-danger">*</span></label>
                <input type="file" name="{{ $name }}" id="{{ $prefix . $name }}" class="form-control"
                    accept=".jpg,.jpeg,.png,.pdf" {{ $prefix == '' ? 'required' : '' }} oninvalid="this.setCustomValidity('Silakan isi file')"
            oninput="this.setCustomValidity('')"><small class="form-text text-muted">Tipe File : JPG,PNG,PDF | Ukuran Maksimal :
                                            2MB.</small>
            </div>
        @endforeach
    </div>
</div>

<div id="sectionDataOrangtua" >
    <h5 class="fw-bold mb-3">Data Orang Tua</h5>

    {{-- Ayah --}}
    <h6 class="fw-semibold mt-2 mb-3">Data Ayah</h6>
    <div class="row">
        <div class="mb-3 col-md-6">
            <label for="{{ $prefix }}nama_ayah" class="form-label">Nama Ayah
                <span class="text-danger">*</span>
            </label>
            <input type="text" name="nama_ayah" id="{{ $prefix }}nama_ayah" class="form-control" required 
            oninvalid="this.setCustomValidity('Silakan isi nama ayah')"
            oninput="this.setCustomValidity('')"placeholder="Masukkan nama ayah">
        </div>
        <div class="mb-3 col-md-6">
            <label for="{{ $prefix }}nik_ayah" class="form-label">NIK Ayah
                <span class="text-danger">*</span>
            </label>
            <input type="text" name="nik_ayah" id="{{ $prefix }}nik_ayah" class="form-control" required 
            oninvalid="this.setCustomValidity('Silakan isi nik ayah')"
            oninput="this.setCustomValidity('')" placeholder="Masukkan NIK ayah">
        </div>
    </div>

    <div class="row">
        <div class="mb-3 col-md-6">
            <label for="{{ $prefix }}tempat_lahir_ayah" class="form-label">Tempat Lahir Ayah
                <span class="text-danger">*</span>
            </label>
            <input type="text" name="tempat_lahir_ayah" id="{{ $prefix }}tempat_lahir_ayah" class="form-control" 
            oninvalid="this.setCustomValidity('Silakan isi tempat lahir ayah')"
            oninput="this.setCustomValidity('')" placeholder="Masukkan tempat lahir ayah">
        </div>
        <div class="mb-3 col-md-6">
            <label for="{{ $prefix }}tanggal_lahir_ayah" class="form-label">Tanggal Lahir Ayah
                <span class="text-danger">*</span>
            </label>
            <input type="date" name="tanggal_lahir_ayah" id="{{ $prefix }}tanggal_lahir_ayah" class="form-control"
            placeholder="Masukkan tanggal lahir ayah"
            oninvalid="this.setCustomValidity('Silakan isi tanggal lahir ayah')"
            oninput="this.setCustomValidity('')">
        </div>
    </div>

    <div class="row">
        <div class="mb-3 col-md-6">
            <label for="{{ $prefix }}agama_ayah" class="form-label">Agama Ayah
                <span class="text-danger">*</span>
            </label>
            <input type="text" name="agama_ayah" id="{{ $prefix }}agama_ayah" class="form-control" required 
            oninvalid="this.setCustomValidity('Silakan isi agama ayah')"
            oninput="this.setCustomValidity('')"placeholder="Masukkan agama ayah">
        </div>
        <div class="mb-3 col-md-6">
            <label for="{{ $prefix }}kewarganegaraan_ayah" class="form-label">Kewarganegaraan Ayah
                <span class="text-danger">*</span>
            </label>
            <input type="text" name="kewarganegaraan_ayah" id="{{ $prefix }}kewarganegaraan_ayah" class="form-control" required 
            oninvalid="this.setCustomValidity('Silakan isi kewarganegaraan ayah')"
            oninput="this.setCustomValidity('')" placeholder="Masukkan kewarganegaraan ayah">
        </div>
    </div>

    <div class="row">
        <div class="mb-3 col-md-6">
            <label for="{{ $prefix }}pekerjaan_ayah" class="form-label">Pekerjaan Ayah
                <span class="text-danger">*</span>
            </label>
            <input type="text" name="pekerjaan_ayah" id="{{ $prefix }}pekerjaan_ayah" class="form-control" required 
            oninvalid="this.setCustomValidity('Silakan isi pekerjaan ayah')"
            oninput="this.setCustomValidity('')"  placeholder="Masukkan pekerjaan ayah">
        </div>
        <div class="mb-3 col-md-6">
            <label for="{{ $prefix }}alamat_ayah" class="form-label">Alamat Ayah
                <span class="text-danger">*</span>
            </label>
            <input type="text" name="alamat_ayah" id="{{ $prefix }}alamat_ayah" class="form-control" required 
            oninvalid="this.setCustomValidity('Silakan isi alamat ayah')"
            oninput="this.setCustomValidity('')"  placeholder="Masukkan alamat ayah">
        </div>
    </div>

    {{-- Ibu --}}
    <h6 class="fw-semibold mt-4 mb-3">Data Ibu</h6>
    <div class="row">
        <div class="mb-3 col-md-6">
            <label for="{{ $prefix }}nama_ibu" class="form-label">Nama Ibu
                <span class="text-danger">*</span>
            </label>
            <input type="text" name="nama_ibu" id="{{ $prefix }}nama_ibu" class="form-control" required 
            oninvalid="this.setCustomValidity('Silakan isi alamat ibu')"
            oninput="this.setCustomValidity('')" placeholder="Masukkan nama ibu">
        </div>
        <div class="mb-3 col-md-6">
            <label for="{{ $prefix }}nik_ibu" class="form-label">NIK Ibu<span class="text-danger">*</span></label>
            <input type="text" name="nik_ibu" id="{{ $prefix }}nik_ibu" class="form-control" required 
            oninvalid="this.setCustomValidity('Silakan isi nik ibu')"
            oninput="this.setCustomValidity('')" placeholder="Masukkan NIK ibu">
        </div>
    </div>

    <div class="row">
        <div class="mb-3 col-md-6">
            <label for="{{ $prefix }}tempat_lahir_ibu" class="form-label">Tempat Lahir Ibu<span class="text-danger">*</span></label>
            <input type="text" name="tempat_lahir_ibu" id="{{ $prefix }}tempat_lahir_ibu" class="form-control" 
            oninvalid="this.setCustomValidity('Silakan isi tempat lahir ibu')"
            oninput="this.setCustomValidity('')" placeholder="Masukkan tempat lahir ibu">
        </div>
        <div class="mb-3 col-md-6">
            <label for="{{ $prefix }}tanggal_lahir_ibu" class="form-label">Tanggal Lahir Ibu<span class="text-danger">*</span></label>
            <input type="date" name="tanggal_lahir_ibu" id="{{ $prefix }}tanggal_lahir_ibu" class="form-control"
            oninvalid="this.setCustomValidity('Silakan isi tanggal lahir ibu')"
            oninput="this.setCustomValidity('')"
            placeholder="Masukkan tanggal lahir ibu" >
        </div>
    </div>

    <div class="row">
        <div class="mb-3 col-md-6">
            <label for="{{ $prefix }}agama_ibu" class="form-label">Agama Ibu<span class="text-danger">*</span></label>
            <input type="text" name="agama_ibu" id="{{ $prefix }}agama_ibu" class="form-control" required 
             oninvalid="this.setCustomValidity('Silakan isi agama ibu')"
            oninput="this.setCustomValidity('')"placeholder="Masukkan agama ibu">
        </div>
        <div class="mb-3 col-md-6">
            <label for="{{ $prefix }}kewarganegaraan_ibu" class="form-label">Kewarganegaraan Ibu<span class="text-danger">*</span></label>
            <input type="text" name="kewarganegaraan_ibu" id="{{ $prefix }}kewarganegaraan_ibu" class="form-control" required
             oninvalid="this.setCustomValidity('Silakan isi kewarganegaraan ibu')"
            oninput="this.setCustomValidity('')" placeholder="Masukkan kewarganegaraan ibu">
        </div>
    </div>

    <div class="row">
        <div class="mb-3 col-md-6">
            <label for="{{ $prefix }}pekerjaan_ibu" class="form-label">Pekerjaan Ibu<span class="text-danger">*</span></label>
            <input type="text" name="pekerjaan_ibu" id="{{ $prefix }}pekerjaan_ibu" class="form-control" required 
             oninvalid="this.setCustomValidity('Silakan isi pekerjaan ibu')"
            oninput="this.setCustomValidity('')"placeholder="Masukkan pekerjaan ibu">
        </div>
        <div class="mb-3 col-md-6">
            <label for="{{ $prefix }}alamat_ibu" class="form-label">Alamat Ibu<span class="text-danger">*</span></label>
            <input type="text" name="alamat_ibu" id="{{ $prefix }}alamat_ibu" class="form-control" required
             oninvalid="this.setCustomValidity('Silakan isi alamat ibu')"
            oninput="this.setCustomValidity('')" placeholder="Masukkan alamat ibu">
        </div>
    </div>
</div>



{{-- Tombol Navigasi --}}
<div class="row ">
    <div class="col-7  text-end">
        <button type="button" class="btn btn-primary" id="btnNextOrtu">Selanjutnya &raquo;</button>
    </div>
</div>
<div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
</div>

   @push('scripts')
       <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const prefix = "{{ $prefix }}";

        const statusKawinSelect = document.getElementById(prefix + 'status_kawin');
        const jenisKelaminSelect = document.getElementById(prefix + 'jenis_kelamin');
        const formNamaPasangan = document.getElementById('formNamaPasangan');
        const formJKPasangan = document.getElementById('formJenisKelaminPasanganDulu');
        const inputJKPasangan = document.getElementById(prefix + 'jenis_kelamin_psgn_dulu');
        const inputNamaPasangan = document.getElementById(prefix + 'nama_pasangan_dulu');

        function updateFormPasangan() {
            const status = statusKawinSelect?.value;
            const jk = jenisKelaminSelect?.value;

            if (status === 'Cerai Hidup' || status === 'Cerai Mati') {
                formNamaPasangan.style.display = 'block';
                formJKPasangan.style.display = 'block';

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
                inputNamaPasangan.value = '';
            }
        }

        if (statusKawinSelect && jenisKelaminSelect) {
            statusKawinSelect.addEventListener('change', updateFormPasangan);
            jenisKelaminSelect.addEventListener('change', updateFormPasangan);
            updateFormPasangan(); // Panggil saat pertama
        } else {
            console.error("❌ Element status atau jenis kelamin tidak ditemukan");
        }
    });

</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
    const btnNext = document.getElementById('btnNextOrtu');
    const sectionPemohon = document.getElementById('sectionDataPemohon');
    const sectionOrangtua = document.getElementById('sectionDataOrangtua');
    const modalTambah = document.getElementById('modalTambahSKP');
    const form = modalTambah.querySelector('form');
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

    // Blokir submit jika belum isi form orang tua
    form.addEventListener('submit', function (e) {
        if (!onOrangtua) {
            e.preventDefault();
            alert('Silakan isi data orang tua terlebih dahulu.');
        }
    });

    // Reset tampilan saat modal dibuka
    modalTambah.addEventListener('show.bs.modal', function () {
        sectionPemohon.style.display = 'block';
        sectionOrangtua.style.display = 'none';
        btnNext.innerHTML = 'Selanjutnya &raquo;';
        onOrangtua = false;
    });
});

</script>
<script>$(document).ready(function () {
    $('.btn-edit-skp').on('click', function () {
        const modal = $('#modalTambahSKP');

        // Ambil data dari atribut tombol
        modal.find('form').attr('action', '/skp/update/' + $(this).data('id')); // contoh endpoint update

        modal.find('#nama').val($(this).data('nama'));
        modal.find('#nik').val($(this).data('nik'));
        modal.find('#jenis_kelamin').val($(this).data('jenis_kelamin'));
        modal.find('#tempat_lahir').val($(this).data('tempat_lahir'));
        modal.find('#tanggal_lahir').val($(this).data('tanggal_lahir'));
        modal.find('#agama').val($(this).data('agama'));
        modal.find('#pekerjaan').val($(this).data('pekerjaan'));
        modal.find('#alamat').val($(this).data('alamat'));
        modal.find('#kewarganegaraan').val($(this).data('kewarganegaraan'));
        modal.find('#status_kawin').val($(this).data('status_kawin'));
        modal.find('#nama_pasangan_dulu').val($(this).data('nama_pasangan_dulu'));

        // Trigger change agar form pasangan ikut update
        modal.find('#status_kawin').trigger('change');
        modal.find('#jenis_kelamin').trigger('change');

        // Optional: Ubah judul & tombol
        modal.find('.modal-title').text('Edit SKP');
        modal.find('button[type=submit]').text('Update');
    });

    // Reset modal saat ditutup
    $('#modalTambahSKP').on('hidden.bs.modal', function () {
        const form = $(this).find('form');
        form.trigger('reset');
        form.attr('action', '/skp/store'); // kembali ke route tambah
        $(this).find('.modal-title').text('Tambah SKP');
        $(this).find('button[type=submit]').text('Simpan');
    });
});
</script>
   @endpush   