<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgamaTable extends Migration
{
    public function up()
    {
        Schema::create('agama', function (Blueprint $table) {
            $table->integer('id_agama')->primary(); // Primary key, bukan auto-increment
            $table->enum('agama', ['ISLAM', 'KONGHUCU', 'KATOLIK', 'KRISTEN', 'HINDU', 'BUDDHA'])->nullable(false);
        });
    }

    public function down()
    {
        Schema::dropIfExists('agama');
    }
}