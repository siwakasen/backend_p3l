<?php

namespace App\Http\Controllers;

use App\Models\Alamat;
use Illuminate\Http\Request;

class AlamatController extends Controller
{
    public function getAlamatById(Request $request)
    {
        $id = $request->id;
        $alamat = Alamat::where('id_user', $id)->get();

        if ($alamat->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'Data alamat tidak ditemukan',
                'data' => null
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'Data alamat berhasil ditampilkan',
            'data' => $alamat
        ]);
    }
}
