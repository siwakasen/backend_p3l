<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\Pesanan;
use App\Models\User;
use App\Models\Produk;
use App\Models\BahanBaku;
use App\Models\LimitProduk;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


class PesananController extends Controller
{
    public function getPesananBelumDibayar(){
        $user = Auth::user();
        $id = $user->id_user;
        try {
            $pesanan = Pesanan::with(['detailPesanan' => function ($query) {
                $query->select('id_pesanan', 'id_produk', 'id_hampers', 'jumlah', 'subtotal')
                    ->with(['Produk' => function ($query) {
                        $query->select('id_produk', 'nama_produk',  'harga_produk');
                    }, 'Hampers' => function ($query) {
                        $query->select('id_hampers', 'nama_hampers', 'harga_hampers');
                    }]);
                }])
                ->where('id_user', $id)
                ->where('status_transaksi', 'Pesanan Belum Dibayar')
                ->get();
            if (count($pesanan) == 0) {
                throw new \Exception();
            }
            return response()->json([
                'status' => true,
                'message' => 'Success get pesanan belum dibayar',
                'data' => $pesanan
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Pesanan not found',
                'error' => $th->getMessage(),
                'data' => []
            ], 404);
        }
    }

    public function bayarPesanan($id, Request $request){
        try {
            $validator = Validator::make($request->all(), [
                'bukti_pembayaran' => 'required'
            ],
            [
                'bukti_pembayaran.required' => 'Bukti pembayaran harus diisi!'
            ]);
            if($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => $validator->errors()
                ], 400);
            }

            $pesanan = Pesanan::where('id_pesanan', $id)->where('status_transaksi', 'Pesanan Belum Dibayar')->first();
            if($pesanan == null){
                throw new \Exception();
            }
            if($pesanan->tanggal_pesanan <= Carbon::now()->addDay()->toDateTimeString()){
                $pesanan->update([
                    'status_transaksi' => 'Pesanan Dibatalkan'
                ]);
                return response()->json([
                    'status' => false,
                    'message' => 'Pesanan sudah meewlati batas waktu pembayaran'
                ], 400);
            }
            $userId = auth()->user()->id;
            $hash = md5($userId . $pesanan->id_pesanan);
            $extension = $request->file('bukti_pembayaran')->guessExtension();
            $path = $request->file('bukti_pembayaran')->storeAs('bukti_pembayaran', $hash . '.' . $extension, 'public');
            
