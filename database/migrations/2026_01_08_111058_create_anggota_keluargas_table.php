<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnggotaKeluargasTable extends Migration
{
    public function up()
    {
        Schema::create('anggota_keluargas', function (Blueprint $table) {
            $table->string('nik', 16)->primary(); 
            $table->string('nama_lengkap', 255);
            $table->date('tanggal_perkawinan')->nullable();
            $table->enum('jenis_kelamin', ['LAKI-LAKI', 'PEREMPUAN']);
            $table->enum('status_hubungan', [
                'KEPALA KELUARGA',
                'ISTERI',
                'ISTRI',
                'ANAK',
                'MENANTU',
                'CUCU',
                'ORANG TUA',
                'MERTUA',
                'SAUDARA',
                'PEMBANTU',
                'LAINNYA'
            ]);

             $table->string('kartu_keluarga_id', 16); 
             $table->foreign('kartu_keluarga_id')->references('no_kk')->on('kartu_keluargas')->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('anggota_keluargas');
    }
}
