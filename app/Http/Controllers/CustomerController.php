<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Pesanan;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    public function register(Request $request) {
        try{

            $validator = Validator::make($request->all(), [
                'nama' => 'required|max:255',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:8',
                'tanggal_lahir' => 'required|date',
                'no_hp' => 'required|numeric'
            ],
            [
                'nama.required' => 'Nama harus diisi!',
                'nama.max' => 'Nama maksimal 255 karakter!',
                'email.required' => 'Email harus diisi!',
                'email.email' => 'Email tidak valid!',
                'email.unique' => 'Email sudah terdaftar!',
                'password.required' => 'Password harus diisi!',
                'password.min' => 'Password minimal 8 karakter!',
                'tanggal_lahir.required' => 'Tanggal lahir harus diisi!',
                'tanggal_lahir.date' => 'Tanggal lahir tidak valid!',
                'no_hp.required' => 'Nomor HP harus diisi!',
                'no_hp.numeric' => 'Nomor HP harus berupa angka!'
            ]);

            if($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => $validator->errors()
                ], 400);
            }

            User::create([
                'nama' => $request->nama,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'tanggal_lahir' => $request->tanggal_lahir,
                'no_hp' => $request->no_hp,
                'email_verified_at' => now(),
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'User registered successfully.'
            ], 201);
        } catch(\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error: ' . $e->getMessage()
            ], 400);
        }
    }

    public function showData(string $id) {
        $user = User::find($id);

        if($user == null) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found.'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'User data fetched successfully.',
            'data' => $user
        ], 200);
    }

    public function changeProfile(Request $request, string $id) {
        try{
            $validator = Validator::make($request->all(), [
                'nama' => 'required|max:255',
                'email' => 'required|email|unique:users,email,'.$id.',id_user',
                'tanggal_lahir' => 'required|date',
                'no_hp' => 'required|numeric'
            ],
            [
                'nama.required' => 'Nama harus diisi!',
                'nama.max' => 'Nama maksimal 255 karakter!',
                'email.required' => 'Email harus diisi!',
                'email.email' => 'Email tidak valid!',
                'email.unique' => 'Email sudah terdaftar!',
                'tanggal_lahir.required' => 'Tanggal lahir harus diisi!',
                'tanggal_lahir.date' => 'Tanggal lahir tidak valid!',
                'no_hp.required' => 'Nomor HP harus diisi!',
                'no_hp.numeric' => 'Nomor HP harus berupa angka!'
            ]);

            if($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => $validator->errors()
                ], 400);
            }

            $user = User::find($id);

            if($user == null) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'User not found.'
                ], 404);
            }

            if($request->email != $user->email) {
                if(User::where('email', $request->email)->first() != null) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Email already registered.'
                    ], 400);
                }
            }else{
                User::where('id_user', $id)->update([
                    'nama' => $request->nama,
                    'email' => $request->email,
                    'tanggal_lahir' => $request->tanggal_lahir,
                    'no_hp' => $request->no_hp
                ]);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'User profile updated successfully.'
            ], 200);
        } catch(\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error: ' . $e->getMessage()
            ], 400);
        }
    }

    public function historyTransaction(string $id) {
        $user = User::find($id);

        if($user == null) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found.'
            ], 404);
        }
        try {
            $data = Pesanan::where('id_user', $id)->get();

            return response()->json([
                'status' => 'success',
                'message' => 'Transaction history fetched successfully.',
                'data' => $data
            ], 200);
        } catch(\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error: ' . $e->getMessage()
            ], 400);
        }
    }

    public function searchTransaction(Request $request, string $id) {
        $user = User::find($id);

        if($user == null) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found.'
            ], 404);
        }
        try {
            $validator = Validator::make($request->all(), [
                'nama_produk' => 'required'
            ],
            [
                'nama_produk.required' => 'Nama produk harus diisi!'
            ]);

            if($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => $validator->errors()
                ], 400);
            }

            $data = Pesanan::where('id_user', $id)->where('nama_produk', 'like', '%'.$request->nama_produk.'%')->get();

            return response()->json([
                'status' => 'success',
                'message' => 'Transaction history fetched successfully.',
                'data' => $data
            ], 200);
        } catch(\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error: ' . $e->getMessage()
            ], 400);
        }
    }
}
