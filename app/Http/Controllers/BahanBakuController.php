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
                'message' => 'Success get all bahan baku',
                'data' => $bahan_baku
            ]);

        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'status' => false,
                'message' => 'Bahan baku not found',
                'data' => null
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
                'message' => 'Success get bahan baku by id',
                'data' => $bahan_baku
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'status' => false,
                'message' => 'Bahan baku not found',
                'data' => null
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
                'message' => 'Success get bahan baku by nama',
                'data' => $data
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'status' => false,
                'message' => 'Bahan Baku not found',
                'data' => null
            ], 404);
        }
    }

    public function insertBahanBaku(Request $request){
        try {
            //code...
            $data =  $request->all();
            $validate = Validator::make($data, [
                'nama_bahan_baku' => 'required|max:255',
                'stok' => 'required|numeric',
                'satuan' => 'required|max:255',
            ], $this->validator_exception);
    
            if($validate->fails()){
                throw new \Exception('invalid-input');
            }
            $bahan_baku = BahanBaku::create($data);
            return response()->json([
                'status' => true,
                'message' => 'Success insert bahan baku',
                'data' => $bahan_baku
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            if($th->getMessage() == 'invalid-input'){
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid input',
                    'errors'=> $validate->errors()
                ], 400);
            }else{
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid request',
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
                'stok' => 'required|numeric',
                'satuan' => 'required|max:255',
            ],$this->validator_exception);
            if($validate->fails()){
                throw new \Exception('invalid-input');
            }
            
            $bahan_baku->update($data);
            return response()->json([
                'status' => true,
                'message' => 'Success update bahan baku',
                'data' => $bahan_baku,
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            if($th->getMessage() == 'not-found'){
                return response()->json([
                    'status' => false,
                    'message' => 'Bahan baku not found',
                    'data' => null
                ], 404);
            }else if($th->getMessage() == 'invalid-input'){
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid input',
                    'errors'=> $validate->errors()
                ], 400);
            }
            else{
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid request',
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
                'message' => 'Success delete bahan baku',
                'data' => $bahan_baku
            ]);
            
        } catch (\Throwable $th) {
            //throw $th;
            if($th->getMessage() == 'not-found'){
                return response()->json([
                    'status' => false,
                    'message' => 'Bahan baku not found',
                    'data' => null
                ], 404);
            }else{
                return response()->json([
                    'status' => false,
                    'message' => 'Failed delete bahan baku',
                    'error'=> $th->getMessage()
                ], 404);
            }
        }
    }
}
