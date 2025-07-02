<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Keterangan Usaha</title>
    <style>
        @page {
            size: A4;
            margin-top: 0.2cm;
        margin-right: 2cm;
        margin-left: 2cm;
        margin-bottom: 2cm;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
            line-height: 1.5;
        }
         table {
        width: 100%;
        font-size: 12pt;
        border-collapse: collapse;
        margin-bottom: 1.5px; /* jarak antar tabel */
        padding-left: 4rem
    }

    td {
        padding: 1.5px 0; /* jarak vertikal antar baris */
    }
        
        .text-end { text-align: right; }
        .fw-bold { font-weight: bold; margin-top: 1rem; }
        td { vertical-align: top; padding: 4px; }
        .mt-2 { margin-top: 1rem; margin-bottom: 1rem; text-align: justify; text-indent: 4rem;}
        .mt-4 { margin-top: 2rem; }
        .underline { text-decoration: underline; }
        .text-center {
            text-align: center;
        }

        .ttd {
            margin-top: 50px;
            width: 100%;
        }

        .kanan {
            float: right;
            text-align: center;
        }

        .bold {
            font-weight: bold;
        }

        .clear {
            clear: both;
        }
        .text{
            line-height: 1;
        }
    </style>
</head>
<body>

    <div class="text-center">
        <p style="font-size:14pt; font-weight:bold; margin-bottom:0;">PEMERINTAH KOTA PEKANBARU</p>
        <p style="font-size:14pt; font-weight:bold; margin:0;">KECAMATAN RUMBAI TIMUR</p>
        <p style="font-size:14pt; font-weight:bold; margin:0;">KELURAHAN TEBING TINGGI OKURA</p>
        <p style="font-size:11pt; margin:0;">Jl. Raja Panjang Okura – Pekanbaru &nbsp;&nbsp;&nbsp;&nbsp; Kode Pos. 28268</p>
        <hr>
        <p class="underline fw-bold" style="font-size:14pt;">SURAT KETERANGAN TIDAK MAMPU</p>
        <p>Nomor: 500/TTO/{{ now()->year }}/...</p>
    </div>

    <p class="mt-2">Lurah Tebing Tinggi Okura Kecamatan Rumbai Timur Kota Pekanbaru, dengan ini menerangkan bahwa:</p>

    <table>
        <tr><td style="width: 30%;">Nama</td><td>: {{ $sktm->nama }}</td></tr>
        <tr><td>Jenis Kelamin</td><td>: {{ $sktm->jenis_kelamin }}</td></tr>
        <tr><td>Tempat/Tanggal Lahir</td><td>: {{ $sktm->tempatLahir }}, {{ \Carbon\Carbon::parse($sktm->tanggalLahir)->format('d-m-Y') }}</td></tr>
        <tr><td>Pekerjaan</td><td>: {{ $sktm->pekerjaan }}</td></tr>
        <tr><td>Agama</td><td>: {{ $sktm->agama }}</td></tr>
        <tr><td>NIK</td><td>: {{ $sktm->nik }}</td></tr>
        <tr><td>Alamat</td><td>: {{ $sktm->alamat }}</td></tr>
    </table>


<p class="mt-2">
    Berdasarkan surat pengantar dari RT.{{ $sktm->rt ?? '...' }} /RW.{{ $sktm->rw ?? '...' }} Kelurahan Tebing Tinggi Okura Kecamatan Rumbai Timur Kota Pekanbaru, dan pernyataan dari yang bersangkutan bahwa nama tersebut di atas adalah penduduk yang tergolong 
    <span class="bold">KELUARGA TIDAK MAMPU/MISKIN</span>.</p>

     <p class="mt-2">Adapun Surat Keterangan ini diberikan kepada yang bersangkutan guna untuk: <span class="bold">{{ $sktm->tujuan }} <span class="bold"></span>.</p>

    <p class="mt-2">Demikian Surat Keterangan ini dibuat dengan sebenarnya, untuk dapat dipergunakan seperlunya.</p>
    <br>
    <table style="width: 100%;">
        <tr>
            <td style="width: 50%"></td>
            <td class="text-center" >
                Pekanbaru, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}<br><br>
            <span>LURAH TEBING TINGGI OKURA</span><br><br><br>
                <p class="bold"><u class="text">RYAN WIBOWO, S.STP, M.Si</u></p>
            <p class="text" >NIP : 19921222 201507 1 001</p>
            </td>
        </tr>
    </table>

</body>
</html>
