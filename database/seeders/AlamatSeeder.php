<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AlamatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('alamat')->insert(
            [
                ['id_alamat' => 1, 'id_user' => 1, 'alamat' => 'Jln. Yadara. No. 10', 'kode_pos' => 55240,'created_at' => now(),'updated_at' => now()],
                ['id_alamat' => 2, 'id_user' => 2, 'alamat' => 'Jln. Kledokan. No. 20', 'kode_pos' => 55340,'created_at' => now(),'updated_at' => now()],
                ['id_alamat' => 3, 'id_user' => 3, 'alamat' => 'Jln. Kledokan. No. 120', 'kode_pos' => 55120,'created_at' => now(),'updated_at' => now()],
                ['id_alamat' => 4, 'id_user' => 4, 'alamat' => 'Jln. Condong Catur. No. 90', 'kode_pos' => 34110,'created_at' => now(),'updated_at' => now()],
                ['id_alamat' => 5, 'id_user' => 5, 'alamat' => 'Jln. Kalasan. No. 1', 'kode_pos' => 18110,'created_at' => now(),'updated_at' => now()],
                ['id_alamat' => 6, 'id_user' => 6, 'alamat' => 'Jln. Babarsari. No. 41', 'kode_pos' => 55420,'created_at' => now(),'updated_at' => now()],
                ['id_alamat' => 7, 'id_user' => 1, 'alamat' => 'Jln. Babarsari. No. 20', 'kode_pos' => 55210,'created_at' => now(),'updated_at' => now()]
            ]
        );
    }
}
