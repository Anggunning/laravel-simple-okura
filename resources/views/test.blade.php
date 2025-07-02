<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Surat Keterangan Tidak Mampu</title>
    <style>
        @page {
            size: A4;
            margin: 2cm;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
        }

        .text-center {
            text-align: center;
        }

        .kop-surat {
            text-align: center;
            margin-bottom: 10px;
        }

        .kop-surat h3, .kop-surat h4 {
            margin: 0;
        }

        .garis {
            border-top: 3px double black;
            margin-top: 5px;
            margin-bottom: 20px;
        }

        .ttd {
            margin-top: 50px;
            width: 100%;
        }

        .ttd .kanan {
            float: right;
            text-align: center;
        }

        .bold {
            font-weight: bold;
        }

        table {
            width: 100%;
            margin-left: 20px;
        }

        table td {
            vertical-align: top;
            padding-bottom: 5px;
        }

        .clear {
            clear: both;
        }
    </style>
</head>
<body>
    <div style="display: flex; align-items: center;">
    {{-- Logo Pemko --}}
    <div style="width: 80px; text-align: center;">
        <img src="{{ public_path('logo/image.png') }}" alt="Logo" width="70">
    </div>

    {{-- Tulisan Kop Surat --}}
    <div style="flex: 1; text-align: center;">
        <h3 style="margin: 0; font-weight: bold;">PEMERINTAH KOTA PEKANBARU</h3>
        <h4 style="margin: 0; font-weight: bold;">KECAMATAN RUMBAI TIMUR</h4>
        <h4 style="margin: 0; font-weight: bold;">KELURAHAN TEBING TINGGI OKURA</h4>
        <p style="margin: 0;">Jl. Raja Panjang Okura – Pekanbaru &nbsp;&nbsp;&nbsp; Kode Pos. 28268</p>
    </div>
</div>

<hr style="border: 2px double black; margin: 10px 0 20px;">

    <p>Lurah Tebing Tinggi Okura Kecamatan Rumbai Timur Kota Pekanbaru, dengan ini menerangkan bahwa:</p>

    <table>
        <tr>
            <td>Nama</td>
            <td>: </td>
        </tr>
        <tr>
            <td>Jenis Kelamin</td>
            <td>: </td>
        </tr>
        <tr>
            <td>Tempat/Tanggal Lahir</td>
            <td>: </td>
        </tr>
        <tr>
            <td>Pekerjaan</td>
            <td>: </td>
        </tr>
        <tr>
            <td>Agama</td>
            <td>: </td>
        </tr>
        <tr>
            <td>NIK</td>
            <td>: </td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td>: </td>
        </tr>
    </table>

    <p>Berdasarkan surat pengantar dari RT.  Kelurahan Tebing Tinggi Okura Kecamatan Rumbai Timur Kota Pekanbaru, dan pernyataan dari yang bersangkutan bahwa nama tersebut di atas adalah penduduk yang tergolong <span class="bold">KELUARGA TIDAK MAMPU/MISKIN</span>.</p>

    <p>Adapun Surat Keterangan ini diberikan kepada yang bersangkutan guna untuk <span class="bold"></span>.</p>

    <p>Demikian Surat Keterangan ini dibuat dengan sebenarnya, untuk dapat dipergunakan seperlunya.</p>

    <div class="ttd">
        <div class="kanan">
            <p>Pekanbaru, </p>
            <p>A/n. LURAH TEBING TINGGI OKURA</p>
            <p>Kasi Pemerintahan/Trantib</p>
            <br><br><br>
            <p class="bold"><u>RYAN WIBOWO, S.STP,M.Si</u></p>
            <p>NIP : 19921222 201507 1 001</p>
        </div>
    </div>

    <div class="clear"></div>
</body>
</html>
