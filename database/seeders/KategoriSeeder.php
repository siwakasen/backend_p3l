<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * INSERT INTO `kategori` (`id_kategori`, `nama`) VALUES
     *(1, 'Cake'),
     *(2, 'Roti'),
     *(3, 'Minuman'),
     *(4, 'Titipan'),
     *(5, 'Hampers');
     */
    public function run(): void
    {
        //DB::table('kategori')->delete();
        DB::table('kategori')->insert(
            [
                ['id_kategori' => 1, 'nama_kategori' => 'Cake','created_at' => now(),'updated_at' => now()],
                ['id_kategori' => 2, 'nama_kategori' => 'Roti','created_at' => now(),'updated_at' => now()],
                ['id_kategori' => 3, 'nama_kategori' => 'Minuman','created_at' => now(),'updated_at' => now()],
                ['id_kategori' => 4, 'nama_kategori' => 'Titipan','created_at' => now(),'updated_at' => now()],
                ['id_kategori' => 5, 'nama_kategori' => 'Hampers','created_at' => now(),'updated_at' => now()]
            ]
            );
    }
}
