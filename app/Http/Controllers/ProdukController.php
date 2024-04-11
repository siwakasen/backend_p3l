<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    public function getProduk(Request $request, $id)
    {
        $produk = Produk::find($id);
        if (!$produk) {
            return response()->json([
                'status' => false,
                'message' => 'Produk not found',
                'data' => null
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Success retrive a produk',
            'data' => $produk
        ]);
    }

    public function getAllProduk(Request $request)
    {
        $produk = Produk::all();

        if (!$produk) {
            return response()->json([
                'status' => false,
                'message' => 'Produk not found',
                'data' => null
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Success retrive all produk',
            'data' => $produk
        ]);
    }

    public function searchProduk(Request $request)
    {
        $keyword = $request->query('query');
        $produks = Produk::where('nama_produk', 'like', "%$keyword%")->get();
        if (count($produks) == 0) {
            return response()->json([
                'status' => false,
                'message' => 'Produk not found',
                'data' => null
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Success search produk',
            'data' => $produks
        ]);
    }

    public function insertProduk(Request $request)
    {
        $produk = $request->all();
        $validate = Validator::make($produk, [
            'id_penitip' => 'numeric',
            'id_kategori' => 'required|numeric',
            'nama_produk' => 'required|string',
            // 'id_resep' => 'required|numeric',
            'foto_produk' => 'required|mimes:jpg,png,jpeg|max:2048',
            'deskripsi_produk' => 'required|string',
            'harga_produk' => 'required|numeric',
            'stok_produk' => 'required|numeric',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid input',
                'errors' => $validate->errors()
            ], 400);
        }

        $guessExtension = $request->file('foto_produk')->guessExtension();
        $path = $request->file('foto_produk')->storeAs('produk', Str::slug($produk['nama_produk']) . '.' . $guessExtension, 'public');
        $produk['foto_produk'] = $path;
        $produk['id_resep'] = 1;
        $produk = Produk::create($produk);

        return response()->json([
            'status' => true,
            'message' => 'Success insert a produk',
            'data' => $produk
        ]);
    }

    public function updateProduk(Request $request, String $id)
    {

        $data = $request->all();
        $produk = Produk::find($id);
        if (!$produk) {
            return response()->json([
                'status' => false,
                'message' => 'Produk not found',
                'data' => null
            ], 404);
        }


        $validate = Validator::make($data, [
            'id_penitip' => 'numeric',
            'id_kategori' => 'numeric',
            'nama_produk' => 'string',
            'id_resep' => 'numeric',
            'foto_produk' => 'mimes:jpg,png,jpeg|max:2048',
            'deskripsi_produk' => 'string',
            'harga_produk' => 'numeric',
            'stok_produk' => 'numeric',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid request',
                'errors' => $validate->errors()
            ], 400);
        }

        if ($request->file('foto_produk') != null) {
            Storage::disk('public')->delete($produk->foto_produk);
            $guessExtension = $request->file('foto_produk')->guessExtension();
            $path = null;
            if ($request->input('nama_produk') != null) {
                $path = $request->file('foto_produk')->storeAs('produk', Str::slug($data['nama_produk']) . '.' . $guessExtension, 'public');
            } else {
                $path = $request->file('foto_produk')->storeAs('produk', Str::slug($produk['nama_produk']) . '.' . $guessExtension, 'public');
            }
            $data['foto_produk'] = $path;
        }

        if ($request->input('nama_produk') != null && $request->file('foto_produk') == null) {
            $filename = explode('/', $produk->foto_produk);
            $extension = explode('.', $filename[1]);
            $path = $filename[0] . '/' . Str::slug($data['nama_produk']) . '.' . $extension[1];
            Storage::disk('public')->move($produk->foto_produk, $path);
            $data['foto_produk'] = $path;
        }

        $produk->update($data);
        return response()->json([
            'status' => true,
            'message' => 'Success update a produk',
            'data' => $produk
        ]);
    }

    public function deleteProduk(Request $request, $id)
    {
        $produk = Produk::find($id);
        if (!$produk) {
            return response()->json([
                'status' => false,
                'message' => 'Produk not found',
                'data' => null
            ], 404);
        }

        Storage::disk('public')->delete($produk->foto_produk);
        $produk->delete();
        return response()->json([
            'status' => true,
            'message' => 'Success delete a produk',
            'data' => $produk
        ]);
    }
}
