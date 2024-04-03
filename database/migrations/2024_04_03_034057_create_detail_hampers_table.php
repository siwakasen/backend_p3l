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
        Schema::create('detail_hampers', function (Blueprint $table) {
            $table->foreignId('id_produk')->nullable()->references('id_produk')->on('produk')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('id_bahan_baku')->nullable()->references('id_bahan_baku')->on('bahan_baku')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('id_hampers')->references('id_hampers')->on('hampers')->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_hampers');
    }
};
