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
        Schema::create('pesanan', function (Blueprint $table) {
            $table->id('id_pesanan');
            $table->foreignId('id_user')->references('id_user')->on('users')->restrictOnDelete()->restrictOnUpdate();
            $table->string('no_nota', 100)->nullable();
            $table->string('metode_pemesanan', 100)->nullable();
            $table->string('metode_pengiriman', 100)->nullable();
            $table->string('bukti_pembayaran')->nullable();
            $table->double('ongkir')->nullable();
            $table->double('total_harga')->nullable();
            $table->double('total_bayar')->nullable();
            $table->string('status_transaksi', 100);
            $table->dateTime('tanggal_pesanan')->nullable();
            $table->dateTime('tanggal_diambil')->nullable();
            $table->dateTime('tanggal_pembayaran')->nullable();
            $table->text('alamat_pengiriman')->nullable();
            $table->double('tip')->nullable();
            $table->integer('poin_dipakai')->nullable();
            $table->integer('poin_didapat')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanan');
    }
};
