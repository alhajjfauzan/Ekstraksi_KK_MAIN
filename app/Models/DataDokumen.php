<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataDokumen extends Model
{
    protected $table = 'data_dokumen';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'nik_fk',
        'no_dokumen',
        'jenis_dokumen',
        'tanggal_pembuatan',
    ];

    public $timestamps = true;

    // Relasi ke AnggotaKeluarga
    public function anggotaKeluarga()
    {
        return $this->belongsTo(AnggotaKeluarga::class, 'nik_fk', 'nik');
    }
}
