<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataStatus extends Model
{
    protected $table = 'data_status';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'nik_fk',
        'status_perkawinan',
        'tanggal_perkawinan',
        'status_hubungan_dalam_keluarga',
    ];

    public $timestamps = true;

    // Relasi ke AnggotaKeluarga
    public function anggotaKeluarga()
    {
        return $this->belongsTo(AnggotaKeluarga::class, 'nik_fk', 'nik');
    }
}
