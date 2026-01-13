<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pendidikan extends Model
{
    protected $table = 'pendidikans';
     protected $primaryKey = 'nik_fk';
    protected $fillable = ['nik_fk','nama'];
    public $timestamps = false;

    public function anggota()
    {
        return $this->hasMany(DataStatus::class, 'pendidikan_id', 'id');
    }
}
