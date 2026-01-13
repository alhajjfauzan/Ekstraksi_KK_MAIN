<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataDokumen extends Model
{
    protected $table = 'data_dokumens';
    protected $primaryKey = 'nik_fk';
    protected $fillable = [
        'nik_fk',
        'no_paspor',
        'no_kitap',
        'tanggal_pembuatan',
    ];

    public $timestamps = true;
    public function anggota()
    {
        return $this->belongsTo(AnggotaKeluarga::class, 'nik_fk', 'nik');
    }
}
