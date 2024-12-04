<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('ruangans', function (Blueprint $table) {
            $table->id('id_ruangan');
            $table->integer('kapasitas');
            $table->string('nama_ruangan');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ruangans');
    }
};
