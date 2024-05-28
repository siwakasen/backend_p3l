<?php

namespace App\Http\Controllers;

use App\Models\DetailPesanan;
use App\Models\Hampers;
use App\Models\LimitProduk;
use App\Models\Pesanan;
use App\Models\Produk;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PesananController extends Controller
{
    public function checkout(Request $request)
    {
        try {
        $data = $request->all();
        $validator = Validator::make($data, [
            'status_transaksi' => 'required',
            'tanggal_pesanan' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors(),
                'data' => null
            ]);
        }

        $pesanan = Pesanan::create($data);

        $pesanan = Pesanan::with('detailPesanan')->where('id_pesanan', $pesanan->id_pesanan)->first();
        $year = date("y", strtotime($pesanan->tanggal_pesanan));
        $month = date("m", strtotime($pesanan->tanggal_pesanan));
        $no_nota = "{$year}.{$month}.{$pesanan->id_pesanan}";
        $pesanan->no_nota = $no_nota;
        $pesanan->save();

        $user = User::where('id_user', $pesanan->id_user)->first();
        if ($user && !is_null($pesanan->poin_dipakai)) {
            $newPoin = $user->poin - $pesanan->poin_dipakai;
            $user->update(['poin' => $newPoin]);
        }

        $date = date("Y-m-d", strtotime($pesanan->tanggal_diambil));

        $cart = Pesanan::where('id_user', $user->id_user)->where('status_transaksi', "Cart")->first();
        foreach ($data['detail_pesanan'] as $dp) {
            DetailPesanan::create([
                'id_pesanan' => $pesanan->id_pesanan,
                'id_produk' => $dp['id_produk'] ?? null,
                'id_hampers' => $dp['id_hampers'] ?? null,
                'jumlah' => $dp['jumlah'],
                'status_pesanan' => $data['statusPesanan'] ?? null,
                'subtotal' => $dp['subtotal']
            ]);
            if ($data['isCart']) {
                if (isset($dp['id_produk']) && !isset($dp['id_hampers'])) {
                    DB::table('detail_pesanan')
                        ->where('id_pesanan', $cart->id_pesanan)
                        ->where('id_produk', $dp['id_produk'])
                        ->delete();
                } else if (is_null($dp['id_produk'] ?? null) && !is_null($dp['id_hampers'])) {
                    DB::table('detail_pesanan')
                        ->where('id_pesanan', $cart->id_pesanan)
                        ->where('id_hampers', $dp['id_hampers'])
                        ->delete();
                }
            }
            if (isset($data['statusPesanan'])) {
                $status = $data['statusPesanan'];
                if ($status == 'Ready') {
                    Produk::find($dp['id_produk'])->decrement('stok_produk', $dp['jumlah']);
                } else if ($status == 'PO') {
                    if (isset($dp['id_hampers']) && !is_null($dp['id_hampers'])) {
                        $tempDetailHamper = Hampers::with('DetailHampers')->find($dp['id_hampers'])['DetailHampers'];
                        foreach ($tempDetailHamper as $detail) {
                            if (!is_null($detail->id_produk)) {
                                LimitProduk::where('tanggal', $date)->where('id_produk', $detail->id_produk)->decrement('limit', $dp['jumlah']);
                            }
                        }
                    } else if (
                        isset($dp['id_produk']) && !is_null($dp['id_produk'])
                    ) {
                        LimitProduk::where('tanggal', $date)->where('id_produk', $dp['id_produk'])->decrement('limit', $dp['jumlah']);
                    }
                }
            }
        }

        return response()->json([
            'status' => true,
            'message' => 'Pesanan berhasil ditambahkan',
            'data' => $pesanan
        ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Pesanan gagal ditambahkan',
                'data' => null
            ]);
        }
    }

    public function addToCart(Request $request)
    {
        try {
            $user = auth()->user();
            if (!$user) {
                return response()->json([
                    'status' => true,
                    'message' => 'Token invalid',
                    'data' => $user,
                ], 400);
            }

            $cart = Pesanan::where('id_user', $user->id_user)->where('status_transaksi', "Cart")->first();
            if (!$cart) {
                $cart = Pesanan::create([
                    'id_user' => $user->id_user,
                    'status_transaksi' => "Cart"
                ]);
            }

            $item = $request->all();
            $detail_pesanan = DetailPesanan::where('id_pesanan', $cart->id_pesanan)->get();
            $isExist = false;

            foreach ($detail_pesanan as $dp) {
                if (isset($item['id_produk'])) {
                    if ($dp->id_produk == $item['id_produk'] && is_null($dp->id_hampers)) {
                        DB::table('detail_pesanan')
                            ->where('id_pesanan', $dp->id_pesanan)
                            ->where('id_produk', $dp->id_produk)
                            ->update(['jumlah' => $dp->jumlah + 1]);
                        $isExist = true;
                    }
                } elseif (isset($item['id_hampers'])) {
                    if ($dp->id_hampers == $item['id_hampers'] && is_null($dp->id_produk)) {
                        DB::table('detail_pesanan')
                            ->where('id_pesanan', $dp->id_pesanan)
                            ->where('id_hampers', $dp->id_hampers)
                            ->update(['jumlah' => $dp->jumlah + 1]);
                        $isExist = true;
                    }
                }
            }

            if (!$isExist) {
                DetailPesanan::create([
                    'id_pesanan' => $cart->id_pesanan,
                    'id_produk' => $item['id_produk'] ?? null,
                    'id_hampers' => $item['id_hampers'] ?? null,
                    'jumlah' => 1,
                    'subtotal' => null
                ]);
            }

            $cart = Pesanan::with('detailPesanan')->where('id_user', $user->id_user)->where('status_transaksi', "Cart")->first();

            return response()->json([
                'status' => true,
                'message' => 'Pesanan berhasil ditambahkan',
                'data' => $cart,
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Pesanan gagal ditambahkan',
                'data' => null
            ], 500);
        }
    }

    public function getCart()
    {
        try {
            $user = auth()->user();
            if (!$user) {
                return response()->json([
                    'status' => true,
                    'message' => 'Token invalid',
                    'data' => $user,
                ], 400);
            }

            $cart = Pesanan::with('detailPesanan')->where('id_user', $user->id_user)->where('status_transaksi', "Cart")->first();

            return response()->json([
                'status' => true,
                'message' => 'Success get cart',
                'data' => $cart,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Failed get cart',
                'data' => null
            ], 500);
        }
    }
}
