<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SkpSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [

            [
                'id' => '8881c2f2-d066-11ee-8bb8-744ca1759401',
                'nama' => 'Budi Santoso',
                'nik' => '1234567890123456',
                'jenis_kelamin' => 'Laki-laki',
                'tempat_lahir' => 'Rumbai Pesisir',
                'tanggal_lahir' => '1990-01-15',
                'kewarganegaraan' => 'Indonesia',
                'pekerjaan' => 'Petani',
                'agama' => 'Islam',
                'status' => 'Diproses',
                'alamat' => 'Jl. Nelayan, Rumbai Pesisir, Riau',
                'status_kawin' => 'Cerai Mati',
                'ktp' => null,
                'kk' => null,
                'pengantar_rt_rw' => null,
                'foto' => null,
                'created_at' => now(),
                'updated_at' => now(),
                'status_perkawinan_id' => '7174b28a-d066-11ee-8bb8-744ca1759432',
            ],
            [
                'id' => '8881c578-d066-11ee-8bb8-744ca1759402',
                'nama' => 'Sari Lestari',
                'nik' => '2345678901234567',
                'jenis_kelamin' => 'Perempuan',
                'tempat_lahir' => 'Rumbai Pesisir',
                'tanggal_lahir' => '1995-06-20',
                'kewarganegaraan' => 'Indonesia',
                'pekerjaan' => 'Ibu Rumah Tangga',
                'agama' => 'Islam',
                'status' => 'Diajukan',
                'alamat' => 'Jl. Teratai, Rumbai Pesisir, Riau',
                'status_kawin' => 'Cerai Hidup',
                'ktp' => null,
                'kk' => null,
                'pengantar_rt_rw' => null,
                'foto' => null,
                'created_at' => now(),
                'updated_at' => now(),
                'status_perkawinan_id' => '7174b28a-d066-11ee-8bb8-744ca1759434',
            ],
            [
                'id' => '8881c70e-d066-11ee-8bb8-744ca1759403',
                'nama' => 'Andi Gunawan',
                'nik' => '3456789012345678',
                'jenis_kelamin' => 'Laki-laki',
                'tempat_lahir' => 'Rumbai Pesisir',
                'tanggal_lahir' => '1998-12-05',
                'kewarganegaraan' => 'Indonesia',
                'pekerjaan' => 'Mahasiswa',
                'agama' => 'Kristen',
                'status' => 'Selesai',
                'alamat' => 'Jl. Pelajar, Rumbai Pesisir, Riau',
                'status_kawin' => 'Belum Pernah Menikah',
                'ktp' => null,
                'kk' => null,
                'pengantar_rt_rw' => null,
                'foto' => null,
                'created_at' => now(),
                'updated_at' => now(),
                'status_perkawinan_id' => '7174b28a-d066-11ee-8bb8-744ca1759436',
            ],
        ];

        DB::table('skp')->insert($data);
    }
}
