<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataDokumenTable extends Migration
{
    public function up()
    {
        Schema::create('data_dokumen', function (Blueprint $table) {
            $table->string('no_paspor', 25)->nullable(false);
            $table->string('no_kitap', 25)->nullable(false);
            $table->string('nik_fk', 16)->nullable(false); // Foreign key ke anggot_keluarga
            $table->foreign('nik_fk')->references('nik')->on('anggot_keluarga');
        });
    }

    public function down()
    {
        Schema::dropIfExists('data_dokumen');
    }
}