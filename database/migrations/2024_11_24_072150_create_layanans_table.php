<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('layanans', function (Blueprint $table) {
            $table->id('id_layanan');
            $table->string('nama_layanan');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('layanans');
    }
};
