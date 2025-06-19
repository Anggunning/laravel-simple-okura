<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\SktmModel;
use Illuminate\Database\Seeder;
use App\Models\RiwayatPengajuanModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RiwayatPengajuanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('riwayat_pengajuan')->insert(
            [
                'id' => '313cdb26-d067-11ee-8bb8-744ca1759436',
                'sktm_id' => '585f56ca-ecd1-11ee-95e5-2a57142798db',
                'status' => 'Diajukan',
                'peninjau' => 'Admin',
                'keterangan' => 'Pengajuan awal melalui seeder',
                'tanggal' => Carbon::now()->toDateString(),
                'waktu' => Carbon::now(),
                'surat_balasan' => null,
            ],
            
            
        );
        }

}
