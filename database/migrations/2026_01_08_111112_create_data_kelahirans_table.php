<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataKelahiransTable extends Migration
{
    public function up()
    {
        Schema::create('data_kelahirans', function (Blueprint $table) {
            $table->string('nik_fk', 16)->primary();
            $table->string('tempat_lahir', 255);
            $table->date('tanggal_lahir');
            $table->string('nama_ayah', 255);
            $table->string('nama_ibu', 255);

            $table->foreign('nik_fk')
                  ->references('nik')
                  ->on('anggota_keluargas')
                  ->cascadeOnDelete();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('data_kelahirans');
    }
}
