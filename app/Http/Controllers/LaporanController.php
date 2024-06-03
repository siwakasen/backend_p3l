<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Presensi;
use App\Models\Karyawan;
use Illuminate\Support\Facades\Validator;

class LaporanController extends Controller
{
        public function laporanPresensiKaryawan($tahun, $bulan){

            if($bulan < 1 || $bulan > 12){
                return response()->json([
                    'status' => false,
                    'message' => 'Bulan tidak valid',
                    'data' => []
                ], 400);
            }
            if($tahun < 1){
                return response()->json([
                    'status' => false,
                    'message' => 'Tahun tidak valid',
                    'data' => []
                ], 400);
            }

            try {
                $karyawan = Karyawan::with(['Role' => function ($query) {
                    $query->select('id_role', 'nama_role','nominal_gaji');
                }])
                ->select('karyawan.id_karyawan', 'karyawan.id_role', 'karyawan.nama_karyawan', 'karyawan.tanggal_masuk', 'karyawan.bonus_gaji')
                    ->selectSub(function ($query) {
                        $query->from('presensi')
                            ->selectRaw('count(id_karyawan)')
                            ->whereColumn('id_karyawan', 'karyawan.id_karyawan')
                            ->where('status', 'Masuk');
                    }, 'Jumlah Hadir')
                    ->selectSub(function ($query) {
                        $query->from('presensi')
                            ->selectRaw('count(id_karyawan)')
                            ->whereColumn('id_karyawan', 'karyawan.id_karyawan')
                            ->where('status', 'Tidak Masuk');
                    }, 'Jumlah Bolos')
                    ->where('id_karyawan', '!=', 1)
                    ->get();
                return response()->json([
                    'status' => true,
                    'message' => 'Data laporan presensi karyawan berhasil diambil',
                    'data' => $karyawan
                ], 200);

                $presensi = Presensi::whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->get();
                if($presensi->count() == 0){
                    return response()->json([
                        'status' => false,
                        'message' => 'Data presensi karyawan tidak ditemukan',
                        'data' => []
                    ], 404);
                }
                // $laporan =[
                //     'bulan' => $bulan,
                //     'tahun' => $tahun,
                //     'tanggal_cetak'=> Carbon::now()->toDateString('Y-m-d'),
                //     'total'=> 
                //     'presensi'=>[
                //         foreach($presensi as $data){
                //             'nama' => $data->id_karyawan,
                //             'jumlah_hadir' => $data->karyawan->nama,
                //             'jumlah_bolos' => $data->tanggal,
                //             'honor_harian' => $data->jam_masuk,
                //             'bonus_rajin' => $data->jam_pulang,
                //             'total' => $data->status
                //         }
                //     ]
                // ];
                return response()->json([
                    'status' => true,
                    'message' => 'Laporan presensi karyawan berhasil diambil',
                    'data' => $presensi
                ], 200);
            } catch (\Throwable $th) {
                return response()->json([
                    'status' => false,
                    'message' => 'Gagal mengambil data laporan presensi karyawan',
                    'data' => [],
                    'error' => $th->getMessage()    
                ], 500);
            }
        }
}
