<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class RiwayatskpModel extends Model
{
    use HasUuids;

    protected $table = 'riwayat_skp';
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
        'status', 'peninjau', 'keterangan', 'tanggal',
        'waktu', 'skp_id'
    ];

    public function skp()
    {
        return $this->belongsTo(SkpModel::class, 'skp_id');
    }
}
