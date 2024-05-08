<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BahanBaku;
use Illuminate\Support\Facades\Validator;

class BahanBakuController extends Controller
{
    public $validator_exception = [
        'nama_bahan_baku.required' => 'Nama bahan baku harus diisi!',
        'nama_bahan_baku.max' => 'Nama bahan baku maksimal 255 karakter!',
        'stok.required' => 'Stok harus diisi!',
        'stok.numeric' => 'Stok harus berupa angka!',
        'stok.min' => 'Stok minimal 0!',
        'satuan.required' => 'Satuan harus diisi!',
        'satuan.max' => 'Satuan maksimal 255 karakter!'
    ];
    public function getAllBahanBaku(){
        try {
            //code...
            $bahan_baku = BahanBaku::all();
            if(!$bahan_baku){
                throw new \Exception();
            }
            return response()->json([
                'status' => true,
                'message' => 'Berhasil mengambil semua data bahan baku',
                'data' => $bahan_baku
            ]);

        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'status' => false,
                'message' => 'Data bahan baku tidak ditemukan',
                'data' => []
            ], 404);
        }
    }

    public function getBahanBaku($id){
        try {
            //code...
            $bahan_baku = BahanBaku::find($id);
            if(!$bahan_baku){
                throw new \Exception();
            }
            return response()->json([
                'status' => true,
                'message' => 'Berhasil mengambil data bahan baku',
                'data' => $bahan_baku
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'status' => false,
                'message' => 'Data bahan baku tidak ditemukan',
                'data' => []
            ], 404);
        }
    }

    public function searchBahanBaku(Request $request){
        try {
            //code...
            $searchkey = $request->query('query');
            $data = BahanBaku::where('nama_bahan_baku', 'like', "%$searchkey%")->get();
            if(count($data) == 0){
                throw new \Exception();
            }
            return response()->json([
                'status' => true,
                'message' => 'Berhasil mencari data bahan baku',
                'data' => $data
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'status' => false,
                'message' => 'Data bahan baku tidak ditemukan',
                'data' => []
            ], 404);
        }
    }

    public function insertBahanBaku(Request $request){
        try {
            //code...
            $data =  $request->all();
            $validate = Validator::make($data, [
                'nama_bahan_baku' => 'required|max:255',
                'stok' => 'required|numeric|min:0',
                'satuan' => 'required|max:255',
            ], $this->validator_exception);
    
            if($validate->fails()){
                throw new \Exception('invalid-input');
            }
            $bahan_baku = BahanBaku::create($data);
            return response()->json([
                'status' => true,
                'message' => 'Berhasil menambah data bahan baku',
                'data' => $bahan_baku
            ],200);
        } catch (\Throwable $th) {
            //throw $th;
            if($th->getMessage() == 'invalid-input'){
                return response()->json([
                    'status' => false,
                    'message' => $validate->errors(),
                ], 400);
            }else{
                return response()->json([
                    'status' => false,
                    'message' => 'Gagal menambah data bahan baku',
                    'error'=> $th->getMessage()
                ], 400);
            }
        }

    }

    public function updateBahanBaku(Request $request, $id){
        try {
            //code...
            $bahan_baku = BahanBaku::find($id);
            if(!$bahan_baku){
                throw new \Exception('not-found');
            }
            $data =  $request->all();
            $validate = Validator::make($data, [
                'nama_bahan_baku' => 'required|max:255',
                'stok' => 'required|numeric|min:0',
                'satuan' => 'required|max:255',
            ],$this->validator_exception);
            if($validate->fails()){
                throw new \Exception('invalid-input');
            }
            
            $bahan_baku->update($data);
            return response()->json([
                'status' => true,
                'message' => 'Berhasil mengubah data bahan baku',
                'data' => $bahan_baku,
            ],200);
        } catch (\Throwable $th) {
            //throw $th;
            if($th->getMessage() == 'not-found'){
                return response()->json([
                    'status' => false,
                    'message' => 'Data bahan baku tidak ditemukan',
                ], 404);
            }else if($th->getMessage() == 'invalid-input'){
                return response()->json([
                    'status' => false,
                    'message' => $validate->errors(),
                ], 400);
            }
            else{
                return response()->json([
                    'status' => false,
                    'message' => 'Gagal mengubah data bahan baku',
                    'error'=> $th->getMessage()
                ], 400);
            }
        }

    }

    public function deleteBahanBaku($id){
        try {
            
            $bahan_baku = BahanBaku::find($id);
            if(!$bahan_baku){
                throw new \Exception('not-found');
            }
            $bahan_baku->delete();
            return response()->json([
                'status' => true,
                'message' => 'Berhasil mengubah data bahan baku',
                'data' => $bahan_baku
            ],200);
            
        } catch (\Throwable $th) {
            //throw $th;
            if($th->getMessage() == 'not-found'){
                return response()->json([
                    'status' => false,
                    'message' => 'Data bahan baku tidak ditemukan',
                ], 404);
            }else{
                if(str_contains($th->getMessage(), 'foreign key constraint fails')){
                    return response()->json([
                        'status' => false,
                        'message' => 'Bahan baku tidak dapat dihapus karena digunakan pada hampers/produk',
                    ], 400);
                }
                return response()->json([
                    'status' => false,
                    'message' => 'Gagal menghapus data bahan baku',
                    'error'=> $th->getMessage()
                ], 400);
            }
        }
    }
}
