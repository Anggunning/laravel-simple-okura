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
                'user_id' => '585f56ca-ecd1-11ee-95e5-2a57142791db',
                'nama' => 'Budi Santoso',
                'nik' => '1234567890123456',
                'jenis_kelamin' => 'Laki-laki',
                'tempat_lahir' => 'Rumbai Pesisir',
                'tanggal_lahir' => '1990-01-15',
                'kewarganegaraan' => 'Indonesia',
                'pekerjaan' => 'Petani',
                'agama' => 'Islam',
                'alasan' => 'Data KK tidak valid',
                'status' => 'Diproses',
                'nomor_surat' => '474.2/TTO/2025/20',
                'keterangan' => 'Permohonan Pernikahan.',
                'alamat' => 'Jl. Nelayan, Rumbai Pesisir, Riau',
                'rt' => '004',
                'rw' => '005',
                'status_kawin' => 'Cerai Mati',
                'ktp' => 'data1.jpg',
                'kk' => 'data1.jpg',
                'pengantar_rt_rw' => 'data1.jpg',
                'foto' => 'data1.jpg',
                'created_at' => now(),
                'updated_at' => now(),
                'status_perkawinan_id' => '7174b28a-d066-11ee-8bb8-744ca1759432',
            ],
            [
                'id' => '8881c578-d066-11ee-8bb8-744ca1759402',
                'user_id' => '585f56ca-ecd1-11ee-95e5-2a57142791db',
                'nama' => 'Sari Lestari',
                'nik' => '2345678901234567',
                'jenis_kelamin' => 'Perempuan',
                'tempat_lahir' => 'Rumbai Pesisir',
                'tanggal_lahir' => '1995-06-20',
                'kewarganegaraan' => 'Indonesia',
                'pekerjaan' => 'Ibu Rumah Tangga',
                'agama' => 'Islam',
                'alasan' => 'Data KK tidak valid',
                'status' => 'Diajukan',
                'nomor_surat' => '474.2/TTO/2025/21',
                'keterangan' => 'Permohonan Pernikahan.',
                'alamat' => 'Jl. Teratai, Rumbai Pesisir, Riau',
                'rt' => '004',
                'rw' => '005',
                'status_kawin' => 'Cerai Hidup',
                'ktp' => 'data2.jpg',
                'kk' => 'data2.jpg',
                'pengantar_rt_rw' => 'data2.jpg',
                'foto' => 'data2.jpg',
                'created_at' => now(),
                'updated_at' => now(),
                'status_perkawinan_id' => '7174b28a-d066-11ee-8bb8-744ca1759434',
            ],
            [
                'id' => '8881c70e-d066-11ee-8bb8-744ca1759403',
                'user_id' => '585f56ca-ecd1-11ee-95e5-2a57142791db',
                'nama' => 'Andi Gunawan',
                'nik' => '3456789012345678',
                'jenis_kelamin' => 'Laki-laki',
                'tempat_lahir' => 'Rumbai Pesisir',
                'tanggal_lahir' => '1998-12-05',
                'kewarganegaraan' => 'Indonesia',
                'pekerjaan' => 'Mahasiswa',
                'agama' => 'Kristen',
                'alasan' => '-',
                'status' => 'Selesai',
                'nomor_surat' => '474.2/TTO/2025/22',
                'keterangan' => 'Permohonan Pernikahan.',
                'alamat' => 'Jl. Pelajar, Rumbai Pesisir, Riau',
                'rt' => '004',
                'rw' => '005',
                'status_kawin' => 'Belum Pernah Menikah',
                'ktp' => 'data3.jpg',
                'kk' => 'data3.jpg',
                'pengantar_rt_rw' => 'data3.jpg',
                'foto' => 'data3.jpg',
                'created_at' => now(),
                'updated_at' => now(),
                'status_perkawinan_id' => '7174b28a-d066-11ee-8bb8-744ca1759436',
            ],
            [
                'id' => '8881c70e-d066-09ee-8bb8-744ca1759403',
                'user_id' => '585f56ca-ecd1-11ee-95e5-2a57142791db',
                'nama' => 'Andi',
                'nik' => '3456709012345678',
                'jenis_kelamin' => 'Laki-laki',
                'tempat_lahir' => 'Rumbai Pesisir',
                'tanggal_lahir' => '1998-12-05',
                'kewarganegaraan' => 'Indonesia',
                'pekerjaan' => 'Mahasiswa',
                'agama' => 'Kristen',
                'alasan' => 'Data KK tidak valid dan pas foto',
                'status' => 'Ditolak',
                'nomor_surat' => '474.2/TTO/2025/23',
                'keterangan' => 'Permohonan Pernikahan.',
                'alamat' => 'Jl. Pelajar, Rumbai Pesisir, Riau',
                'rt' => '004',
                'rw' => '005',
                'status_kawin' => 'Belum Pernah Menikah',
                'ktp' => 'data3.jpg',
                'kk' => 'data3.jpg',
                'pengantar_rt_rw' => 'data3.jpg',
                'foto' => 'data3.jpg',
                'created_at' => now(),
                'updated_at' => now(),
                'status_perkawinan_id' => '7174b28a-d066-11ee-8bb8-744ca1759436',
        ]
    ];

        DB::table('skp')->insert($data);
    }
}
