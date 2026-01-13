<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgamasTable extends Migration
{
    public function up()
    {
        Schema::create('agamas', function (Blueprint $table) {
            $table->string('nik_fk', 16)->primary();
            $table->enum('nama', [
                'ISLAM',
                'KONGHUCU',
                'KATOLIK',
                'KRISTEN',
                'HINDU',
                'BUDDHA'
            ]);
            $table->foreign('nik_fk')
                    ->references('nik')
                    ->on('anggota_keluargas')
                    ->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('agamas');
    }
}
