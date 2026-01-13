<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataStatus extends Model
{
    protected $table = 'data_statuses';
    protected $primaryKey = 'nik_fk';
    protected $fillable = [
        'nik_fk',
        'pekerjaan',
        'golongan_darah',
        'status_perkawinan',
        'kewarganegaraan',
        'agama_id',
        'pendidikan_id',
    ];

    public function anggota()
    {
        return $this->belongsTo(
            AnggotaKeluarga::class,
            'nik_fk',
            'nik'
        );
    }

    public function agama()
    {
        return $this->belongsTo(
            Agama::class,
            'agama_id',
            'id'
        );
    }

    public function pendidikan()
    {
        return $this->belongsTo(
            Pendidikan::class,
            'pendidikan_id',
            'id'
        );
    }
}
