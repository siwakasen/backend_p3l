<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resep;
use App\Models\DetailResep;
use App\Models\Produk;
use Illuminate\Support\Facades\Validator;

class ResepController extends Controller
{
    public $validator_exception = [
        'nama_resep.required' => 'Nama resep harus diisi!',
        'nama_resep.unique' => 'Nama resep sudah terdaftar!',
        'nama_resep.max' => 'Nama resep maksimal 255 karakter!',
        'detail_resep.required' => 'Detail resep harus diisi!',
        'detail_resep.array' => 'Detail resep harus berupa array!'
    ];

    public function getAllResep()
    {
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully fetch resep data.',
            'data' => Resep::all()
        ], 200);
    }

    public function getResep(string $id)
    {
        if (Resep::find($id) == null) {
            return response()->json([
                'status' => 'error',
                'message' => 'Resep not found.'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Successfully fetch resep data.',
            'data' => Resep::find($id)->load('DetailResep')
        ], 200);
    }

    public function  insertResep(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                'nama_resep' => 'required|max:255|unique:resep',
                'detail_resep' => 'required|array',
            ], $this->validator_exception);

            if($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'type' => 'validation',
                    'message' => $validator->errors()
                ], 400);
            }

            $resep = Resep::create($request->only('nama_resep'));

            foreach ($request->detail_resep as $detail) {
                DetailResep::create([
                    'id_bahan_baku' => $detail['id_bahan_baku'],
                    'id_resep' => $resep->id_resep,
                    'jumlah' => $detail['jumlah']
                ]);
            }

            return response()->json([
                'status' => 'success', 
                'message' => 'Resep created successfully.'
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error: ' . $e->getMessage()
            ], 400);
        }  
    }

    public function updateResep(Request $request, string $id)
    {
        if (Resep::find($id) == null) {
            return response()->json([
                'status' => 'error',
                'message' => 'Resep not found.'
            ], 404);
        }

        try{
            $validator = Validator::make($request->all(), [
                'nama_resep' => 'required|max:255|unique:resep,nama_resep,'.$id.',id_resep',
                'detail_resep' => 'required|array',
            ], $this->validator_exception);

            if($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => $validator->errors()
                ], 400);
            }

            Resep::find($id)->update($request->only('nama_resep'));

            DetailResep::where('id_resep', $id)->delete();

            foreach ($request->detail_resep as $detail) {
                DetailResep::create([
                    'id_bahan_baku' => $detail['id_bahan_baku'],
                    'id_resep' => $id,
                    'jumlah' => $detail['jumlah']
                ]);
            }

            return response()->json([
                'status' => 'success', 
                'message' => 'Resep updated successfully.'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error: ' . $e->getMessage()
            ], 404);
        }  
    }

    public function deleteResep(string $id)
    {
        if (Resep::find($id) == null) {
            return response()->json([
                'status' => 'error',
                'message' => 'Resep not found.'
            ], 404);
        }

        try{
            $resep = Resep::find($id);
            $produk = Produk::where('id_resep', $id)->get();
            if(count($produk) > 0) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Resep cannot be deleted because it is used in some products.'
                ], 400);
            }
            
            $resep->delete();
            
            DetailResep::where('id_resep', $id)->delete();
            
            return response()->json([
                'status' => 'success', 
                'message' => 'Resep deleted successfully.'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error: ' . $e->getMessage()
            ], 400);
        }
    }
    


}
