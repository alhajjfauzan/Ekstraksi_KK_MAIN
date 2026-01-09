<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agama extends Model
{
    protected $table = 'agamas'; 
    protected $fillable = ['nama']; 
    public $timestamps = true;

    public function dataStatus()
    {
        return $this->hasMany(DataStatus::class, 'agama_id', 'id');
    }
}
