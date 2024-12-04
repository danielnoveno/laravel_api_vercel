<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('kelas_olahragas', function (Blueprint $table) {
            $table->id('id_kelas');
            $table->string('nama_olahraga');
            $table->integer('kapasitas');
            $table->unsignedBigInteger('id_jadwal');
            $table->unsignedBigInteger('id_ruangan');
            $table->unsignedBigInteger('id_coach');
            $table->text('deskripsi');
            $table->timestamps();

            $table->foreign('id_jadwal')->references('id_jadwal')->on('jadwals')->onDelete('cascade');
            $table->foreign('id_ruangan')->references('id_ruangan')->on('ruangans')->onDelete('cascade');
            $table->foreign('id_coach')->references('id_coach')->on('coaches')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('kelas_olahragas');
    }
};
