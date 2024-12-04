<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('jenis_memberships', function (Blueprint $table) {
            $table->id('id_jenis_membership');
            $table->string('nama_jenis_membership');
            $table->decimal('harga_membership', 10, 2);
            $table->string('jadwal');
            $table->integer('durasi');
            $table->text('deskripsi');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('jenis_memberships');
    }
};
