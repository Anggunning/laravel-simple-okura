<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RiwayatSkpSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('riwayat_skp')->insert([
            [
                'id' => 'aaa1b101-d066-11ee-8bb8-744ca1759401',
                'status' => 'Diproses',
                'peninjau' => 'Admin',
                'keterangan' => 'Dokumen belum lengkap',
                'tanggal' => '2024-06-01',
                'waktu' => now(),
                'surat_balasan' => null,
                'created_at' => now(),
                'updated_at' => now(),
                'skp_id' => '8881c2f2-d066-11ee-8bb8-744ca1759401', // Budi Santoso
            ],
            [
                'id' => 'aaa1b102-d066-11ee-8bb8-744ca1759402',
                'status' => 'Diajukan',
                'peninjau' => 'Lurah',
                'keterangan' => 'Sudah sesuai persyaratan',
                'tanggal' => '2024-06-02',
                'waktu' => now(),
                'surat_balasan' => 'files/surat_balasan_sari.pdf',
                'created_at' => now(),
                'updated_at' => now(),
                'skp_id' => '8881c578-d066-11ee-8bb8-744ca1759402', // Sari Lestari
            ],
            [
                'id' => 'aaa1b103-d066-11ee-8bb8-744ca1759403',
                'status' => 'Selesai',
                'peninjau' => 'Admin',
                'keterangan' => 'Data pekerjaan tidak sesuai',
                'tanggal' => '2024-06-03',
                'waktu' => now(),
                'surat_balasan' => 'files/penolakan_andi.pdf',
                'created_at' => now(),
                'updated_at' => now(),
                'skp_id' => '8881c70e-d066-11ee-8bb8-744ca1759403', // Andi Gunawan
            ],
        ]);
    }
}
