<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('review_trainers', function (Blueprint $table) {
            $table->id('id_review');
            $table->date('tanggal_review');
            $table->text('review');
            $table->unsignedBigInteger('id_trainer');
            $table->unsignedBigInteger('id_pelanggan');
            $table->timestamps();

            $table->foreign('id_trainer')->references('id_trainer')->on('trainers')->onDelete('cascade');
            $table->foreign('id_pelanggan')->references('id_pelanggan')->on('pelanggans')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('review_trainers');
    }
};
