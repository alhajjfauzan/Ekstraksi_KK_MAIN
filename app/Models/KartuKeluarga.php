<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KartuKeluarga extends Model
{
    protected $table = 'kartu_keluargas';

    protected $primaryKey = 'no_kk';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'no_kk',
        'kepala_keluarga',
        'alamat',
        'rt',
        'rw',
        'kelurahan',
        'kecamatan',
        'kabupaten',
        'provinsi',
        'kode_pos',
        'tanggal_dikeluarkan'
    ];

    public $timestamps = false;
    public function anggota()
{
    return $this->hasMany(
        AnggotaKeluarga::class,
        'kartu_keluarga_id', 
        'no_kk'               
    );
}

}
