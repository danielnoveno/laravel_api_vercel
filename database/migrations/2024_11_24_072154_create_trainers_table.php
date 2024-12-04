<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('trainers', function (Blueprint $table) {
            $table->id('id_trainer');
            $table->string('nama');
            $table->integer('umur');
            $table->integer('lama_pengalaman');
            $table->enum('spesialis', ['Fitness', 'Yoga', 'Aerobics', 'Strength Training']);
            $table->unsignedBigInteger('id_paket_personal_trainer');
            $table->timestamps();

            $table->foreign('id_paket_personal_trainer')->references('id_paket_personal_trainer')->on('personal_trainers')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('trainers');
    }
};
