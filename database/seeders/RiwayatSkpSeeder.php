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
                'alasan' => 'Sedang diproses',
                'keterangan' => 'Dokumen belum lengkap',
                'created_at' => now(),
                'updated_at' => now(),
                'skp_id' => '8881c2f2-d066-11ee-8bb8-744ca1759401', // Budi Santoso
            ],
            [
                'id' => 'aaa1b102-d066-11ee-8bb8-744ca1759402',
                'status' => 'Diajukan',
                'peninjau' => 'Lurah',
                'alasan' => 'Sedang diproses',
                'keterangan' => 'Sudah sesuai persyaratan',
                'created_at' => now(),
                'updated_at' => now(),
                'skp_id' => '8881c578-d066-11ee-8bb8-744ca1759402', // Sari Lestari
            ],
            [
                'id' => 'aaa1b103-d066-11ee-8bb8-744ca1759403',
                'status' => 'Selesai',
                'peninjau' => 'Admin',
                'alasan' => 'Surat sudah selesai. Silahkan print atau ambil di kantor lurah.',
                'keterangan' => 'Data pekerjaan tidak sesuai',
                'created_at' => now(),
                'updated_at' => now(),
                'skp_id' => '8881c70e-d066-11ee-8bb8-744ca1759403', // Andi Gunawan
            ],
            [
                'id' => 'aaa1b103-d066-11ee-8bb8-744ca1759477',
                'status' => 'Ditolak',
                'peninjau' => 'Admin',
                'alasan' => 'Data KK tidak valid',
                'keterangan' => 'Data pekerjaan tidak sesuai',
                'created_at' => now(),
                'updated_at' => now(),
                'skp_id' => '8881c70e-d066-09ee-8bb8-744ca1759403', // Andi Gunawan
            ],
        ]);
    }
}
