<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\User;
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
            $token = User::where('id_user', $user->id_user)->first();
            $payload = [
                'id' => $user->id_user,
                'name' => $user->nama,
                'email' => $user->email,
                'tanggal_lahir' => $user->tanggal_lahir,
                'no_hp' => $user->no_hp,
                'saldo' => $user->saldo,
                'poin' => $user->poin,
                'email_verified_at' => $user->email_verified_at,
                'role' => 'User'
            ];
            $token = User::where('id_user', $user->id_user)->first();
            $token = $token->createToken('authToken', ["user"])->plainTextToken;
            return response()->json([
                'status' => true,
                'message' => 'Login success',
                'data' => $payload,
                'token' => $token
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Invalid credentials',
            'data' => null,
        ], 401);
    }

    /*
    ============================================
    |             Administrator Access         |
    ============================================
    */
    public function changePassword(Request $request, string $id)
    {
        $karyawan = Karyawan::find($id);

        if ($karyawan == null) {
            return response()->json([
                'status' => 'error',
                'message' => 'Karyawan not found.'
            ], 404);
        }

        try {
            $validator = Validator::make($request->all(), [
                'password' => 'required|min:8',
                'new_password' => 'required|min:8',
                'confirm_password' => 'required|same:new_password',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => $validator->errors()
                ], 400);
            }

            if (!password_verify($request->password, $karyawan->password)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Invalid password.'
                ], 400);
            }

            $karyawan->update([
                'password' => bcrypt($request->new_password)
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Password updated successfully.'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error: ' . $e->getMessage()
            ], 400);
        }
    }
}
