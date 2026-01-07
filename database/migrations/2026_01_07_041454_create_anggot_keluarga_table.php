<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnggotKeluargaTable extends Migration
{
    public function up()
    {
        Schema::create('anggot_keluarga', function (Blueprint $table) {
            $table->string('nik', 16)->primary(); // Primary key
            $table->string('nama_anggota', 255)->nullable(false);
            $table->enum('jenis_kelamin', ['LAKI-LAKI', 'PEREMPUAN'])->nullable(false);
            $table->enum('status_hubungan', ['KEPALA KELUARGA', 'ISTERI', 'ANAK', 'LAINNYA'])->nullable(false);
            $table->string('no_kk_id', 16)->nullable(false); // Foreign key ke kartu_keluarga
            $table->foreign('no_kk_id')->references('no_kk')->on('kartu_keluarga');
        });
    }

    public function down()
    {
        Schema::dropIfExists('anggot_keluarga');
    }
}