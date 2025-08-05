<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Pengantar Perkawinan</title>
    <style>
     @page {
            size: 21.0cm 33.0cm;
            margin-top: 0.2cm;
        margin-right: 1cm;
        margin-left: 1cm;
        margin-bottom: 1cm;
        
        }
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
            margin: 1cm;
            margin-top: 0.2cm;
            line-height: 1.1;
        }

        .judul, .subjudul, .nomor {
            text-align: center;
        }

        .judul {
            font-weight: bold;
            text-decoration: underline;
            margin-bottom: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
             text-align: justify; text-indent: 3rem;
        }

        td {
            vertical-align: top;
            padding: 2px 4px;
        }

        .label {
            width: 50%;
        }
.mt-2 { margin-top: 0.3rem; margin-bottom: 0.3rem; text-align: justify; }

        .right {
            text-align: right;
        }

        .ttd {
            margin-top: 50px;
            width: 100%;
        }

        .ttd td {
            text-align: center;
        }

        .bold {
            font-weight: bold;
        }

        .underline {
            text-decoration: underline;
        }
        .td { vertical-align: top; padding: 4px; }
        .pojok-kanan {
    position: absolute;
    top: 0.5cm;
    right: 2cm;
    font-size: 12pt;
    font-weight: bold;
}
.text-center {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="pojok-kanan">Mode N 1</div> <br>
    <p >Lampiran I</p>
    <p>Keputusan Dirjen Bimas Islam No 713 Tahun 2018</p>
<br>
    <p class="text-center">FORMULIR SURAT PENGANTAR PERKAWINAN</p>

    <table>
        <tr>
            <td class="label">KANTOR DESA/KELURAHAN</td>
            <td>: TEBING TINGGI OKURA</td>
        </tr>
        <tr>
            <td>KECAMATAN</td>
            <td>: RUMBAI TIMUR</td>
        </tr>
        <tr>
            <td>KABUPATEN/KOTA</td>
            <td>: PEKANBARU</td>
        </tr>
    </table>

    <div class="nomor">
        <p class="underline bold" style="margin-bottom: 0;">SURAT PENGANTAR PERKAWINAN</p>
        <p>Nomor: {{ $skp->nomor_surat }}</p>
    </div>

    <p class="mt-2">Yang bertanda tangan di bawah ini menjelaskan dengan sesungguhnya bahwa :</p>
    <table class="mt-2">
    <tr><td class="label">1. Nama</td><td>: {{ $skp->nama }}</td></tr>
    <tr><td>2. Nomor Induk Kependudukan (NIK)</td><td>: {{ $skp->nik }}</td></tr>
    <tr><td>3. Jenis Kelamin</td><td>: {{ $skp->jenis_kelamin }}</td></tr>
    <tr>
        <td>4. Tempat dan Tanggal Lahir</td>
        <td>: {{ $skp->tempat_lahir }}, {{ \Carbon\Carbon::parse($skp->tanggal_lahir)->format('d-m-Y') }}</td>
    </tr>
    <tr><td>5. Kewarganegaraan</td><td>: {{ $skp->kewarganegaraan }}</td></tr>
    <tr><td>6. Agama</td><td>: {{ $skp->agama }}</td></tr>
    <tr><td>7. Pekerjaan</td><td>: {{ $skp->pekerjaan }}</td></tr>
    <tr><td>8. Alamat</td><td>: {{ $skp->alamat }}</td></tr>
    <tr><td>9. Status Perkawinan</td><td>: {{ $skp->status_perkawinan?->status_kawin ?? '-' }}</td></tr>
    <tr><td>10. Nama Istri/Suami Terdahulu</td><td>: {{ $skp->status_perkawinan?->nama_pasangan_dulu ?? '-' }}</td></tr>
</table>

<p class="mt-2">Adalah benar anak dari perkawinan seorang pria:</p>
<table class="mt-2">
    <tr><td class="label">1. Nama lengkap dan alias</td><td>: {{ $skp->orangTua?->nama_ayah ?? '-' }}</td></tr>
    <tr><td>2. NIK</td><td>: {{ $skp->orangTua?->nik_ayah ?? '-' }}</td></tr>
    <tr>
        <td>3. Tempat dan tanggal lahir</td>
        <td>: {{ $skp->orangTua?->tempat_lahir_ayah ?? '-' }}, {{ $skp->orangTua?->tanggal_lahir_ayah ?? '-' }}</td>
    </tr>
    <tr><td>4. Warga Negara</td><td>: {{ $skp->orangTua?->kewarganegaraan_ayah ?? '-' }}</td></tr>
    <tr><td>5. Agama</td><td>: {{ $skp->orangTua?->agama_ayah ?? '-' }}</td></tr>
    <tr><td>6. Pekerjaan</td><td>: {{ $skp->orangTua?->pekerjaan_ayah ?? '-' }}</td></tr>
    <tr><td>7. Alamat</td><td>: {{ $skp->orangTua?->alamat_ayah ?? '-' }}</td></tr>
</table>

<p class="mt-2">Dengan seorang wanita:</p>
<table class="mt-2">
    <tr><td class="label">1. Nama lengkap dan alias</td><td>: {{ $skp->orangTua?->nama_ibu ?? '-' }}</td></tr>
    <tr><td>2. NIK</td><td>: {{ $skp->orangTua?->nik_ibu ?? '-' }}</td></tr>
    <tr>
        <td>3. Tempat dan tanggal lahir</td>
        <td>: {{ $skp->orangTua?->tempat_lahir_ibu ?? '-' }}, {{ $skp->orangTua?->tanggal_lahir_ibu ?? '-' }}</td>
    </tr>
    <tr><td>4. Warga Negara</td><td>: {{ $skp->orangTua?->kewarganegaraan_ibu ?? '-' }}</td></tr>
    <tr><td>5. Agama</td><td>: {{ $skp->orangTua?->agama_ibu ?? '-' }}</td></tr>
    <tr><td>6. Pekerjaan</td><td>: {{ $skp->orangTua?->pekerjaan_ibu ?? '-' }}</td></tr>
    <tr><td>7. Alamat</td><td>: {{ $skp->orangTua?->alamat_ibu ?? '-' }}</td></tr>
</table>


    <p>Demikianlah surat pengantar ini dibuat dengan mengingat sumpah jabatan dan untuk digunakan sebagaimana mestinya.</p>

    <table class="ttd">
        <tr>
            <td style="width:50%"></td>
            <td>
                Pekanbaru,{{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}<br>
                LURAH TEBING TINGGI OKURA<br><br><br><br><br>
               
                <span class="bold underline">RYAN WIBOWO, S.STP, M.Si</span><br>
                <span>NIP : 19921222 201507 1 001</span>
            </td>
        </tr>
    </table>
</body>
</html>
