<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\PembelianBahanBaku;
use App\Models\PengeluaranLain;
use App\Models\Penitip;
use App\Models\Pesanan;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index() {
        $karyawan = Karyawan::count();
        $penitip = Penitip::count();
        $produk = Produk::count();
        $pesanan = Pesanan::count();

        $monthlyPendapatan = Pesanan::selectRaw("CONCAT(DATE_FORMAT(tanggal_pesanan, '%M'), ' ',DATE_FORMAT(tanggal_pesanan, '%Y')) as bulan, SUM(total_bayar) as total")
            ->whereYear('tanggal_pesanan', date('Y'))
            ->where('status_transaksi', 'Pesanan Sudah Selesai')
            ->groupBy('bulan')
            ->get();

        $monthlyPengeluaran = PengeluaranLain::selectRaw("CONCAT(DATE_FORMAT(tanggal_pengeluaran, '%M'), ' ',DATE_FORMAT(tanggal_pengeluaran, '%Y')) as bulan, SUM(nominal_pengeluaran) as total")
            ->whereYear('tanggal_pengeluaran', date('Y'))
            ->groupBy('bulan')
            ->get();

        $monthlyPengeluaranBahanBaku = PembelianBahanBaku::selectRaw("CONCAT(DATE_FORMAT(tanggal_pembelian, '%M'), ' ',DATE_FORMAT(tanggal_pembelian, '%Y')) as bulan, SUM(harga) as total")
            ->whereYear('tanggal_pembelian', date('Y'))
            ->groupBy('bulan')
            ->get();
        
        $pendapatanBulanan = [];

        $pengeluaranBulanan = [];

        foreach ($monthlyPendapatan as $data) {
            $pendapatanBulanan[] = [
                $data->bulan => [
                    'total_pendapatan' => $data->total
                ]
            ];
        }

        foreach ($monthlyPengeluaran as $data) {
            $pengeluaranBulanan[] = [
                $data->bulan => [
                    'total_pengeluaran' => $data->total
                ]
            ];
        }

        foreach ($monthlyPengeluaranBahanBaku as $data) {
            $pengeluaranBulanan[] = [
                $data->bulan => [
                    'total_pengeluaran' => $data->total
                ]
            ];
        }
        
        $ppBulanan = [];
        foreach ($pendapatanBulanan as $pendapatan) {
            foreach ($pengeluaranBulanan as $pengeluaran) {
                if (array_key_first($pendapatan) === array_key_first($pengeluaran)) {
                    $ppBulanan[] = [
                        array_key_first($pendapatan) => [
                            'total_pendapatan' => $pendapatan[array_key_first($pendapatan)]['total_pendapatan'],
                            'total_pengeluaran' => $pengeluaran[array_key_first($pengeluaran)]['total_pengeluaran'] ?? 0
                        ]
                    ];
                }
            }
        }

        foreach ($pendapatanBulanan as $pendapatan) {
            $isExist = false;
            foreach ($ppBulanan as $pp) {
                if (array_key_first($pendapatan) === array_key_first($pp)) {
                    $isExist = true;
                }
            }

            if (!$isExist) {
                $ppBulanan[] = [
                    array_key_first($pendapatan) => [
                        'total_pendapatan' => $pendapatan[array_key_first($pendapatan)]['total_pendapatan'],
                        'total_pengeluaran' => 0
                    ]
                ];
            }
        }

        foreach ($pengeluaranBulanan as $pengeluaran) {
            $isExist = false;
            foreach ($ppBulanan as $pp) {
                if (array_key_first($pengeluaran) === array_key_first($pp)) {
                    $isExist = true;
                }
            }

            if (!$isExist) {
                $ppBulanan[] = [
                    array_key_first($pengeluaran) => [
                        'total_pendapatan' => 0,
                        'total_pengeluaran' => $pengeluaran[array_key_first($pengeluaran)]['total_pengeluaran']
                    ]
                ];
            }
        }

        usort($ppBulanan, function($a, $b) {
            return strtotime(array_key_first($a)) - strtotime(array_key_first($b));
        });

        

        return response()->json([
            'message' => 'Successfully fetch dashboard data',
            'userData' => Auth::user(),
            'data' => [
                'karyawan' => $karyawan,
                'penitip' => $penitip,
                'produk' => $produk,
                'pesanan' => $pesanan
            ],
            'ppBulanan' => $ppBulanan
        ]);
    }
}
