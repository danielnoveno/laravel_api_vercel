<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pelanggans', function (Blueprint $table) {
            $table->id('id_pelanggan');
            $table->string('nama');
            $table->integer('umur');
            $table->string('alamat');
            $table->string('no_telepon');
            $table->string('email');
            $table->string('password');
            $table->timestamp('tanggal_daftar')->useCurrent();
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('pelanggans');
    }
};
