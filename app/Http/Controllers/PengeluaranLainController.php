<?php

namespace App\Http\Controllers;

use App\Models\PengeluaranLain;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;


class PengeluaranLainController extends Controller
{
    public function getAllPengeluaranLain(){
        try {
            $pengeluaran_lain = PengeluaranLain::all();
            //code...
            if(!$pengeluaran_lain){
                throw new \Exception();
            }
            return response()->json([
                'status' => true,
                'message' => 'Success get all pengeluaran lain',
                'data' => $pengeluaran_lain
            ],200);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'status' => false,
                'message' => 'Pengeluaran lain not found',
                'data' => null
            ], 404);
        }
    }

    public function getPengeluaranLain($id){
        try {
            $pengeluaran_lain = PengeluaranLain::find($id);
            if(!$pengeluaran_lain){
                throw new \Exception();
            }
            return response()->json([
                'status'=>true,
                'message'=>'Success get pengeluaran lain by id',
                'data'=>$pengeluaran_lain
            ],200);
        } catch (\Throwable $th) {
            return response()->json([
                'status'=>false,
                'message'=>'Pengeluaran lain not found',
                'data'=>null
            ],404);
        }
    }
    public function searchPengeluaranLain(Request $request){
        try {
                $searchkey = $request->query('query');
                $pengeluaran_lain = PengeluaranLain::where('nama_pengeluaran', 'like', "%$searchkey%")->get();
                if(count($pengeluaran_lain)==0){
                    throw new \Exception();
                }
                return response()->json([
                    'status'=>true,
                    'message'=>'Success get pengeluaran lain by id',
                    'data'=>$pengeluaran_lain
                ],200);
            } catch (\Throwable $th) {
                return response()->json([
                    'status'=>false,
                    'message'=>'Pengeluaran lain not found',
                    'data'=>null
                ],404);
            }
        }

    public function insertPengeluaranLain(Request $request){
        try {
            $data = $request->all();
            $validate = Validator::make($data,[
                'nama_pengeluaran' => 'required',
                'nominal_pengeluaran' => 'required|numeric',
                'tanggal_pengeluaran' => 'required|date'
            ]);

            if($validate->fails()){
                throw new \Exception('invalid-input');
            }
            $pengeluaran_lain = PengeluaranLain::create($data);
            return response()->json([
                'status'=>true,
                'message'=>'Success insert pengeluaran lain',
                'data'=>$pengeluaran_lain
            ],200);
        } catch (\Throwable $th) {
            if($th->getMessage() === 'invalid-input'){
                return response()->json([
                    'status'=>false,
                    'message'=>'Invalid input',
                    'errors'=>$validate->errors()
                ],400);
            }else{
                return response()->json([
                    'status'=>false,
                    'message'=>'Invalid request',
                ],400);
            }
        }
    }

    public function updatePengeluaranLain(Request $request, $id){
        try {
            $pengeluaran_lain = PengeluaranLain::find($id);
            if(!$pengeluaran_lain){
                throw new \Exception('not-found');
            }
            
            $data = $request->all();
            $validate = Validator::make($data,[
                'nama_pengeluaran' => 'required',
                'nominal_pengeluaran' => 'required|numeric',
                'tanggal_pengeluaran' => 'required|date'
            ]);
        
            if($validate->fails()){
                throw new \Exception('invalid-input');
            }
        
            $pengeluaran_lain->update($data);
            return response()->json([
                'status'=>true,
                'message'=>'Success update pengeluaran lain',
                'data'=>$pengeluaran_lain
            ],200);
        } catch (\Throwable $th) {
            if ($th->getMessage() === 'not-found') {
                return response()->json([
                    'status'=>false,
                    'message'=>'Pengeluaran lain not found',
                    'data'=>null
                ],404);
            }else if($th->getMessage() === 'invalid-input'){
                return response()->json([
                    'status'=>false,
                    'message'=>'Invalid input',
                    'errors'=>$validate->errors()
                ],400);
            }else {
                return response()->json([
                    'status'=>false,
                    'message'=>'Invalid request',
                ],400);
            }
        }
        
    }

    public function deletePengeluaranLain($id){
        try {
            $pengeluaran_lain = PengeluaranLain::find($id);
            if(!$pengeluaran_lain){
                throw new \Exception('not-found');
            }
            $pengeluaran_lain->delete();
            return response()->json([
                'status'=>true,
                'message'=>'Success delete pengeluaran lain',
                'data'=>$pengeluaran_lain
            ],200);
        } catch (\Throwable $th) {
            if($th->getMessage() === 'not-found'){
                return response()->json([
                    'status'=>false,
                    'message'=>'Pengeluaran lain not found',
                    'data'=>null
                ],404);
            }else{
                return response()->json([
                    'status'=>false,
                    'message'=>'Failed delete pengeluaran lain',
                    'data'=>null
                ],400);
            }
        }
    }
}
