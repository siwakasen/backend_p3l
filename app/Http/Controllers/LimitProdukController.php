<?php

namespace App\Http\Controllers;

use App\Models\LimitProduk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LimitProdukController extends Controller
{
    public function getLimitProduk(String $id)
    {
        $limitProduk = LimitProduk::where('id_produk', $id)->get();
        if (!$limitProduk) {
            return response()->json([
                'status' => false,
                'message' => 'Data limit produk tidak ditemukan',
                'data' => null
            ], 404);
        }
        return response()->json([
            'status' => true,
            'message' => 'Data limit produk berhasil diambil',
            'data' => $limitProduk
        ]);
    }

    public function getAllLimitProduct()
    {
        $limitProduk = LimitProduk::all();
        if (!$limitProduk) {
            return response()->json([
                'status' => false,
                'message' => 'Data limit produk tidak ditemukan',
                'data' => null
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Data limit produk berhasil diambil',
            'data' => $limitProduk
        ]);
    }

    public function udpateLimitProduk(Request $request, String $id)
    {
        $data = $request->all();
        $limitProduk = LimitProduk::where('id_limit_produk', $id)->first();
        if (!$limitProduk) {
            return response()->json([
                'status' => false,
                'message' => 'Data limit produk tidak ditemukan',
                'data' => null
            ], 404);
        }

        $validate = Validator::make($data, [
            'tanggal' => 'date',
            'limit' => 'numeric',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Data limit produk gagal diubah',
                'data' => $validate->errors()
            ], 400);
        }

        $limitProduk->update($data);
        return response()->json([
            'status' => true,
            'message' => 'Data limit produk berhasil diubah',
            'data' => $limitProduk
        ]);
    }

    public function insertLimitProduk(Request $request)
    {
        $data = $request->all();
        $validate = Validator::make($data, [
            'id_produk' => 'required|numeric',
            'tanggal' => 'required|date',
            'limit' => 'required|numeric',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Data limit produk gagal ditambahkan',
                'data' => $validate->errors()
            ], 400);
        }

        $limitProduk = LimitProduk::create($data);
        return response()->json([
            'status' => true,
            'message' => 'Data limit produk berhasil ditambahkan',
            'data' => $limitProduk
        ]);
    }

    public function deleteLimitProduk(String $id)
    {
        $limitProduk = LimitProduk::where('id_limit_produk', $id)->first();
        if (!$limitProduk) {
            return response()->json([
                'status' => false,
                'message' => 'Data limit produk tidak ditemukan',
                'data' => null
            ], 404);
        }

        $limitProduk->delete();
        return response()->json([
            'status' => true,
            'message' => 'Data limit produk berhasil dihapus',
            'data' => $limitProduk
        ]);
    }
}

