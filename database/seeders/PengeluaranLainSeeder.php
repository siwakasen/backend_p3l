<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PengeluaranLainSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * INSERT INTO `pengeluaran_lain` (`id_pengeluaran`, `nama`, `jumlah`, `tanggal_pengeluaran`) VALUES
     *(1, 'listrik', 250000, '2024-01-05'),
     *(2, 'gas', 60000, '2024-01-05'),
     *(3, 'bensin', 30000, '2024-01-06'),
     *(4, 'air', 50000, '2024-01-06'),
     *(5, 'internet', 349999, '2024-01-06'),
     *(6, 'sewa ruko', 40000000, '2024-01-01');
     */
    public function run(): void
    {
        //DB::table('pengeluaran_lain')->delete();
        DB::table('pengeluaran_lain')->insert(
          [
            ['id_pengeluaran' => 1, 'nama_pengeluaran' => 'listrik', 'nominal_pengeluaran' => 250000, 'tanggal_pengeluaran' => '2024-01-05','created_at' => now(),'updated_at' => now()],
            ['id_pengeluaran' => 2, 'nama_pengeluaran' => 'gas', 'nominal_pengeluaran' => 60000, 'tanggal_pengeluaran' => '2024-01-05','created_at' => now(),'updated_at' => now()],
            ['id_pengeluaran' => 3, 'nama_pengeluaran' => 'bensin', 'nominal_pengeluaran' => 30000, 'tanggal_pengeluaran' => '2024-01-06','created_at' => now(),'updated_at' => now()],
            ['id_pengeluaran' => 4, 'nama_pengeluaran' => 'air', 'nominal_pengeluaran' => 50000, 'tanggal_pengeluaran' => '2024-01-06','created_at' => now(),'updated_at' => now()],
            ['id_pengeluaran' => 5, 'nama_pengeluaran' => 'internet', 'nominal_pengeluaran' => 349999, 'tanggal_pengeluaran' => '2024-01-06','created_at' => now(),'updated_at' => now()],
            ['id_pengeluaran' => 6, 'nama_pengeluaran' => 'sewa ruko', 'nominal_pengeluaran' => 40000000, 'tanggal_pengeluaran' => '2024-01-01','created_at' => now(),'updated_at' => now()]
          ]

        );
    }
}
