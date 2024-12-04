<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('alat_gyms', function (Blueprint $table) {
            $table->id('id_alat');
            $table->string('nama_alat');
            $table->string('kategori');
            $table->enum('status', ['available', 'unavailable']);
            $table->decimal('harga', 8, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('alat_gyms');
    }
};
