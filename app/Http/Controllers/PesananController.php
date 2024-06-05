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
use Illuminate\Support\Facades\DB;
use App\Models\Hampers;
use App\Models\DetailPesanan;
use App\Models\PencatatanBahanBaku;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;
use Kreait\Laravel\Firebase\Facades\Firebase;


class PesananController extends Controller
{
    public function getPesananBelumDibayar()
    {
        $user = Auth::user();
        $id = $user->id_user;
        try {
            $pesanan = Pesanan::with(['detailPesanan' => function ($query) {
                $query->select('id_pesanan', 'id_produk', 'id_hampers', 'jumlah', 'subtotal')
                    ->with(['Produk' => function ($query) {
                        $query->select('id_produk', 'nama_produk',  'harga_produk', 'id_kategori', 'foto_produk', 'deskripsi_produk',);
                    }, 'Hampers' => function ($query) {
                        $query->select('id_hampers', 'nama_hampers', 'harga_hampers', 'foto_hampers', 'deskripsi_hampers');
                    }]);
            }])
                ->where('id_user', $id)
                ->where('status_transaksi', 'Menunggu Pembayaran')
                ->orderBy('tanggal_pesanan', 'desc')
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

    public function bayarPesanan($id, Request $request)
        {
            try {
                $validator = Validator::make($request->all(), [
                    'bukti_pembayaran' => 'required'
                ]);
                if ($validator->fails()) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Bukti pembayaran harus diisi!'
                    ], 400);
                }

                $pesanan = Pesanan::with(['detailPesanan' => function ($query) {
                    $query->select('id_pesanan', 'id_produk', 'id_hampers', 'jumlah', 'subtotal', 'status_pesanan')
                        ->with(['Produk' => function ($query) {
                            $query->select('id_produk', 'nama_produk',  'harga_produk', 'id_kategori', 'id_penitip');
                        }, 'Hampers' => function ($query) {
                            $query->select('id_hampers', 'nama_hampers', 'harga_hampers');
                        }]);
                }])
                    ->where('id_pesanan', $id)
                    ->where('status_transaksi', 'Menunggu Pembayaran')
                    ->first();

                if ($pesanan == null) {
                    throw new \Exception();
                }
                $isPreOrder = false;
                foreach ($pesanan->detailPesanan as $detail) {
                    if ($detail->status_pesanan == 'PO') {
                        $isPreOrder = true;
                        break;
                    }
                }

                if ($isPreOrder) {
                    if (Carbon::parse($pesanan->tanggal_diambil)->toDateString() <= Carbon::now()->addDay()->toDateString()) {
                        return response()->json([
                            'status' => false,
                            'message' => 'Pesanan sudah melewati batas waktu pembayaran'
                        ], 400);
                    }
                } else {
                    if (Carbon::parse($pesanan->tanggal_diambil)->toDateString() < Carbon::now()->toDateString() ) {
                        return response()->json([
                            'status' => false,
                            'message' => 'Pesanan sudah melewati batas waktu pembayaran',
                        ], 400);
                    }
                }

                $userId = auth()->user()->id;
                $hash = md5($userId . $pesanan->id_pesanan);
                $extension = $request->file('bukti_pembayaran')->guessExtension();
                $path = $request->file('bukti_pembayaran')->storeAs('bukti_pembayaran', $hash . '.' . $extension, 'public');

                $pesanan->update([
                    'status_transaksi' => 'Menunggu Konfirmasi Pembayaran',
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

    public function getPesananValid()
    {
        try {
            $pesanan = Pesanan::with(['detailPesanan' => function ($query) {
                $query->select('id_pesanan', 'id_produk', 'id_hampers', 'jumlah', 'subtotal')
                    ->with(['Produk' => function ($query) {
                        $query->select('id_produk', 'nama_produk',  'harga_produk', 'id_resep', 'id_penitip');
                    }, 'Hampers' => function ($query) {
                        $query->select('id_hampers', 'nama_hampers', 'harga_hampers');
                    }]);
            }])
                ->where('status_transaksi', 'Pembayaran Valid')
                ->orderBy('tanggal_pesanan', 'desc')
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

        public function confirmPesanan($id, Request $request)
        {
            try {
                $validator = Validator::make(
                    $request->all(),
                    [
                        'status_transaksi' => 'required|in:diterima,ditolak'
                    ],
                    [
                        'status_transaksi.required' => 'Status konfirmasi harus diisi!',
                        'status_transaksi.in' => 'Status konfirmasi harus `diterima` atau `ditolak`!',
                    ]
                );
                if ($validator->fails()) {
                    return response()->json([
                        'status' => 'error',
                        'message' => $validator->errors()
                    ], 400);
                }
                $pesanan = Pesanan::with(['detailPesanan' => function ($query) {
                    $query->select('id_pesanan', 'id_produk', 'id_hampers', 'status_pesanan', 'jumlah', 'subtotal')
                        ->with(['Produk' => function ($query) {
                            $query->select('id_produk', 'nama_produk',  'harga_produk', 'id_resep', 'id_penitip', 'stok_produk')
                                ->with(['Resep' => function ($query) {
                                    $query->select('id_resep', 'nama_resep')
                                        ->with(['DetailResep' => function ($query) {
                                            $query->select('id_resep', 'id_bahan_baku', 'jumlah');
                                        }]);
                                }]);
                        }, 'Hampers' => function ($query) {
                            $query->select('id_hampers', 'nama_hampers', 'harga_hampers')
                                ->with(['DetailHampers' => function ($query) {
                                    $query->select('id_hampers', 'id_produk', 'id_bahan_baku')
                                        ->with(['Produk' => function ($query) {
                                            $query->select('id_produk', 'nama_produk',  'harga_produk', 'id_resep', 'id_penitip', 'stok_produk')
                                                ->with(['Resep' => function ($query) {
                                                    $query->select('id_resep', 'nama_resep')
                                                        ->with(['DetailResep' => function ($query) {
                                                            $query->select('id_resep', 'id_bahan_baku', 'jumlah');
                                                        }]);
                                                }]);
                                        }]);
                                }]);
                        }]);
                }])
                    ->where('id_pesanan', $id)
                    ->where('status_transaksi', 'Pembayaran Valid')
                    ->first();
                if ($pesanan == null) {
                    throw new \Exception();
                }
                if ($request->status_transaksi == 'diterima') {

                    if ($pesanan->poin_didapat != null) {
                        $user = User::where('id_user', $pesanan->id_user)->first();
                        $user->update([
                            'poin' => $user->poin + $pesanan->poin_didapat
                        ]);
                    }
                    
                    $pesanan->update([
                        'status_transaksi' => 'Pesanan Diterima'
                    ]);
                } else {
                    //mengembalikan stok ready produk penitip, produk toko atau kuota produk toko
                    foreach ($pesanan->detailPesanan as $detail) {
                        if ($detail->id_produk != null) {
                            //produk penitip 
                            if ($detail->Produk->id_penitip != null) {
                                //pengembalian produk penitip
                                $produk = Produk::where('id_produk', $detail->id_produk)->first();
                                if ($produk != null) {
                                    $produk->update([
                                        'stok_produk' => $produk->stok_produk + $detail->jumlah
                                    ]);
                                }
                            } else {
                                if ($detail->status_pesanan == 'Ready') {
                                    //pengembalian produk ready
                                    $produk = Produk::where('id_produk', $detail->id_produk)->first();
                                    if ($produk != null) {
                                        $produk->update([
                                            'stok_produk' => $produk->stok_produk + $detail->jumlah
                                        ]);
                                    }
                                } else {
                                    //pengembalian produk pre order
                                    $limitProduk = LimitProduk::where('id_produk', $detail->id_produk)
                                        ->where('tanggal', $pesanan->tanggal_diambil)
                                        ->first();
                                    if ($limitProduk != null) {
                                        $limitProduk->update([
                                            'limit' => $limitProduk->limit + $detail->jumlah
                                        ]);
                                    }
                                }
                            }
                        } else {
                            foreach ($detail->Hampers->DetailHampers as $detailHampers) {
                                if ($detailHampers->id_produk != null) {
                                    //pengembalian produk pada hampers
                                    $limitProduk = LimitProduk::where('id_produk', $detailHampers->id_produk)
                                        ->where('tanggal', $pesanan->tanggal_diambil)
                                        ->first();
                                    if ($limitProduk != null) {
                                        $limitProduk->update([
                                            'limit' => $limitProduk->limit + $detail->jumlah
                                        ]);
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
                ], 200);
            } catch (\Throwable $th) {
                return response()->json([
                    'status' => false,
                    'message' => 'Pesanan not found',
                    'error' => $th->getMessage()
                ], 404);
            }
        }
        
    public function bahanBakuKurang()
    {
        try {
            $bahanBaku = BahanBaku::where('stok', '<', 0)->get();
            return response()->json([
                'status' => true,
                'message' => 'Success get bahan baku kurang',
                'data' => $bahanBaku
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Bahan baku not found',
                'data' => [],
                'error' => $th->getMessage()
            ], 404);
        }
    }

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
                if (isset($data['isCart'])) {
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

    public function getAllPesananMasuk()
    {
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully fetch pesanan data.',
            'data' => Pesanan::where(function ($query) {
                $query->where(function ($subQuery) {
                    $subQuery->where('status_transaksi', 'Menunggu Konfirmasi Pesanan')
                        ->where('metode_pengiriman', 'Pengantaran Kurir Toko');
                })->orWhere('status_transaksi', 'Menunggu Konfirmasi Pembayaran');
            })->orderBy('tanggal_pesanan', 'desc')
                ->get()
                ->load('User')
                ->load('DetailPesanan')
        ], 200);
    }

    public function getPesanan($id)
    {
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

    public function updateOngkir(Request $request, $id)
    {
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

    public function updateTotalBayar(Request $request, $id)
    {
        $pesanan = Pesanan::where('id_pesanan', $id)->first();
        if ($pesanan == null) {
            return response()->json([
                'status' => 'error',
                'message' => 'Pesanan not found.'
            ], 404);
        }

        $total_bayar = $request->total_bayar;
        if ($total_bayar > $pesanan->total_harga) {
            $tip = $total_bayar - ($pesanan->total_harga + $pesanan->ongkir);
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

    public function getAllPesananDiproses()
    {
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully fetch pesanan data.',
            'data' => Pesanan::where('status_transaksi', 'Pesanan Sedang Diproses')->orWhere('status_transaksi', 'Pesanan Siap Di Pick Up')->orderBy('tanggal_pesanan', 'desc')
                ->get()
                ->load('User')
                ->load('DetailPesanan')
        ], 200);
    }

    public function updateStatusPesanan(Request $request, $id)
    {
        $pesanan = Pesanan::where('id_pesanan', $id)->first();
        if ($pesanan == null) {
            return response()->json([
                'status' => 'error',
                'message' => 'Pesanan not found.'
            ], 404);
        }

        $status_transaksi = $request->status_transaksi;
        $pesanan->status_transaksi = $status_transaksi == 'Pesanan Sudah Diambil' ? 'Pesanan Sudah Selesai' : $status_transaksi;
        $pesanan->save();

        $year = date("y", strtotime($pesanan->tanggal_pesanan));
        $month = date("m", strtotime($pesanan->tanggal_pesanan));
        $no_nota = "{$year}.{$month}.{$pesanan->id_pesanan}";
        $notification = Notification::create($pesanan->status_transaksi, 'Hai ' . $pesanan->User->nama_user . ', pesanan dengan no nota ' . $no_nota . ' kamu sudah ' . strtolower(substr($pesanan->status_transaksi, 8)) . '. Terima kasih sudah berbelanja di Atma Kitchen!');

        foreach ($pesanan->User->MobileTokens as $data) {
            try {
                $message = CloudMessage::withTarget('token', $data->token)
                    ->withNotification($notification);

                Firebase::messaging()->send($message);
            } catch (\Throwable $th) {
                continue;
            }
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Successfully update status pesanan data.',
            'data' => $pesanan,

        ], 200);
    }

    public function getReminderPesanan()
    {
        $pesanan = Pesanan::where('status_transaksi', 'Menunggu Pembayaran')->get()->load('User');
        $reminder = [];
        foreach ($pesanan as $data) {
            $date = date("Y-m-d", strtotime($data->tanggal_diambil));
            $now = date("Y-m-d");
            $diff = strtotime($date) - strtotime($now);
            $diff = $diff / (60 * 60 * 24);
            if ($diff <= 1) {
                array_push($reminder, $data);
            }
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Successfully fetch reminder pesanan data.',
            'data' => $reminder
        ], 200);
    }

    public function batalPesanan($id)
    {
        $pesanan = Pesanan::where('id_pesanan', $id)->first();

        if ($pesanan == null) {
            return response()->json([
                'status' => 'error',
                'message' => 'Pesanan not found.'
            ], 404);
        }

        $date = date("Y-m-d", strtotime($pesanan->tanggal_diambil));
        foreach ($pesanan->detailPesanan as $detail) {
            if ($detail->id_produk != null) {
                if ($detail->Produk->id_penitip != null) {
                    $produk = Produk::where('id_produk', $detail->id_produk)->first();
                    $produk->update([
                        'stok_produk' => $produk->stok_produk + $detail->jumlah
                    ]);
                } else {
                    if ($detail->status_pesanan == 'Ready') {
                        $produk = Produk::where('id_produk', $detail->id_produk)->first();
                        $produk->update([
                            'stok_produk' => $produk->stok_produk + $detail->jumlah
                        ]);
                    } else {
                        $limitProduk = LimitProduk::where('id_produk', $detail->id_produk)
                            ->where('tanggal', $date)
                            ->first();
                        if ($limitProduk != null) {
                            $limitProduk->update([
                                'limit' => $limitProduk->limit + $detail->jumlah
                            ]);
                        }
                    }
                }
            } else {
                foreach ($detail->Hampers->DetailHampers as $detailHampers) {
                    if ($detailHampers->id_produk != null) {
                        $limitProduk = LimitProduk::where('id_produk', $detailHampers->id_produk)
                            ->where('tanggal', $date)
                            ->first();
                        if ($limitProduk != null) {
                            $limitProduk->update([
                                'limit' => $limitProduk->limit + $detail->jumlah
                            ]);
                        }
                    }
                }
            }


            $pesanan->status_transaksi = 'Pesanan Dibatalkan';
            $pesanan->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Successfully cancel pesanan data.',
                'data' => $pesanan
            ], 200);
        }
    }

    public function laporanPenjualanPerProduk(Request $request)
    {
        try {

            $query = $request->query('date');
            $yearMonth = substr($query, 0, 7);

            $pesanan = Pesanan::where('status_transaksi', 'Pesanan Sudah Selesai')->where(fn ($query) => $query->where('tanggal_diambil', 'like', $yearMonth . '%'))->with(['detailPesanan.Produk', 'detailPesanan.Hampers'])->get();

            $laporan = [
                'produk' => [],
                'hampers' => []
            ];

            foreach ($pesanan as $p) {
                foreach ($p['DetailPesanan'] as $dp) {
                    if ($dp['id_produk'] != null) {
                        $found = array_filter($laporan['produk'], function ($item) use ($dp) {
                            return $item['id_produk'] == $dp['id_produk'];
                        });
                        if (count($found) == 0) {
                            $laporan['produk'][] = [
                                'id_produk' => $dp['id_produk'],
                                'nama_produk' => $dp['produk']['nama_produk'],
                                'harga_produk' => $dp['produk']['harga_produk'],
                                'jumlah' => $dp['jumlah'],
                                'subtotal' => $dp['subtotal']
                            ];
                        } else {
                            foreach ($laporan['produk'] as $key => $value) {
                                if ($value['id_produk'] == $dp['id_produk']) {
                                    $laporan['produk'][$key]['jumlah'] += $dp['jumlah'];
                                    $laporan['produk'][$key]['subtotal'] += $dp['subtotal'];
                                }
                            }
                        }
                    } else {
                        if ($dp['id_hampers'] != null) {
                            $found = array_filter($laporan['hampers'], function ($item) use ($dp) {
                                return $item['id_hampers'] == $dp['id_hampers'];
                            });
                            if (count($found) == 0) {
                                $laporan['hampers'][] = [
                                    'id_hampers' => $dp['id_hampers'],
                                    'nama_hampers' => $dp['hampers']['nama_hampers'],
                                    'harga_hampers' => $dp['hampers']['harga_hampers'],
                                    'jumlah' => $dp['jumlah'],
                                    'subtotal' => $dp['subtotal']
                                ];
                            } else {
                                foreach ($laporan['hampers'] as $key => $value) {
                                    if ($value['id_hampers'] == $dp['id_hampers']) {
                                        $laporan['hampers'][$key]['jumlah'] += $dp['jumlah'];
                                        $laporan['hampers'][$key]['subtotal'] += $dp['subtotal'];
                                    }
                                }
                            }
                        }
                    }
                }
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Successfully fetch laporan penjualan per produk data.',
                'data' => $laporan,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Laporan tidak ditemukan',
                'data' => []
            ], 404);
        }
    }

    public function pesananDiproses()
    {
        try {
            $today = Carbon::now()->toDateString();
            $pesanan = Pesanan::where('status_transaksi', 'Pesanan Diterima')->where(DB::raw("DATE_SUB(tanggal_diambil, INTERVAL 1 DAY)"), '=', $today)->get();
            if (count($pesanan) == 0) {
                throw new \Exception();
            }
            return response()->json([
                'status' => true,
                'message' => 'Success get pesanan diproses',
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

    public function memprosesPesanan(Request $request)
    {
        try {
            $input = $request->input('data');
            $data = [];

            foreach ($input as $item) {
                $pesanan = Pesanan::where('id_pesanan', $item)->with([
                    'detailPesanan.produk.resep.detailResep',
                    'detailPesanan.hampers.detailHampers.produk.resep.detailResep'
                ])
                    ->get();

                if (count($pesanan) == 0) {
                    throw new \Exception();
                }

                $bahanBakuUsage = [];

                foreach ($pesanan as $order) {
                    foreach ($order->detailPesanan as $detail) {
                        if ($detail->produk && $detail->produk->resep) {
                            foreach ($detail->produk->resep->detailResep as $detailResep) {
                                if (isset($bahanBakuUsage[$detailResep->id_bahan_baku])) {
                                    $bahanBakuUsage[$detailResep->id_bahan_baku] += $detailResep->jumlah * $detail->jumlah;
                                } else {
                                    $bahanBakuUsage[$detailResep->id_bahan_baku] = $detailResep->jumlah * $detail->jumlah;
                                }
                            }
                        }

                        if ($detail->hampers != null && $detail->hampers->detailHampers != null) {
                            foreach ($detail->hampers->detailHampers as $hampersDetail) {
                                if ($hampersDetail->produk && $hampersDetail->produk->resep) {
                                    foreach ($hampersDetail->produk->resep->detailResep as $detailResep) {
                                        if (isset($bahanBakuUsage[$detailResep->id_bahan_baku])) {
                                            $bahanBakuUsage[$detailResep->id_bahan_baku] += $detailResep->jumlah * $detail->jumlah;
                                        } else {
                                            $bahanBakuUsage[$detailResep->id_bahan_baku] = $detailResep->jumlah * $detail->jumlah;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }

                foreach ($bahanBakuUsage as $key => $value) {
                    $bahanBaku = BahanBaku::where('id_bahan_baku', $key)->first();
                    if ($bahanBaku->stok < $value) {
                        return response()->json([
                            'status' => false,
                            'message' => 'Bahan baku untuk pesanan ' . $pesanan[0]->no_nota . ' tidak mencukupi',
                            'data' => $bahanBaku
                        ]);
                    }
                    PencatatanBahanBaku::create([
                        'id_bahan_baku' => $key,
                        'jumlah' => $value,
                        'tanggal_pencatatan' => now()->timezone('Asia/Jakarta')
                    ]);

                    $bahanBaku->update([
                        'stok' => $bahanBaku->stok - $value
                    ]);
                }

                $order = Pesanan::where('id_pesanan', $item)->first();
                $order->update([
                    'status_transaksi' => 'Pesanan Sedang Diproses'
                ]);
                $data[] = $order;
            }



            return response()->json([
                'status' => true,
                'message' => 'Pesanan berhasil diproses',
                'data' => $data
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
