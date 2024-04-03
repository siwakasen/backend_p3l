<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DetailPesananSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * INSERT INTO `detail_pesanan` (`id_produk`, `id_hampers`, `id_pesanan`, `jumlah`, `subtotal`) VALUES
     *(10, NULL, 1, 1, 200000),
     *(10, NULL, 2, 1, 200000),
     *(10, NULL, 3, 1, 200000),
     *(15, NULL, 4, 1, 100000),
     *(15, NULL, 5, 1, 100000),
     *(4, NULL, 6, 1, 300000),
     *(4, NULL, 7, 1, 300000),
     *(15, NULL, 8, 1, 100000),
     *(15, NULL, 9, 1, 100000),
     *(18, NULL, 10, 1, 300000),
     *(15, NULL, 11, 1, 100000),
     *(10, NULL, 12, 1, 200000),
     *(10, NULL, 13, 1, 200000),
     *(10, NULL, 14, 1, 200000),
     *(15, NULL, 15, 1, 100000),
     *(18, NULL, 15, 1, 300000),
     *(16, NULL, 16, 1, 75000),
     *(NULL, 1, 17, 1, 65000),
     *(NULL, 3, 18, 1, 350000);
     */
    public function run(): void
    {
        DB::table('detail_pesanan')->insert(
            [
                ['id_produk' => 10, 'id_hampers' => NULL, 'id_pesanan' => 1, 'jumlah' => 1, 'subtotal' => 200000,'created_at'=>now(),'updated_at'=>now()],
                ['id_produk' => 10, 'id_hampers' => NULL, 'id_pesanan' => 2, 'jumlah' => 1, 'subtotal' => 200000,'created_at'=>now(),'updated_at'=>now()],
                ['id_produk' => 10, 'id_hampers' => NULL, 'id_pesanan' => 3, 'jumlah' => 1, 'subtotal' => 200000,'created_at'=>now(),'updated_at'=>now()],
                ['id_produk' => 15, 'id_hampers' => NULL, 'id_pesanan' => 4, 'jumlah' => 1, 'subtotal' => 100000,'created_at'=>now(),'updated_at'=>now()],
                ['id_produk' => 15, 'id_hampers' => NULL, 'id_pesanan' => 5, 'jumlah' => 1, 'subtotal' => 100000,'created_at'=>now(),'updated_at'=>now()],
                ['id_produk' => 4, 'id_hampers' => NULL, 'id_pesanan' => 6, 'jumlah' => 1, 'subtotal' => 300000,'created_at'=>now(),'updated_at'=>now()],
                ['id_produk' => 4, 'id_hampers' => NULL, 'id_pesanan' => 7, 'jumlah' => 1, 'subtotal' => 300000,'created_at'=>now(),'updated_at'=>now()],
                ['id_produk' => 15, 'id_hampers' => NULL, 'id_pesanan' => 8, 'jumlah' => 1, 'subtotal' => 100000,'created_at'=>now(),'updated_at'=>now()],
                ['id_produk' => 15, 'id_hampers' => NULL, 'id_pesanan' => 9, 'jumlah' => 1, 'subtotal' => 100000,'created_at'=>now(),'updated_at'=>now()],
                ['id_produk' => 18, 'id_hampers' => NULL, 'id_pesanan' => 10, 'jumlah' => 1, 'subtotal' => 300000,'created_at'=>now(),'updated_at'=>now()],
                ['id_produk' => 15, 'id_hampers' => NULL, 'id_pesanan' => 11, 'jumlah' => 1, 'subtotal' => 100000,'created_at'=>now(),'updated_at'=>now()],
                ['id_produk' => 10, 'id_hampers' => NULL, 'id_pesanan' => 12, 'jumlah' => 1, 'subtotal' => 200000,'created_at'=>now(),'updated_at'=>now()],
                ['id_produk' => 10, 'id_hampers' => NULL, 'id_pesanan' => 13, 'jumlah' => 1, 'subtotal' => 200000,'created_at'=>now(),'updated_at'=>now()],
                ['id_produk' => 10, 'id_hampers' => NULL, 'id_pesanan' => 14, 'jumlah' => 1, 'subtotal' => 200000,'created_at'=>now(),'updated_at'=>now()],
                ['id_produk' => 15, 'id_hampers' => NULL, 'id_pesanan' => 15, 'jumlah' => 1, 'subtotal' => 100000,'created_at'=>now(),'updated_at'=>now()],
                ['id_produk' => 18, 'id_hampers' => NULL, 'id_pesanan' => 15, 'jumlah' => 1, 'subtotal' => 300000,'created_at'=>now(),'updated_at'=>now()],
                ['id_produk' => 16, 'id_hampers' => NULL, 'id_pesanan' => 16, 'jumlah' => 1, 'subtotal' => 75000,'created_at'=>now(),'updated_at'=>now()],
                ['id_produk' => NULL, 'id_hampers' => 1, 'id_pesanan' => 17, 'jumlah' => 1, 'subtotal' => 65000,'created_at'=>now(),'updated_at'=>now()],
                ['id_produk' => NULL, 'id_hampers' => 3, 'id_pesanan' => 18, 'jumlah' => 1, 'subtotal' => 350000,'created_at'=>now(),'updated_at'=>now()]
            ]
        );
    }
}
