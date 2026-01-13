<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataDokumensTable extends Migration
{
    public function up()
    {
        Schema::create('data_dokumens', function (Blueprint $table) {
            $table->string('nik_fk', 16)->primary();
            $table->string('no_paspor', 25)->nullable();
            $table->string('no_kitap', 25)->nullable();
            $table->foreign('nik_fk')
                  ->references('nik')
                  ->on('anggota_keluargas')
                  ->cascadeOnDelete();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('data_dokumens');
    }
}