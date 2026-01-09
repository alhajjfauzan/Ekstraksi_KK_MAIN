<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataStatusesTable extends Migration
{
    public function up()
    {
        Schema::create('data_statuses', function (Blueprint $table) {
            $table->id();

            $table->string('nik_fk', 16)->unique();

            $table->string('pekerjaan', 255);

            $table->enum('golongan_darah', [
                'A', 'B', 'AB', 'O',
                'A+', 'A-', 'B+', 'B-',
                'AB+', 'AB-', 'O+', 'O-'
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

            $table->unsignedBigInteger('agama_id');
            $table->unsignedBigInteger('pendidikan_id');

            $table->foreign('nik_fk')
                ->references('nik')
                ->on('anggota_keluargas')
                ->cascadeOnDelete();

            $table->foreign('agama_id')
                ->references('id')
                ->on('agamas');

            $table->foreign('pendidikan_id')
                ->references('id')
                ->on('pendidikans');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('data_statuses');
    }
}
