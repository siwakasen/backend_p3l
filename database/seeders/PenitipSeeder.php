<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenitipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * INSERT INTO `penitip` (`id_penitip`, `nama`, `no_hp`, `email`) VALUES
     *(1, 'John Doe', '08123456789', 'john.doe@example.com'),
     *(2, 'Jane Smith', '081987654321', 'jane.smith@example.com'),
     *(3, 'Ahmad Abdullah', '08123456789', 'ahmad.abdullah@example.com'),
     *(4, 'Lisa Tan', '08567891234', 'lisa.tan@example.com'),
     *(5, 'Mohammed Ali', '0812345678', 'mohammed.ali@example.com');
     */
    public function run(): void
    {
        //DB::table('penitip')->delete();
        DB::table('penitip')->insert(
            [
                ['id_penitip' => 1, 'nama_penitip' => 'John Doe', 'no_hp' => '08123456789', 'email' => 'johndoe@example.com','created_at' => now(),'updated_at' => now()],
                ['id_penitip' => 2, 'nama_penitip' => 'Jane Smith', 'no_hp' => '081987654321', 'email' => 'jane@example.com','created_at' => now(),'updated_at' => now()],
                ['id_penitip' => 3, 'nama_penitip' => 'Ahmad Abdullah', 'no_hp' => '08123456789', 'email' => 'ahmad@example.com','created_at' => now(),'updated_at' => now()],
                ['id_penitip' => 4, 'nama_penitip' => 'Lisa Tan', 'no_hp' => '08567891234', 'email' => 'lisa@example.com','created_at' => now(),'updated_at' => now()],
                ['id_penitip' => 5, 'nama_penitip' => 'Muhammad Ali', 'no_hp' => '0812345678', 'email' => 'muhammad@example.com','created_at' => now(),'updated_at' => now()]
            ]
        );
    }
}
