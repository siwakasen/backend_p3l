<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use Illuminate\Auth\Events\Validated;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = [
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ];

        $validate = Validator::make($credentials, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid credentials',
                'errors' => $validate->errors(),
            ], 401);
        }

        if (Auth::guard('karyawan')->attempt($credentials)) {
            $karyawan = auth()->guard('karyawan')->user();
            $payload = [
                'id_karyawan' => $karyawan->id_karyawan,
                'id_role' => $karyawan->id_role,
                'nama_karyawan' => $karyawan->nama_karyawan,
                'email' => $karyawan->email,
                'tanggal_masuk' => $karyawan->tanggal_masuk,
                'bonus_gaji' => $karyawan->bonus_gaji,
                'role' => $karyawan->Role->nama_role,
            ];
            $token = Karyawan::where('id_karyawan', $karyawan->id_karyawan)->first();
            $token = $token->createToken('authToken', [Str::slug($karyawan->Role->nama_role)])->plainTextToken;
            return response()->json([
                'status' => true,
                'message' => 'Login success',
                'data' => $payload,
                'token' => $token
            ]);
        } else if (Auth::guard('user')->attempt($credentials)) {
            $user = auth()->guard('user')->user();
            $payload = [
                'id' => $user->id_user,
                'name' => $user->nama,
                'email' => $user->email,
                'tanggal_lahir' => $user->tanggal_lahir,
                'no_hp' => $user->no_hp,
                'saldo' => $user->saldo,
                'poin' => $user->poin,
            ];

            return response()->json([
                'status' => true,
                'message' => 'Login success',
                'data' => $payload,
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Invalid credentials',
            'data' => null,
        ], 401);
    }
}
