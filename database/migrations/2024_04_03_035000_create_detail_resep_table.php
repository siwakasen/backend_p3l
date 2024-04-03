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
        Schema::create('detail_resep', function (Blueprint $table) {
            $table->foreignId('id_bahan_baku')->references('id_bahan_baku')->on('bahan_baku')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('id_resep')->references('id_resep')->on('resep')->cascadeOnDelete()->cascadeOnUpdate();
            $table->integer('jumlah');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_resep');
    }
};
