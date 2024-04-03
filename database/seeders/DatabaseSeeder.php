<?php

namespace Database\Seeders;
 
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
 
class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;
 
    /**
     * Run the database seeders.
     */
    public function run(): void
    {
        $this->call([
            UsersSeeder::class,
            AlamatSeeder::class,
            HistorySaldoSeeder::class,

            RolesSeeder::class,
            KaryawanSeeder::class,
            PresensiSeeder::class,

            PengeluaranLainSeeder::class,

            BahanBakuSeeder::class,
            PembelianBahanBakuSeeder::class,
            ResepSeeder::class,
            DetailResepSeeder::class,

            PenitipSeeder::class,
            KategoriSeeder::class,
            ProdukSeeder::class,
            LimitProdukSeeder::class,

            HampersSeeder::class,
            DetailHampersSeeder::class,

            PesananSeeder::class,
            DetailPesananSeeder::class,
        ]);
    }
}
