<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('riwayats', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->id('id_riwayat');
            $table->date('tanggal_riwayat');
            $table->string('jenis_layanan');
            $table->timestamps();

            // Kolom foreign key harus memiliki tipe yang sama
            $table->unsignedBigInteger('id_detail_transaksi');
            $table->unsignedBigInteger('id_layanan');

            // Definisikan foreign key constraints
            $table->foreign('id_detail_transaksi')
                ->references('id_detail_transaksi')
                ->on('detail_transaksis')
                ->onDelete('cascade');

            $table->foreign('id_layanan')
                ->references('id_layanan')
                ->on('layanans')
                ->onDelete('cascade');
        });
    }
};
