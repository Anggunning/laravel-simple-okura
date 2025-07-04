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
                <span>Surat Keterangan Tidak Mampu</span>
            </li>
        </ul>


    </div>
    <div class="title">
        <h4>Data Pengajuan Surat Keterangan Tidak Mampu</h4>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">

                    <div class="mb-3 d-flex justify-content-between align-items-center">
                        <!-- Search di kiri -->
                        {{-- <div id="sampleTable_filter" class="dataTables_filter mb-0">
                            <label class="mb-0">
                                Search:
                                <input type="search" class="form-control form-control-sm" placeholder=""
                                    id="customSearchInput">
                            </label>
                        </div> --}}

                        {{-- Tombol Tambah Pengajuan --}}
                        @if (auth()->check() && in_array(auth()->user()->role, ['Masyarakat', 'Admin']))
                            <a href="#" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#modalTambahPengajuan">
                                <i class="bi bi-plus-circle"></i> Tambah Pengajuan
                            </a>
                        @endif

                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover table-bordered" id="sktmTable">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Nama Pemohon</th>
                                <th>Alamat</th>
                                <th>Tujuan</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($sktm as $item)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y') }}
                                        <br><small
                                            class="text-muted">{{ \Carbon\Carbon::parse($item->created_at)->format('H:i:s') }}</small>
                                    </td>
                                    <td>{{ $item->nama }}</td>
                                    <td>{{ $item->alamat }}</td>
                                    <td>{{ $item->tujuan }}</td>
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
                                                    data-id="{{ $item->id }}" data-nama="{{ $item->nama }}"
                                                    data-tujuan="{{ $item->tujuan }}"
                                                    data-jenis_kelamin="{{ $item->jenis_kelamin }}"
                                                    data-tempat_lahir="{{ $item->tempatLahir }}"
                                                    data-tanggal_lahir="{{ \Carbon\Carbon::parse($item->tanggalLahir)->format('Y-m-d') }}"
                                                    data-agama="{{ $item->agama }}" data-nik="{{ $item->nik }}"
                                                    data-alamat="{{ $item->alamat }}"
                                                    data-pekerjaan="{{ $item->pekerjaan }}"
                                                    data-keterangan="{{ e($item->keterangan) }}"
                                                    data-file_ktp="{{ $item->ktp }}" data-file_kk="{{ $item->kk }}"
                                                    data-file_surat_pernyataan="{{ $item->surat_pernyataan }}"
                                                    data-file_pengantar_rt_rw="{{ $item->pengantar_rt_rw }}"
                                                    onclick="{{ $isDisabled ? 'return false;' : '' }}">
                                                    <i class="bi bi-pencil-square fs-5"
                                                        style="color: {{ $isDisabled ? '#A9A9A9' : '#2E8B57' }}"></i>
                                                </a>
                                                </a>
                                                <form id="formHapus-{{ $item->id }}"
                                                    action="{{ route('sktm.destroy', $item->id) }}" method="POST"
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
                                            <a class="btn btn-white me-2" style="color: #2E8B57;"
                                                href="{{ route('sktm.show', $item->id) }}">
                                                <i class="bi bi-info-circle fs-5"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">Tidak ada data pengajuan SKU.</td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>
            </div>



            {{-- Paginate --}}
            {{-- <div class="d-flex justify-content-center mt-3">
                    {{ $sktm->links() }}
                </div> --}}



            <!-- Modal Tambah Pengajuan -->
            <div class="modal fade" id="modalTambahPengajuan" tabindex="-1" aria-labelledby="modalTambahLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $err)
                                        <li>{{ $err }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form action="{{ route('sktm.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalTambahLabel">Tambah Pengajuan Surat</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>

                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="nama" class="form-label">Nama Pemohon <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="nama" class="form-control" required
                                        placeholder="Masukkan Nama Lengkap"
                                        oninvalid="this.setCustomValidity('Silakan isi nama lengkap')"
                                        oninput="this.setCustomValidity('')">
                                </div>

                                <div class="mb-3">
                                    <label for="tujuan" class="form-label">Tujuan <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="tujuan" class="form-control" required
                                        placeholder="Masukkan Tujuan"
                                        oninvalid="this.setCustomValidity('Silakan isi tujuan pengajuan')"
                                        oninput="this.setCustomValidity('')">
                                </div>
                                 <div class="mb-3">
                                    <label for="pekerjaan" class="form-label">Pekerjaan <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="pekerjaan" class="form-control" required
                                        placeholder="Masukkan Pekerjaan"
                                        oninvalid="this.setCustomValidity('Silakan isi pekerjaan pengajuan')"
                                        oninput="this.setCustomValidity('')">
                                </div>

                                <div class="mb-3">
                                    <label for="jenis_kelamin" class="form-label">Jenis Kelamin <span
                                            class="text-danger">*</span></label>
                                    <select name="jenis_kelamin" class="form-select" required
                                        oninvalid="this.setCustomValidity('Silakan pilih jenis kelamin')"
                                        oninput="this.setCustomValidity('')">
                                        <option value="" disabled selected hidden>Jenis Kelamin</option>
                                        <option value="Laki-laki">Laki-laki</option>
                                        <option value="Perempuan">Perempuan</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="tempatLahir" class="form-label">Tempat Lahir <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="tempatLahir" class="form-control" required
                                        placeholder="Masukkan Tempat Lahir"
                                        oninvalid="this.setCustomValidity('Silakan isi tempat lahir')"
                                        oninput="this.setCustomValidity('')">
                                </div>

                                <div class="mb-3">
                                    <label for="tanggalLahir" class="form-label">Tanggal Lahir <span
                                            class="text-danger">*</span></label>
                                    <input type="date" name="tanggalLahir" class="form-control" required
                                        oninvalid="this.setCustomValidity('Silakan pilih tanggal lahir')"
                                        oninput="this.setCustomValidity('')">
                                </div>

                                <div class="mb-3">
                                    <label for="agama" class="form-label">Agama <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="agama" class="form-control" required
                                        placeholder="Masukkan Agama"
                                        oninvalid="this.setCustomValidity('Silakan isi agama')"
                                        oninput="this.setCustomValidity('')">
                                </div>

                                <div class="mb-3">
                                    <label for="nik" class="form-label">NIK <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="nik" id="nik" class="form-control" required
                                        placeholder="Masukkan NIK" maxlength="16">
                                </div>

                                <div class="mb-3">
                                    <label for="alamat" class="form-label">Alamat <span
                                            class="text-danger">*</span></label>
                                    <textarea name="alamat" class="form-control" rows="2" required placeholder="Masukkan Alamat"
                                        oninvalid="this.setCustomValidity('Silakan isi alamat')" oninput="this.setCustomValidity('')"></textarea>
                                </div>

                                <input type="hidden" name="tanggal" id="tanggal">

                                <div class="mb-3">
                                    <label for="keterangan" class="form-label">Keterangan <span
                                            class="text-danger">*</span></label>
                                    <textarea name="keterangan" class="form-control" rows="3" required placeholder="Masukkan Keterangan"
                                        oninvalid="this.setCustomValidity('Silakan isi keterangan')" oninput="this.setCustomValidity('')"></textarea>
                                </div>

                                <!-- INPUT FILE -->
                                <div class="mb-3">
                                    <label for="pengantar_rt_rw" class="form-label">Surat Pengantar RT/RW <span
                                            class="text-danger">*</span></label>
                                    <input type="file" name="pengantar_rt_rw" id="pengantar_rt_rw"
                                        class="form-control" accept=".jpg,.jpeg,.png,.pdf" required
                                        oninvalid="this.setCustomValidity('Silakan unggah surat pengantar RT/RW')"
                                        oninput="this.setCustomValidity('')">
                                    <small class="form-text text-muted">Tipe File : JPG,PNG,PDF | Ukuran Maksimal :
                                        2MB.</small>
                                </div>

                                <div class="mb-3">
                                    <label for="kk" class="form-label">Kartu Keluarga <span
                                            class="text-danger">*</span></label>
                                    <input type="file" name="kk" id="kk" class="form-control"
                                        accept=".jpg,.jpeg,.png,.pdf" required
                                        oninvalid="this.setCustomValidity('Silakan unggah file KK')"
                                        oninput="this.setCustomValidity('')">
                                    <small class="form-text text-muted">Tipe File : JPG,PNG,PDF | Ukuran Maksimal :
                                        2MB.</small>
                                </div>

                                <div class="mb-3">
                                    <label for="ktp" class="form-label">Kartu Tanda Penduduk <span
                                            class="text-danger">*</span></label>
                                    <input type="file" name="ktp" id="ktp" class="form-control"
                                        accept=".jpg,.jpeg,.png,.pdf" required
                                        oninvalid="this.setCustomValidity('Silakan unggah file KTP')"
                                        oninput="this.setCustomValidity('')">
                                    <small class="form-text text-muted">Tipe File : JPG,PNG,PDF | Ukuran Maksimal :
                                        2MB.</small>
                                </div>

                                <div class="mb-3">
                                    <label for="surat_pernyataan" class="form-label">Surat Pernyataan <span
                                            class="text-danger">*</span></label>
                                    <input type="file" name="surat_pernyataan" id="surat_pernyataan"
                                        class="form-control" accept=".jpg,.jpeg,.png,.pdf" required
                                        oninvalid="this.setCustomValidity('Silakan unggah surat pernyataan')"
                                        oninput="this.setCustomValidity('')">
                                    <small class="form-text text-muted">Tipe File : JPG,PNG,PDF | Ukuran Maksimal :
                                        2MB.</small>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Modal Edit Pengajuan -->
            <div class="modal fade" id="modalEditPengajuan" tabindex="-1" aria-labelledby="modalEditLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <form id="formEditPengajuan" action="" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <input type="hidden" name="id" id="edit-id">

                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalEditLabel">Edit Pengajuan Surat</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>

                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="edit-nama" class="form-label">Nama Pemohon <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="nama" id="edit-nama" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label for="edit-tujuan" class="form-label">Tujuan <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="tujuan" id="edit-tujuan" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label for="edit-pekerjaan" class="form-label">Pekerjaan <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="pekerjaan" id="edit-pekerjaan" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label for="edit-jenis_kelamin" class="form-label">Jenis Kelamin <span
                                            class="text-danger">*</span></label>
                                    <select name="jenis_kelamin" id="edit-jenis_kelamin" class="form-select" required>
                                        <option value="Laki-laki">Laki-laki</option>
                                        <option value="Perempuan">Perempuan</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="edit-tempatLahir" class="form-label">Tempat Lahir <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="tempatLahir" id="edit-tempatLahir" class="form-control"
                                        required>
                                </div>

                                <div class="mb-3">
                                    <label for="edit-tanggalLahir" class="form-label">Tanggal Lahir <span
                                            class="text-danger">*</span></label>
                                    <input type="date" name="tanggalLahir" id="edit-tanggalLahir"
                                        class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label for="edit-agama" class="form-label">Agama <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="agama" id="edit-agama" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label for="edit-nik" class="form-label">NIK <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="nik" id="edit-nik" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label for="edit-alamat" class="form-label">Alamat <span
                                            class="text-danger">*</span></label>
                                    <textarea name="alamat" id="edit-alamat" class="form-control" rows="2" required></textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="edit-keterangan" class="form-label">Keterangan <span
                                            class="text-danger">*</span></label>
                                    <textarea name="keterangan" id="edit-keterangan" class="form-control" rows="3" required></textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="edit-pengantar_rt_rw" class="form-label">Surat Pengantar RT/RW <span
                                            class="text-danger">*</span></label>
                                    <input type="file" name="pengantar_rt_rw" id="edit-pengantar_rt_rw"
                                        class="form-control" accept=".jpg,.jpeg,.png,.pdf">
                                    <small class="form-text text-muted">Tipe File : JPG,PNG,PDF | Ukuran Maksimal :
                                        2MB.</small>
                                    <div id="link_pengantar_rt_rw_lama" class="mt-2"></div>
                                </div>
                                <div class="mb-3">
                                    <label for="edit-kk" class="form-label">Kartu Keluarga <span
                                            class="text-danger">*</span></label>
                                    <div class="mb-2" id="preview-edit-kk"></div>
                                    <input type="file" name="kk" id="edit-kk" class="form-control"
                                        accept=".jpg,.jpeg,.png,.pdf">
                                    <small class="form-text text-muted">Tipe File : JPG,PNG,PDF | Ukuran Maksimal :
                                        2MB.</small>
                                    <div id="link_kk_lama" class="mt-2"></div>
                                </div>
                                <div class="mb-3">
                                    <label for="edit-ktp" class="form-label">Kartu Tanda Penduduk <span
                                            class="text-danger">*</span></label>
                                    <input type="file" name="ktp" id="edit-ktp" class="form-control"
                                        accept=".jpg,.jpeg,.png,.pdf">
                                    <small class="form-text text-muted">Tipe File : JPG,PNG,PDF | Ukuran Maksimal :
                                        2MB.</small>
                                    <div id="link_ktp_lama" class="mt-2"></div>
                                </div>
                                <div class="mb-3">
                                    <label for="edit-surat_pernyataan" class="form-label">Surat Pernyataan <span
                                            class="text-danger">*</span></label>
                                    <input type="file" name="surat_pernyataan" id="edit-surat_pernyataan"
                                        class="form-control" accept=".jpg,.jpeg,.png,.pdf">
                                    <small class="form-text text-muted">Tipe File : JPG,PNG,PDF | Ukuran Maksimal :
                                        2MB.</small>
                                    <div id="link_surat_pernyataan_lama" class="mt-2"></div>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            </div>
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

            <script>
                $(document).ready(function() {
                    $('#modalEditPengajuan').on('show.bs.modal', function(event) {
                        var button = $(event.relatedTarget);

                        $('#edit-id').val(button.data('id'));
                        $('#edit-nama').val(button.data('nama'));
                        $('#edit-tujuan').val(button.data('tujuan'));
                        $('#edit-jenis_kelamin').val(button.data('jenis_kelamin'));
                        $('#edit-tempatLahir').val(button.data('tempat_lahir'));
                        $('#edit-tanggalLahir').val(button.data('tanggal_lahir'));
                        $('#edit-agama').val(button.data('agama'));
                        $('#edit-nik').val(button.data('nik'));
                        $('#edit-alamat').val(button.data('alamat'));
                        $('#edit-keterangan').val(button.data('keterangan'));
                        $('#edit-pekerjaan').val(button.data('pekerjaan'));

                        let newAction = "{{ route('sktm.update', ['id' => 'REPLACE_ID']) }}".replace('REPLACE_ID',
                            button.data('id'));
                        $('#formEditPengajuan').attr('action', newAction);
                    });
                });
            </script>
            <script>
                $('#modalEditPengajuan').on('show.bs.modal', function(event) {
                    const button = $(event.relatedTarget);

                    const fileFields = ['ktp', 'kk', 'pengantar_rt_rw', 'surat_pernyataan'];
                    fileFields.forEach(field => {
                        const fileUrl = button.data('file_' + field);
                        const folder =
                        'sktm'; // Ganti sesuai folder, misalnya 'sktm' atau 'skp' kalau form-nya beda

                        if (fileUrl) {
                            const fileName = fileUrl.split('/').pop();
                            const link = `<a href="/dokumen/${folder}/${fileName}" target="_blank" class="btn btn-sm btn-outline-primary">
                            Lihat File Sebelumnya
                        </a>`;
                            $('#link_' + field + '_lama').html(link);
                        } else {
                            $('#link_' + field + '_lama').html(
                                '<span class="text-muted">Tidak ada file sebelumnya</span>');
                        }
                    });
                });
            </script>

            {{-- <script>
                    $('#sktmTable').DataTable({
                        paging: true,
                        pageLength: 10

                    });
                </script> --}}
            @if ($sktm->count() > 0)
                <script>
                    $(document).ready(function() {
                        $('#sktmTable').DataTable({
                            order: [
                                [0, 'desc']
                            ]
                            // paging: true,
                            // pageLength: 10
                        });
                    });
                </script>
            @endif

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
