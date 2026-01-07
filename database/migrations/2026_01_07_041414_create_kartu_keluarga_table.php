<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKartuKeluargaTable extends Migration
{
    public function up()
    {
        Schema::create('kartu_keluarga', function (Blueprint $table) {
            $table->string('no_kk', 16)->primary(); // Primary key
            $table->string('kepala_keluarga', 255)->nullable(false);
            $table->string('kelurahan', 255)->nullable(false);
            $table->string('kecamatan', 255)->nullable(false);
            $table->string('kabupaten', 255)->nullable(false);
            $table->string('provinsi', 255)->nullable(false);
            $table->string('alamat', 255)->nullable(false);
            $table->string('kode_pos', 10)->nullable(false);
            $table->string('rt', 3)->nullable(false);
            $table->string('rw', 3)->nullable(false);
        });
    }

    public function down()
    {
        Schema::dropIfExists('kartu_keluarga');
    }
}