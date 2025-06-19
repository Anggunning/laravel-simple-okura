<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StatusPerkawinanModel extends Model
{
    use HasFactory;

    protected $table = 'status_perkawinan';
    public $incrementing = false;
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
    protected $fillable = [
        'surat_perkawinan_id', 'status_kawin',
        'jenis_kelamin_psgn_dulu', 'nama_pasangan_dulu'
    ];

    public function skp()
    {
        return $this->hasMany(SkpModel::class, 'status_perkawinan_id');
    }
}
