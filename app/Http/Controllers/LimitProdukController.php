<?php

namespace App\Http\Controllers;

use App\Models\LimitProduk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LimitProdukController extends Controller
{
    public $validator_exception = [
        'id_produk.required' => 'Id produk harus diisi',
        'id_produk.numeric' => 'Id produk harus berupa angka',
        'tanggal.required' => 'Tanggal harus diisi',
        'tanggal.date' => 'Tanggal harus berupa tanggal',
        'limit.required' => 'Limit harus diisi',
        'limit.numeric' => 'Limit harus berupa angka',
    ];

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

    public function updateLimitProduk(Request $request, String $id)
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
        ], $this->validator_exception);

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
        ], $this->validator_exception);

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
        ], 201);
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
