<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::create('personal_trainers', function (Blueprint $table) {
        $table->id('id_paket_personal_trainer');
        $table->string('nama_paket');
        $table->decimal('harga', 10, 2);
        $table->text('deskripsi');
        $table->timestamps();
    });
}

public function down()
{
    Schema::dropIfExists('personal_trainers');
}

};
