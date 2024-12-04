<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('jadwals', function (Blueprint $table) {
            $table->id('id_jadwal');
            $table->date('tanggal');
            $table->integer('bulan');
            $table->integer('tahun');
            $table->time('waktu');
            $table->unsignedBigInteger('id_ruangan');
            $table->unsignedBigInteger('id_trainer');
            $table->timestamps();

            $table->foreign('id_ruangan')->references('id_ruangan')->on('ruangans')->onDelete('cascade');
            $table->foreign('id_trainer')->references('id_trainer')->on('trainers')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('jadwals');
    }
};
