<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePendidikanTable extends Migration
{
    public function up()
    {
        Schema::create('pendidikan', function (Blueprint $table) {
            $table->integer('id_pendidikan')->primary(); // Primary key, bukan auto-increment
            $table->string('pendidikan', 255)->nullable(false);
        });
    }

    public function down()
    {
        Schema::dropIfExists('pendidikan');
    }
}