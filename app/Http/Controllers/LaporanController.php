<?php

namespace App\Http\Controllers;

use App\Models\Presensi;
use App\Models\Karyawan;
use Illuminate\Support\Facades\Validator;
use App\Models\BahanBaku;
use App\Models\DetailPesanan;
use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Models\Penitip;
use Carbon\Carbon;
use App\Models\PembelianBahanBaku;
use App\Models\PengeluaranLain;
use Illuminate\Support\Facades\DB; 

class LaporanController extends Controller
{
    public function laporanBulanan($year) {
        $laporanPerBulan = Pesanan::selectRaw('MONTH(tanggal_pesanan) as bulan, SUM(total_bayar) as total, COUNT(id_pesanan) as jumlah_pesanan')
            ->where('status_transaksi', 'Pesanan Sudah Selesai')
            ->whereYear('tanggal_pesanan', $year)
            ->groupBy('bulan')
            ->orderBy('bulan') 
            ->get();

        $getYearWhereHasPesanan = Pesanan::selectRaw('YEAR(tanggal_pesanan) as tahun')
            ->where('status_transaksi', 'Pesanan Sudah Selesai')
            ->groupBy('tahun')
            ->orderBy('tahun')
            ->get();

        $filledLaporanPerBulan = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthData = $laporanPerBulan->firstWhere('bulan', $i);
            if ($monthData) {
                $filledLaporanPerBulan[] = $monthData;
            } else {
                $filledLaporanPerBulan[] = (object)[
                    'bulan' => $i,
                    'total' => 0,
                    'jumlah_pesanan' => 0,
                ];
            }
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Laporan per bulan',
            'data' => $filledLaporanPerBulan,
            'listYear' => $getYearWhereHasPesanan
        ]);
    }


    public function penggunaanBahanBakuByPeriod($from, $to) {
        $from = Carbon::parse($from)->startOfDay();
        $to = Carbon::parse($to)->endOfDay();
        $pesanan = Pesanan::whereIn('status_transaksi', ['Pesanan Sudah Selesai', 'Pesanan Diterima', 'Pesanan Sedang Diproses', 'Pesanan Siap Di Pick Up', 'Pesanan Sudah Di Pick Up', 'Pesanan Sedang Diantar Kurir'])
            ->whereBetween('tanggal_pesanan', [$from, $to])
            ->get()
            ->load('detailPesanan.Produk.Resep.DetailResep', 'detailPesanan.Hampers.DetailHampers.Produk.Resep.DetailResep');

        $bahanBaku = [];
        foreach ($pesanan as $data) {
            foreach ($data->detailPesanan as $detail) {
                if ($detail->id_produk != null && $detail->Produk->id_penitip == null) {
                    foreach ($detail->Produk->Resep->DetailResep as $resep) {
                        $bahan = BahanBaku::where('id_bahan_baku', $resep->id_bahan_baku)->first();
                        if (array_key_exists($bahan->id_bahan_baku, $bahanBaku)) {
                            $bahanBaku[$bahan->id_bahan_baku] += $resep->jumlah * $detail->jumlah;
                        } else {
                            $bahanBaku[$bahan->id_bahan_baku] = $resep->jumlah * $detail->jumlah;
                        }
                    }
                } else if ($detail->id_hampers != null && $detail->Hampers->id_penitip == null) {
                    foreach ($detail->Hampers->DetailHampers as $detailHampers) {
                        if ($detailHampers->id_produk != null) {
                            foreach ($detailHampers->Produk->Resep->DetailResep as $resep) {
                                $bahan = BahanBaku::where('id_bahan_baku', $resep->id_bahan_baku)->first();
                                if (array_key_exists($bahan->id_bahan_baku, $bahanBaku)) {
                                    $bahanBaku[$bahan->id_bahan_baku] += $resep->jumlah * $detail->jumlah;
                                } else {
                                    $bahanBaku[$bahan->id_bahan_baku] = $resep->jumlah * $detail->jumlah;
                                }
                            }
                        } else {
                            $bahan = BahanBaku::where('id_bahan_baku', $detailHampers->id_bahan_baku)->first();
                            if (array_key_exists($bahan->id_bahan, $bahanBaku)) {
                                $bahanBaku[$bahan->id_bahan_baku] += $detail->jumlah;
                            } else {
                                $bahanBaku[$bahan->id_bahan_baku] = $detail->jumlah;
                            }
                        }
                    }
                }else{
                    continue;
                }
            }
        }

        $laporanBahanBaku = [];
        $tmpBahanBaku = BahanBaku::whereIn('id_bahan_baku', array_keys($bahanBaku))->get();
        foreach ($tmpBahanBaku as $bahan) {
            $laporanBahanBaku[] = [
                'id_bahan_baku' => $bahan->id_bahan_baku,
                'nama_bahan_baku' => $bahan->nama_bahan_baku,
                'satuan' => $bahan->satuan, 
                'jumlah' => $bahanBaku[$bahan->id_bahan_baku]
            ];
        }
        

        return response()->json([
            'status' => 'success',
            'message' => 'Successfully fetch penggunaan bahan baku data.',
            'data' => $laporanBahanBaku
        ], 200);
    }
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
                $karyawan = Karyawan::with(['Role' => function ($query ) {
                    $query->select('id_role', 'nama_role','nominal_gaji');
                }])
                ->select('karyawan.id_karyawan', 'karyawan.id_role', 'karyawan.nama_karyawan', 'karyawan.tanggal_masuk', 'karyawan.bonus_gaji')
                    ->selectSub(function ($query) use ($tahun, $bulan) {
                        $query->from('presensi')
                            ->selectRaw('count(id_karyawan)')
                            ->whereColumn('id_karyawan', 'karyawan.id_karyawan')
                            ->where('status', 'Masuk')
                            ->whereYear('tanggal', $tahun)
                            ->whereMonth('tanggal', $bulan);
                    }, 'jumlah_hadir')
                    ->selectSub(function ($query) use ($tahun, $bulan) {
                        $query->from('presensi')
                            ->selectRaw('count(id_karyawan)')
                            ->whereColumn('id_karyawan', 'karyawan.id_karyawan')
                            ->where('status', 'Tidak Masuk')
                            ->whereYear('tanggal', $tahun)
                            ->whereMonth('tanggal', $bulan);
                    }, 'jumlah_bolos')
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

        public function laporanTransaksiPenitip($tahun, $bulan){
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
                $laporanPenitip = Penitip::with(['Produk' => function ($query) use ($tahun, $bulan) {
                    $query->withCount(['detailPesanan as Qty' => function ($query) use ($tahun, $bulan) {
                        $query->select(DB::raw('COALESCE(SUM(jumlah), 0)'))
                            ->whereHas('Pesanan', function ($query) use ($tahun, $bulan) {
                                $query->where('status_transaksi', 'Pesanan Sudah Selesai')
                                    ->whereYear('tanggal_pesanan', $tahun)
                                    ->whereMonth('tanggal_pesanan', $bulan);
                            });
                    }]);
                }])->select('id_penitip','nama_penitip','no_hp','email')
                    ->get();
                
                
                if($laporanPenitip->count() == 0){
                    return response()->json([
                        'status' => false,
                        'message' => 'Data laporan transaksi penitip tidak ditemukan',
                        'data' => []
                    ], 404);
                }
                return response()->json([
                    'status' => true,
                    'message' => 'Laporan transaksi penitip berhasil diambil',
                    'data' => $laporanPenitip,
                ], 200);
            } catch (\Throwable $th) {
                return response()->json([
                    'status' => false,
                    'message' => 'Gagal mengambil data laporan transaksi penitip',
                    'data' => [],
                    'error' => $th->getMessage()    
                ], 500);
            }
        }

        public function laporanCashflow($tahun, $bulan){
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
                //pendapatan 
                $penjualan = Pesanan::select('id_pesanan','tanggal_pesanan','total_harga','status_transaksi', 'tip')
                    ->where('status_transaksi', 'Pesanan Sudah Selesai')
                    ->whereYear('tanggal_pesanan', $tahun)
                    ->whereMonth('tanggal_pesanan', $bulan)
                    ->sum('total_harga');
                $tip = Pesanan::select('id_pesanan','tanggal_pesanan','total_harga','status_transaksi', 'tip')
                    ->where('status_transaksi', 'Pesanan Sudah Selesai')
                    ->whereYear('tanggal_pesanan', $tahun)
                    ->whereMonth('tanggal_pesanan', $bulan)
                    ->sum('tip');

                $karyawans = Karyawan::with('Role')
                    ->where('id_karyawan', '!=', 1)
                    ->get();
                $totalPerKarayawan = [];
                foreach($karyawans as $karyawan){
                    $totalPerKarayawan[] = [
                        'id_karyawan' => $karyawan->id_karyawan,
                        'total' => $karyawan->Role->nominal_gaji + $karyawan->bonus_gaji
                    ];
                }
                $pengeluaranGaji =  array_sum(array_column($totalPerKarayawan, 'total'));
                
                $penitips = Penitip::with(['Produk' => function ($query) use ($tahun, $bulan) {
                    $query->withCount(['detailPesanan as Qty' => function ($query) use ($tahun, $bulan) {
                        $query->select(DB::raw('COALESCE(SUM(jumlah), 0)'))
                            ->whereHas('Pesanan', function ($query) use ($tahun, $bulan) {
                                $query->where('status_transaksi', 'Pesanan Sudah Selesai')
                                    ->whereYear('tanggal_pesanan', $tahun)
                                    ->whereMonth('tanggal_pesanan', $bulan);
                            });
                    }]);
                }])->select('id_penitip','nama_penitip','no_hp','email')
                    ->get();
                
                $pengeluaranBahanBaku = PembelianBahanBaku::whereYear('tanggal_pembelian', $tahun)
                    ->whereMonth('tanggal_pembelian', $bulan)
                    ->sum('harga');

                $pengeluaranLain = PengeluaranLain::
                    whereYear('tanggal_pengeluaran', $tahun)
                    ->whereMonth('tanggal_pengeluaran', $bulan)
                    ->get();

                //pengeluaran to penitip
                $totalPerPenitip = [];
                foreach ($penitips as $penitip) {
                    $total = 0;
                    foreach ($penitip->Produk as $produk) {
                        $total += $produk->Qty * $produk->harga_produk;
                    }
                    $totalPerPenitip[] = [
                        'id_penitip' => $penitip->id_penitip,
                        'total' => ($total-$total*0.2),
                    ];
                }
                $pembayaranPenitip =  array_sum(array_column($totalPerPenitip, 'total'));
                $totalPengLain = 0;
                foreach($pengeluaranLain as $pengeluaran){
                    $totalPengLain += $pengeluaran->nominal_pengeluaran;
                }
                $total = $penjualan + $tip - $pengeluaranGaji - $pembayaranPenitip - $pengeluaranBahanBaku - $totalPengLain;
                return response()->json([
                    'status' => true,
                    'message' => 'Laporan cashflow berhasil diambil',
                    'data'=>[
                        'total'=> $total,
                        'pendapatan'=>[
                            'penjualan' => $penjualan,
                            'tip' => $tip
                        ],
                        'pengeluaran'=>[
                            'gaji' => $pengeluaranGaji,
                            'penitip' => $pembayaranPenitip,
                            'bahan_baku' => $pengeluaranBahanBaku,
                        ],
                        'pengeluaran_lain' => $pengeluaranLain
                    ]
                ], 200);
            } catch (\Throwable $th) {
                return response()->json([
                    'status' => false,
                    'message' => 'Gagal mengambil data laporan cashflow',
                    'data' => [],
                    'error' => $th->getMessage()    
                ], 500);
            }
        }
}
