<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LimitProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.`
     */
    public function run(): void
    {
        //DB::table('limit_produk')->delete();
        DB::table('limit_produk')->insert(
            [
                ['id_limit_produk' => 1, 'id_produk' => 1, 'limit' => 10, 'tanggal' => '2024-03-23','created_at'=>now(),'updated_at'=>now()],
                ['id_limit_produk' => 2, 'id_produk' => 1, 'limit' => 10, 'tanggal' => '2024-03-24','created_at'=>now(),'updated_at'=>now()],
                ['id_limit_produk' => 3, 'id_produk' => 1, 'limit' => 10, 'tanggal' => '2024-03-25','created_at'=>now(),'updated_at'=>now()],
                ['id_limit_produk' => 4, 'id_produk' => 1, 'limit' => 10, 'tanggal' => '2024-03-26','created_at'=>now(),'updated_at'=>now()],
                ['id_limit_produk' => 5, 'id_produk' => 1, 'limit' => 10, 'tanggal' => '2024-03-27','created_at'=>now(),'updated_at'=>now()],
                ['id_limit_produk' => 6, 'id_produk' => 1, 'limit' => 10, 'tanggal' => '2024-03-28','created_at'=>now(),'updated_at'=>now()],
                ['id_limit_produk' => 7, 'id_produk' => 1, 'limit' => 10, 'tanggal' => '2024-03-29','created_at'=>now(),'updated_at'=>now()],
                ['id_limit_produk' => 8, 'id_produk' => 2, 'limit' => 10, 'tanggal' => '2024-03-23','created_at'=>now(),'updated_at'=>now()],
                ['id_limit_produk' => 9, 'id_produk' => 2, 'limit' => 10, 'tanggal' => '2024-03-24','created_at'=>now(),'updated_at'=>now()],
                ['id_limit_produk' => 10, 'id_produk' => 2, 'limit' => 10, 'tanggal' => '2024-03-25','created_at'=>now(),'updated_at'=>now()],
                ['id_limit_produk' => 11, 'id_produk' => 2, 'limit' => 10, 'tanggal' => '2024-03-26','created_at'=>now(),'updated_at'=>now()],
                ['id_limit_produk' => 12, 'id_produk' => 2, 'limit' => 10, 'tanggal' => '2024-03-27','created_at'=>now(),'updated_at'=>now()],
                ['id_limit_produk' => 13, 'id_produk' => 2, 'limit' => 10, 'tanggal' => '2024-03-28','created_at'=>now(),'updated_at'=>now()],
                ['id_limit_produk' => 14, 'id_produk' => 2, 'limit' => 10, 'tanggal' => '2024-03-29','created_at'=>now(),'updated_at'=>now()],
                ['id_limit_produk' => 15, 'id_produk' => 3, 'limit' => 10, 'tanggal' => '2024-03-23','created_at'=>now(),'updated_at'=>now()],
                ['id_limit_produk' => 16, 'id_produk' => 3, 'limit' => 10, 'tanggal' => '2024-03-24','created_at'=>now(),'updated_at'=>now()],
                ['id_limit_produk' => 17, 'id_produk' => 3, 'limit' => 10, 'tanggal' => '2024-03-25','created_at'=>now(),'updated_at'=>now()],
                ['id_limit_produk' => 18, 'id_produk' => 3, 'limit' => 10, 'tanggal' => '2024-03-26','created_at'=>now(),'updated_at'=>now()],
                ['id_limit_produk' => 19, 'id_produk' => 3, 'limit' => 10, 'tanggal' => '2024-03-27','created_at'=>now(),'updated_at'=>now()],
                ['id_limit_produk' => 20, 'id_produk' => 3, 'limit' => 10, 'tanggal' => '2024-03-28','created_at'=>now(),'updated_at'=>now()],
                ['id_limit_produk' => 21, 'id_produk' => 3, 'limit' => 10, 'tanggal' => '2024-03-29','created_at'=>now(),'updated_at'=>now()],
                ['id_limit_produk' => 22, 'id_produk' => 4, 'limit' => 10, 'tanggal' => '2024-03-23','created_at'=>now(),'updated_at'=>now()],
                ['id_limit_produk' => 23, 'id_produk' => 4, 'limit' => 10, 'tanggal' => '2024-03-24','created_at'=>now(),'updated_at'=>now()],
                ['id_limit_produk' => 24, 'id_produk' => 4, 'limit' => 10, 'tanggal' => '2024-03-25','created_at'=>now(),'updated_at'=>now()],
                ['id_limit_produk' => 25, 'id_produk' => 4, 'limit' => 10, 'tanggal' => '2024-03-26','created_at'=>now(),'updated_at'=>now()],
                ['id_limit_produk' => 26, 'id_produk' => 4, 'limit' => 10, 'tanggal' => '2024-03-27','created_at'=>now(),'updated_at'=>now()],
                ['id_limit_produk' => 27, 'id_produk' => 4, 'limit' => 10, 'tanggal' => '2024-03-28','created_at'=>now(),'updated_at'=>now()],
                ['id_limit_produk' => 28, 'id_produk' => 4, 'limit' => 10, 'tanggal' => '2024-03-29','created_at'=>now(),'updated_at'=>now()],
                ['id_limit_produk' => 29, 'id_produk' => 5, 'limit' => 10, 'tanggal' => '2024-03-23','created_at'=>now(),'updated_at'=>now()],
                ['id_limit_produk' => 30, 'id_produk' => 5, 'limit' => 10, 'tanggal' => '2024-03-24','created_at'=>now(),'updated_at'=>now()],
                ['id_limit_produk' => 31, 'id_produk' => 5, 'limit' => 10, 'tanggal' => '2024-03-25','created_at'=>now(),'updated_at'=>now()],
                ['id_limit_produk' => 32, 'id_produk' => 5, 'limit' => 10, 'tanggal' => '2024-03-26','created_at'=>now(),'updated_at'=>now()],
                ['id_limit_produk' => 33, 'id_produk' => 5, 'limit' => 10, 'tanggal' => '2024-03-27','created_at'=>now(),'updated_at'=>now()],
                ['id_limit_produk' => 34, 'id_produk' => 5, 'limit' => 10, 'tanggal' => '2024-03-28','created_at'=>now(),'updated_at'=>now()],
                ['id_limit_produk' => 35, 'id_produk' => 5, 'limit' => 10, 'tanggal' => '2024-03-29','created_at'=>now(),'updated_at'=>now()],
                ['id_limit_produk' => 36, 'id_produk' => 6, 'limit' => 10, 'tanggal' => '2024-03-23','created_at'=>now(),'updated_at'=>now()],
                ['id_limit_produk' => 37, 'id_produk' => 6, 'limit' => 10, 'tanggal' => '2024-03-24','created_at'=>now(),'updated_at'=>now()],
                ['id_limit_produk' => 38, 'id_produk' => 6, 'limit' => 10, 'tanggal' => '2024-03-25','created_at'=>now(),'updated_at'=>now()],
                ['id_limit_produk' => 39, 'id_produk' => 6, 'limit' => 10, 'tanggal' => '2024-03-26','created_at'=>now(),'updated_at'=>now()],
                ['id_limit_produk' => 40, 'id_produk' => 6, 'limit' => 10, 'tanggal' => '2024-03-27','created_at'=>now(),'updated_at'=>now()],
                ['id_limit_produk' => 41, 'id_produk' => 6, 'limit' => 10, 'tanggal' => '2024-03-28','created_at'=>now(),'updated_at'=>now()],
                ['id_limit_produk' => 42, 'id_produk' => 6, 'limit' => 10, 'tanggal' => '2024-03-29','created_at'=>now(),'updated_at'=>now()],
                ['id_limit_produk' => 43, 'id_produk' => 7, 'limit' => 10, 'tanggal' => '2024-03-23','created_at'=>now(),'updated_at'=>now()],
                ['id_limit_produk' => 44, 'id_produk' => 7, 'limit' => 10, 'tanggal' => '2024-03-24','created_at'=>now(),'updated_at'=>now()],
                ['id_limit_produk' => 45, 'id_produk' => 7, 'limit' => 10, 'tanggal' => '2024-03-25','created_at'=>now(),'updated_at'=>now()],
                ['id_limit_produk' => 46, 'id_produk' => 7, 'limit' => 10, 'tanggal' => '2024-03-26','created_at'=>now(),'updated_at'=>now()],
                ['id_limit_produk' => 47, 'id_produk' => 7, 'limit' => 10, 'tanggal' => '2024-03-27','created_at'=>now(),'updated_at'=>now()],
                ['id_limit_produk' => 48, 'id_produk' => 7, 'limit' => 10, 'tanggal' => '2024-03-28','created_at'=>now(),'updated_at'=>now()],
                ['id_limit_produk' => 49, 'id_produk' => 7, 'limit' => 10, 'tanggal' => '2024-03-29','created_at'=>now(),'updated_at'=>now()],
                ['id_limit_produk' => 50, 'id_produk' => 8, 'limit' => 10, 'tanggal' => '2024-03-23','created_at'=>now(),'updated_at'=>now()],
                ['id_limit_produk' => 51, 'id_produk' => 8, 'limit' => 10, 'tanggal' => '2024-03-24','created_at'=>now(),'updated_at'=>now()],
                ['id_limit_produk' => 52, 'id_produk' => 8, 'limit' => 10, 'tanggal' => '2024-03-25','created_at'=>now(),'updated_at'=>now()],
                ['id_limit_produk' => 53, 'id_produk' => 8, 'limit' => 10, 'tanggal' => '2024-03-26','created_at'=>now(),'updated_at'=>now()],
                ['id_limit_produk' => 54, 'id_produk' => 8, 'limit' => 10, 'tanggal' => '2024-03-27','created_at'=>now(),'updated_at'=>now()],
                ['id_limit_produk' => 55, 'id_produk' => 8, 'limit' => 10, 'tanggal' => '2024-03-28','created_at'=>now(),'updated_at'=>now()],
                ['id_limit_produk' => 56, 'id_produk' => 8, 'limit' => 10, 'tanggal' => '2024-03-29','created_at'=>now(),'updated_at'=>now()],
                ['id_limit_produk' => 57, 'id_produk' => 9, 'limit' => 10, 'tanggal' => '2024-03-23','created_at'=>now(),'updated_at'=>now()],
                ['id_limit_produk' => 58, 'id_produk' => 9, 'limit' => 10, 'tanggal' => '2024-03-24','created_at'=>now(),'updated_at'=>now()],
                ['id_limit_produk' => 59, 'id_produk' => 9, 'limit' => 10, 'tanggal' => '2024-03-25','created_at'=>now(),'updated_at'=>now()],
                ['id_limit_produk' => 60, 'id_produk' => 9, 'limit' => 10, 'tanggal' => '2024-03-26','created_at'=>now(),'updated_at'=>now()],
                ['id_limit_produk' => 61, 'id_produk' => 9, 'limit' => 10, 'tanggal' => '2024-03-27','created_at'=>now(),'updated_at'=>now()],
                ['id_limit_produk' => 62, 'id_produk' => 9, 'limit' => 10, 'tanggal' => '2024-03-28','created_at'=>now(),'updated_at'=>now()],
                ['id_limit_produk' => 63, 'id_produk' => 9, 'limit' => 10, 'tanggal' => '2024-03-29','created_at'=>now(),'updated_at'=>now()],
                ['id_limit_produk' => 64, 'id_produk' => 10, 'limit' => 10, 'tanggal' => '2024-03-23','created_at'=>now(),'updated_at'=>now()],
                ['id_limit_produk' => 65, 'id_produk' => 10, 'limit' => 10, 'tanggal' => '2024-03-24','created_at'=>now(),'updated_at'=>now()],
                ['id_limit_produk' => 66, 'id_produk' => 10, 'limit' => 10, 'tanggal' => '2024-03-25','created_at'=>now(),'updated_at'=>now()],
                ['id_limit_produk' => 67, 'id_produk' => 10, 'limit' => 10, 'tanggal' => '2024-03-26','created_at'=>now(),'updated_at'=>now()],
                ['id_limit_produk' => 68, 'id_produk' => 10, 'limit' => 10, 'tanggal' => '2024-03-27','created_at'=>now(),'updated_at'=>now()],
                ['id_limit_produk' => 69, 'id_produk' => 10, 'limit' => 10, 'tanggal' => '2024-03-28','created_at'=>now(),'updated_at'=>now()],
                ['id_limit_produk' => 70, 'id_produk' => 10, 'limit' => 10, 'tanggal' => '2024-03-29','created_at'=>now(),'updated_at'=>now()],
                ['id_limit_produk' => 71, 'id_produk' => 11, 'limit' => 10, 'tanggal' => '2024-03-23','created_at'=>now(),'updated_at'=>now()],
                ['id_limit_produk' => 72, 'id_produk' => 11, 'limit' => 10, 'tanggal' => '2024-03-24','created_at'=>now(),'updated_at'=>now()],
                ['id_limit_produk' => 73, 'id_produk' => 11, 'limit' => 10, 'tanggal' => '2024-03-25','created_at'=>now(),'updated_at'=>now()],
                ['id_limit_produk' => 74, 'id_produk' => 11, 'limit' => 10, 'tanggal' => '2024-03-26','created_at'=>now(),'updated_at'=>now()],
                ['id_limit_produk' => 75, 'id_produk' => 11, 'limit' => 10, 'tanggal' => '2024-03-27','created_at'=>now(),'updated_at'=>now()],
                ['id_limit_produk' => 76, 'id_produk' => 11, 'limit' => 10, 'tanggal' => '2024-03-28','created_at'=>now(),'updated_at'=>now()],
                ['id_limit_produk' => 77, 'id_produk' => 11, 'limit' => 10, 'tanggal' => '2024-03-29','created_at'=>now(),'updated_at'=>now()],
                ['id_limit_produk' => 78, 'id_produk' => 12, 'limit' => 10, 'tanggal' => '2024-03-23','created_at'=>now(),'updated_at'=>now()],
                ['id_limit_produk' => 79, 'id_produk' => 12, 'limit' => 10, 'tanggal' => '2024-03-24','created_at'=>now(),'updated_at'=>now()],
                ['id_limit_produk' => 80, 'id_produk' => 12, 'limit' => 10, 'tanggal' => '2024-03-25','created_at'=>now(),'updated_at'=>now()],
                ['id_limit_produk' => 81, 'id_produk' => 12, 'limit' => 10, 'tanggal' => '2024-03-26','created_at'=>now(),'updated_at'=>now()],
                ['id_limit_produk' => 82, 'id_produk' => 12, 'limit' => 10, 'tanggal' => '2024-03-27','created_at'=>now(),'updated_at'=>now()],
                ['id_limit_produk' => 83, 'id_produk' => 12, 'limit' => 10, 'tanggal' => '2024-03-28','created_at'=>now(),'updated_at'=>now()],
                ['id_limit_produk' => 84, 'id_produk' => 12, 'limit' => 10, 'tanggal' => '2024-03-29','created_at'=>now(),'updated_at'=>now()],
                ['id_limit_produk' => 85, 'id_produk' => 13, 'limit' => 10, 'tanggal' => '2024-03-23','created_at'=>now(),'updated_at'=>now()],
                ['id_limit_produk' => 86, 'id_produk' => 13, 'limit' => 10, 'tanggal' => '2024-03-24','created_at'=>now(),'updated_at'=>now()],
                ['id_limit_produk' => 87, 'id_produk' => 13, 'limit' => 10, 'tanggal' => '2024-03-25','created_at'=>now(),'updated_at'=>now()],
                ['id_limit_produk' => 88, 'id_produk' => 13, 'limit' => 10, 'tanggal' => '2024-03-26','created_at'=>now(),'updated_at'=>now()],
                ['id_limit_produk' => 89, 'id_produk' => 13, 'limit' => 10, 'tanggal' => '2024-03-27','created_at'=>now(),'updated_at'=>now()],
                ['id_limit_produk' => 90, 'id_produk' => 13, 'limit' => 10, 'tanggal' => '2024-03-28','created_at'=>now(),'updated_at'=>now()],
                ['id_limit_produk' => 91, 'id_produk' => 13, 'limit' => 10, 'tanggal' => '2024-03-29','created_at'=>now(),'updated_at'=>now()],
                ['id_limit_produk' => 92, 'id_produk' => 14, 'limit' => 10, 'tanggal' => '2024-03-23','created_at'=>now(),'updated_at'=>now()],
                ['id_limit_produk' => 93, 'id_produk' => 14, 'limit' => 10, 'tanggal' => '2024-03-24','created_at'=>now(),'updated_at'=>now()],
                ['id_limit_produk' => 94, 'id_produk' => 14, 'limit' => 10, 'tanggal' => '2024-03-25','created_at'=>now(),'updated_at'=>now()],
                ['id_limit_produk' => 95, 'id_produk' => 14, 'limit' => 10, 'tanggal' => '2024-03-26','created_at'=>now(),'updated_at'=>now()],
                ['id_limit_produk' => 96, 'id_produk' => 14, 'limit' => 10, 'tanggal' => '2024-03-27','created_at'=>now(),'updated_at'=>now()],
                ['id_limit_produk' => 97, 'id_produk' => 14, 'limit' => 10, 'tanggal' => '2024-03-28','created_at'=>now(),'updated_at'=>now()],
                ['id_limit_produk' => 98, 'id_produk' => 14, 'limit' => 10, 'tanggal' => '2024-03-29','created_at'=>now(),'updated_at'=>now()],
                ['id_limit_produk' => 99, 'id_produk' => 15, 'limit' => 10, 'tanggal' => '2024-03-23','created_at'=>now(),'updated_at'=>now()],
                ['id_limit_produk' => 100, 'id_produk' => 15, 'limit' => 10, 'tanggal' => '2024-03-24','created_at'=>now(),'updated_at'=>now()],
                ['id_limit_produk' => 101, 'id_produk' => 15, 'limit' => 10, 'tanggal' => '2024-03-25','created_at'=>now(),'updated_at'=>now()],
                ['id_limit_produk' => 102, 'id_produk' => 15, 'limit' => 10, 'tanggal' => '2024-03-26','created_at'=>now(),'updated_at'=>now()],
                ['id_limit_produk' => 103, 'id_produk' => 15, 'limit' => 10, 'tanggal' => '2024-03-27','created_at'=>now(),'updated_at'=>now()],
                ['id_limit_produk' => 104, 'id_produk' => 15, 'limit' => 10, 'tanggal' => '2024-03-28','created_at'=>now(),'updated_at'=>now()],
                ['id_limit_produk' => 105, 'id_produk' => 15, 'limit' => 10, 'tanggal' => '2024-03-29','created_at'=>now(),'updated_at'=>now()],
            ]
        );
    }
}
