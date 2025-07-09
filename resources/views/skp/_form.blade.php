<div id="{{ $prefix }}sectionDataPemohon">
    {{-- Form Pemohon --}}
    <div class="row">
        <div class="mb-3 col-md-6">
            <label for="nama" class="form-label">Nama
                <span class="text-danger">*</span>
            </label>
            <input type="text" name="nama" id="nama" class="form-control" required
                placeholder="Masukkan nama lengkap" oninvalid="this.setCustomValidity('Silakan isi nama lengkap')"
                oninput="this.setCustomValidity('')">
        </div>
        <div class="mb-3 col-md-6">
                            <label for="nik" class="form-label">NIK <span class="text-danger">*</span></label>
                            <input type="text" pattern="\d{16}" inputmode="numeric" name="nik" id="nik"
                                class="form-control" required onblur="cekPanjangNIK(this)"
                                oninvalid="this.setCustomValidity('Silakan isi NIK Anda')"
                                oninput="this.setCustomValidity('')" placeholder="Masukkan NIK" maxlength="16">
                        </div>
    </div>

    <div class="row">
        <div class="mb-3 col-md-6">
            <label for="jenis_kelamin" class="form-label">Jenis Kelamin
                <span class="text-danger">*</span>
            </label>
            <select name="jenis_kelamin" id="jenis_kelamin" class="form-select" required
                oninvalid="this.setCustomValidity('Silakan isi jenis kelamin')" oninput="this.setCustomValidity('')">
                <option value="" disabled selected hidden>Jenis Kelamin</option>
                <option value="Laki-laki">Laki-laki</option>
                <option value="Perempuan">Perempuan</option>
            </select>

        </div>
        <div class="mb-3 col-md-6">
            <label for="tempat_lahir" class="form-label">Tempat Lahir
                <span class="text-danger">*</span>
            </label>
            <input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control" required
                oninvalid="this.setCustomValidity('Silakan isi tempat lahir')" oninput="this.setCustomValidity('')"
                placeholder="Masukkan tempat lahir">
        </div>
    </div>

    <div class="row">
        <div class="mb-3 col-md-6">
            <label for="tanggal_lahir" class="form-label">Tanggal Lahir
                <span class="text-danger">*</span>
            </label>
            <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control" required
                oninvalid="this.setCustomValidity('Silakan isi tanggal lahir')" oninput="this.setCustomValidity('')">
        </div>
        <div class="mb-3 col-md-6">
            <label for="agama" class="form-label">Agama
                <span class="text-danger">*</span></label>
            <select name="agama" class="form-select" required
                oninvalid="this.setCustomValidity('Silakan pilih agama')" oninput="this.setCustomValidity('')">
                <option value="" disabled selected hidden>Agama</option>
                <option value="Islam">Islam</option>
                <option value="Kristen Protestan">Kristen Protestan</option>
                <option value="Katolik">Katolik</option>
                <option value="Hindu">Hindu</option>
                <option value="Buddha">Buddha</option>
                <option value="Konghuchu">Konghuchu</option>
            </select>
        </div>
    </div>

    <div class="row">
        <div class="mb-3 col-md-6">
            <label for="pekerjaan" class="form-label">Pekerjaan
                <span class="text-danger">*</span>
            </label>
            <input type="text" name="pekerjaan" id="pekerjaan" class="form-control" required
                oninvalid="this.setCustomValidity('Silakan isi pekerjaan')" oninput="this.setCustomValidity('')"
                placeholder="Masukkan pekerjaan">
        </div>
        <div class="mb-3 col-md-6" id="formNamaPasangan" style="display: none;">
            <label for="nama_pasangan_dulu" class="form-label">Nama Pasangan Dulu
                <span class="text-danger">*</span>
            </label>
            <input type="text" name="nama_pasangan_dulu" id="nama_pasangan_dulu" class="form-control"
                oninvalid="this.setCustomValidity('Silakan isi nama pasangan dulu')"
                oninput="this.setCustomValidity('')" placeholder="Masukkan nama pasangan">
        </div>
        <div class="mb-3 col-md-6">
            <label for="status_kawin" class="form-label">Status Perkawinan
                <span class="text-danger">*</span>
            </label>
            <select name="status_kawin" id="status_kawin" class="form-select" required
                oninvalid="this.setCustomValidity('Silakan isi status kawin')" oninput="this.setCustomValidity('')">
                <option value="">Pilih Status</option>
                <option value="Belum Menikah">Belum Menikah</option>
                <option value="Cerai Hidup">Cerai Hidup</option>
                <option value="Cerai Mati">Cerai Mati</option>
            </select>
        </div>


        <div class="mb-3 col-md-6" id="formJenisKelaminPasanganDulu" style="display: none;">
            <label for="jenis_kelamin_psgn_dulu" class="form-label">Jenis Kelamin Pasangan
                <span class="text-danger">*</span>
            </label>
            <input type="text" id="jenis_kelamin_psgn_dulu" class="form-control" readonly>
        </div>

    </div>

    <div class="row">
        <div class="mb-3 col-md-6">
            <label for="alamat" class="form-label">Alamat
                <span class="text-danger">*</span>
            </label>
            <input type="text" name="alamat" id="alamat" class="form-control" required
                oninvalid="this.setCustomValidity('Silakan isi alamat')"
                oninput="this.setCustomValidity('')"placeholder="Masukkan alamat tempat tinggal">
        </div>

        <div class="mb-3 col-md-6">
            <label for="kewarganegaraan" class="form-label">Kewarganegaraan
                <span class="text-danger">*</span>
            </label>
            <input type="text" name="kewarganegaraan" id="kewarganegaraan" class="form-control" required
                oninvalid="this.setCustomValidity('Silakan isi kewarganegaraan')" oninput="this.setCustomValidity('')"
                placeholder="Contoh: Indonesia">
        </div>
    </div>
    <div class="row">
        <div class="mb-3 col-md-6">
            <label for="rt" class="form-label">RT <span class="text-danger">*</span></label>
            <input type="text" name="rt" id="rt" class="form-control" required maxlength="3"
                pattern="^\d{3}$" placeholder="Contoh: 001"
                oninvalid="this.setCustomValidity('Isi 3 digit angka, contoh: 001')"
                oninput="this.setCustomValidity('')">
        </div>
        <div class="mb-3 col-md-6">
            <label for="rw" class="form-label">RW <span class="text-danger">*</span></label>
            <input type="text" name="rw" id="rw" class="form-control" required maxlength="3"
                pattern="^\d{3}$" placeholder="Contoh: 002"
                oninvalid="this.setCustomValidity('Isi 3 digit angka, contoh: 002')"
                oninput="this.setCustomValidity('')">
        </div>
    </div>


    <div class="row">
        <div class="mb-3 col-12">
            <label for="keterangan" class="form-label">Keterangan </label>
            <textarea name="keterangan" id="keterangan" class="form-control" rows="2"
                placeholder="Masukkan Keterangan (optional)"></textarea>
        </div>
    </div>


    {{-- Upload File --}}
    <div class="row">

        {{-- KTP --}}
        <div class="mb-3 col-md-6">
            <label for="ktp" class="form-label">KTP <span class="text-danger">*</span></label>
            <input type="file" name="ktp" id="ktp" class="form-control validate-file"
                accept=".jpg,.jpeg,.png,.pdf" @if (!request()->isMethod('put') && $prefix == '') required @endif>
            <small class="form-text text-muted">Tipe File : JPG, PNG, PDF | Ukuran Maksimal: 2MB.</small>
            <div id="link_ktp_lama" class="mt-2"></div>
        </div>

        {{-- KK --}}
        <div class="mb-3 col-md-6">
            <label for="kk" class="form-label">Kartu Keluarga <span class="text-danger">*</span></label>
            <input type="file" name="kk" id="kk" class="form-control validate-file"
                accept=".jpg,.jpeg,.png,.pdf" @if (!request()->isMethod('put') && $prefix == '') required @endif>
            <small class="form-text text-muted">Tipe File : JPG, PNG, PDF | Ukuran Maksimal: 2MB.</small>
            <div id="link_kk_lama" class="mt-2"></div>
        </div>

        {{-- Surat Pengantar RT/RW --}}
        <div class="mb-3 col-md-6">
            <label for="pengantar_rt_rw" class="form-label">Surat Pengantar RT/RW <span
                    class="text-danger">*</span></label>
            <input type="file" name="pengantar_rt_rw" id="pengantar_rt_rw" class="form-control validate-file"
                accept=".jpg,.jpeg,.png,.pdf" @if (!request()->isMethod('put') && $prefix == '') required @endif>
            <small class="form-text text-muted">Tipe File : JPG, PNG, PDF | Ukuran Maksimal: 2MB.</small>
            <div id="link_pengantar_rt_rw_lama" class="mt-2"></div>
        </div>

        {{-- Foto --}}
        <div class="mb-3 col-md-6">
            <label for="foto" class="form-label">Pas Foto 3x4 <span class="text-danger">*</span></label>
            <input type="file" name="foto" id="foto" class="form-control validate-file"
                accept=".jpg,.jpeg,.png,.pdf" @if (!request()->isMethod('put') && $prefix == '') required @endif>
            <small class="form-text text-muted">Tipe File : JPG, PNG, PDF | Ukuran Maksimal: 2MB.</small>
            <div id="link_foto_lama" class="mt-2"></div>
        </div>

    </div>

