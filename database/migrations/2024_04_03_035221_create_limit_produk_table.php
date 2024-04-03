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
        Schema::create('limit_produk', function (Blueprint $table) {
            $table->id('id_limit_produk');
            $table->foreignId('id_produk')->references('id_produk')->on('produk')->cascadeOnDelete()->cascadeOnUpdate();
            $table->integer('limit');
            $table->date('tanggal');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('limit_produk');
    }
};
