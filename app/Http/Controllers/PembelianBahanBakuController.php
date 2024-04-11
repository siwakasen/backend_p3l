<?php

namespace App\Http\Controllers;

use App\Models\BahanBaku;
use App\Models\PembelianBahanBaku;
use App\Models\Resep;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PembelianBahanBakuController extends Controller
{
    public function getAllPembelianBahanBaku()
    {
        $datas = PembelianBahanBaku::all();
        if (!$datas) {
            return response()->json([
                'status' => false,
                'message' => 'Pembelian Bahan Baku not found',
                'data' => null
            ], 404);
        }
        return response()->json([
            'status' => true,
            'message' => 'Success retrive all pembelian bahan baku',
            'data' => $datas
        ]);
    }

    public function getPembelianBahanBaku(Request $request, $id)
    {
        $data = PembelianBahanBaku::find($id);
        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Pembelian Bahan Baku not found',
                'data' => null
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Success retrive a pembelian bahan baku',
            'data' => $data
        ]);
    }

    public function searchPembelianBahanBaku(Request $request)
    {
        $keyword = $request->query('query');
        $datas = PembelianBahanBaku::where('tanggal_pembelian', 'like', "%$keyword%")->get();
        if (count($datas) == 0) {
            return response()->json([
                'status' => false,
                'message' => 'Pembelian Bahan Baku not found',
                'data' => null
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Success retrive all pembelian bahan baku',
            'data' => $datas
        ]);
    }

    public function insertPembelianBahanBaku(Request $request)
    {
        $data = $request->all();
        $validate = Validator::make($data, [
            'id_bahan_baku' => 'required|numeric',
            'jumlah' => 'required|numeric',
            'harga' => 'required|numeric',
            'tanggal_pembelian' => 'required|date',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid input',
                'errors' => $validate->errors(),
            ], 400);
        }

        $resep = BahanBaku::find($data['id_bahan_baku']);
        if (!$resep) {
            return response()->json([
                'status' => false,
                'message' => 'Bahan Baku not found',
                'data' => null
            ], 404);
        }

        $data = PembelianBahanBaku::create($data);
        return response()->json([
            'status' => true,
            'message' => 'Success insert a pembelian bahan baku',
            'data' => $data
        ]);
    }

    public function deletePembelianBahanBaku(Request $request, String $id)
    {
        $data = PembelianBahanBaku::find($id);
        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Pembelian Bahan Baku not found',
                'data' => null
            ], 404);
        }

        $data->delete();
        return response()->json([
            'status' => true,
            'message' => 'Success delete pembelian bahan baku',
            'data' => $data
        ]);
    }

    public function updatePembelianBahanBaku(Request $request, String $id)
    {
        $request = $request->all();
        $data = PembelianBahanBaku::find($id);
        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Pembelian Bahan Baku not found',
                'data' => null
            ], 404);
        }

        $validate = Validator::make($request, [
            'id_bahan_baku' => 'numeric',
            'jumlah' => 'numeric',
            'harga' => 'numeric',
            'tanggal_pembelian' => 'date',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid input',
                'errors' => $validate->errors()
            ], 400);
        }

        $data->update($request);
        return response()->json([
            'status' => true,
            'message' => 'Success update pembelian bahan baku',
            'data' => $data
        ]);
    }
}
