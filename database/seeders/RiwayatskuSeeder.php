<?php

namespace Database\Seeders;

use Illuminate\Support\Carbon;
use App\Models\RiwayatskuModel;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RiwayatskuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data=[ 
            [
        'id' => 'b1b1b1b1-dc01-11ee-a1a1-0011a1a1a1b1',
        'sku_id' => 'e5f5e556-ecce-11ee-9c0c-4b5a173f5d66',
        'status' => 'Selesai',
        'peninjau' => 'Lurah',
        'keterangan' => 'Surat disahkan',
        'tanggal' => Carbon::now()->toDateString(),
        'waktu' => Carbon::now(),
        'surat_balasan' => null
    ],
    [
        'id' => 'c2c2c2c2-dc01-11ee-a1a1-0011a1a1a1c2',
        'sku_id' => 'e5f5e557-ecce-11ee-9c0c-4b5a173f5d67',
        'status' => 'Diajukan',
        'peninjau' => 'Masyarakat',
        'keterangan' => 'Permintaan surat baru',
        'tanggal' => Carbon::now()->subDays(12)->toDateString(),
        'waktu' => Carbon::now()->subDays(12),
        'surat_balasan' => null
    ],
    [
        'id' => 'd3d3d3d3-dc01-11ee-a1a1-0011a1a1a1d3',
        'sku_id' => 'e5f5e558-ecce-11ee-9c0c-4b5a173f5d68',
        'status' => 'Diproses',
        'peninjau' => 'Admin',
        'keterangan' => 'Admin proses cepat',
        'tanggal' => Carbon::now()->subDays(11)->toDateString(),
        'waktu' => Carbon::now()->subDays(11),
        'surat_balasan' => null
    ],
    [
        'id' => 'e4e4e4e4-dc01-11ee-a1a1-0011a1a1a1e4',
        'sku_id' => 'e5f5e559-ecce-11ee-9c0c-4b5a173f5d69',
        'status' => 'Selesai',
        'peninjau' => 'Lurah',
        'keterangan' => 'Lurah menyetujui',
        'tanggal' => Carbon::now()->subDays(10)->toDateString(),
        'waktu' => Carbon::now()->subDays(10),
        'surat_balasan' => null
    ],  [
        'id' => 'f5f5f5f5-dc01-11ee-a1a1-0011a1a1a1f5',
        'sku_id' => 'e5f5e560-ecce-11ee-9c0c-4b5a173f5d70',
        'status' => 'Diajukan',
        'peninjau' => 'Admin',
        'keterangan' => 'Pengajuan sku baru oleh admin',
        'tanggal' => Carbon::now()->subDays(8)->toDateString(),
        'waktu' => Carbon::now()->subDays(8),
        'surat_balasan' => null,
    ],
    [
        'id' => 'f6f6f6f6-dc01-11ee-a1a1-0011a1a1a1f6',
        'sku_id' => 'f6f6f666-ecce-11ee-9c0c-4b5a173f5d71',
        'status' => 'Diproses',
        'peninjau' => 'Sekretaris',
        'keterangan' => 'Pemeriksaan dokumen tambahan',
        'tanggal' => Carbon::now()->subDays(7)->toDateString(),
        'waktu' => Carbon::now()->subDays(7),
        'surat_balasan' => null,
    ],
    [
        'id' => 'f7f7f7f7-dc01-11ee-a1a1-0011a1a1a1f7',
        'sku_id' => 'f7f7f777-ecce-11ee-9c0c-4b5a173f5d72',
        'status' => 'Selesai',
        'peninjau' => 'Lurah',
        'keterangan' => 'sku disahkan oleh lurah',
        'tanggal' => Carbon::now()->subDays(6)->toDateString(),
        'waktu' => Carbon::now()->subDays(6),
        'surat_balasan' => null,
    ],
    [
        'id' => 'f8f8f8f8-dc01-11ee-a1a1-0011a1a1a1f8',
        'sku_id' => 'f8f8f888-ecce-11ee-9c0c-4b5a173f5d73',
        'status' => 'Diajukan',
        'peninjau' => 'Masyarakat',
        'keterangan' => 'Pengajuan pribadi warga',
        'tanggal' => Carbon::now()->subDays(5)->toDateString(),
        'waktu' => Carbon::now()->subDays(5),
        'surat_balasan' => null,
    ],
    [
        'id' => 'f9f9f9f9-dc01-11ee-a1a1-0011a1a1a1f9',
        'sku_id' => 'f9f9f999-ecce-11ee-9c0c-4b5a173f5d74',
        'status' => 'Diproses',
        'peninjau' => 'Admin',
        'keterangan' => 'Validasi oleh admin kelurahan',
        'tanggal' => Carbon::now()->subDays(4)->toDateString(),
        'waktu' => Carbon::now()->subDays(4),
        'surat_balasan' => null,
    ],
    [
        'id' => 'g0g0g0g0-dc01-11ee-a1a1-0011a1a1a1g0',
        'sku_id' => 'g0g0g000-ecce-11ee-9c0c-4b5a173f5d75',
        'status' => 'Selesai',
        'peninjau' => 'Lurah',
        'keterangan' => 'Surat ditandatangani lurah',
        'tanggal' => Carbon::now()->subDays(3)->toDateString(),
        'waktu' => Carbon::now()->subDays(3),
        'surat_balasan' => null,
    ],
    
        ];
        RiwayatskuModel::insert($data);
    }
}
