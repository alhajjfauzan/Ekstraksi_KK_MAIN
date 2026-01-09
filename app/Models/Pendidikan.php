<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pendidikan extends Model
{
    protected $table = 'pendidikans'; 
    protected $fillable = ['nama'];
    public $timestamps = false;

    public function dataStatus()
    {
        return $this->hasMany(DataStatus::class, 'pendidikan_id', 'id');
    }
}
