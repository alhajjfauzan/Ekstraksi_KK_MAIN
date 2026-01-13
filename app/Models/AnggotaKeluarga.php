<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnggotaKeluarga extends Model
{
    protected $table = 'anggota_keluargas';

    protected $primaryKey = 'nik';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'nik',
        'kartu_keluarga_id',
        'nama_lengkap',
        'tanggal_perkawinan',
        'jenis_kelamin',
        'status_hubungan',
    ];

    public $timestamps = false;

    public function kartuKeluarga()
    {
        return $this->belongsTo(KartuKeluarga::class, 'kartu_keluarga_id');
    }
   public function dataKelahiran()
{
    return $this->hasOne(DataKelahiran::class, 'nik_fk', 'nik');
}

public function dataDokumen()
{
    return $this->hasOne(DataDokumen::class, 'nik_fk', 'nik');
}

public function dataStatus()
{
    return $this->hasOne(DataStatus::class, 'nik_fk', 'nik');
}
public function agama()
{
    return $this->hasOne(Agama::class, 'nik_fk', 'nik');
}

public function pendidikan()
{
    return $this->hasOne(Pendidikan::class, 'nik_fk', 'nik');
}
}
