<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class StatusPerkawinanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $data = [
            [
                'id' => '7174b28a-d066-11ee-8bb8-744ca1759432',
                
                'status_kawin' => 'Cerai Mati',
                'jenis_kelamin_psgn_dulu' => 'Perempuan',
                'nama_pasangan_dulu' => 'Siti Aminah',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => '7174b28a-d066-11ee-8bb8-744ca1759434',
                
                'status_kawin' => 'Cerai Hidup',
                'jenis_kelamin_psgn_dulu' => 'Laki-laki',
                'nama_pasangan_dulu' => 'Rudi Hartono',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => '7174b28a-d066-11ee-8bb8-744ca1759436',
                
                'status_kawin' => 'Belum Pernah Menikah',
                'jenis_kelamin_psgn_dulu' => null,
                'nama_pasangan_dulu' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('status_perkawinan')->insert($data);
    }
}
