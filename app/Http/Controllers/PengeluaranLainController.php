<?php

namespace App\Http\Controllers;

use App\Models\PengeluaranLain;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;


class PengeluaranLainController extends Controller
{
    public $validator_exception = [
        'nama_pengeluaran.required' => 'Nama pengeluaran harus diisi!',
        'nama_pengeluaran.max' => 'Nama pengeluaran maksimal 255 karakter!',
        'nominal_pengeluaran.required' => 'Nominal pengeluaran harus diisi!',
        'nominal_pengeluaran.numeric' => 'Nominal pengeluaran harus berupa angka!',
        'nominal_pengeluaran.min' => 'Nominal pengeluaran minimal 1!',
        'tanggal_pengeluaran.required' => 'Tanggal pengeluaran harus diisi!',
        'tanggal_pengeluaran.date' => 'Tanggal pengeluaran tidak valid!',
    ];
    public function getAllPengeluaranLain(){
        try {
            $pengeluaran_lain = PengeluaranLain::all();
            //code...
            if(!$pengeluaran_lain){
                throw new \Exception();
            }
            return response()->json([
                'status' => true,
                'message' => 'Berhasil mengambil semua data pengeluaran lain',
                'data' => $pengeluaran_lain
            ],200);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'status' => false,
                'message' => 'Data pengeluaran lain tidak ditemukan',
                'error' => 'Request invalid',
                'data' => []
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
                'message'=>'Berhasil mengambil data pengeluaran lain',
                'data'=>$pengeluaran_lain
            ],200);
        } catch (\Throwable $th) {
            return response()->json([
                'status'=>false,
                'message'=>'Data pengeluaran lain tidak ditemukan',
                'data'=> []
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
                    'message'=>'Berhasil mencari data pengeluaran lain',
                    'data'=>$pengeluaran_lain
                ],200);
            } catch (\Throwable $th) {
                return response()->json([
                    'status'=>false,
                    'message'=>'Data pengeluaran lain tidak ditemukan',
                    'data'=> []
                ],404);
            }
        }

    public function insertPengeluaranLain(Request $request){
        try {
            $data = $request->all();
            $validate = Validator::make($data,[
                'nama_pengeluaran' => 'required|max:255',
                'nominal_pengeluaran' => 'required|numeric|min:1',
                'tanggal_pengeluaran' => 'required|date'
            ],$this->validator_exception);

            if($validate->fails()){
                throw new \Exception('invalid-input');
            }
            $pengeluaran_lain = PengeluaranLain::create($data);
            return response()->json([
                'status'=>true,
                'message'=>'Berhasil menambahkan data pengeluaran lain',
                'data'=>$pengeluaran_lain
            ],200);
        } catch (\Throwable $th) {
            if($th->getMessage() === 'invalid-input'){
                return response()->json([
                    'status'=>false,
                    'message'=>$validate->errors(),
                ],400);
            }else{
                return response()->json([
                    'status'=>false,
                    'message'=>'Gagal menambahkan data pengeluaran lain',
                    'error'=>$th->getMessage()
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
                'nama_pengeluaran' => 'required|max:255',
                'nominal_pengeluaran' => 'required|numeric|min:1',
                'tanggal_pengeluaran' => 'required|date'
            ],$this->validator_exception);
        
            if($validate->fails()){
                throw new \Exception('invalid-input');
            }
        
            $pengeluaran_lain->update($data);
            return response()->json([
                'status'=>true,
                'message'=>'Berhasil mengubah data pengeluaran lain',
                'data'=>$pengeluaran_lain
            ],200);
        } catch (\Throwable $th) {
            if ($th->getMessage() === 'not-found') {
                return response()->json([
                    'status'=>false,
                    'message'=>'Data pengeluaran lain tidak ditemukan',
                ],404);
            }else if($th->getMessage() === 'invalid-input'){
                return response()->json([
                    'status'=>false,
                    'message'=>$validate->errors(),
                ],400);
            }else {
                return response()->json([
                    'status'=>false,
                    'message'=>'Gagal mengubah data pengeluaran lain',
                    'error'=>$th->getMessage()
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
                'message'=>'Berhasil menghapus data pengeluaran lain',
                'data'=>$pengeluaran_lain
            ],200);
        } catch (\Throwable $th) {
            if($th->getMessage() === 'not-found'){
                return response()->json([
                    'status'=>false,
                    'message'=>'Data pengeluaran lain tidak ditemukan',
                ],404);
            }else{
                return response()->json([
                    'status'=>false,
                    'message'=>'Gagal menghapus data pengeluaran lain',
                    'error'=>$th->getMessage()
                ],400);
            }
        }
    }
}
