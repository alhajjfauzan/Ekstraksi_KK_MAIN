<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KartuKeluarga extends Model
{
    protected $table = 'kartu_keluarga';
    protected $primaryKey = 'no_kk';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'no_kk',
        'kepala_keluarga',
        'kelurahan',
        'kecamatan',
        'kabupaten',
        'provinsi',
        'alamat',
        'kode_pos',
        'rt',
        'rw',
    ];

    // Relasi ke anggota keluarga
    public function anggotaKeluarga()
    {
        return $this->hasMany(AnggotaKeluarga::class, 'no_kk_id', 'no_kk');
    }
}