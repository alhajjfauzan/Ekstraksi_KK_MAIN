<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnggotaKeluarga extends Model
{
    protected $table = 'anggot_keluarga';
    protected $primaryKey = 'nik';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'nik',
        'nama_anggota',
        'jenis_kelamin',
        'status_hubungan',
        'no_kk_id',
        'tempat_lahir',
        'tanggal_lahir',
        'agama',
        'pendidikan',
        'pekerjaan',
        'golongan_darah',
        'status_perkawinan',
        'kewarganegaraan',
        'nama_ayah',
        'nama_ibu',
        'tanggal_perkawinan',
        'no_pasport',
        'no_kitap',
    ];

    // Relasi balik ke KartuKeluarga
    public function kartuKeluarga()
    {
        return $this->belongsTo(KartuKeluarga::class, 'no_kk_id', 'no_kk');
    }

    // Relasi ke tabel lain
    public function dataKelahiran()
    {
        return $this->hasOne(DataKelahiran::class, 'nik_fk', 'nik');
    }

    public function dataStatus()
    {
        return $this->hasOne(DataStatus::class, 'nik_fk', 'nik');
    }

    public function dataDokumen()
    {
        return $this->hasOne(DataDokumen::class, 'nik_fk', 'nik');
    }
}