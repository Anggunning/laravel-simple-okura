<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'id' => '7174b28a-d066-11ee-8bb8-744ca1759434',
                'username' => 'Admin',
                'no_hp' => '082111111111',
                'email_verified_at' => now(),
                'password' => Hash::make('admin123'), // Gunakan password yang kuat di produksi
                'role' => 'Admin',
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => '585f45a6-ecd1-11ee-95e5-2a57142798db',
                'username' => 'budi',
                'no_hp' => '081222222222',
                'email_verified_at' => now(),
                'password' => Hash::make('12345678'),
                'role' => 'Lurah',
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => '07608176-d067-11ee-8bb8-744ca1759434',
                'username' => 'anggun',
                'no_hp' => '088233333333',
                'email_verified_at' => now(),
                'password' => Hash::make('12345678'),
                'role' => 'Sekretaris',
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => '585f56ca-ecd1-11ee-95e5-2a57142791db',
                'username' => 'anto',
                'no_hp' => '089744444444',
                'email_verified_at' => now(),
                'password' => Hash::make('12345678'),
                'role' => 'Masyarakat',
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

    }
}
