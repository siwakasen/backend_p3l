<?php

namespace App\Http\Controllers;

use App\Models\DetailHampers;
use App\Models\Hampers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;


class HampersController extends Controller
{
    public function getAllHampers()
    {
        $hampers = Hampers::all();

        if (!$hampers) {
            return response()->json([
                'status' => false,
                'message' => 'Hampers not found',
                'data' => null
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Success retrive all hampers',
            'data' => $hampers
        ]);
    }

    public function getHampers(String $id)
    {
        $hampers = Hampers::find($id);
        $detail_hampers = DetailHampers::where('id_hampers', $id)->get();
        $bahan_baku = [];
        $produk = [];
        foreach ($detail_hampers as $detail) {
            if (!$detail->BahanBaku) {
                $produk[] = $detail->Produk;
            }
            if (!$detail->Produk) {
                $bahan_baku[] = $detail->BahanBaku;
            }
        }

        if (!$hampers) {
            return response()->json([
                'status' => false,
                'message' => 'Hampers not found',
                'data' => null
            ], 404);
        }

        $hampers['detail'] = [
            'produk' => $produk,
            'bahan_baku' => $bahan_baku,
        ];

        return response()->json([
            'status' => true,
            'message' => 'Success retrive a hampers',
            'data' => $hampers
        ]);
    }

    public function updateHampers(Request $request, String $id)
    {
        $data = $request->all();
        $hampers = Hampers::find($id);
        if (!$hampers) {
            return response()->json([
                'status' => false,
                'message' => 'Hampers not found',
                'data' => null
            ], 404);
        }

        $validate = Validator::make($data, [
            'nama_hampers' => 'string',
            'harga_hampers' => 'numeric',
            'deskripsi_hampers' => 'string',
            'foto_hampers' => 'mimes:jpg,png,jpeg|max:2048',
        ]);


        if ($validate->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid request',
                'errors' => $validate->errors()
            ], 400);
        }

        if ($request->file('foto_hampers') != null) {
            Storage::disk('public')->delete($hampers->foto_hampers);
            $guessExtension = $request->file('foto_hampers')->guessExtension();
            $path = null;
            if ($request->input('nama_hampers') != null) {
                $path = $request->file('foto_hampers')->storeAs('hampers', Str::slug($data['nama_hampers']) . '.' . $guessExtension, 'public');
            } else {
                $path = $request->file('foto_hampers')->storeAs('hampers', Str::slug($hampers['nama_hampers']) . '.' . $guessExtension, 'public');
            }
            $data['foto_hampers'] = $path;
        }

        if ($request->input('nama_hampers') != null && $request->file('foto_hampers') == null) {
            $filename = explode('/', $hampers->foto_hampers);
            $extension = explode('.', $filename[1]);
            $path = $filename[0] . '/' . Str::slug($data['nama_hampers']) . '.' . $extension[1];
            Storage::disk('public')->move($hampers->foto_hampers, $path);
            $data['foto_hampers'] = $path;
        }

        $hampers->update($data);
        return response()->json([
            'status' => true,
            'message' => 'Success update hampers',
            'data' => $hampers,
        ]);
    }

    public function insertHampers(Request $request)
    {
        $data = $request->all();
        $validate = Validator::make($data, [
            'nama_hampers' => 'required|string',
            'harga_hampers' => 'required|numeric',
            'deskripsi_hampers' => 'required|string',
            'foto_hampers' => 'required|mimes:jpg,png,jpeg|max:2048',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid request',
                'errors' => $validate->errors()
            ], 400);
        }

        $guessExtension = $request->file('foto_hampers')->guessExtension();
        $path = $request->file('foto_hampers')->storeAs('hampers', Str::slug($data['nama_hampers']) . '.' . $guessExtension, 'public');
        $data['foto_hampers'] = $path;



        $hampers = Hampers::create($data);
        $data = [
            ['id_hampers' => $hampers->id_hampers, 'id_bahan_baku' => 19],
            ['id_hampers' => $hampers->id_hampers, 'id_bahan_baku' => 20],
        ];
        foreach ($data as $d) {
            DetailHampers::create($d);
        }
        return response()->json([
            'status' => true,
            'message' => 'Success insert a hampers',
            'data' => $hampers
        ]);
    }

    public function deleteHampers(Request $request, String $id)
    {
        $hampers = Hampers::find($id);
        if (!$hampers) {
            return response()->json([
                'status' => false,
                'message' => 'Hampers not found',
                'data' => null
            ], 404);
        }

        Storage::disk('public')->delete($hampers->foto_hampers);
        $hampers->delete();
        return response()->json([
            'status' => true,
            'message' => 'Success delete hampers',
            'data' => $hampers
        ]);
    }

    public function searchHampers(Request $request)
    {
        $keyword = $request->query('query');
        $hampers = Hampers::where('nama_hampers', 'like', "%$keyword%")->get();
        if (count($hampers) == 0) {
            return response()->json([
                'status' => false,
                'message' => 'Hampers not found',
                'data' => $hampers
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Success search hampers',
            'data' => $hampers
        ]);
    }
}
