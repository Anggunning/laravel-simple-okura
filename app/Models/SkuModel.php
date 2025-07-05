<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class SkuModel extends Model
{
    public $incrementing = false; // wajib kalau pakai UUID
    protected $keyType = 'string';

        protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }
     protected $table = 'sku'; // pastikan nama tabel sesuai
    protected $fillable = [
        'nama',
        'tujuan',
        'jenis_kelamin',
        'tempatLahir',
        'tanggalLahir',
        'agama',
        'nik',
        'pekerjaan',
        'jenis_usaha',
        'tempat_usaha',
        'kelurahan',
        'kecamatan',
        'kota',
        'alamat',
        'keterangan',
        'status',
        'alasan',
        'foto_usaha',
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

   public function riwayat_sku()
{
    return $this->hasMany(RiwayatskuModel::class, 'sku_id');
}


public function user()
{
    return $this->belongsTo(User::class);
}

}
