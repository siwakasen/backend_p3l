<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\Penitip;
use App\Models\Pesanan;
use App\Models\Produk;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard() {
        $karyawan = Karyawan::count();
        $penitip = Penitip::count();
        $produk = Produk::count();
        $pesanan = Pesanan::count();

        return response()->json([
            'message' => 'Successfully fetch dashboard data',
            'data' => [
                'karyawan' => $karyawan,
                'penitip' => $penitip,
                'produk' => $produk,
                'pesanan' => $pesanan
            ]
        ]);
    }
}
