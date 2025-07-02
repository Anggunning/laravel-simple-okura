<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class PendudukMiskinModel extends Model
{
    protected $table = 'pendudukMiskin'; // pastikan nama tabel sesuai
    
    use HasUuids;
    protected $fillable = [
        'nama',
        'alamat',
        'nama_kepala_keluarga',
        'jml_agt_keluarga',
        'kelompokPKH',
        'longitude',
        'latitude',
        'foto_rumah',
    ];
}
