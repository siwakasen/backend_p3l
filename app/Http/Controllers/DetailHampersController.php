<?php

namespace App\Http\Controllers;

use App\Models\DetailHampers;
use App\Models\Produk;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DetailHampersController extends Controller
{
    public function getAllDetailHampers()
    {
        $datas = DetailHampers::all();
        if (!$datas) {
            return response()->json([
                'status' => false,
                'message' => 'Detail Hampers not found',
                'data' => null
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Success retrive all detail hampers',
            'data' => $datas
        ]);
    }

    public function getDetailHampers(Request $request, $id)
    {
        $detailHampers = DetailHampers::where('id_hampers', $id)->get();
        if (!$detailHampers) {
            return response()->json([
                'status' => false,
                'message' => 'Detail Hampers not found',
                'data' => null
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Success retrive a detail hampers',
            'data' => $detailHampers
        ]);
    }

    public function searchDetailHampers(Request $request)
    {
        $keyword = $request->query('query');
        $detailHampers = DetailHampers::where('id_produk', $keyword)->get();
        if (!$detailHampers) {
            return response()->json([
                'status' => false,
                'message' => 'Detail Hampers not found',
                'data' => null
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Success retrive a detail hampers',
            'data' => $detailHampers
        ]);
    }

    public function insertDetailHampers(Request $request)
    {
        $data = $request->all();
        $validate = Validator::make($data, [
            'id_hampers' => 'required|numeric',
            'id_produk' => 'required|numeric',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid input',
                'errors' => $validate->errors(),
            ], 400);
        }

        $produk = Produk::find($data['id_produk']);
        if (!$produk) {
            return response()->json([
                'status' => false,
                'message' => 'Produk not found',
                'data' => null
            ], 404);
        }

        $detailHampers = DetailHampers::create($data);
        $payload = [
            'id_hampers' => $detailHampers->id_hampers,
            'id_produk' => $detailHampers->id_produk,
            'created_at' => $detailHampers->created_at,
            'updated_at' => $detailHampers->updated_at,
        ];
        return response()->json([
            'status' => true,
            'message' => 'Success insert detail hampers',
            'data' => $payload
        ]);
    }

    public function updateDetailHampers(Request $request, String $id)
    {
        $data = $request->all();
        $detailHampers = DetailHampers::where('id_hampers', $id)->where('id_produk', $data['id_produk'])->first();
        if (!$detailHampers) {
            return response()->json([
                'status' => false,
                'message' => 'Detail Hampers not found',
                'data' => null
            ], 404);
        }

        $validate = Validator::make($data, [
            'id_produk' => 'numeric',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid input',
                'errors' => $validate->errors(),
            ], 400);
        }

        $produk = Produk::find($data['id_produk']);
        if (!$produk) {
            return response()->json([
                'status' => false,
                'message' => 'Produk not found',
                'data' => null
            ], 404);
        }

        $detailHampers->update($data);
        return response()->json([
            'status' => true,
            'message' => 'Success update a detail hampers',
            'data' => $detailHampers
        ]);
    }

    public function deleteDetailHampers(Request $request, String $id)
    {
        $data = $request->all();
        $detailHampers = DetailHampers::where('id_hampers', $id)->where('id_produk', $data['id_produk'])->first();
        if (!$detailHampers) {
            return response()->json([
                'status' => false,
                'message' => 'Detail Hampers not found',
                'data' => null
            ], 404);
        }

        DB::table('detail_hampers')
            ->where('id_hampers', '=', $id)
            ->where('id_produk', '=', $data['id_produk'])
            ->limit(1)
            ->delete();

        return response()->json([
            'status' => true,
            'message' => 'Success delete a produk hampers',
            'data' => $detailHampers
        ]);
    }
}
