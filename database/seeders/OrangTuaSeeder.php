<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class OrangTuaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       DB::table('orang_tua')->insert([
            [
                'id' => '9991a111-d066-11ee-8bb8-744ca1759401',
                'skp_id' => '8881c2f2-d066-11ee-8bb8-744ca1759401', // Budi Santoso
                'nama_ayah' => 'Slamet Santoso',
                'nik_ayah' => '1111111111111111',
                'tempat_lahir_ayah' => 'Rumbai Pesisir',
                'tanggal_lahir_ayah' => '1960-05-12',
                'kewarganegaraan_ayah' => 'Indonesia',
                'pekerjaan_ayah' => 'Petani',
                'agama_ayah' => 'Islam',
                'alamat_ayah' => 'Jl. Nelayan, Rumbai Pesisir, Riau',

                'nama_ibu' => 'Sri Wahyuni',
                'nik_ibu' => '2222222222222222',
                'tempat_lahir_ibu' => 'Rumbai Pesisir',
                'tanggal_lahir_ibu' => '1965-08-30',
                'kewarganegaraan_ibu' => 'Indonesia',
                'pekerjaan_ibu' => 'Ibu Rumah Tangga',
                'agama_ibu' => 'Islam',
                'alamat_ibu' => 'Jl. Nelayan, Rumbai Pesisir, Riau',

                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => '9991a222-d066-11ee-8bb8-744ca1759402',
                'skp_id' => '8881c578-d066-11ee-8bb8-744ca1759402', // Sari Lestari
                'nama_ayah' => 'Sunaryo',
                'nik_ayah' => '3333333333333333',
                'tempat_lahir_ayah' => 'Rumbai Pesisir',
                'tanggal_lahir_ayah' => '1958-03-21',
                'kewarganegaraan_ayah' => 'Indonesia',
                'pekerjaan_ayah' => 'Nelayan',
                'agama_ayah' => 'Islam',
                'alamat_ayah' => 'Jl. Teratai, Rumbai Pesisir, Riau',

                'nama_ibu' => 'Murniati',
                'nik_ibu' => '4444444444444444',
                'tempat_lahir_ibu' => 'Rumbai Pesisir',
                'tanggal_lahir_ibu' => '1962-09-14',
                'kewarganegaraan_ibu' => 'Indonesia',
                'pekerjaan_ibu' => 'Ibu Rumah Tangga',
                'agama_ibu' => 'Islam',
                'alamat_ibu' => 'Jl. Teratai, Rumbai Pesisir, Riau',

                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => '9991a333-d066-11ee-8bb8-744ca1759403',
                'skp_id' => '8881c70e-d066-11ee-8bb8-744ca1759403', // Andi Gunawan
                'nama_ayah' => 'Gunarto',
                'nik_ayah' => '5555555555555555',
                'tempat_lahir_ayah' => 'Rumbai Pesisir',
                'tanggal_lahir_ayah' => '1963-07-10',
                'kewarganegaraan_ayah' => 'Indonesia',
                'pekerjaan_ayah' => 'Guru',
                'agama_ayah' => 'Kristen',
                'alamat_ayah' => 'Jl. Pelajar, Rumbai Pesisir, Riau',

                'nama_ibu' => 'Maria Magdalena',
                'nik_ibu' => '6666666666666666',
                'tempat_lahir_ibu' => 'Rumbai Pesisir',
                'tanggal_lahir_ibu' => '1967-11-02',
                'kewarganegaraan_ibu' => 'Indonesia',
                'pekerjaan_ibu' => 'Ibu Rumah Tangga',
                'agama_ibu' => 'Kristen',
                'alamat_ibu' => 'Jl. Pelajar, Rumbai Pesisir, Riau',

                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
