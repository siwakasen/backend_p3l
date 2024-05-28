<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use Illuminate\Http\Request;

class PesananController extends Controller
{
    public function getAllPesananMasuk() {
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully fetch pesanan data.',
            'data' => Pesanan::where(function($query) {
                $query->where(function($subQuery) {
                    $subQuery->where('status_transaksi', 'Menunggu Konfirmasi Pesanan')
                             ->where('metode_pengiriman', 'LIKE', 'Pick Up %');
                    })->orWhere('status_transaksi', 'Menunggu Konfirmasi Pembayaran');
                })
                ->get()
                ->load('User')
                ->load('DetailPesanan')
        ], 200);
    }

    public function getPesanan($id) {
        if (Pesanan::where('id_pesanan', $id)->first() == null) {
            return response()->json([
                'status' => 'error',
                'message' => 'Pesanan not found.'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Successfully fetch pesanan data.',
            'data' => Pesanan::where('id_pesanan', $id)->first()->load('User')->load('detailPesanan.Produk', 'detailPesanan.Hampers', 'detailPesanan.Produk.Kategori')
        ], 200);
    }

    public function updateOngkir(Request $request, $id) {
        $pesanan = Pesanan::where('id_pesanan', $id)->first();
        if ($pesanan == null) {
            return response()->json([
                'status' => 'error',
                'message' => 'Pesanan not found.'
            ], 404);
        }

        $jarak_pengiriman = $request->jarak_pengiriman;
        $ongkir = 0;
        if ($jarak_pengiriman <= 5) {
            $ongkir = 10000;
        } else if ($jarak_pengiriman > 5 && $jarak_pengiriman <= 10) {
            $ongkir = 15000;
        } else if ($jarak_pengiriman > 10 && $jarak_pengiriman <= 15) {
            $ongkir = 20000;
        } else {
            $ongkir = 25000;
        }

        $pesanan->ongkir = $ongkir;
        $pesanan->status_transaksi = 'Menunggu Pembayaran';
        $pesanan->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Successfully update ongkir data.',
            'data' => $pesanan
        ], 200);
    }

    public function updateTotalBayar(Request $request, $id) {
        $pesanan = Pesanan::where('id_pesanan', $id)->first();
        if ($pesanan == null) {
            return response()->json([
                'status' => 'error',
                'message' => 'Pesanan not found.'
            ], 404);
        }

        $total_bayar = $request->total_bayar;
        if ($total_bayar > $pesanan->total_harga) {
            $tip = $total_bayar - $pesanan->total_harga;
            $pesanan->tip = $tip;
        }

        $pesanan->total_bayar = $total_bayar;
        $pesanan->status_transaksi = 'Pembayaran Valid';
        $pesanan->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Successfully update total bayar data.',
            'data' => $pesanan
        ], 200);
    }
}
