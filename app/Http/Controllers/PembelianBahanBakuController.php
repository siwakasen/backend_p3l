<?php

namespace App\Http\Controllers;

use App\Models\BahanBaku;
use App\Models\PembelianBahanBaku;
use App\Models\Resep;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PembelianBahanBakuController extends Controller
{
    public $validator_exception = [
        'id_bahan_baku.required' => 'Id bahan baku harus diisi',
        'id_bahan_baku.numeric' => 'Id bahan baku harus berupa angka',
        'jumlah.required' => 'Jumlah harus diisi',
        'jumlah.numeric' => 'Jumlah harus berupa angka',
        'jumlah.gt' => 'Jumlah harus lebih besar dari 0',
        'harga.required' => 'Harga harus diisi',
        'harga.numeric' => 'Harga harus berupa angka',
        'harga.gt' => 'Harga harus lebih besar dari 0',
        'tanggal_pembelian.required' => 'Tanggal pembelian harus diisi',
        'tanggal_pembelian.date' => 'Tanggal pembelian harus berupa tanggal',
    ];

    public function getAllPembelianBahanBaku()
    {
        $datas = PembelianBahanBaku::with('BahanBaku')->get();
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
            'jumlah' => 'required|numeric|gt:0',
            'harga' => 'required|numeric|gt:0',
            'tanggal_pembelian' => 'required|date',
        ], $this->validator_exception);

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

        $resep->stok += $data['jumlah'];

        $resep->save();
        $data = PembelianBahanBaku::create($data);
        return response()->json([
            'status' => true,
            'message' => 'Success insert a pembelian bahan baku',
            'data' => $data
        ], 201);
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
            'jumlah' => 'numeric|gt:0',
            'harga' => 'numeric|gt:0',
            'tanggal_pembelian' => 'date',
        ], $this->validator_exception);

        if ($validate->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid input',
                'errors' => $validate->errors()
            ], 400);
        }

        $bahan_baku = BahanBaku::find($request['id_bahan_baku']);
        if (!$bahan_baku) {
            return response()->json([
                'status' => false,
                'message' => 'Bahan Baku not found',
                'data' => null
            ], 404);
        }

        if ($data['id_bahan_baku'] != $request['id_bahan_baku']) {
            $old_bahan_baku = BahanBaku::find($data['id_bahan_baku']);
            $old_bahan_baku->stok -= $data['jumlah'];
            $bahan_baku->stok += $request['jumlah'];
            $old_bahan_baku->save();
        } else {
            $bahan_baku->stok -= $data['jumlah'];
            $bahan_baku->stok += $request['jumlah'];
        }

        $bahan_baku->save();
        $data->update($request);
        return response()->json([
            'status' => true,
            'message' => 'Success update pembelian bahan baku',
            'data' => $data
        ]);
    }
}
