<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DetailResepSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //DB::table('detail_resep')->delete();
        DB::table('detail_resep')->insert(
            [
                ['id_bahan_baku' => 1, 'id_resep' => 1, 'jumlah' => 500,'created_at'=>now(),'updated_at'=>now()],
                ['id_bahan_baku' => 2, 'id_resep' => 1, 'jumlah' => 50,'created_at'=>now(),'updated_at'=>now()],
                ['id_bahan_baku' => 3, 'id_resep' => 1, 'jumlah' => 50,'created_at'=>now(),'updated_at'=>now()],
                ['id_bahan_baku' => 4, 'id_resep' => 1, 'jumlah' => 300,'created_at'=>now(),'updated_at'=>now()],
                ['id_bahan_baku' => 5, 'id_resep' => 1, 'jumlah' => 100,'created_at'=>now(),'updated_at'=>now()],
                ['id_bahan_baku' => 6, 'id_resep' => 1, 'jumlah' => 20,'created_at'=>now(),'updated_at'=>now()],
                ['id_bahan_baku' => 1, 'id_resep' => 2, 'jumlah' => 500,'created_at'=>now(),'updated_at'=>now()],
                ['id_bahan_baku' => 2, 'id_resep' => 2, 'jumlah' => 50,'created_at'=>now(),'updated_at'=>now()],
                ['id_bahan_baku' => 3, 'id_resep' => 2, 'jumlah' => 40,'created_at'=>now(),'updated_at'=>now()],
                ['id_bahan_baku' => 4, 'id_resep' => 2, 'jumlah' => 300,'created_at'=>now(),'updated_at'=>now()],
                ['id_bahan_baku' => 5, 'id_resep' => 2, 'jumlah' => 100,'created_at'=>now(),'updated_at'=>now()],
                ['id_bahan_baku' => 6, 'id_resep' => 2, 'jumlah' => 100,'created_at'=>now(),'updated_at'=>now()],
                ['id_bahan_baku' => 7, 'id_resep' => 2, 'jumlah' => 10,'created_at'=>now(),'updated_at'=>now()],
                ['id_bahan_baku' => 8, 'id_resep' => 2, 'jumlah' => 25,'created_at'=>now(),'updated_at'=>now()],
                ['id_bahan_baku' => 9, 'id_resep' => 2, 'jumlah' => 100,'created_at'=>now(),'updated_at'=>now()],
                ['id_bahan_baku' => 18, 'id_resep' => 3, 'jumlah' => 250,'created_at'=>now(),'updated_at'=>now()],
                ['id_bahan_baku' => 1, 'id_resep' => 3, 'jumlah' => 100,'created_at'=>now(),'updated_at'=>now()],
                ['id_bahan_baku' => 10, 'id_resep' => 3, 'jumlah' => 50,'created_at'=>now(),'updated_at'=>now()],
                ['id_bahan_baku' => 3, 'id_resep' => 3, 'jumlah' => 6,'created_at'=>now(),'updated_at'=>now()],
                ['id_bahan_baku' => 4, 'id_resep' => 3, 'jumlah' => 200,'created_at'=>now(),'updated_at'=>now()],
                ['id_bahan_baku' => 6, 'id_resep' => 3, 'jumlah' => 150,'created_at'=>now(),'updated_at'=>now()],
                ['id_bahan_baku' => 8, 'id_resep' => 3, 'jumlah' => 60,'created_at'=>now(),'updated_at'=>now()],
                ['id_bahan_baku' => 1, 'id_resep' => 4, 'jumlah' => 300,'created_at'=>now(),'updated_at'=>now()],
                ['id_bahan_baku' => 2, 'id_resep' => 4, 'jumlah' => 30,'created_at'=>now(),'updated_at'=>now()],
                ['id_bahan_baku' => 3, 'id_resep' => 4, 'jumlah' => 30,'created_at'=>now(),'updated_at'=>now()],
                ['id_bahan_baku' => 4, 'id_resep' => 4, 'jumlah' => 200,'created_at'=>now(),'updated_at'=>now()],
                ['id_bahan_baku' => 6, 'id_resep' => 4, 'jumlah' => 80,'created_at'=>now(),'updated_at'=>now()],
                ['id_bahan_baku' => 5, 'id_resep' => 4, 'jumlah' => 80,'created_at'=>now(),'updated_at'=>now()],
                ['id_bahan_baku' => 7, 'id_resep' => 4, 'jumlah' => 5,'created_at'=>now(),'updated_at'=>now()],
                ['id_bahan_baku' => 8, 'id_resep' => 4, 'jumlah' => 25,'created_at'=>now(),'updated_at'=>now()],
                ['id_bahan_baku' => 9, 'id_resep' => 4, 'jumlah' => 50,'created_at'=>now(),'updated_at'=>now()],
                ['id_bahan_baku' => 3, 'id_resep' => 5, 'jumlah' => 20,'created_at'=>now(),'updated_at'=>now()],
                ['id_bahan_baku' => 4, 'id_resep' => 5, 'jumlah' => 200,'created_at'=>now(),'updated_at'=>now()],
                ['id_bahan_baku' => 6, 'id_resep' => 5, 'jumlah' => 90,'created_at'=>now(),'updated_at'=>now()],
                ['id_bahan_baku' => 12, 'id_resep' => 5, 'jumlah' => 20,'created_at'=>now(),'updated_at'=>now()],
                ['id_bahan_baku' => 5, 'id_resep' => 5, 'jumlah' => 10,'created_at'=>now(),'updated_at'=>now()],
                ['id_bahan_baku' => 11, 'id_resep' => 5, 'jumlah' => 5,'created_at'=>now(),'updated_at'=>now()],
                ['id_bahan_baku' => 1, 'id_resep' => 5, 'jumlah' => 200,'created_at'=>now(),'updated_at'=>now()],
                ['id_bahan_baku' => 6, 'id_resep' => 6, 'jumlah' => 250,'created_at'=>now(),'updated_at'=>now()],
                ['id_bahan_baku' => 4, 'id_resep' => 6, 'jumlah' => 30,'created_at'=>now(),'updated_at'=>now()],
                ['id_bahan_baku' => 14, 'id_resep' => 6, 'jumlah' => 3,'created_at'=>now(),'updated_at'=>now()],
                ['id_bahan_baku' => 3, 'id_resep' => 6, 'jumlah' => 3,'created_at'=>now(),'updated_at'=>now()],
                ['id_bahan_baku' => 15, 'id_resep' => 6, 'jumlah' => 150,'created_at'=>now(),'updated_at'=>now()],
                ['id_bahan_baku' => 1, 'id_resep' => 6, 'jumlah' => 50,'created_at'=>now(),'updated_at'=>now()],
                ['id_bahan_baku' => 7, 'id_resep' => 6, 'jumlah' => 2,'created_at'=>now(),'updated_at'=>now()],
                ['id_bahan_baku' => 13, 'id_resep' => 6, 'jumlah' => 10,'created_at'=>now(),'updated_at'=>now()],
                ['id_bahan_baku' => 6, 'id_resep' => 7, 'jumlah' => 250,'created_at'=>now(),'updated_at'=>now()],
                ['id_bahan_baku' => 4, 'id_resep' => 7, 'jumlah' => 30,'created_at'=>now(),'updated_at'=>now()],
                ['id_bahan_baku' => 14, 'id_resep' => 7, 'jumlah' => 3,'created_at'=>now(),'updated_at'=>now()],
                ['id_bahan_baku' => 3, 'id_resep' => 7, 'jumlah' => 4,'created_at'=>now(),'updated_at'=>now()],
                ['id_bahan_baku' => 15, 'id_resep' => 7, 'jumlah' => 300,'created_at'=>now(),'updated_at'=>now()],
                ['id_bahan_baku' => 1, 'id_resep' => 7, 'jumlah' => 60,'created_at'=>now(),'updated_at'=>now()],
                ['id_bahan_baku' => 7, 'id_resep' => 7, 'jumlah' => 3,'created_at'=>now(),'updated_at'=>now()],
                ['id_bahan_baku' => 16, 'id_resep' => 7, 'jumlah' => 200,'created_at'=>now(),'updated_at'=>now()],
                ['id_bahan_baku' => 5, 'id_resep' => 7, 'jumlah' => 50,'created_at'=>now(),'updated_at'=>now()],
                ['id_bahan_baku' => 6, 'id_resep' => 8, 'jumlah' => 250,'created_at'=>now(),'updated_at'=>now()],
                ['id_bahan_baku' => 4, 'id_resep' => 8, 'jumlah' => 30,'created_at'=>now(),'updated_at'=>now()],
                ['id_bahan_baku' => 14, 'id_resep' => 8, 'jumlah' => 3,'created_at'=>now(),'updated_at'=>now()],
                ['id_bahan_baku' => 3, 'id_resep' => 8, 'jumlah' => 3,'created_at'=>now(),'updated_at'=>now()],
                ['id_bahan_baku' => 17, 'id_resep' => 8, 'jumlah' => 150,'created_at'=>now(),'updated_at'=>now()],
                ['id_bahan_baku' => 1, 'id_resep' => 8, 'jumlah' => 50,'created_at'=>now(),'updated_at'=>now()],
                ['id_bahan_baku' => 7, 'id_resep' => 8, 'jumlah' => 2,'created_at'=>now(),'updated_at'=>now()],
                ['id_bahan_baku' => 17, 'id_resep' => 8, 'jumlah' => 350,'created_at'=>now(),'updated_at'=>now()],
                ['id_bahan_baku' => 8, 'id_resep' => 9, 'jumlah' => 120,'created_at'=>now(),'updated_at'=>now()],
                ['id_bahan_baku' => 2, 'id_resep' => 9, 'jumlah' => 80,'created_at'=>now(),'updated_at'=>now()],
                ['id_bahan_baku' => 15, 'id_resep' => 9, 'jumlah' => 800,'created_at'=>now(),'updated_at'=>now()],
                ['id_bahan_baku' => 18, 'id_resep' => 10, 'jumlah' => 120,'created_at'=>now(),'updated_at'=>now()],
                ['id_bahan_baku' => 2, 'id_resep' => 10, 'jumlah' => 80,'created_at'=>now(),'updated_at'=>now()],
                ['id_bahan_baku' => 15, 'id_resep' => 10, 'jumlah' => 800,'created_at'=>now(),'updated_at'=>now()]
            ]
        );
    }
}
