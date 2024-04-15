<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Karyawan;
use Illuminate\Support\Facades\Validator;

class KaryawanController extends Controller
{
    public $validator_exception = [
        'id_role.required' => 'ID role harus diisi!',
        'id_role.exists' => 'ID role tidak valid!',
        'nama_karyawan.required' => 'Nama karyawan harus diisi!',
        'nama_karyawan.max' => 'Nama karyawan maksimal 255 karakter!',
        'email.required' => 'Email harus diisi!',
        'email.email' => 'Email tidak valid!',
        'password.required' => 'Password harus diisi!',
        'tanggal_masuk.required' => 'Tanggal masuk harus diisi!',
        'tanggal_masuk.date' => 'Tanggal masuk tidak valid!',
        'bonus_gaji.required' => 'Bonus gaji harus diisi!',
        'bonus_gaji.numeric' => 'Bonus gaji harus berupa angka!'
    ];

    public function getAllKaryawan()
    {
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully fetch karyawan data.',
            'data' => Karyawan::all()->load('Role')
        ], 200);
    }

    public function getKaryawan(string $id)
    {
        if (Karyawan::find($id) == null) {
            return response()->json([
                'status' => 'error',
                'message' => 'Karyawan not found.'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Successfully fetch karyawan data.',
            'data' => Karyawan::find($id)
        ], 200);
    }

    public function insertKaryawan(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                'id_role' => 'required|exists:roles,id_role',
                'nama_karyawan' => 'required|max:255',
                'email' => 'required|email',
                'password' => 'required',
                'tanggal_masuk' => 'required|date',
                'bonus_gaji' => 'required|numeric|min:0',
            ], $this->validator_exception);

            if($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => $validator->errors()
                ], 400);
            }

            Karyawan::create($request->all());

            return response()->json([
                'status' => 'success', 
                'message' => 'Karyawan created successfully.'
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error: ' . $e->getMessage()
            ], 400);
        }  
    }

    public function updateKaryawan(Request $request, string $id)
    {
        if (Karyawan::find($id) == null) {
            return response()->json([
                'status' => 'error',
                'message' => 'Karyawan not found.'
            ], 404);
        }

        try{
            $validator = Validator::make($request->all(), [
                'id_role' => 'required|exists:roles,id_role',
                'nama_karyawan' => 'required|max:255',
                'email' => 'required|email',
                'password' => 'required',
                'tanggal_masuk' => 'required|date',
                'bonus_gaji' => 'required|numeric|min:0',
            ], $this->validator_exception);

            if($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => $validator->errors()
                ], 400);
            }

            Karyawan::find($id)->update($request->all());

            return response()->json([
                'status' => 'success', 
                'message' => 'Karyawan updated successfully.'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error: ' . $e->getMessage()
            ], 400);
        }
    }

    public function deleteKaryawan(string $id)
    {
        if (Karyawan::find($id) == null) {
            return response()->json([
                'status' => 'error',
                'message' => 'Karyawan not found.'
            ], 404);
        } 

        try{
            Karyawan::destroy($id);
    
            return response()->json([
                'status' => 'success',
                'message' => 'Karyawan deleted successfully.'
            ], 200);
        } catch(\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error: ' . $e->getMessage()
            ], 400);
        }
    }
}
