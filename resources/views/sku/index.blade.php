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
                <span>Surat Keterangan Usaha</span>
            </li>
        </ul>
    </div>
    <div class="title">
        <h4>Data Pengajuan Surat Keterangan Usaha</h4>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">

                    <div class="mb-3 d-flex justify-content-between align-items-center">
                        {{-- <!-- Search di kiri -->
                        <div id="sampleTable_filter" class="dataTables_filter mb-0">
                            <label class="mb-0">
                                Search:
                                <input type="search" class="form-control form-control-sm" placeholder=""
                                    aria-controls="sampleTable">
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
                    <table class="table table-hover table-bordered" id="skuTable">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Nama Pemohon</th>
                                <th>Jenis Usaha</th>
                                <th>Tempat Usaha</th>
                                <th>Tujuan</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($sku as $item)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y') }}
                                         <br><small class="text-muted">{{ \Carbon\Carbon::parse($item->created_at)->format('H:i:s') }}</small>
                                    </td>
                                    <td>{{ $item->nama }}</td>
                                    <td>{{ $item->jenis_usaha }}</td>
                                    <td>{{ $item->tempat_usaha }}</td>
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
                                                    data-bs-target="{{ $isDisabled ? '' : '#modalEditSku' }}"
                                                    data-id="{{ $item->id }}" data-nama="{{ $item->nama }}"
                                                    data-tujuan="{{ $item->tujuan }}"
                                                    data-jenis_kelamin="{{ $item->jenis_kelamin }}"
                                                    data-tempat_lahir="{{ $item->tempatLahir }}"
                                                    data-tanggal_lahir="{{ \Carbon\Carbon::parse($item->tanggalLahir)->format('Y-m-d') }}"
                                                    data-agama="{{ $item->agama }}" data-nik="{{ $item->nik }}"
                                                    data-alamat="{{ $item->alamat }}"
                                                    data-pekerjaan="{{ $item->pekerjaan }}"
                                                    data-jenis_usaha="{{ $item->jenis_usaha }}"
                                                    data-tempat_usaha="{{ $item->tempat_usaha }}"
                                                    data-kelurahan="{{ $item->kelurahan }}"
                                                    data-kecamatan="{{ $item->kecamatan }}"
                                                    data-kota="{{ $item->kota }}"
                                                    data-keterangan="{{ e($item->keterangan) }}"
                                                    data-file_ktp="{{ $item->ktp }}"
                                                    data-file_kk="{{ $item->kk }}"
                                                    data-file_surat_pernyataan="{{ $item->surat_pernyataan }}"
                                                    data-file_pengantar_rt_rw="{{ $item->pengantar_rt_rw }}"
                                                    data-file_foto_usaha="{{ $item->foto_usaha }}"
                                                    onclick="{{ $isDisabled ? 'return false;' : '' }}">
                                                    <i class="bi bi-pencil-square fs-5"
                                                        style="color: {{ $isDisabled ? '#A9A9A9' : '#2E8B57' }}"></i>
                                                </a>

                                               <form id="formHapus-{{ $item->id }}"
                            action="{{ route('sku.destroy', $item->id) }}" method="POST"
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
                                                href="{{ route('sku.show', $item->id) }}">
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
                {{-- Paginate --}}
                {{-- <div class="d-flex justify-content-center mt-3">
                    {{ $sku->links() }}
                </div> --}}
            </div>
        </div>

        <!-- Modal Tambah Pengajuan -->
        <div class="modal fade" id="modalTambahPengajuan" tabindex="-1" aria-labelledby="modalTambahLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form action="{{ route('sku.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalTambahLabel">Tambah Pengajuan Surat</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama Pemohon<span
                                        class="text-danger">*</span></label>
                                <input type="text" name="nama" class="form-control" required
                                    placeholder="Masukkan Nama Lengkap"
                                    oninvalid="this.setCustomValidity('Silakan isi nama lengkap')"
                                    oninput="this.setCustomValidity('')">
                            </div>


                            <div class="mb-3">
                                <label for="tujuan" class="form-label">Tujuan
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="tujuan" class="form-control" required
                                    placeholder="Masukkan Tujuan" oninvalid="this.setCustomValidity('Silakan isi tujuan')"
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
                                <label for="tempatLahir" class="form-label">Tempat Lahir
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="tempatLahir" class="form-control" required
                                    placeholder="Masukkan Tempat Lahir"
                                    oninvalid="this.setCustomValidity('Silakan isi tempat lahir')"
                                    oninput="this.setCustomValidity('')">
                            </div>

                            <div class="mb-3">
                                <label for="tanggalLahir" class="form-label">Tanggal Lahir
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="date" name="tanggalLahir" class="form-control" required
                                    placeholder="Masukkan Tanggal Lahir"
                                    oninvalid="this.setCustomValidity('Silakan isi tanggal lahir')"
                                    oninput="this.setCustomValidity('')">
                            </div>

                            <div class="mb-3">
                                <label for="agama" class="form-label">Agama
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="agama" class="form-control" required
                                    placeholder="Masukkan Agama" oninvalid="this.setCustomValidity('Silakan isi agama')"
                                    oninput="this.setCustomValidity('')">
                            </div>

                            <div class="mb-3">
                                <label for="nik" class="form-label">NIK
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="nik" class="form-control" required
                                    placeholder="Masukkan NIK" oninvalid="this.setCustomValidity('Silakan isi NIK')"
                                    oninput="this.setCustomValidity('')">
                            </div>

                            <div class="mb-3">
                                <label for="alamat" class="form-label">Alamat
                                    <span class="text-danger">*</span>
                                </label>
                                <textarea name="alamat" class="form-control" rows="2" required placeholder="Masukkan Alamat"
                                    oninvalid="this.setCustomValidity('Silakan isi alamat')" oninput="this.setCustomValidity('')"></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="pekerjaan" class="form-label">Pekerjaan
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="pekerjaan" class="form-control" required
                                    placeholder="Masukkan Pekerjaan"
                                    oninvalid="this.setCustomValidity('Silakan isi pekerjaan')"
                                    oninput="this.setCustomValidity('')">
                            </div>

                            <div class="mb-3">
                                <label for="jenis_usaha" class="form-label">Jenis Usaha
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="jenis_usaha" class="form-control" required
                                    placeholder="Masukkan Jenis Usaha"
                                    oninvalid="this.setCustomValidity('Silakan isi jenis usaha')"
                                    oninput="this.setCustomValidity('')">
                            </div>

                            <div class="mb-3">
                                <label for="tempat_usaha" class="form-label">Tempat Usaha
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="tempat_usaha" class="form-control" required
                                    placeholder="Masukkan Tempat Usaha"
                                    oninvalid="this.setCustomValidity('Silakan isi tempat usaha')"
                                    oninput="this.setCustomValidity('')">
                            </div>

                            <div class="mb-3">
                                <label for="kelurahan" class="form-label">Kelurahan
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="kelurahan" class="form-control" required
                                    placeholder="Masukkan Kelurahan"
                                    oninvalid="this.setCustomValidity('Silakan isi kelurahan')"
                                    oninput="this.setCustomValidity('')">
                            </div>

                            <div class="mb-3">
                                <label for="kecamatan" class="form-label">Kecamatan
                                    <span class="text-danger">*</span></label>
                                </label>
                                <input type="text" name="kecamatan" class="form-control" required
                                    placeholder="Masukkan Kecamatan"
                                    oninvalid="this.setCustomValidity('Silakan isi kecamatan')"
                                    oninput="this.setCustomValidity('')">
                            </div>

                            <div class="mb-3">
                                <label for="kota" class="form-label">Kota
                                    <span class="text-danger">*</span></label>
                                </label>
                                <input type="text" name="kota" class="form-control" required
                                    placeholder="Masukkan Kota" oninvalid="this.setCustomValidity('Silakan isi kota')"
                                    oninput="this.setCustomValidity('')">
                            </div>


                            <div class="mb-3">
                                <label for="keterangan" class="form-label">Keterangan<span
                                        class="text-danger">*</span></label></label>
                                <textarea name="keterangan" class="form-control" rows="3" required placeholder="Masukkan Keterangan"
                                    oninvalid="this.setCustomValidity('Silakan isi keterangan')" oninput="this.setCustomValidity('')"></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="foto_usaha" class="form-label">Foto Usaha <span
                                        class="text-danger">*</span></label></label>
                                <input type="file" name="foto_usaha" class="form-control" accept=".jpg,.jpeg,.png"
                                    required oninvalid="this.setCustomValidity('Silakan unggah foto usaha')"
                                    oninput="this.setCustomValidity('')">
                                <small class="form-text text-muted">Tipe File : JPG,PNG,PDF | Ukuran Maksimal :
                                    2MB.</small>
                            </div>
                            <div class="mb-3">
                                <label for="pengantar_rt_rw" class="form-label">Surat Pengantar RT/RW <span
                                        class="text-danger">*</span></label>
                                <input type="file" name="pengantar_rt_rw" id="pengantar_rt_rw" class="form-control"
                                    accept=".jpg,.jpeg,.png,.pdf" required
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
                                <input type="file" name="surat_pernyataan" id="surat_pernyataan" class="form-control"
                                    accept=".jpg,.jpeg,.png,.pdf" required
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


        <!-- Modal Edit SKU -->
        <div class="modal fade" id="modalEditSku" tabindex="-1" aria-labelledby="modalEditSkuLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form id="formEditSku" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Pengajuan SKU</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" id="edit_id">

                            <div class="mb-3">
                                <label for="edit_nama" class="form-label">Nama Pemohon
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="nama" id="edit_nama" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="edit_tujuan" class="form-label">Tujuan
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="tujuan" id="edit_tujuan" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="edit_jenis_kelamin" class="form-label">Jenis Kelamin
                                    <span class="text-danger">*</span>
                                </label>
                                <select name="jenis_kelamin" id="edit_jenis_kelamin" class="form-select" required>
                                    <option value="Laki-laki">Laki-laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="edit_tempatLahir" class="form-label">Tempat Lahir
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="tempatLahir" id="edit_tempatLahir" class="form-control"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label for="edit_tanggalLahir" class="form-label">Tanggal Lahir
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="date" name="tanggalLahir" id="edit_tanggalLahir" class="form-control"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label for="edit_agama" class="form-label">Agama
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="agama" id="edit_agama" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="edit_nik" class="form-label">NIK
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="nik" id="edit_nik" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="edit_alamat" class="form-label">Alamat
                                    <span class="text-danger">*</span>
                                </label>
                                <textarea name="alamat" id="edit_alamat" class="form-control" rows="2" required></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="edit_pekerjaan" class="form-label">Pekerjaan
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="pekerjaan" id="edit_pekerjaan" class="form-control"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label for="edit_jenis_usaha" class="form-label">Jenis Usaha
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="jenis_usaha" id="edit_jenis_usaha" class="form-control"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label for="edit_tempat_usaha" class="form-label">Tempat Usaha
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="tempat_usaha" id="edit_tempat_usaha" class="form-control"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label for="edit_kelurahan" class="form-label">Kelurahan
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="kelurahan" id="edit_kelurahan" class="form-control"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label for="edit_kecamatan" class="form-label">Kecamatan
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="kecamatan" id="edit_kecamatan" class="form-control"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label for="edit_kota" class="form-label">Kota
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="kota" id="edit_kota" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="edit_keterangan" class="form-label">Keterangan
                                    <span class="text-danger">*</span>
                                </label>
                                <textarea name="keterangan" id="edit_keterangan" class="form-control" rows="3" required></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="edit_foto_usaha" class="form-label">Foto Usaha
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="file" name="foto_usaha" id="edit_foto_usaha" class="form-control"
                                    accept=".jpg,.jpeg,.png">
                                <small class="form-text text-muted">Tipe File : JPG,PNG,PDF | Ukuran Maksimal :
                                    2MB.</small>
                                    <div id="link_foto_usaha_lama" class="mt-2"></div>
                            </div>

                            <div class="mb-3">
                                <label for="edit_pengantar_rt_rw" class="form-label">Surat Pengantar RT/RW
                                    <span class="text-danger">*</span></label>
                                <input type="file" name="pengantar_rt_rw" id="edit_pengantar_rt_rw"
                                    class="form-control" accept=".jpg,.jpeg,.png,.pdf">
                                <small class="form-text text-muted">Tipe File : JPG,PNG,PDF | Ukuran Maksimal :
                                    2MB.</small>
                                    <div id="link_pengantar_rt_rw_lama" class="mt-2"></div>
                            </div>

                            <div class="mb-3">
                                <label for="edit_kk" class="form-label">Kartu Keluarga
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="file" name="kk" id="edit_kk" class="form-control"
                                    accept=".jpg,.jpeg,.png,.pdf">
                                <small class="form-text text-muted">Tipe File : JPG,PNG,PDF | Ukuran Maksimal :
                                    2MB.</small>
                                    <div id="link_kk_lama" class="mt-2"></div>
                            </div>

                            <div class="mb-3">
                                <label for="edit_ktp" class="form-label">Kartu Tanda Penduduk
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="file" name="ktp" id="edit_ktp" class="form-control"
                                    accept=".jpg,.jpeg,.png,.pdf">
                                <small class="form-text text-muted">Tipe File : JPG,PNG,PDF | Ukuran Maksimal :
                                    2MB.</small>
                                    <div id="link_ktp_lama" class="mt-2"></div>
                            </div>

                            <div class="mb-3">
                                <label for="edit_surat_pernyataan" class="form-label">Surat Pernyataan
                                    <span class="text-danger">*</span></label>
                                <input type="file" name="surat_pernyataan" id="edit_surat_pernyataan"
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
                    </form>
                </div>
            </div>
        </div>
    @endsection


    @push('scripts')
        <!-- Pastikan urutan script -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

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
            document.addEventListener('DOMContentLoaded', function() {
                var modal = document.getElementById('modalEditSku');

                if (modal) {
                    modal.addEventListener('show.bs.modal', function(event) {
                        var button = event.relatedTarget;

                        // Ambil data dari atribut tombol edit
                        var id = button.getAttribute('data-id');
                        var nama = button.getAttribute('data-nama');
                        var tujuan = button.getAttribute('data-tujuan');
                        var jenisKelamin = button.getAttribute('data-jenis_kelamin');
                        var tempatLahir = button.getAttribute('data-tempat_lahir');
                        var tanggalLahir = button.getAttribute('data-tanggal_lahir');
                        var agama = button.getAttribute('data-agama');
                        var nik = button.getAttribute('data-nik');
                        var alamat = button.getAttribute('data-alamat');
                        var pekerjaan = button.getAttribute('data-pekerjaan');
                        var jenisUsaha = button.getAttribute('data-jenis_usaha');
                        var tempatUsaha = button.getAttribute('data-tempat_usaha');
                        var kelurahan = button.getAttribute('data-kelurahan');
                        var kecamatan = button.getAttribute('data-kecamatan');
                        var kota = button.getAttribute('data-kota');
                        var keterangan = button.getAttribute('data-keterangan');

                        // Set nilai ke form modal
                        modal.querySelector('#edit_id').value = id;
                        modal.querySelector('#edit_nama').value = nama;
                        modal.querySelector('#edit_tujuan').value = tujuan;
                        modal.querySelector('#edit_jenis_kelamin').value = jenisKelamin;
                        modal.querySelector('#edit_tempatLahir').value = tempatLahir;
                        modal.querySelector('#edit_tanggalLahir').value = tanggalLahir;
                        modal.querySelector('#edit_agama').value = agama;
                        modal.querySelector('#edit_nik').value = nik;
                        modal.querySelector('#edit_alamat').value = alamat;
                        modal.querySelector('#edit_pekerjaan').value = pekerjaan;
                        modal.querySelector('#edit_jenis_usaha').value = jenisUsaha;
                        modal.querySelector('#edit_tempat_usaha').value = tempatUsaha;
                        modal.querySelector('#edit_kelurahan').value = kelurahan;
                        modal.querySelector('#edit_kecamatan').value = kecamatan;
                        modal.querySelector('#edit_kota').value = kota;
                        modal.querySelector('#edit_keterangan').value = keterangan;

                        // Set action form dengan ID dinamis
                        var form = modal.querySelector('#formEditSku');
                        form.action = "{{ route('sku.update', ['id' => 'REPLACE_ID']) }}".replace('REPLACE_ID',
                            id);
                    });
                }
            });
        </script>
        <script>
            $('#modalEditSku').on('show.bs.modal', function (event) {
    const button = $(event.relatedTarget);

    const fileFields = ['ktp', 'kk', 'foto_usaha', 'pengantar_rt_rw', 'surat_pernyataan'];
    fileFields.forEach(field => {
        const fileUrl = button.data('file_' + field);
        const folder = 'sku'; // Ganti sesuai folder, misalnya 'sktm' atau 'skp' kalau form-nya beda

        if (fileUrl) {
            const fileName = fileUrl.split('/').pop();
            const link = `<a href="/dokumen/${folder}/${fileName}" target="_blank" class="btn btn-sm btn-outline-primary">
                            Lihat File Sebelumnya
                        </a>`;
            $('#link_' + field + '_lama').html(link);
        } else {
            $('#link_' + field + '_lama').html('<span class="text-muted">Tidak ada file sebelumnya</span>');
        }
    });
});

        </script>

        </script>

        @if ($sku->count() > 0)
            <script>
                $(document).ready(function() {
                    $('#skuTable').DataTable({
                        order: [[0, 'desc']]
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
