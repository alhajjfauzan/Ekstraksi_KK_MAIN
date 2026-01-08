<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataKelahiran extends Model
{
    protected $table = 'data_kelahiran';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'nik_fk',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
    ];

    public $timestamps = true;

    // Relasi ke AnggotaKeluarga
    public function anggotaKeluarga()
    {
        return $this->belongsTo(AnggotaKeluarga::class, 'nik_fk', 'nik');
    }
}