            $pesanan->update([
                'status_transaksi' => 'Pesanan Sudah Dibayar',
                'tanggal_pembayaran' => now(),
                'bukti_pembayaran' => $hash . '.' . $extension
            ]);
            return response()->json([
                'status' => true,
                'message' => 'Pesanan berhasil dibayar'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Pesanan not found',
                'error' => $th->getMessage()
            ], 404);
        }
    }

    public function getPesananValid(){
        try {
            $pesanan = Pesanan::with(['detailPesanan' => function ($query) {
                $query->select('id_pesanan', 'id_produk', 'id_hampers', 'jumlah', 'subtotal')
                    ->with(['Produk' => function ($query) {
                        $query->select('id_produk', 'nama_produk',  'harga_produk','id_resep','id_penitip');
                    }, 'Hampers' => function ($query) {
                        $query->select('id_hampers', 'nama_hampers', 'harga_hampers');
                    }]);
                }])
                ->where('status_transaksi', 'Pembayaran Valid')
                ->get();
            if (count($pesanan) == 0) {
                throw new \Exception();
            }
            return response()->json([
                'status' => true,
                'message' => 'Success get pesanan valid',
                'data' => $pesanan
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Pesanan not found',
                'error' => $th->getMessage(),
                'data' => []
            ], 404);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Pesanan not found',
                'error' => $th->getMessage()
            ], 404);
        }
    }

    public function confirmPesanan($id,Request $request){
        try {
            $validator = Validator::make($request->all(), [
                'status' => 'required|in:diterima,ditolak'
            ],
            [
                'status.required' => 'Status konfirmasi harus diisi!',
                'status.in' => 'Status konfirmasi harus `diterima` atau `ditolak`!',
            ]);
            if($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => $validator->errors()
                ], 400);
            }
            $pesanan = Pesanan::with(['detailPesanan' => function ($query) {
                $query->select('id_pesanan', 'id_produk', 'id_hampers','status_pesanan', 'jumlah', 'subtotal')
                    ->with(['Produk' => function ($query) {
                        $query->select('id_produk', 'nama_produk',  'harga_produk','id_resep','id_penitip','stok_produk')
                        ->with(['Resep' => function ($query) {
                            $query->select('id_resep', 'nama_resep')
                            ->with(['DetailResep' => function ($query) {
                                $query->select('id_resep','id_bahan_baku','jumlah');
                            }]);
                        }]);
                    }, 'Hampers' => function ($query) {
                        $query->select('id_hampers', 'nama_hampers', 'harga_hampers')
                        ->with(['DetailHampers' => function ($query) {
                            $query->select('id_hampers', 'id_produk', 'id_bahan_baku')
                            ->with(['Produk' => function ($query) {
                                $query->select('id_produk', 'nama_produk',  'harga_produk','id_resep','id_penitip','stok_produk')
                                ->with(['Resep' => function ($query) {
                                    $query->select('id_resep', 'nama_resep')
                                    ->with(['DetailResep' => function ($query) {
                                        $query->select('id_resep','id_bahan_baku','jumlah');
                                    }]);
                                }]);
                            }]);
                        }]);
                    }]);
                }])
                ->where('id_pesanan', $id)
                ->where('status_transaksi', 'Pembayaran Valid')
                ->first();
            if($pesanan == null){
                throw new \Exception();
            }
            if($request->status == 'diterima'){
                if($pesanan->poin_didapat!=null){
                    $user = User::where('id_user', $pesanan->id_user)->first();
                    $user->update([
                        'poin' => $user->poin + $pesanan->poin_didapat
                    ]);
                }
                $pesanan->update([
                    'status_transaksi' => 'Pesanan Diterima'
                ]);
            }else{
                //mengembalikan stok bahan baku produk penitip, produk toko, hampers
                foreach ($pesanan->detailPesanan as $detail) {
                    if($detail->id_produk!=null){
                        //produk penitip 
                        if($detail->Produk->id_penitip!=null){
                            $produk = Produk::where('id_produk', $detail->id_produk)->first();
                            $produk->update([
                                'stok' => $produk->stok + $detail->jumlah
                            ]);
                        }else{
                            if($detail->status_pesanan == 'ready'){
                                //pengembalian produk ready
                                $produk = Produk::where('id_produk', $detail->id_produk)->first();
                                $produk->update([
                                    'stok' => $produk->stok + $detail->jumlah
                                ]);
                            }else{
                                //pengembalian produk pre order
                                foreach ($detail->Produk->Resep->DetailResep as $resep) {
                                    $bahanBaku = BahanBaku::where('id_bahan_baku', $resep->id_bahan_baku)->first();
                                    $jml_stok_kembali = $resep->jumlah * $detail->jumlah;
                                    $bahanBaku->update([
                                        'stok' => $bahanBaku->stok + $jml_stok_kembali
                                    ]);
                                }
                                $limitProduk = LimitProduk::where('id_produk', $detail->id_produk)->first();
                                $limitProduk->update([
                                    'limit' => $limitProduk->limit + $detail->jumlah
                                ]);
                            }
                        }
                    }else{
                        foreach ($detail->Hampers->DetailHampers as $detailHampers) {
                            //pengembalian hampers
                            if($detailHampers->id_bahan_baku!=null){
                                //pengembalian bahan baku card dan box
                                $bahanBaku = BahanBaku::where('id_bahan_baku', $detailHampers->id_bahan_baku)->first();
                                $bahanBaku->update([
                                    'stok' => $bahanBaku->stok + $detail->jumlah
                                ]);
                            }else{
                                if($detail->status_pesanan == 'ready'){
                                    //pengembalian hampers ready (jika kedua produk di dalam hampers ready)
                                    $produk = Produk::where('id_produk', $detailHampers->id_produk)->first();
                                    $produk->update([
                                        'stok' => $produk->stok + $detail->jumlah
                                    ]);
                                }else{
                                    //pengembalian hampers pre order
                                    $limitProduk = LimitProduk::where('id_produk', $detailHampers->id_produk)->first();
                                    $limitProduk->update([
                                        'limit' => $limitProduk->limit + $detail->jumlah
                                    ]);
                                    foreach ($detailHampers->Produk->Resep->detailResep as $resep) {
                                        $bahanBaku = BahanBaku::where('id_bahan_baku', $resep->id_bahan_baku)->first();
                                        $jml_stok_kembali = $resep->jumlah * $detail->jumlah;
                                        $bahanBaku->update([
                                            'stok' => $bahanBaku->stok + $jml_stok_kembali
                                        ]);
                                    }
                                }
                            }
                        }
                    }
                }

                //menambah saldo customer
                $user = User::where('id_user', $pesanan->id_user)->first();
                $user->update([
                    'saldo' => $user->saldo + $pesanan->total_bayar
                ]);
                $pesanan->update([
                    'status_transaksi' => 'Pesanan Ditolak'
                ]);
            }
            return response()->json([
                'status' => true,
                'message' => $pesanan->status_transaksi,
                'data' => $pesanan
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Pesanan not found',
                'error' => $th->getMessage()
            ], 404);
        }
    }
}
