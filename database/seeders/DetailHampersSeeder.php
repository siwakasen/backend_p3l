<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DetailHampersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('detail_hampers')->insert(
            [
                ['id_produk' => 2, 'id_hampers' => 1,'id_bahan_baku'=> NULL,'created_at'=>now(),'updated_at'=>now()],
                ['id_produk' => 6, 'id_hampers' => 1,'id_bahan_baku'=> NULL,'created_at'=>now(),'updated_at'=>now()],
                ['id_produk' => 6, 'id_hampers' => 2,'id_bahan_baku'=> NULL,'created_at'=>now(),'updated_at'=>now()],
                ['id_produk' => 11, 'id_hampers' => 2,'id_bahan_baku'=> NULL,'created_at'=>now(),'updated_at'=>now()],
                ['id_produk' => 10, 'id_hampers' => 3,'id_bahan_baku'=> NULL,'created_at'=>now(),'updated_at'=>now()],
                ['id_produk' => 15, 'id_hampers' => 3,'id_bahan_baku'=> NULL,'created_at'=>now(),'updated_at'=>now()],
                ['id_produk' => NULL,'id_hampers'=> 1,'id_bahan_baku'=> 19,'created_at'=>now(),'updated_at'=>now()],
                ['id_produk' => NULL,'id_hampers'=> 1,'id_bahan_baku'=> 20,'created_at'=>now(),'updated_at'=>now()],
                ['id_produk' => NULL,'id_hampers'=> 2,'id_bahan_baku'=> 19,'created_at'=>now(),'updated_at'=>now()],
                ['id_produk' => NULL,'id_hampers'=> 2,'id_bahan_baku'=> 20,'created_at'=>now(),'updated_at'=>now()],
                ['id_produk' => NULL,'id_hampers'=> 3,'id_bahan_baku'=> 19,'created_at'=>now(),'updated_at'=>now()],
                ['id_produk' => NULL,'id_hampers'=> 3,'id_bahan_baku'=> 20,'created_at'=>now(),'updated_at'=>now()]
            ]
        );
    }
}
