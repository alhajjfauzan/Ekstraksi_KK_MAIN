<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataKelahiran extends Model
{
    protected $table = 'data_kelahirans';
    protected $primaryKey = 'nik_fk';
    protected $fillable = [
        'nik_fk',
        'tempat_lahir',
        'tanggal_lahir',
        'nama_ayah',
        'nama_ibu'
    ];

    public $timestamps = true;
    public function anggota()
    {
        return $this->belongsTo(AnggotaKeluarga::class, 'nik_fk', 'nik');
    }
}
