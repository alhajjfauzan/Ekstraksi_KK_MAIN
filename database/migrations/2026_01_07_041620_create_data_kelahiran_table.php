<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataKelahiranTable extends Migration
{
    public function up()
    {
        Schema::create('data_kelahiran', function (Blueprint $table) {
            $table->string('tempat_lahir', 255)->nullable(false);
            $table->date('tanggal_lahir')->nullable(false);
            $table->string('nama_ayah', 255)->nullable(false);
            $table->string('nama_ibu', 255)->nullable(false);
            $table->string('nik_fk', 16)->nullable(false); // Foreign key ke anggot_keluarga
            $table->foreign('nik_fk')->references('nik')->on('anggot_keluarga');
        });
    }

    public function down()
    {
        Schema::dropIfExists('data_kelahiran');
    }
}