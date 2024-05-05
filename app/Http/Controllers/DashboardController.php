<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\PembelianBahanBaku;
use App\Models\PengeluaranLain;
use App\Models\Penitip;
use App\Models\Pesanan;
use App\Models\Produk;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index() {
        $karyawan = Karyawan::count();
        $penitip = Penitip::count();
        $produk = Produk::count();
        $pesanan = Pesanan::count();

        $monthlyPendapatan = Pesanan::selectRaw("DATE_FORMAT(tanggal_pesanan, '%M %Y') as bulan, SUM(total_bayar) as total")
            ->whereYear('tanggal_pesanan', date('Y'))
            ->where('status_transaksi', 'Pesanan Sudah Selesai')
            ->groupBy('bulan')
            ->get();

        $monthlyPengeluaran = PengeluaranLain::selectRaw("DATE_FORMAT(tanggal_pengeluaran, '%M %Y') as bulan, SUM(nominal_pengeluaran) as total")
            ->whereYear('tanggal_pengeluaran', date('Y'))
            ->groupBy('bulan')
            ->get();

        $monthlyPengeluaranBahanBaku = PembelianBahanBaku::selectRaw("DATE_FORMAT(tanggal_pembelian, '%M %Y') as bulan, SUM(harga) as total")
            ->whereYear('tanggal_pembelian', date('Y'))
            ->groupBy('bulan')
            ->get();

            $uniqueMonths = collect()
            ->merge($monthlyPendapatan->pluck('bulan'))
            ->merge($monthlyPengeluaran->pluck('bulan'))
            ->merge($monthlyPengeluaranBahanBaku->pluck('bulan'))
            ->unique();

        $ppBulanan = [];

        foreach ($uniqueMonths as $bulan) {
            $total_pendapatan = $monthlyPendapatan->where('bulan', $bulan)->first()->total ?? 0;
            
            $total_pengeluaran = 0;
            foreach ($monthlyPengeluaran as $pengeluaran) {
                if ($pengeluaran->bulan === $bulan) {
                    $total_pengeluaran += $pengeluaran->total;
                }
            }
            foreach ($monthlyPengeluaranBahanBaku as $pengeluaran) {
                if ($pengeluaran->bulan === $bulan) {
                    $total_pengeluaran += $pengeluaran->total;
                }
            }

            $ppBulanan[] = [
                'bulan' => $bulan,
                'total_pendapatan' => $total_pendapatan,
                'total_pengeluaran' => $total_pengeluaran
            ];
        }

        usort($ppBulanan, function($a, $b) {
            return strtotime($a['bulan']) - strtotime($b['bulan']);
        });

        $get7Days = Pesanan::selectRaw("DATE_FORMAT(tanggal_pesanan, '%Y-%m-%d') as tanggal, SUM(total_bayar) as total")
            ->whereBetween('tanggal_pesanan', [date('Y-m-d', strtotime('-7 days')), date('Y-m-d')])
            ->where('status_transaksi', 'Pesanan Sudah Selesai')
            ->groupBy('tanggal')
            ->get();

        $get7DaysPengeluaran = PengeluaranLain::selectRaw("DATE_FORMAT(tanggal_pengeluaran, '%Y-%m-%d') as tanggal, SUM(nominal_pengeluaran) as total")
            ->whereBetween('tanggal_pengeluaran', [date('Y-m-d', strtotime('-7 days')), date('Y-m-d')])
            ->groupBy('tanggal')
            ->get();

        $get7DaysPengeluaranBahanBaku = PembelianBahanBaku::selectRaw("DATE_FORMAT(tanggal_pembelian, '%Y-%m-%d') as tanggal, SUM(harga) as total")
            ->whereBetween('tanggal_pembelian', [date('Y-m-d', strtotime('-7 days')), date('Y-m-d')])
            ->groupBy('tanggal')
            ->get();

        $ppHarian = [];

        foreach ($get7Days as $data) {
            $ppHarian[] = [
                'tanggal' => $data->tanggal,
                'total_pendapatan' => $data->total,
                'total_pengeluaran' => 0,
            ];
        }
        
        foreach ($get7DaysPengeluaran as $data) {
            $tanggal = $data->tanggal;
            $found = false;
            foreach ($ppHarian as &$item) {
                if ($item['tanggal'] === $tanggal) {
                    $item['total_pengeluaran'] += $data->total;
                    $found = true;
                    break;
                }
            }
            if (!$found) {
                $ppHarian[] = [
                    'tanggal' => $tanggal,
                    'total_pendapatan' => 0,
                    'total_pengeluaran' => $data->total,
                ];
            }
        }
            
        foreach ($get7DaysPengeluaranBahanBaku as $data) {
            $tanggal = $data->tanggal;
            $found = false;
            foreach ($ppHarian as &$item) {
                if ($item['tanggal'] === $tanggal) {
                    $item['total_pengeluaran'] += $data->total;
                    $found = true;
                    break;
                }
            }
            if (!$found) {
                $ppHarian[] = [
                    'tanggal' => $tanggal,
                    'total_pendapatan' => 0,
                    'total_pengeluaran' => $data->total,
                ];
            }
        }

        $ppHarian = array_values($ppHarian);

        ksort($ppHarian);

        $dataPreviousYear = Pesanan::selectRaw("DATE_FORMAT(tanggal_pesanan, '%M %Y') as bulan, SUM(total_bayar) as total")
            ->whereYear('tanggal_pesanan', date('Y') - 1)
            ->where('status_transaksi', 'Pesanan Sudah Selesai')
            ->groupBy('bulan')
            ->get();
        
        $dataCurrentYear = Pesanan::selectRaw("DATE_FORMAT(tanggal_pesanan, '%M %Y') as bulan, SUM(total_bayar) as total")
            ->whereYear('tanggal_pesanan', date('Y'))
            ->where('status_transaksi', 'Pesanan Sudah Selesai')
            ->groupBy('bulan')
            ->get();

        $ppTahunan = [
            'tahun_lalu' => 0,
            'tahun_ini' => 0
        ];

        foreach ($dataPreviousYear as $data) {
            $ppTahunan['tahun_lalu'] += $data->total;
        }

        foreach ($dataCurrentYear as $data) {
            $ppTahunan['tahun_ini'] += $data->total;
        }

        $averageMonthlyEarning = 0;
        $lastYearAverageMonthlyEarning = 0;

        if (count($dataCurrentYear) > 0) {
            $averageMonthlyEarning = $ppTahunan['tahun_ini'] / count($dataCurrentYear);
        }

        if (count($dataPreviousYear) > 0) {
            $lastYearAverageMonthlyEarning = $ppTahunan['tahun_lalu'] / count($dataPreviousYear);
        }
        
        return response()->json([
            'message' => 'Successfully fetch dashboard data',
            'data' => [
                'karyawan' => $karyawan,
                'penitip' => $penitip,
                'produk' => $produk,
                'pesanan' => $pesanan,
                'ppHarian' => $ppHarian, 
                'ppBulanan' => $ppBulanan,
                'ppTahunan' => $ppTahunan,
                'averageMonthlyEarning' => $averageMonthlyEarning,
                'lastYearAverageMonthlyEarning' => $lastYearAverageMonthlyEarning
            ],
        ]);
    }
}
