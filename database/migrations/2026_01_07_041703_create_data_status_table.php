<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataStatusTable extends Migration
{
    public function up()
    {
        Schema::create('data_status', function (Blueprint $table) {
            $table->string('pekerjaan', 255)->nullable(false);
            $table->enum('gol_darah', ['A', 'B', 'AB', 'O', 'A-', 'A+', 'B-', 'B+', 'AB+', 'O-', 'O+', 'AB-'])->nullable(false);
            $table->enum('status_perkawinan', ['BELUM KAWIN', 'KAWIN', 'KAWIN TERCATAT', 'KAWIN TIDAK TERCATAT', 'CERAI HIDUP', 'CERAI MATI'])->nullable(false);
            $table->enum('kewarganegaraan', ['WNA', 'WNI'])->nullable(false);
            $table->integer('agama_id')->nullable(false); // Foreign key ke agama
            $table->integer('pendidikan_id')->nullable(false); // Foreign key ke pendidikan
            $table->string('nik_fk', 16)->nullable(false); // Foreign key ke anggot_keluarga
            $table->foreign('agama_id')->references('id_agama')->on('agama');
            $table->foreign('pendidikan_id')->references('id_pendidikan')->on('pendidikan');
            $table->foreign('nik_fk')->references('nik')->on('anggot_keluarga');
        });
    }

    public function down()
    {
        Schema::dropIfExists('data_status');
    }
}