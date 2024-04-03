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
        Schema::create('produk', function (Blueprint $table) {
            $table->id('id_produk');
            $table->foreignId('id_kategori')->references('id_kategori')->on('kategori')->restrictOnDelete()->restrictOnUpdate();
            $table->foreignId('id_penitip')->nullable()->references('id_penitip')->on('penitip')->restrictOnDelete()->restrictOnUpdate();
            $table->foreignId('id_resep')->nullable()->references('id_resep')->on('resep')->restrictOnDelete()->restrictOnUpdate();
            $table->string('nama_produk');
            $table->string('foto_produk');
            $table->text('deskripsi_produk');
            $table->double('harga_produk');
            $table->integer('stok_produk')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produk');
    }
};
