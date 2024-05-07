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
        Schema::create('pengeluaran_lain', function (Blueprint $table) {
            $table->id('id_pengeluaran');
            $table->string('nama_pengeluaran');
            $table->double('nominal_pengeluaran');
            $table->date('tanggal_pengeluaran');
            $table->boolean('status_pengeluaran_lain')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengeluaran_lain');
    }
};
