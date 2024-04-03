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
        Schema::create('karyawan', function (Blueprint $table) {
            $table->id('id_karyawan');
            $table->foreignId('id_role')->references('id_role')->on('roles')->restrictOnDelete()->restrictOnUpdate();
            $table->string('nama_karyawan');
            $table->string('email')->unique();
            $table->string('password');
            $table->date('tanggal_masuk');
            $table->double('bonus_gaji');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('karyawan');
    }
};
