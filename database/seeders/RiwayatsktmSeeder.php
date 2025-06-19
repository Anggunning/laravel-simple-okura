<?php

namespace Database\Seeders;

use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use App\Models\RiwayatsktmModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RiwayatsktmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $data = [
            [
                'id' => '1a1a1a11-dc01-11ee-a1a1-0011a1a1a1a1',
                'sktm_id' => '585f56ca-ecd1-11ee-95e5-2a57142798db',
                'status' => 'Diajukan',
                'peninjau' => 'Masyarakat',
                'keterangan' => 'Pengajuan oleh masyarakat',
                'tanggal' => Carbon::now()->subDays(10)->toDateString(),
                'waktu' => Carbon::now()->subDays(10),
                'surat_balasan' => null
            ],
            [
                'id' => '2b2b2b22-dc01-11ee-a1a1-0011a1a1a1a2',
                'sktm_id' => '0f3b1c70-ecce-11ee-9c0c-4b5a173f5d61',
                'status' => 'Diajukan',
                'peninjau' => 'Admin',
                'keterangan' => 'Pengajuan melalui admin',
                'tanggal' => Carbon::now()->subDays(9)->toDateString(),
                'waktu' => Carbon::now()->subDays(9),
                'surat_balasan' => null
            ],
            [
                'id' => '3c3c3c33-dc01-11ee-a1a1-0011a1a1a1a3',
                'sktm_id' => '1679c5ae-ecce-11ee-9d3b-7a15bc729f72',
                'status' => 'Diproses',
                'peninjau' => 'Admin',
                'keterangan' => 'Verifikasi data awal',
                'tanggal' => Carbon::now()->subDays(8)->toDateString(),
                'waktu' => Carbon::now()->subDays(8),
                'surat_balasan' => null
            ],
            [
                'id' => '4d4d4d44-dc01-11ee-a1a1-0011a1a1a1a4',
                'sktm_id' => '1e2226e6-ecce-11ee-a551-dc65d81bdab0',
                'status' => 'Diproses',
                'peninjau' => 'Sekretaris',
                'keterangan' => 'Pengecekan dokumen',
                'tanggal' => Carbon::now()->subDays(7)->toDateString(),
                'waktu' => Carbon::now()->subDays(7),
                'surat_balasan' => null
            ],
            [
                'id' => '5e5e5e55-dc01-11ee-a1a1-0011a1a1a1a5',
                'sktm_id' => '25e3f6bc-ecce-11ee-89f9-8a45e10242a3',
                'status' => 'Selesai',
                'peninjau' => 'Lurah',
                'keterangan' => 'Pengesahan oleh lurah',
                'tanggal' => Carbon::now()->subDays(6)->toDateString(),
                'waktu' => Carbon::now()->subDays(6),
                'surat_balasan' => null
            ],
            [
                'id' => '6f6f6f66-dc01-11ee-a1a1-0011a1a1a1a6',
                'sktm_id' => '2d778ccc-ecce-11ee-9876-8b351aa5210e',
                'status' => 'Diajukan',
                'peninjau' => 'Masyarakat',
                'keterangan' => 'Pengajuan ulang dari warga',
                'tanggal' => Carbon::now()->subDays(5)->toDateString(),
                'waktu' => Carbon::now()->subDays(5),
                'surat_balasan' => null
            ],
            [
                'id' => '7g7g7g77-dc01-11ee-a1a1-0011a1a1a1a7',
                'sktm_id' => '34fe4ac8-ecce-11ee-b3d2-f01fa2aa881c',
                'status' => 'Diproses',
                'peninjau' => 'Admin',
                'keterangan' => 'Admin proses berkas',
                'tanggal' => Carbon::now()->subDays(4)->toDateString(),
                'waktu' => Carbon::now()->subDays(4),
                'surat_balasan' => null
            ],
            [
                'id' => '8h8h8h88-dc01-11ee-a1a1-0011a1a1a1a8',
                'sktm_id' => '3cf9fa38-ecce-11ee-ae23-d083fcb0c4fb',
                'status' => 'Selesai',
                'peninjau' => 'Lurah',
                'keterangan' => 'Ditandatangani lurah',
                'tanggal' => Carbon::now()->subDays(3)->toDateString(),
                'waktu' => Carbon::now()->subDays(3),
                'surat_balasan' => null
            ],
            [
                'id' => '9i9i9i99-dc01-11ee-a1a1-0011a1a1a1a9',
                'sktm_id' => '447299d8-ecce-11ee-8c11-7076cfa9e9e6',
                'status' => 'Diajukan',
                'peninjau' => 'Admin',
                'keterangan' => 'Admin input data baru',
                'tanggal' => Carbon::now()->subDays(2)->toDateString(),
                'waktu' => Carbon::now()->subDays(2),
                'surat_balasan' => null
            ],
            [
                'id' => 'a0a0a0a0-dc01-11ee-a1a1-0011a1a1a1a0',
                'sktm_id' => '4be0c0de-ecce-11ee-b70a-4c528e1d1c3f',
                'status' => 'Diproses',
                'peninjau' => 'Sekretaris',
                'keterangan' => 'Sekretaris mengecek ulang',
                'tanggal' => Carbon::now()->subDay()->toDateString(),
                'waktu' => Carbon::now()->subDay(),
                'surat_balasan' => null
            ],
        ];
        RiwayatsktmModel::insert($data);
    }
}
