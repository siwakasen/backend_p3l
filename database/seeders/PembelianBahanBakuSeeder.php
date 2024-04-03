<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PembelianBahanBakuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * INSERT INTO `pembelian_bahan_baku` (`id_pembelian`, `id_bahan_baku`, `jumlah`, `harga`, `tanggal_pembelian`) VALUES
     *(1, 1, 100, 500000, '2024-03-25'),
     *(2, 2, 50, 200000, '2024-03-25'),
     *(3, 3, 60, 150000, '2024-03-25'),
     *(4, 4, 200, 300000, '2024-03-26'),
     *(5, 5, 80, 180000, '2024-03-26'),
     *(6, 6, 25, 100000, '2024-03-27'),
     *(7, 7, 10, 50000, '2024-03-27'),
     *(8, 8, 30, 120000, '2024-03-27'),
     *(9, 9, 50, 75000, '2024-03-28'),
     *(10, 10, 100, 250000, '2024-03-28'),
     *(11, 11, 20, 80000, '2024-03-29'),
     *(12, 12, 10, 40000, '2024-03-29'),
     *(13, 13, 15, 60000, '2024-03-30'),
     *(14, 14, 20, 90000, '2024-03-30'),
     *(15, 15, 200, 1000000, '2024-03-31'),
     *(16, 16, 50, 150000, '2024-03-31'),
     *(17, 17, 80, 300000, '2024-04-01'),
     *(18, 18, 60, 240000, '2024-04-01');
     */
    public function run(): void
    {
        DB::table('pembelian_bahan_baku')->insert(
            [
                ['id_pembelian' => 1, 'id_bahan_baku' => 1, 'jumlah' => 100, 'harga' => 500000, 'tanggal_pembelian' => '2024-03-25','created_at'=>now(),'updated_at'=>now()],
                ['id_pembelian' => 2, 'id_bahan_baku' => 2, 'jumlah' => 50, 'harga' => 200000, 'tanggal_pembelian' => '2024-03-25','created_at'=>now(),'updated_at'=>now()],
                ['id_pembelian' => 3, 'id_bahan_baku' => 3, 'jumlah' => 60, 'harga' => 150000, 'tanggal_pembelian' => '2024-03-25','created_at'=>now(),'updated_at'=>now()],
                ['id_pembelian' => 4, 'id_bahan_baku' => 4, 'jumlah' => 200, 'harga' => 300000, 'tanggal_pembelian' => '2024-03-26','created_at'=>now(),'updated_at'=>now()],
                ['id_pembelian' => 5, 'id_bahan_baku' => 5, 'jumlah' => 80, 'harga' => 180000, 'tanggal_pembelian' => '2024-03-26','created_at'=>now(),'updated_at'=>now()],
                ['id_pembelian' => 6, 'id_bahan_baku' => 6, 'jumlah' => 25, 'harga' => 100000, 'tanggal_pembelian' => '2024-03-27','created_at'=>now(),'updated_at'=>now()],
                ['id_pembelian' => 7, 'id_bahan_baku' => 7, 'jumlah' => 10, 'harga' => 50000, 'tanggal_pembelian' => '2024-03-27','created_at'=>now(),'updated_at'=>now()],
                ['id_pembelian' => 8, 'id_bahan_baku' => 8, 'jumlah' => 30, 'harga' => 120000, 'tanggal_pembelian' => '2024-03-27','created_at'=>now(),'updated_at'=>now()],
                ['id_pembelian' => 9, 'id_bahan_baku' => 9, 'jumlah' => 50, 'harga' => 75000, 'tanggal_pembelian' => '2024-03-28','created_at'=>now(),'updated_at'=>now()],
                ['id_pembelian' => 10, 'id_bahan_baku' => 10, 'jumlah' => 100, 'harga' => 250000, 'tanggal_pembelian' => '2024-03-28','created_at'=>now(),'updated_at'=>now()],
                ['id_pembelian' => 11, 'id_bahan_baku' => 11, 'jumlah' => 20, 'harga' => 80000, 'tanggal_pembelian' => '2024-03-29','created_at'=>now(),'updated_at'=>now()],
                ['id_pembelian' => 12, 'id_bahan_baku' => 12, 'jumlah' => 10, 'harga' => 40000, 'tanggal_pembelian' => '2024-03-29','created_at'=>now(),'updated_at'=>now()],
                ['id_pembelian' => 13, 'id_bahan_baku' => 13, 'jumlah' => 15, 'harga' => 60000, 'tanggal_pembelian' => '2024-03-30','created_at'=>now(),'updated_at'=>now()],
                ['id_pembelian' => 14, 'id_bahan_baku' => 14, 'jumlah' => 20, 'harga' => 90000, 'tanggal_pembelian' => '2024-03-30','created_at'=>now(),'updated_at'=>now()],
                ['id_pembelian' => 15, 'id_bahan_baku' => 15, 'jumlah' => 200, 'harga' => 1000000, 'tanggal_pembelian' => '2024-03-31','created_at'=>now(),'updated_at'=>now()],
                ['id_pembelian' => 16, 'id_bahan_baku' => 16, 'jumlah' => 50, 'harga' => 150000, 'tanggal_pembelian' => '2024-03-31','created_at'=>now(),'updated_at'=>now()],
                ['id_pembelian' => 17, 'id_bahan_baku' => 17, 'jumlah' => 80, 'harga' => 300000, 'tanggal_pembelian' => '2024-04-01','created_at'=>now(),'updated_at'=>now()],
                ['id_pembelian' => 18, 'id_bahan_baku' => 18, 'jumlah' => 60, 'harga' => 240000, 'tanggal_pembelian' => '2024-04-01','created_at'=>now(),'updated_at'=>now()]
            ]
            );
    }
}
