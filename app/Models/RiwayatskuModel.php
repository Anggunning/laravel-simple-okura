<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RiwayatskuModel extends Model
{
    use HasFactory;
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

    protected $table = 'riwayat_sku'; // pastikan nama tabel sesuai
    protected $fillable = [
        'status',
        'keterangan',
        'peninjau',
        'tanggal',
        'waktu',
        'alasan',
        'sku_id',
       
    ];


  public function sku()
{
    return $this->belongsTo(SkuModel::class, 'sku_id');
}
}
