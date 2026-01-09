<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataDokumen extends Model
{
    protected $table = 'data_dokumens';
    protected $fillable = [
        'nik_fk',
        'no_pasfor',
        'no_kitap',
        'tanggal_pembuatan',
    ];

    public $timestamps = true;
    public function anggotaKeluarga()
    {
        return $this->belongsTo(AnggotaKeluarga::class, 'nik_fk', 'nik');
    }
}
