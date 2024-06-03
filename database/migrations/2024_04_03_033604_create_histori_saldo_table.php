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
        Schema::create('histori_saldo', function (Blueprint $table) {
            $table->id('id_histori_saldo');
            $table->foreignId('id_user')->references('id_user')->on('users')->restrictOnDelete()->restrictOnUpdate();
            $table->double('nominal_saldo');
            $table->string('keterangan_transaksi', 100);
            $table->dateTime('tanggal_pengajuan');
            $table->dateTime('tanggal_konfirmasi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('histori_saldo');
    }
};
