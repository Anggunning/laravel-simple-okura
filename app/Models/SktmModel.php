<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;

class SktmModel extends Model
{
  
    protected $keyType = 'string';
    public $incrementing = false;


    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }
    protected $table = 'sktm'; // pastikan nama tabel sesuai
    protected $fillable = [
        'nama',
        'tujuan',
        'jenis_kelamin',
        'tempatLahir',
        'tanggalLahir',
        'agama',
        'nik',
        'alamat',
        'rt',
        'rw',
        'keterangan',
        'pekerjaan',
        'status',
        'alasan',
        'pengantar_rt_rw',     
        'kk',                   
        'ktp',                 
        'surat_pernyataan',     
        'user_id'
    ];

    protected $casts = [
        'tanggalLahir' => 'date',
        'tanggal' => 'date',
    ];

   public function riwayat_sktm()
{
   return $this->hasMany(RiwayatsktmModel::class, 'sktm_id', 'id');
}


public function user()
{
    return $this->belongsTo(User::class);
}


}
