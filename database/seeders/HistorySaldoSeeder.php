<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HistorySaldoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * INSERT INTO `histori_saldo` (`id_histori_saldo`, `id_user`, `nominal`, `jenis_transaksi`, `tanggal`) VALUES
     *(1, 1, 205000, 'Pengembalian Saldo', '2024-03-01'),
     *(2, 4, 305000, 'Pengembalian Saldo', '2024-03-04'),
     *(3, 3, 105000, 'Pengembalian Saldo', '2024-03-06'),
     *(4, 6, 105000, 'Pengembalian Saldo', '2024-03-10'),
     *(5, 2, 305000, 'Pengembalian Saldo', '2024-03-14'),
     *(6, 2, 200000, 'Penarikan Saldo', '2024-03-15'),
     *(7, 4, 200000, 'Penarikan Saldo', '2024-03-04');
     */
    public function run(): void
    {
        //DB::table('histori_saldo')->delete();
        DB::table('histori_saldo')->insert(
            [
                ['id_histori_saldo' => 1, 'id_user' => 1, 'nominal_saldo' => 205000, 'keterangan_transaksi' => 'Pengembalian Saldo', 'tanggal_transaksi' => '2024-03-01','created_at' => now(),'updated_at' => now()],
                ['id_histori_saldo' => 2, 'id_user' => 4, 'nominal_saldo' => 305000, 'keterangan_transaksi' => 'Pengembalian Saldo', 'tanggal_transaksi' => '2024-03-04','created_at' => now(),'updated_at' => now()],
                ['id_histori_saldo' => 3, 'id_user' => 3, 'nominal_saldo' => 105000, 'keterangan_transaksi' => 'Pengembalian Saldo', 'tanggal_transaksi' => '2024-03-06','created_at' => now(),'updated_at' => now()],
                ['id_histori_saldo' => 4, 'id_user' => 6, 'nominal_saldo' => 105000, 'keterangan_transaksi' => 'Pengembalian Saldo', 'tanggal_transaksi' => '2024-03-10','created_at' => now(),'updated_at' => now()],
                ['id_histori_saldo' => 5, 'id_user' => 2, 'nominal_saldo' => 305000, 'keterangan_transaksi' => 'Pengembalian Saldo', 'tanggal_transaksi' => '2024-03-14','created_at' => now(),'updated_at' => now()],
                ['id_histori_saldo' => 6, 'id_user' => 2, 'nominal_saldo' => 200000, 'keterangan_transaksi' => 'Penarikan Saldo', 'tanggal_transaksi' => '2024-03-15','created_at' => now(),'updated_at' => now()],
                ['id_histori_saldo' => 7, 'id_user' => 4, 'nominal_saldo' => 200000, 'keterangan_transaksi' => 'Penarikan Saldo', 'tanggal_transaksi' => '2024-03-04','created_at' => now(),'updated_at' => now()]
            ]
            );
    }
}
