<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RiwayatsktmModel extends Model
{
    use HasFactory;
    protected $keyType = 'string';
    public $incrementing = false;
  protected static function boot()
{
    parent::boot();

    static::creating(function ($model) {
        if (empty($model->id)) {
            $model->id = (string) Str::uuid();
        }
    });
}

    protected $table = 'riwayat_sktm'; // pastikan nama tabel sesuai
    protected $fillable = [
        'status',
        'keterangan',
        'peninjau',
        'tanggal',
        'waktu',
        'alasan',
        'sktm_id',
       
    ];


  public function sktm()
{
    return $this->belongsTo(SktmModel::class, 'sktm_id');
}
}
