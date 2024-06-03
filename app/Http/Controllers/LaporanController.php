<?php

namespace App\Http\Controllers;

use App\Models\BahanBaku;
use App\Models\DetailPesanan;
use Illuminate\Http\Request;
use App\Models\Pesanan;
use Carbon\Carbon;

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
}
