<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            SktmSeeder::class,
            SkuSeeder::class,
            StatusPerkawinanSeeder::class,
            SkpSeeder::class,
            RiwayatsktmSeeder::class,
            RiwayatskuSeeder::class,
            RiwayatSkpSeeder::class,
            OrangTuaSeeder::class,
            PendudukMiskinSeeder::class,
            
            
        ]);
    }
}
