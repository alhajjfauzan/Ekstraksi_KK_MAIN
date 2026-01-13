<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePendidikansTable extends Migration
{
    public function up()
    {
        Schema::create('pendidikans', function (Blueprint $table) {
            $table->string('nik_fk', 16)->unique();
            $table->string('nama', 255)->nullable();
            $table->timestamps();

            $table->foreign('nik_fk')
                ->references('nik')
                ->on('anggota_keluargas')
                ->cascadeOnDelete();
        });
    }
    public function down()
    {
        Schema::dropIfExists('pendidikans');
    }
}
