<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class OrangTuaModel extends Model
{
    use HasUuids;

    protected $table = 'orang_tua';
    protected $primaryKey = 'id';
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
  protected $fillable = [
    'nama_ayah', 'nik_ayah', 'tempat_lahir_ayah', 'tanggal_lahir_ayah',
    'kewarganegaraan_ayah', 'pekerjaan_ayah', 'agama_ayah', 'alamat_ayah',
    'nama_ibu', 'nik_ibu', 'tempat_lahir_ibu', 'tanggal_lahir_ibu',
    'kewarganegaraan_ibu', 'pekerjaan_ibu', 'agama_ibu', 'alamat_ibu',
    'skp_id',
];


     public function skp()
    {
        return $this->belongsTo(SkpModel::class, 'skp_id');
    }
}
