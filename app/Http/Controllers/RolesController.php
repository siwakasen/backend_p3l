<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use Illuminate\Http\Request;
use App\Models\Roles;
use Illuminate\Support\Facades\Validator;

class RolesController extends Controller
{
    public $validator_exception = [
        'nama_role.required' => 'Nama role harus diisi!',
        'nama_role.max' => 'Nama role maksimal 255 karakter!',
        'nama_role.unique' => 'Nama role sudah terdaftar!',
        'nominal_gaji.numeric' => 'Nominal gaji harus berupa angka!'
    ];

    public function getAllRole()
    {
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully fetch roles data',
            'data' => Roles::all()
        ], 200);
    }

    public function getRole(string $id)
    {
        if (Roles::find($id) == null) {
            return response()->json([
                'status' => 'error',
                'message' => 'Role not found.'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Successfully fetch role data',
            'data' => Roles::find($id)
        ], 200);
    }

    public function insertRole(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                'nama_role' => 'required|max:255|unique:roles',
                'nominal_gaji' => 'numeric'
            ], $this->validator_exception);

            if($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'type' => 'validation',
                    'message' => $validator->errors()
                ], 400);
            }

            Roles::create($request->all());

            return response()->json([
                'status' => 'success', 
                'message' => 'Role created successfully.'
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error: ' . $e->getMessage()
            ], 400);
        }  
    }

    public function updateRole(Request $request, string $id)
    {
        if (Roles::find($id) == null) {
            return response()->json([
                'status' => 'error',
                'message' => 'Role not found.'
            ], 404);
        }

        try {
            $validator = Validator::make($request->all(), [
                'nama_role' => 'max:255|unique:roles,nama_role,'.$id.',id_role',
                'nominal_gaji' => 'numeric'
            ], $this->validator_exception);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'type' => 'validation',
                    'message' => $validator->errors()
                ], 400);
            }

            Roles::find($id)->update($request->all());

            return response()->json([
                'status' => 'success',
                'message' => 'Role updated successfully.'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error: ' . $e->getMessage()
            ], 400);
        }
    }

    public function deleteRole(string $id)
    {
        if (Roles::find($id) == null) {
            return response()->json([
                'status' => 'error',
                'message' => 'Role not found.'
            ], 404);
        } 

        try{
            $karyawan = Karyawan::all()->load('Role')->where('Role.nama_role', '=', Roles::find($id)->nama_role);
            if ($karyawan->count() > 0) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Role cannot be deleted because it is used by employee.'
                ], 400);
            }
            Roles::destroy($id);
            return response()->json([
                'status' => 'success',
                'message' => 'Role deleted successfully.'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error: ' . $e->getMessage()
            ], 400);
        }
    }
}
