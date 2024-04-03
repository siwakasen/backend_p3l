<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ResepSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * INSERT INTO `resep` (`id_resep`, `nama`) VALUES
     * (1, 'Lapis Legit'),
     * (2, 'Lapis Surabaya'),
     * (3, 'Brownies'),
     * (4, 'Mandarin'),
     * (5, 'Spioke'),
     * (6, 'Roti Sosis'),
     * (7, 'Milk Bun'),
     * (8, 'Roti Keju'),
     * (9, 'Choco Creamy Latte'),
     * (10, 'Matcha Creamy Latte');
     */
    public function run(): void
    {
        //DB::table('resep')->delete();
        DB::table('resep')->insert(
            [
                ['id_resep' => 1, 'nama_resep' => 'Lapis Legit','created_at'=>now(),'updated_at'=>now()],
                ['id_resep' => 2, 'nama_resep' => 'Lapis Surabaya','created_at'=>now(),'updated_at'=>now()],
                ['id_resep' => 3, 'nama_resep' => 'Brownies','created_at'=>now(),'updated_at'=>now()],
                ['id_resep' => 4, 'nama_resep' => 'Mandarin','created_at'=>now(),'updated_at'=>now()],
                ['id_resep' => 5, 'nama_resep' => 'Spioke','created_at'=>now(),'updated_at'=>now()],
                ['id_resep' => 6, 'nama_resep' => 'Roti Sosis','created_at'=>now(),'updated_at'=>now()],
                ['id_resep' => 7, 'nama_resep' => 'Milk Bun','created_at'=>now(),'updated_at'=>now()],
                ['id_resep' => 8, 'nama_resep' => 'Roti Keju','created_at'=>now(),'updated_at'=>now()],
                ['id_resep' => 9, 'nama_resep' => 'Choco Creamy Latte','created_at'=>now(),'updated_at'=>now()],
                ['id_resep' => 10, 'nama_resep' => 'Matcha Creamy Latte','created_at'=>now(),'updated_at'=>now()]
            ]
            );
    }
}
