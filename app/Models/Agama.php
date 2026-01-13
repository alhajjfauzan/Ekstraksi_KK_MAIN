<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agama extends Model
{
    protected $table = 'agamas';
     protected $primaryKey = 'nik_fk'; 
    protected $fillable = ['nik_fk','nama']; 
    public $timestamps = true;

    public function anggota()
    {
        return $this->belongsTo(AnggotaKeluarga::class, 'nik_fk', 'nik');
    }
}
