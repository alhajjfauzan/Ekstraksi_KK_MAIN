<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKartuKeluargasTable extends Migration
{
    public function up()
    {
        Schema::create('kartu_keluargas', function (Blueprint $table) {
            // $table->string('id', 16)->primary();
            $table->string('no_kk', 16)->primary(); 
            $table->string('kepala_keluarga', 255);
            $table->string('alamat', 255);
            $table->string('kelurahan', 255);
            $table->string('kecamatan', 255);
            $table->string('kabupaten', 255);
            $table->string('provinsi', 255);
            $table->string('kode_pos', 10);
            $table->string('rt', 3);
            $table->string('rw', 3);
            $table->date('tanggal_dikeluarkan'); 
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('kartu_keluargas');
    }
}