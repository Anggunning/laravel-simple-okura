<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SkpModel extends Model
{
     use HasFactory;

    protected $table = 'skp';
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
        'nama', 'nik', 'jenis_kelamin', 'tempat_lahir', 'status', 'alasan',
        'tanggal_lahir', 'kewarganegaraan', 'pekerjaan', 'agama', 'rt','rw',
        'alamat', 'status_kawin', 'ktp', 'kk', 'pengantar_rt_rw','keterangan','nomor_surat',
        'foto', 'status_perkawinan_id', 'orang_tua_id', 'user_id'
    ];

    public function statusPerkawinan()
{
    return $this->belongsTo(StatusPerkawinanModel::class, 'status_perkawinan_id');
}

    public function orangTua()
{
    return $this->hasOne(OrangTuaModel::class, 'skp_id');
}

    public function riwayat_skp()
    {
        return $this->hasMany(RiwayatskpModel::class, 'skp_id');
    }
    public function user()
{
    return $this->belongsTo(User::class);
}

    
}