</div>

<div id="{{ $prefix }}sectionDataOrangtua">


    {{-- Ayah --}}

    <div class="row">
        <div class="mb-3 col-md-6">
            <label for="nama_ayah" class="form-label">Nama Ayah
                <span class="text-danger">*</span>
            </label>
            <input type="text" name="nama_ayah" id="nama_ayah" class="form-control" required
                oninvalid="this.setCustomValidity('Silakan isi nama ayah')"
                oninput="this.setCustomValidity('')"placeholder="Masukkan nama ayah">
        </div>

        <div class="mb-3 col-md-6">
            <label for="nik_ayah" class="form-label">NIK Ayah<span class="text-danger">*</span></label>
            <input type="text" pattern="\d{16}" inputmode="numeric" name="nik_ayah" id="nik_ayah"
                class="form-control" required onblur="cekPanjangNIK(this)"
                oninvalid="this.setCustomValidity('Silakan isi NIK Anda')" oninput="this.setCustomValidity('')"
                placeholder="Masukkan NIK Ayah" maxlength="16">
        </div>
    </div>

    <div class="row">
        <div class="mb-3 col-md-6">
            <label for="tempat_lahir_ayah" class="form-label">Tempat Lahir Ayah
                <span class="text-danger">*</span>
            </label>
            <input type="text" name="tempat_lahir_ayah" id="tempat_lahir_ayah" class="form-control"
                oninvalid="this.setCustomValidity('Silakan isi tempat lahir ayah')"
                oninput="this.setCustomValidity('')" placeholder="Masukkan tempat lahir ayah">
        </div>
        <div class="mb-3 col-md-6">
            <label for="tanggal_lahir_ayah" class="form-label">Tanggal Lahir Ayah
                <span class="text-danger">*</span>
            </label>
            <input type="date" name="tanggal_lahir_ayah" id="tanggal_lahir_ayah" class="form-control"
                placeholder="Masukkan tanggal lahir ayah"
                oninvalid="this.setCustomValidity('Silakan isi tanggal lahir ayah')"
                oninput="this.setCustomValidity('')">
        </div>
    </div>

    <div class="row">
        <div class="mb-3 col-md-6">
            <label for="agama_ayah" class="form-label">Agama Ayah
                <span class="text-danger">*</span>
            </label>
            <input type="text" name="agama_ayah" id="agama_ayah" class="form-control" required
                oninvalid="this.setCustomValidity('Silakan isi agama ayah')"
                oninput="this.setCustomValidity('')"placeholder="Masukkan agama ayah">
        </div>
        <div class="mb-3 col-md-6">
            <label for="kewarganegaraan_ayah" class="form-label">Kewarganegaraan Ayah
                <span class="text-danger">*</span>
            </label>
            <input type="text" name="kewarganegaraan_ayah" id="kewarganegaraan_ayah" class="form-control"
                required oninvalid="this.setCustomValidity('Silakan isi kewarganegaraan ayah')"
                oninput="this.setCustomValidity('')" placeholder="Masukkan kewarganegaraan ayah">
        </div>
    </div>

    <div class="row">
        <div class="mb-3 col-md-6">
            <label for="pekerjaan_ayah" class="form-label">Pekerjaan Ayah
                <span class="text-danger">*</span>
            </label>
            <input type="text" name="pekerjaan_ayah" id="pekerjaan_ayah" class="form-control" required
                oninvalid="this.setCustomValidity('Silakan isi pekerjaan ayah')" oninput="this.setCustomValidity('')"
                placeholder="Masukkan pekerjaan ayah">
        </div>
        <div class="mb-3 col-md-6">
            <label for="alamat_ayah" class="form-label">Alamat Ayah
                <span class="text-danger">*</span>
            </label>
            <input type="text" name="alamat_ayah" id="alamat_ayah" class="form-control" required
                oninvalid="this.setCustomValidity('Silakan isi alamat ayah')" oninput="this.setCustomValidity('')"
                placeholder="Masukkan alamat ayah">
        </div>
    </div>
    <div class="row">
        <div class="mb-3 col-md-6">
            <label for="rt_ayah" class="form-label">RT Ayah <span class="text-danger">*</span></label>
            <input type="text" name="rt_ayah" id="rt_ayah" class="form-control" required maxlength="3"
                pattern="^\d{3}$" placeholder="Contoh: 001"
                oninvalid="this.setCustomValidity('Isi 3 digit angka, contoh: 001')"
                oninput="this.setCustomValidity('')">
        </div>
        <div class="mb-3 col-md-6">
            <label for="rw_ayah" class="form-label">RW Ayah <span class="text-danger">*</span></label>
            <input type="text" name="rw_ayah" id="rw_ayah" class="form-control" required maxlength="3"
                pattern="^\d{3}$" placeholder="Contoh: 002"
                oninvalid="this.setCustomValidity('Isi 3 digit angka, contoh: 002')"
                oninput="this.setCustomValidity('')">
        </div>
    </div>

    {{-- Ibu --}}
    <br>
    <div class="row">
        <div class="mb-3 col-md-6">
            <label for="nama_ibu" class="form-label">Nama Ibu
                <span class="text-danger">*</span>
            </label>
            <input type="text" name="nama_ibu" id="nama_ibu" class="form-control" required
                oninvalid="this.setCustomValidity('Silakan isi alamat ibu')" oninput="this.setCustomValidity('')"
                placeholder="Masukkan nama ibu">
        </div>
        <div class="mb-3 col-md-6">
            <label for="nik_ibu" class="form-label">NIK Ibu<span class="text-danger">*</span></label>
            <input type="text" pattern="\d{16}" inputmode="numeric" name="nik_ibu" id="nik_ibu"
                class="form-control" required onblur="cekPanjangNIK(this)"
                oninvalid="this.setCustomValidity('Silakan isi NIK Ibu')" oninput="this.setCustomValidity('')"
                placeholder="Masukkan NIK Ibu" maxlength="16">
        </div>
    </div>

    <div class="row">
        <div class="mb-3 col-md-6">
            <label for="tempat_lahir_ibu" class="form-label">Tempat Lahir Ibu<span
                    class="text-danger">*</span></label>
            <input type="text" name="tempat_lahir_ibu" id="tempat_lahir_ibu" class="form-control"
                oninvalid="this.setCustomValidity('Silakan isi tempat lahir ibu')"
                oninput="this.setCustomValidity('')" placeholder="Masukkan tempat lahir ibu">
        </div>
        <div class="mb-3 col-md-6">
            <label for="tanggal_lahir_ibu" class="form-label">Tanggal Lahir Ibu<span
                    class="text-danger">*</span></label>
            <input type="date" name="tanggal_lahir_ibu" id="tanggal_lahir_ibu" class="form-control"
                oninvalid="this.setCustomValidity('Silakan isi tanggal lahir ibu')"
                oninput="this.setCustomValidity('')" placeholder="Masukkan tanggal lahir ibu">
        </div>
    </div>

    <div class="row">
        <div class="mb-3 col-md-6">
            <label for="agama_ibu" class="form-label">Agama Ibu<span class="text-danger">*</span></label>
            <input type="text" name="agama_ibu" id="agama_ibu" class="form-control" required
                oninvalid="this.setCustomValidity('Silakan isi agama ibu')"
                oninput="this.setCustomValidity('')"placeholder="Masukkan agama ibu">
        </div>
        <div class="mb-3 col-md-6">
            <label for="kewarganegaraan_ibu" class="form-label">Kewarganegaraan Ibu<span
                    class="text-danger">*</span></label>
            <input type="text" name="kewarganegaraan_ibu" id="kewarganegaraan_ibu" class="form-control" required
                oninvalid="this.setCustomValidity('Silakan isi kewarganegaraan ibu')"
                oninput="this.setCustomValidity('')" placeholder="Masukkan kewarganegaraan ibu">
        </div>
    </div>

    <div class="row">
        <div class="mb-3 col-md-6">
            <label for="pekerjaan_ibu" class="form-label">Pekerjaan Ibu<span class="text-danger">*</span></label>
            <input type="text" name="pekerjaan_ibu" id="pekerjaan_ibu" class="form-control" required
                oninvalid="this.setCustomValidity('Silakan isi pekerjaan ibu')"
                oninput="this.setCustomValidity('')"placeholder="Masukkan pekerjaan ibu">
        </div>
        <div class="mb-3 col-md-6">
            <label for="alamat_ibu" class="form-label">Alamat Ibu<span class="text-danger">*</span></label>
            <input type="text" name="alamat_ibu" id="alamat_ibu" class="form-control" required
                oninvalid="this.setCustomValidity('Silakan isi alamat ibu')" oninput="this.setCustomValidity('')"
                placeholder="Masukkan alamat ibu">
        </div>
    </div>
    <div class="row">
        <div class="mb-3 col-md-6">
            <label for="rt_ibu" class="form-label">RT Ibu <span class="text-danger">*</span></label>
            <input type="text" name="rt_ibu" id="rt_ibu" class="form-control" required maxlength="3"
                pattern="^\d{3}$" placeholder="Contoh: 001"
                oninvalid="this.setCustomValidity('Isi 3 digit angka, contoh: 001')"
                oninput="this.setCustomValidity('')">
        </div>
        <div class="mb-3 col-md-6">
            <label for="rw_ibu" class="form-label">RW Ibu<span class="text-danger">*</span></label>
            <input type="text" name="rw_ibu" id="rw_ibu" class="form-control" required maxlength="3"
                pattern="^\d{3}$" placeholder="Contoh: 002"
                oninvalid="this.setCustomValidity('Isi 3 digit angka, contoh: 002')"
                oninput="this.setCustomValidity('')">
        </div>
    </div>
