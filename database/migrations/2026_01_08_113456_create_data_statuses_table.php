<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataStatusesTable extends Migration
{
    public function up()
    {
        Schema::create('data_statuses', function (Blueprint $table) {
            $table->string('nik_fk', 16)->unique();
            $table->string('pekerjaan', 255)->nullable();
            $table->enum('golongan_darah', [
                'A', 'B', 'AB', 'O',
                'A+', 'A-', 'B+', 'B-',
                'AB+', 'AB-', 'O+', 'O-','TIDAK TAHU'
            ]);

            $table->enum('status_perkawinan', [
                'BELUM KAWIN',
                'KAWIN',
                'KAWIN TERCATAT',
                'KAWIN TIDAK TERCATAT',
                'CERAI HIDUP',
                'CERAI MATI'
            ]);

            $table->enum('kewarganegaraan', ['WNI', 'WNA']);
            $table->foreign('nik_fk')
                ->references('nik')
                ->on('anggota_keluargas')
                ->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('data_statuses');
    }
}
