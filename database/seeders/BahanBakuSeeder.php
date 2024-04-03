<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BahanBakuSeeder extends Seeder
{
    /**
     * 
     * INSERT INTO `bahan_baku` (`nama`, `stok`, `satuan`) VALUES
     *( 'Butter', 1510, 'gram'),
     *( 'Creamer', 320, 'gram'),
     *( 'Telur', 175, 'butir'),
     *( 'Gula Pasir', 1460, 'gram'),
     *( 'Susu Bubuk', 460, 'gram'),
     *( 'Tepung Terigu', 1230, 'gram'),
     *( 'Garam', 33, 'gram'),
     *( 'Coklat Bubuk', 290, 'gram'),
     *( 'Selai Strawberry', 150, 'gram'),
     *( 'Minyak Goreng', 50, 'ml'),
     *( 'Baking Powder', 5, 'gram'),
     *( 'Tepung Maizena', 20, 'gram'),
     *( 'Kacang Kenari', 100, 'gram'),
     *( 'Ragi', 9, 'gram'),
     *( 'Susu Cair', 3900, 'ml'),
     *( 'Whipped Cream', 200, 'gram'),
     *( 'Keju Mozzarella', 350, 'gram'),
     *( 'Matcha Bubuk', 120, 'gram'),
     *( 'Exclusive Box', 15, 'Set'),
     *( 'Card', 20, 'Buah');
     * 
     * 
     * 
     */
    public function run(): void
    {
        //DB::table('bahan_baku')->delete();
        DB::table('bahan_baku')->insert([
            ['nama_bahan_baku' => 'Butter', 'stok' => 1510, 'satuan' => 'gram','created_at' => now(),'updated_at' => now()],
            ['nama_bahan_baku' => 'Creamer', 'stok' => 320, 'satuan' => 'gram','created_at' => now(),'updated_at' => now()],
            ['nama_bahan_baku' => 'Telur', 'stok' => 175, 'satuan' => 'butir','created_at' => now(),'updated_at' => now()],
            ['nama_bahan_baku' => 'Gula Pasir', 'stok' => 1460, 'satuan' => 'gram','created_at' => now(),'updated_at' => now()],
            ['nama_bahan_baku' => 'Susu Bubuk', 'stok' => 460, 'satuan' => 'gram','created_at' => now(),'updated_at' => now()],
            ['nama_bahan_baku' => 'Tepung Terigu', 'stok' => 1230, 'satuan' => 'gram','created_at' => now(),'updated_at' => now()],
            ['nama_bahan_baku' => 'Garam', 'stok' => 33, 'satuan' => 'gram','created_at' => now(),'updated_at' => now()],
            ['nama_bahan_baku' => 'Coklat Bubuk', 'stok' => 290, 'satuan' => 'gram','created_at' => now(),'updated_at' => now()],
            ['nama_bahan_baku' => 'Selai Strawberry', 'stok' => 150, 'satuan' => 'gram','created_at' => now(),'updated_at' => now()],
            ['nama_bahan_baku' => 'Minyak Goreng', 'stok' => 50, 'satuan' => 'ml','created_at' => now(),'updated_at' => now()],
            ['nama_bahan_baku' => 'Baking Powder', 'stok' => 5, 'satuan' => 'gram','created_at' => now(),'updated_at' => now()],
            ['nama_bahan_baku' => 'Tepung Maizena', 'stok' => 20, 'satuan' => 'gram','created_at' => now(),'updated_at' => now()],
            ['nama_bahan_baku' => 'Kacang Kenari', 'stok' => 100, 'satuan' => 'gram','created_at' => now(),'updated_at' => now()],
            ['nama_bahan_baku' => 'Ragi', 'stok' => 9, 'satuan' => 'gram','created_at' => now(),'updated_at' => now()],
            ['nama_bahan_baku' => 'Susu Cair', 'stok' => 3900, 'satuan' => 'ml','created_at' => now(),'updated_at' => now()],
            ['nama_bahan_baku' => 'Whipped Cream', 'stok' => 200, 'satuan' => 'gram','created_at' => now(),'updated_at' => now()],
            ['nama_bahan_baku' => 'Keju Mozzarella', 'stok' => 350, 'satuan' => 'gram','created_at' => now(),'updated_at' => now()],
            ['nama_bahan_baku' => 'Matcha Bubuk', 'stok' => 120, 'satuan' => 'gram','created_at' => now(),'updated_at' => now()],
            ['nama_bahan_baku' => 'Exclusive Box', 'stok' =>15, 'satuan' => 'Set','created_at' => now(),'updated_at' => now()],
            ['nama_bahan_baku' => 'Card', 'stok' => 20, 'satuan' => 'Buah','created_at' => now(),'updated_at' => now()]  
        ]);
    }
}
