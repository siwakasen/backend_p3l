<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pembelian_bahan_baku', function (Blueprint $table) {
            $table->id('id_pembelian');
            $table->foreignId('id_bahan_baku')->references('id_bahan_baku')->on('bahan_baku')->cascadeOnDelete()->cascadeOnUpdate();
            $table->integer('jumlah');
            $table->double('harga');
            $table->date('tanggal_pembelian');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembelian_bahan_baku');
    }
};
