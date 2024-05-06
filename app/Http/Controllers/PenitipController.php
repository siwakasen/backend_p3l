<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penitip;
use Illuminate\Support\Facades\Validator;

class PenitipController extends Controller
{
    public $validator_exception = [
        'nama_penitip.required' => 'Nama penitip harus diisi!',
        'nama_penitip.max' => 'Nama penitip maksimal 255 karakter!',
        'no_hp.required' => 'Nomor HP harus diisi!',
        'no_hp.numeric' => 'Nomor HP harus berupa angka!',
        'no_hp.digits_between' => 'Nomor HP harus berjumlah 11-13 digit!',
        'email.required' => 'Email harus diisi!',
        'email.email' => 'Email tidak valid!'
    ];

    public function getAllPenitip(){
        try {
            //code...
            $penitip = Penitip::all();
            if(!$penitip){
                throw new \Exception();
            }
            return response()->json([
                'status' => true,
                'message' => 'Berhasil mengambil semua data penitip',
                'data' => $penitip
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Data penitip tidak ditemukan',
                'data' => []
            ], 404);
            //throw $th;
        }
    }

    public function getPenitip($id){
        try {
            //code...
            $penitip = Penitip::find($id);
            if(!$penitip){
                throw new \Exception();
            }
            return response()->json([
                'status' => true,
                'message' => 'Berhasil mengambil data penitip',
                'data' => $penitip
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'status' => false,
                'message' => 'Data penitip tidak ditemukan',
                'data' => []
            ], 404);
        }
        }

    public function searchPenitip(Request $request){
        try {
            //code...
            $searchkey = $request->query('query');
            $data = Penitip::where('nama_penitip', 'like', '%'.$searchkey.'%')->get();
            if(count($data) == 0){
                throw new \Exception();
            }
            return response()->json([
                'status' => true,
                'message' => 'Berhasil mencari data penitip',
                'data' => $data
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Data penitip tidak ditemukan',
                'data' => []
            ], 404);
        }
    }

    public function insertPenitip(Request $request){
        try {
            //code...
            $data = $request->all();
            $validator = Validator::make($data, [
                'nama_penitip' => 'required|max:255',
                'no_hp' => 'required|numeric|digits_between:11,13',
                'email' => 'required|email'
            ], $this->validator_exception);
            
            if($validator->fails()){
                throw new \Exception('input-invalid');
            }

            $penitip = Penitip::create($data);
            return response()->json([
                'status' => true,
                'message' => 'Berhasil menambahkan data penitip',
                'data' => $penitip
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            if($th->getMessage() == 'input-invalid'){
                return response()->json([
                    'status' => false,
                    'message' => $validator->errors(),
                ], 400);
            }else{
                return response()->json([
                    'status' => false,
                    'message' => 'Gagal menambahkan data penitip',
                    'error'=> $th->getMessage()
                ], 400);
            }
        }
    }

    public function updatePenitip(Request $request, $id){
        try {
            //code...
            $penitip = Penitip::find($id);
            if(!$penitip){
                throw new \Exception('not-found');
            }
            
            $data = $request->all();
            $validator = Validator::make($data, [
                'nama_penitip' => 'required|max:255',
                'no_hp' => 'required|numeric|digits_between:11,13',
                'email' => 'required|email'
            ],$this->validator_exception);
            
            if($validator->fails()){
                throw new \Exception('invalid-input');
            }
            
            $penitip->update($data);
            return response()->json([
                'status' => true,
                'message' => 'Berhasil mengubah data penitip',
                'data' => $penitip
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            if($th->getMessage() == 'not-found'){
                return response()->json([
                    'status' => false,
                    'message' => 'Data penitip tidak ditemukan',
                    'data' => []
                ], 404);
            }else if($th->getMessage() == 'invalid-input'){
                return response()->json([
                    'status' => false,
                    'message' => $validator->errors(),
                    'data' => []
                ], 400);
            }else{
                return response()->json([
                    'status' => false,
                    'message' => 'Gagal mengubah data penitip',
                    'error'=> $th->getMessage()
                ], 400);
            }
        }
    }

    public function deletePenitip($id){
        try{
            $penitip = Penitip::find($id);
            if(!$penitip){
                throw new \Exception('not-found');
            }
            $penitip->delete();
            return response()->json([
                'status' => true,
                'message' => 'Berhasil hapus data penitip',
                'data' => $penitip
            ]);

        }catch(\Throwable $th){
            if($th->getMessage() == 'not-found'){
                return response()->json([
                    'status' => false,
                    'message' => 'Data penitip tidak ditemukan',
                    'data' => []
                ], 404);
            }else if(str_contains($th->getMessage(), 'a foreign key constraint fails')){
                return response()->json([
                    'status' => false,
                    'message'=> 'Data penitip tidak bisa dihapus karena memiliki produk yang terdaftar',
                ], 400);
            }
            else{
                return response()->json([
                    'status' => false,
                    'message' => 'Gagal menghapus data penitip',
                    'error'=> $th->getMessage(),
                    'data'=>[]
                ], 400);
            }
        }
    }

}
