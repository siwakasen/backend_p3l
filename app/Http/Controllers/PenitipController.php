<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penitip;
use Illuminate\Support\Facades\Validator;

class PenitipController extends Controller
{
    public function getAllPenitip(){
        try {
            //code...
            $penitip = Penitip::all();
            if(!$penitip){
                throw new \Exception();
            }
            return response()->json([
                'status' => true,
                'message' => 'Success get all penitip',
                'data' => $penitip
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Penitip not found',
                'data' => null
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
                'message' => 'Success get penitip by id',
                'data' => $penitip
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'status' => false,
                'message' => 'Penitip not found',
                'data' => null
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
                'message' => 'Success get penitip by nama',
                'data' => $data
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Penitip not found',
                'data' => null
            ], 404);
            //throw $th;
        }
    }

    public function insertPenitip(Request $request){
        try {
            //code...
            $data = $request->all();
            $validator = Validator::make($data, [
                'nama_penitip' => 'required|string',
                'no_hp' => 'required|numeric|digits_between:11,13',
                'email' => 'required|email'
            ]);

            if($validator->fails()){
                throw new \Exception('invalid-input');
            }

            $penitip = Penitip::create($data);
            return response()->json([
                'status' => true,
                'message' => 'Success insert penitip',
                'data' => $penitip
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            if($th->getMessage() == 'invalid-input'){
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid input',
                    'error' => $validator->errors(),
                    'data' => null
                ], 400);
            }else{
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid request',
                    'data' => null
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
                'nama_penitip' => 'required|string',
                'no_hp' => 'required|numeric|digits_between:11,13',
                'email' => 'required|email'
            ]);
            
            if($validator->fails()){
                throw new \Exception('invalid-input');
            }
            
            $penitip->update($data);
            return response()->json([
                'status' => true,
                'message' => 'Success update penitip',
                'data' => $penitip
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            if($th->getMessage() == 'not-found'){
                return response()->json([
                    'status' => false,
                    'message' => 'Penitip not found',
                    'data' => null
                ], 404);
            }else if($th->getMessage() == 'invalid-input'){
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid input',
                    'error' => $validator->errors(),
                    'data' => null
                ], 400);
            }else{
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid request',
                    'data' => null
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
                'message' => 'Success delete penitip',
                'data' => $penitip
            ]);

        }catch(\Throwable $th){
            if($th->getMessage() == 'not-found'){
                return response()->json([
                    'status' => false,
                    'message' => 'Penitip not found',
                    'data' => null
                ], 404);
            }else{
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid request',
                    'data' => null
                ], 400);
            }
        }
    }

}
