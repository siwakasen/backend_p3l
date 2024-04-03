<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
class KaryawanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * INSERT INTO `karyawan` (`id_karyawan`, `id_role`, `nama_karyawan`, `email`, `password`, `tanggal_masuk`, `bonus_gaji`) VALUES
    * (1, 1, 'Ferdy Firmansyah', 'ferdy@example.com', 'ferdy123', '2023-05-16', 0),
    * (2, 2, 'Talia Nita', 'talia@example.com', 'talia123', '2023-02-01', 400000),
    * (3, 3, 'John Chill', 'jhonc@example.com', 'jhonc123', '2023-12-02', 0),
    * (4, 4, 'Mike Tyson', 'mike@example.com', 'mike123', '2023-12-03', 200000),
    * (5, 5, 'Simen Sipit', 'simen@example.com', 'simen123', '2024-03-01', 200000),
    * (6, 5, 'Panji Pusaka', 'panji@example.com', 'panji123', '2024-05-01', 0);
     */
    public function run(): void
    {
        //DB::table('karyawan')->delete();
        DB::table('karyawan')->insert([
            [
                'id_karyawan' => 1,
                'id_role' => 1,
                'nama_karyawan' => 'Ferdy Firmansyah',
                'email'=> 'ferdy@example.com',
                'password' => Hash::make('ferdy123'),
                'tanggal_masuk' => '2023-05-16',
                'bonus_gaji' => 0,
                'created_at'=> now(),
                'updated_at'=> now()
            ],
            [
                'id_karyawan' => 2,
                'id_role' => 2,
                'nama_karyawan' => 'Talia Nita',
                'email'=> 'talia@example.com',
                'password' => Hash::make('talia123'),
                'tanggal_masuk' => '2023-02-01',
                'bonus_gaji' => 400000,
                'created_at'=> now(),
                'updated_at'=> now()
            ],
            [
                'id_karyawan' => 3,
                'id_role' => 3,
                'nama_karyawan' => 'John Chill',
                'email'=> 'jhon@example.com',
                'password' => Hash::make('jhon123'),
                'tanggal_masuk' => '2023-12-02',
                'bonus_gaji' => 0,
                'created_at'=> now(),
                'updated_at'=> now()
            ],
            [
                'id_karyawan' => 4,
                'id_role' => 4,
                'nama_karyawan' => 'Mike Tyson',
                'email'=> 'mike@example.com',
                'password' => Hash::make('mike123'),
                'tanggal_masuk' => '2023-12-03',
                'bonus_gaji' => 200000,
                'created_at'=> now(),
                'updated_at'=> now()
            ],
            [
                'id_karyawan' => 5,
                'id_role' => 5,
                'nama_karyawan' => 'Simen Sipit',
                'email'=> 'simen@example.com',
                'password' => Hash::make('simen123'),
                'tanggal_masuk' => '2024-03-01',
                'bonus_gaji' => 200000,
                'created_at'=> now(),
                'updated_at'=> now()
            ],
            [
                'id_karyawan' => 6,
                'id_role' => 5,
                'nama_karyawan' => 'Panji Pusaka',
                'email'=> 'panji@example.com',
                'password' => Hash::make('panji123'),
                'tanggal_masuk' => '2024-05-01',
                'bonus_gaji' => 0,
                'created_at'=> now(),
                'updated_at'=> now()
            ]
        ]
            );
    }
}
