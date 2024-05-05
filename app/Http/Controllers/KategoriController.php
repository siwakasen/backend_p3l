<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function getAllKategori()
    {
        $kategori = Kategori::all();
        return response()->json([
            'status' => true,
            'message' => 'Data kategori berhasil diambil',
            'data' => $kategori
        ]);
    }
}
