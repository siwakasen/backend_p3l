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
        Schema::create('detail_pesanan', function (Blueprint $table) {
            $table->foreignId('id_produk')->nullable()->references('id_produk')->on('produk')->restrictOnDelete()->restrictOnUpdate();
            $table->foreignId('id_hampers')->nullable()->references('id_hampers')->on('hampers')->restrictOnDelete()->restrictOnUpdate();
            $table->foreignId('id_pesanan')->references('id_pesanan')->on('pesanan')->restrictOnDelete()->restrictOnUpdate();
            $table->string('status_pesanan', 100)->nullable();
            $table->integer('jumlah');
            $table->double('subtotal');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_pesanan');
    }
};
