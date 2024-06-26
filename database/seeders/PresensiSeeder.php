<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PresensiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * INSERT INTO `presensi` (`id_presensi`, `id_karyawan`, `tanggal`, `status`) VALUES
     *(1, 2, '2024-02-08', 'Masuk'),
     *(2, 3, '2024-02-09', 'Masuk'),
     *(3, 4, '2024-02-06', 'Masuk'),
     *(4, 5, '2024-02-06', 'Masuk'),
     *(5, 6, '2024-02-06', 'Masuk'),
     *(6, 2, '2024-02-07', 'Masuk'),
     *(7, 3, '2024-02-07', 'Masuk'),
     *(8, 4, '2024-02-07', 'Masuk'),
     *(9, 5, '2024-02-07', 'Masuk'),
     *(10, 6, '2024-02-07', 'Masuk'),
     *(11, 2, '2024-02-08', 'Tidak Masuk'),
     *(12, 3, '2024-02-08', 'Masuk'),
     *(13, 4, '2024-02-08', 'Tidak Masuk'),
     *(14, 5, '2024-02-08', 'Masuk'),
     *(15, 6, '2024-02-08', 'Masuk'),
     *(16, 2, '2024-02-09', 'Masuk'),
     *(17, 3, '2024-02-09', 'Tidak Masuk'),
     *(18, 4, '2024-02-08', 'Masuk'),
     *(19, 5, '2024-02-09', 'Masuk'),
     *(20, 6, '2024-02-09', 'Masuk'),
     *(21, 2, '2024-02-01', 'Masuk'),
     *(22, 3, '2024-02-10', 'Tidak Masuk'),
     *(23, 4, '2024-02-10', 'Masuk'),
     *(24, 5, '2024-02-10', 'Masuk'),
     *(25, 6, '2024-02-10', 'Masuk'),
     *(26, 2, '2024-02-11', 'Tidak Masuk'),
     *(27, 3, '2024-02-11', 'Masuk'),
     *(28, 4, '2024-02-11', 'Tidak Masuk'),
     *(29, 5, '2024-02-11', 'Masuk'),
     *(30, 6, '2024-02-11', 'Masuk'),
     *(31, 2, '2024-02-12', 'Tidak Masuk'),
     *(32, 3, '2024-02-12', 'Masuk'),
     *(33, 4, '2024-02-12', 'Masuk'),
     *(34, 5, '2024-02-12', 'Masuk'),
     *(35, 6, '2024-02-12', 'Masuk'),
     *(36, 2, '2024-02-13', 'Masuk'),
     *(37, 3, '2024-02-13', 'Masuk'),
     *(38, 4, '2024-02-13', 'Masuk'),
     *(39, 5, '2024-02-13', 'Masuk'),
     *(40, 6, '2024-02-13', 'Tidak Masuk'),
     *(41, 2, '2024-02-14', 'Masuk'),
     *(42, 3, '2024-02-14', 'Tidak Masuk'),
     *(43, 4, '2024-02-14', 'Masuk'),
     *(44, 5, '2024-02-14', 'Masuk'),
     *(45, 6, '2024-02-14', 'Masuk'),
     *(46, 2, '2024-02-15', 'Masuk'),
     *(47, 3, '2024-02-15', 'Tidak Masuk'),
     *(48, 4, '2024-02-15', 'Masuk'),
     *(49, 5, '2024-02-15', 'Masuk'),
     *(50, 6, '2024-02-15', 'Masuk'),
     *(51, 2, '2024-02-16', 'Masuk'),
     *(52, 3, '2024-02-16', 'Masuk'),
     *(53, 4, '2024-02-16', 'Masuk'),
     *(54, 5, '2024-02-16', 'Masuk'),
     *(55, 6, '2024-02-16', 'Masuk'),
     *(56, 2, '2024-02-17', 'Masuk'),
     *(57, 3, '2024-02-17', 'Masuk'),
     *(58, 4, '2024-02-17', 'Masuk'),
     *(59, 5, '2024-02-17', 'Masuk'),
     *(60, 6, '2024-02-17', 'Masuk'),
     *(61, 2, '2024-02-18', 'Masuk'),
     *(62, 3, '2024-02-18', 'Tidak Masuk'),
     *(63, 4, '2024-02-18', 'Masuk'),
     *(64, 5, '2024-02-18', 'Masuk'),
     *(65, 6, '2024-02-18', 'Tidak Masuk'),
     *(66, 2, '2024-02-19', 'Masuk'),
     *(67, 3, '2024-02-19', 'Masuk'),
     *(68, 4, '2024-02-19', 'Masuk'),
     *(69, 5, '2024-02-19', 'Masuk'),
     *(70, 6, '2024-02-19', 'Tidak Masuk'),
     *(71, 2, '2024-02-20', 'Masuk'),
     *(72, 3, '2024-02-20', 'Masuk'),
     *(73, 4, '2024-02-20', 'Masuk'),
     *(74, 5, '2024-02-20', 'Masuk'),
     *(75, 6, '2024-02-20', 'Masuk'),
     *(76, 2, '2024-02-21', 'Masuk'),
     *(77, 3, '2024-02-21', 'Masuk'),
     *(78, 4, '2024-02-21', 'Masuk'),
     *(79, 5, '2024-02-21', 'Masuk'),
     *(80, 6, '2024-02-21', 'Tidak Masuk'),
     *(81, 2, '2024-02-22', 'Masuk'),
     *(82, 3, '2024-02-22', 'Masuk'),
     *(83, 4, '2024-02-22', 'Masuk'),
     *(84, 5, '2024-02-22', 'Tidak Masuk'),
     *(85, 6, '2024-02-22', 'Tidak Masuk');
     */
    public function run(): void
    {
        //DB::table('presensi')->delete();
        DB::table('presensi')->insert(
            [
                ['id_presensi' => 1, 'id_karyawan' => 2, 'tanggal' => '2024-02-08', 'status' => 'Masuk','created_at' => now(),'updated_at' => now()],
                ['id_presensi' => 2, 'id_karyawan' => 3, 'tanggal' => '2024-02-09', 'status' => 'Masuk','created_at' => now(),'updated_at' => now()],
                ['id_presensi' => 3, 'id_karyawan' => 4, 'tanggal' => '2024-02-06', 'status' => 'Masuk','created_at' => now(),'updated_at' => now()],
                ['id_presensi' => 4, 'id_karyawan' => 5, 'tanggal' => '2024-02-06', 'status' => 'Masuk','created_at' => now(),'updated_at' => now()],
                ['id_presensi' => 5, 'id_karyawan' => 6, 'tanggal' => '2024-02-06', 'status' => 'Masuk','created_at' => now(),'updated_at' => now()],
                ['id_presensi' => 6, 'id_karyawan' => 2, 'tanggal' => '2024-02-07', 'status' => 'Masuk','created_at' => now(),'updated_at' => now()],
                ['id_presensi' => 7, 'id_karyawan' => 3, 'tanggal' => '2024-02-07', 'status' => 'Masuk','created_at' => now(),'updated_at' => now()],
                ['id_presensi' => 8, 'id_karyawan' => 4, 'tanggal' => '2024-02-07', 'status' => 'Masuk','created_at' => now(),'updated_at' => now()],
                ['id_presensi' => 9, 'id_karyawan' => 5, 'tanggal' => '2024-02-07', 'status' => 'Masuk','created_at' => now(),'updated_at' => now()],
                ['id_presensi' => 10, 'id_karyawan' => 6, 'tanggal' => '2024-02-07', 'status' => 'Masuk','created_at' => now(),'updated_at' => now()],
                ['id_presensi' => 11, 'id_karyawan' => 2, 'tanggal' => '2024-02-08', 'status' => 'Tidak Masuk','created_at' => now(),'updated_at' => now()],
                ['id_presensi' => 12, 'id_karyawan' => 3, 'tanggal' => '2024-02-08', 'status' => 'Masuk','created_at' => now(),'updated_at' => now()],
                ['id_presensi' => 13, 'id_karyawan' => 4, 'tanggal' => '2024-02-08', 'status' => 'Tidak Masuk','created_at' => now(),'updated_at' => now()],
                ['id_presensi' => 14, 'id_karyawan' => 5, 'tanggal' => '2024-02-08', 'status' => 'Masuk','created_at' => now(),'updated_at' => now()],
                ['id_presensi' => 15, 'id_karyawan' => 6, 'tanggal' => '2024-02-08', 'status' => 'Masuk','created_at' => now(),'updated_at' => now()],
                ['id_presensi' => 16, 'id_karyawan' => 2, 'tanggal' => '2024-02-09', 'status' => 'Masuk','created_at' => now(),'updated_at' => now()],
                ['id_presensi' => 17, 'id_karyawan' => 3, 'tanggal' => '2024-02-09', 'status' => 'Tidak Masuk','created_at' => now(),'updated_at' => now()],
                ['id_presensi' => 18, 'id_karyawan' => 4, 'tanggal' => '2024-02-08', 'status' => 'Masuk','created_at' => now(),'updated_at' => now()],
                ['id_presensi' => 19, 'id_karyawan' => 5, 'tanggal' => '2024-02-09', 'status' => 'Masuk','created_at' => now(),'updated_at' => now()],
                ['id_presensi' => 20, 'id_karyawan' => 6, 'tanggal' => '2024-02-09', 'status' => 'Masuk','created_at' => now(),'updated_at' => now()],
                ['id_presensi' => 21, 'id_karyawan' => 2, 'tanggal' => '2024-02-01', 'status' => 'Masuk','created_at' => now(),'updated_at' => now()],
                ['id_presensi' => 22, 'id_karyawan' => 3, 'tanggal' => '2024-02-10', 'status' => 'Tidak Masuk','created_at' => now(),'updated_at' => now()],
                ['id_presensi' => 23, 'id_karyawan' => 4, 'tanggal' => '2024-02-10', 'status' => 'Masuk','created_at' => now(),'updated_at' => now()],
                ['id_presensi' => 24, 'id_karyawan' => 5, 'tanggal' => '2024-02-10', 'status' => 'Masuk','created_at' => now(),'updated_at' => now()],
                ['id_presensi' => 25, 'id_karyawan' => 6, 'tanggal' => '2024-02-10', 'status' => 'Masuk','created_at' => now(),'updated_at' => now()],
                ['id_presensi' => 26, 'id_karyawan' => 2, 'tanggal' => '2024-02-11', 'status' => 'Tidak Masuk','created_at' => now(),'updated_at' => now()],
                ['id_presensi' => 27, 'id_karyawan' => 3, 'tanggal' => '2024-02-11', 'status' => 'Masuk','created_at' => now(),'updated_at' => now()],
                ['id_presensi' => 28, 'id_karyawan' => 4, 'tanggal' => '2024-02-11', 'status' => 'Tidak Masuk','created_at' => now(),'updated_at' => now()],
                ['id_presensi' => 29, 'id_karyawan' => 5, 'tanggal' => '2024-02-11', 'status' => 'Masuk','created_at' => now(),'updated_at' => now()],
                ['id_presensi' => 30, 'id_karyawan' => 6, 'tanggal' => '2024-02-11', 'status' => 'Masuk','created_at' => now(),'updated_at' => now()],
                ['id_presensi' => 31, 'id_karyawan' => 2, 'tanggal' => '2024-02-12', 'status' => 'Tidak Masuk','created_at' => now(),'updated_at' => now()],
                ['id_presensi' => 32, 'id_karyawan' => 3, 'tanggal' => '2024-02-12', 'status' => 'Masuk','created_at' => now(),'updated_at' => now()],
                ['id_presensi' => 33, 'id_karyawan' => 4, 'tanggal' => '2024-02-12', 'status' => 'Masuk','created_at' => now(),'updated_at' => now()],
                ['id_presensi' => 34, 'id_karyawan' => 5, 'tanggal' => '2024-02-12', 'status' => 'Masuk','created_at' => now(),'updated_at' => now()],
                ['id_presensi' => 35, 'id_karyawan' => 6, 'tanggal' => '2024-02-12', 'status' => 'Masuk','created_at' => now(),'updated_at' => now()],
                ['id_presensi' => 36, 'id_karyawan' => 2, 'tanggal' => '2024-02-13', 'status' => 'Masuk','created_at' => now(),'updated_at' => now()],
                ['id_presensi' => 37, 'id_karyawan' => 3, 'tanggal' => '2024-02-13', 'status' => 'Masuk','created_at' => now(),'updated_at' => now()],
                ['id_presensi' => 38, 'id_karyawan' => 4, 'tanggal' => '2024-02-13', 'status' => 'Masuk','created_at' => now(),'updated_at' => now()],
                ['id_presensi' => 39, 'id_karyawan' => 5, 'tanggal' => '2024-02-13', 'status' => 'Masuk','created_at' => now(),'updated_at' => now()],
                ['id_presensi' => 40, 'id_karyawan' => 6, 'tanggal' => '2024-02-13', 'status' => 'Tidak Masuk','created_at' => now(),'updated_at' => now()],
                ['id_presensi' => 41, 'id_karyawan' => 2, 'tanggal' => '2024-02-14', 'status' => 'Masuk','created_at' => now(),'updated_at' => now()],
                ['id_presensi' => 42, 'id_karyawan' => 3, 'tanggal' => '2024-02-14', 'status' => 'Tidak Masuk','created_at' => now(),'updated_at' => now()],
                ['id_presensi' => 43, 'id_karyawan' => 4, 'tanggal' => '2024-02-14', 'status' => 'Masuk','created_at' => now(),'updated_at' => now()],
                ['id_presensi' => 44, 'id_karyawan' => 5, 'tanggal' => '2024-02-14', 'status' => 'Masuk','created_at' => now(),'updated_at' => now()],
                ['id_presensi' => 45, 'id_karyawan' => 6, 'tanggal' => '2024-02-14', 'status' => 'Masuk','created_at' => now(),'updated_at' => now()],
                ['id_presensi' => 46, 'id_karyawan' => 2, 'tanggal' => '2024-02-15', 'status' => 'Masuk','created_at' => now(),'updated_at' => now()],
                ['id_presensi' => 47, 'id_karyawan' => 3, 'tanggal' => '2024-02-15', 'status' => 'Tidak Masuk','created_at' => now(),'updated_at' => now()],
                ['id_presensi' => 48, 'id_karyawan' => 4, 'tanggal' => '2024-02-15', 'status' => 'Masuk','created_at' => now(),'updated_at' => now()],
                ['id_presensi' => 49, 'id_karyawan' => 5, 'tanggal' => '2024-02-15', 'status' => 'Masuk','created_at' => now(),'updated_at' => now()],
                ['id_presensi' => 50, 'id_karyawan' => 6, 'tanggal' => '2024-02-15', 'status' => 'Masuk','created_at' => now(),'updated_at' => now()],
                ['id_presensi' => 51, 'id_karyawan' => 2, 'tanggal' => '2024-02-16', 'status' => 'Masuk','created_at' => now(),'updated_at' => now()],
                ['id_presensi' => 52, 'id_karyawan' => 3, 'tanggal' => '2024-02-16', 'status' => 'Masuk','created_at' => now(),'updated_at' => now()],
                ['id_presensi' => 53, 'id_karyawan' => 4, 'tanggal' => '2024-02-16', 'status' => 'Masuk','created_at' => now(),'updated_at' => now()],
                ['id_presensi' => 54, 'id_karyawan' => 5, 'tanggal' => '2024-02-16', 'status' => 'Masuk','created_at' => now(),'updated_at' => now()],
                ['id_presensi' => 55, 'id_karyawan' => 6, 'tanggal' => '2024-02-16', 'status' => 'Masuk','created_at' => now(),'updated_at' => now()],
                ['id_presensi' => 56, 'id_karyawan' => 2, 'tanggal' => '2024-02-17', 'status' => 'Masuk','created_at' => now(),'updated_at' => now()],
                ['id_presensi' => 57, 'id_karyawan' => 3, 'tanggal' => '2024-02-17', 'status' => 'Masuk','created_at' => now(),'updated_at' => now()],
                ['id_presensi' => 58, 'id_karyawan' => 4, 'tanggal' => '2024-02-17', 'status' => 'Masuk','created_at' => now(),'updated_at' => now()],
                ['id_presensi' => 59, 'id_karyawan' => 5, 'tanggal' => '2024-02-17', 'status' => 'Masuk','created_at' => now(),'updated_at' => now()],
                ['id_presensi' => 60, 'id_karyawan' => 6, 'tanggal' => '2024-02-17', 'status' => 'Masuk','created_at' => now(),'updated_at' => now()],
                ['id_presensi' => 61, 'id_karyawan' => 2, 'tanggal' => '2024-02-18', 'status' => 'Masuk','created_at' => now(),'updated_at' => now()],
                ['id_presensi' => 62, 'id_karyawan' => 3, 'tanggal' => '2024-02-18', 'status' => 'Tidak Masuk','created_at' => now(),'updated_at' => now()],
                ['id_presensi' => 63, 'id_karyawan' => 4, 'tanggal' => '2024-02-18', 'status' => 'Masuk','created_at' => now(),'updated_at' => now()],
                ['id_presensi' => 64, 'id_karyawan' => 5, 'tanggal' => '2024-02-18', 'status' => 'Masuk','created_at' => now(),'updated_at' => now()],
                ['id_presensi' => 65, 'id_karyawan' => 6, 'tanggal' => '2024-02-18', 'status' => 'Tidak Masuk','created_at' => now(),'updated_at' => now()],
                ['id_presensi' => 66, 'id_karyawan' => 2, 'tanggal' => '2024-02-19', 'status' => 'Masuk','created_at' => now(),'updated_at' => now()],
                ['id_presensi' => 67, 'id_karyawan' => 3, 'tanggal' => '2024-02-19', 'status' => 'Masuk','created_at' => now(),'updated_at' => now()],
                ['id_presensi' => 68, 'id_karyawan' => 4, 'tanggal' => '2024-02-19', 'status' => 'Masuk','created_at' => now(),'updated_at' => now()],
                ['id_presensi' => 69, 'id_karyawan' => 5, 'tanggal' => '2024-02-19', 'status' => 'Masuk','created_at' => now(),'updated_at' => now()],
                ['id_presensi' => 70, 'id_karyawan' => 6, 'tanggal' => '2024-02-19', 'status' => 'Tidak Masuk','created_at' => now(),'updated_at' => now()],
                ['id_presensi' => 71, 'id_karyawan' => 2, 'tanggal' => '2024-02-20', 'status' => 'Masuk','created_at' => now(),'updated_at' => now()],
                ['id_presensi' => 72, 'id_karyawan' => 3, 'tanggal' => '2024-02-20', 'status' => 'Masuk','created_at' => now(),'updated_at' => now()],
                ['id_presensi' => 73, 'id_karyawan' => 4, 'tanggal' => '2024-02-20', 'status' => 'Masuk','created_at' => now(),'updated_at' => now()],
                ['id_presensi' => 74, 'id_karyawan' => 5, 'tanggal' => '2024-02-20', 'status' => 'Masuk','created_at' => now(),'updated_at' => now()],
                ['id_presensi' => 75, 'id_karyawan' => 6, 'tanggal' => '2024-02-20', 'status' => 'Masuk','created_at' => now(),'updated_at' => now()],
                ['id_presensi' => 76, 'id_karyawan' => 2, 'tanggal' => '2024-02-21', 'status' => 'Masuk','created_at' => now(),'updated_at' => now()],
                ['id_presensi' => 77, 'id_karyawan' => 3, 'tanggal' => '2024-02-21', 'status' => 'Masuk','created_at' => now(),'updated_at' => now()],
                ['id_presensi' => 78, 'id_karyawan' => 4, 'tanggal' => '2024-02-21', 'status' => 'Masuk','created_at' => now(),'updated_at' => now()],
                ['id_presensi' => 79, 'id_karyawan' => 5, 'tanggal' => '2024-02-21', 'status' => 'Masuk','created_at' => now(),'updated_at' => now()],
                ['id_presensi' => 80, 'id_karyawan' => 6, 'tanggal' => '2024-02-21', 'status' => 'Tidak Masuk','created_at' => now(),'updated_at' => now()],
                ['id_presensi' => 81, 'id_karyawan' => 2, 'tanggal' => '2024-02-22', 'status' => 'Masuk','created_at' => now(),'updated_at' => now()],
                ['id_presensi' => 82, 'id_karyawan' => 3, 'tanggal' => '2024-02-22', 'status' => 'Masuk','created_at' => now(),'updated_at' => now()],
                ['id_presensi' => 83, 'id_karyawan' => 4, 'tanggal' => '2024-02-22', 'status' => 'Masuk','created_at' => now(),'updated_at' => now()],
                ['id_presensi' => 84, 'id_karyawan' => 5, 'tanggal' => '2024-02-22', 'status' => 'Tidak Masuk','created_at' => now(),'updated_at' => now()],
                ['id_presensi' => 85, 'id_karyawan' => 6, 'tanggal' => '2024-02-22', 'status' => 'Tidak Masuk','created_at' => now(),'updated_at' => now()]
            ]
        );
    }
}