</div>
<br>
{{-- Tombol Navigasi --}}
<div class="row ">
    <div class="col-7  text-end">
        <button type="button" class="btn btn-primary" id="{{ $prefix }}btnNextOrtu">Selanjutnya
            &raquo;</button>
    </div>
</div>
{{-- <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
    <button type="submit" class="btn btn-primary">Simpan</button>
</div> --}}


@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function setupPasanganForm(prefix = '') {
                const statusKawin = document.getElementById(prefix + 'status_kawin');
                const jenisKelamin = document.getElementById(prefix + 'jenis_kelamin');
                const formNamaPasangan = document.getElementById('formNamaPasangan');
                const formJKPasangan = document.getElementById('formJenisKelaminPasanganDulu');
                const inputJKPasangan = document.getElementById(prefix + 'jenis_kelamin_psgn_dulu');
                const inputNamaPasangan = document.getElementById(prefix + 'nama_pasangan_dulu');

                function updateForm() {
                    const status = statusKawin?.value;
                    const jk = jenisKelamin?.value;

                    if (status === 'Cerai Hidup' || status === 'Cerai Mati') {
                        formNamaPasangan.style.display = 'block';
                        formJKPasangan.style.display = 'block';
                        inputJKPasangan.value = jk === 'Laki-laki' ? 'Perempuan' : jk === 'Perempuan' ?
                            'Laki-laki' : '';
                    } else {
                        formNamaPasangan.style.display = 'none';
                        formJKPasangan.style.display = 'none';
                        inputJKPasangan.value = '';
                        inputNamaPasangan.value = '';
                    }
                }

                if (statusKawin && jenisKelamin) {
                    statusKawin.addEventListener('change', updateForm);
                    jenisKelamin.addEventListener('change', updateForm);
                }

                // Jalankan saat awal tampil
                updateForm();
            }

            // Saat modal Tambah tampil
            const modalTambah = document.getElementById('modalTambahSKP');
            modalTambah?.addEventListener('show.bs.modal', function() {
                setupPasanganForm('');
            });

            // Saat modal Edit tampil
            const modalEdit = document.getElementById('modalEditSKP');
            modalEdit?.addEventListener('show.bs.modal', function() {
                setupPasanganForm('edit_');
            });
        });
    </script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const prefix = "{{ $prefix }}"; // Akan jadi '' atau 'edit_'
            const btnNext = document.getElementById(prefix + 'btnNextOrtu');
            const sectionPemohon = document.getElementById(prefix + 'sectionDataPemohon');
            const sectionOrangtua = document.getElementById(prefix + 'sectionDataOrangtua');
            const modal = document.getElementById(prefix === 'edit_' ? 'modalEditSKP' : 'modalTambahSKP');
            const form = modal.querySelector('form');
            let onOrangtua = false;

            if (!btnNext || !sectionPemohon || !sectionOrangtua || !modal) return;

            btnNext.addEventListener('click', function() {
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

            form.addEventListener('submit', function(e) {
                if (!onOrangtua) {
                    e.preventDefault();
                    alert('Silakan isi data orang tua terlebih dahulu.');
                }
            });

            modal.addEventListener('show.bs.modal', function() {
                sectionPemohon.style.display = 'block';
                sectionOrangtua.style.display = 'none';
                btnNext.innerHTML = 'Selanjutnya &raquo;';
                onOrangtua = false;
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('formPengajuanSKP');

            form.addEventListener('submit', function(e) {
                // Cegah hanya jika bukan hasil konfirmasi SweetAlert
                if (!form.dataset.konfirmasi) {
                    e.preventDefault();

                    Swal.fire({
                        title: 'Yakin mau menyimpan?',
                        text: 'Pastikan semua data sudah benar.',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: 'Simpan',
                        cancelButtonText: 'Batal',
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#6c757d',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.dataset.konfirmasi =
                            "true"; // Flag agar tidak masuk ke SweetAlert lagi
                            form.requestSubmit(); // ✅ Gunakan ini, bukan form.submit()
                        }
                    });
                } else {
                    delete form.dataset.konfirmasi; // Reset setelah konfirmasi
                }
            });
        });
    </script>
@endpush
