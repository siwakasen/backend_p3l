<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Pesanan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\MailVerification;
use Illuminate\Support\Str;
use App\Mail\MailSend;
use App\Models\MobileTokens;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class CustomerController extends Controller
{
    /*
    ===============================================
    |              Customer Access Only           |
    ===============================================
    */
    public function register(Request $request)
    {
        try {

            $validator = Validator::make(
                $request->all(),
                [
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
                ]
            );

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'type' => 'validation',
                    'message' => $validator->errors()
                ], 400);
            }

            $user = User::create([
                'nama' => $request->nama,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'tanggal_lahir' => $request->tanggal_lahir,
                'no_hp' => $request->no_hp
            ]);

            $id_token = $user->id_user;

            if ($user->id_user < 10) {
                $id_token = '0' . $user->id_user;
            } else {
                $id_token = substr($user->id_user, 0, 2);
            }

            $digitSec = substr($user->no_hp, -4) . $id_token;
            $token = $user->id_user . md5($user->email . $user->nama);

            $data = [
                'id_user' => $user->id_user,
                'nama' => $user->nama,
                'email' => $user->email,
                'tanggal_lahir' => $user->tanggal_lahir,
                'no_hp' => $user->no_hp,
                'token' => $token,
                'digit' => $digitSec
            ];

            Mail::to($request->email)->send(new MailVerification($data));

            return response()->json([
                'status' => 'success',
                'message' => 'User registered successfully.',
                'token' => $token
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error: ' . $e->getMessage()
            ], 400);
        }
    }

    public function storeNotifTokens(Request $request){
        $validate = Validator::make($request->all(), [
            'token' => 'required',
            'id_user' => 'required',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid credentials',
                'errors' => $validate->errors(),
            ], 401);
        }

        $notifToken = MobileTokens::where('id_user', $request->id_user)->where('token', $request->token)->first();
        if ($notifToken) {
            return response()->json([
                'status' => false,
                'message' => 'Token already stored',
                'data' => null,
            ]);
        } else {
            MobileTokens::create([
                'token' => $request->token,
                'id_user' => $request->id_user
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'Token stored successfully',
            'data' => null,
        ]);
    }

    public function emailCheck(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if ($user == null) {
            return response()->json([
                'status' => true,
                'message' => 'Email available.'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Email already registered.'
            ]);
        }
    }

    public function checkTokenValidity($token)
    {
        $user = User::where('id_user', substr($token, 0, -32))->first();
        if ($user == null) {
            return response()->json([
                'status' => false,
                'message' => 'User not found.'
            ], 404);
        }

        if ($token == $user->id_user . md5($user->email . $user->nama) && $user->email_verified_at == null) {
            return response()->json([
                'status' => true,
                'message' => 'Token valid.',
                'email' => $user->email
            ], 200);
        }

        return response()->json([
            'status' => false,
            'message' => 'Invalid token.'
        ], 400);
    }

    public function verify(Request $request, $token)
    {
        $user = User::where('id_user', substr($token, 0, -32))->first();

        if ($user == null) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found.'
            ], 404);
        }

        $id_token = $user->id_user;

        if ($user->id_user < 10) {
            $id_token = '0' . $user->id_user;
        } else {
            $id_token = substr($user->id_user, 0, 2);
        }

        if ($token == $user->id_user . md5($user->email . $user->nama) && $request->digit == substr($user->no_hp, -4) . $id_token && $user->email_verified_at == null) {
            $user->update([
                'email_verified_at' => date('Y-m-d H:i:s')
            ]);

            $userToken = $user->createToken('authToken', ["user"])->plainTextToken;

            return response()->json([
                'status' => 'success',
                'message' => 'Berhasil melakukan verifikasi email.',
                'token' => $userToken
            ], 200);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Token atau digit tidak valid.'
        ], 400);
    }

    public function resendEmail(Request $request)
    {
        $user = User::where('id_user', substr($request->token, 0, -32))->first();

        if ($user == null) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found.'
            ], 404);
        }

        if ($user->email_verified_at != null) {
            return response()->json([
                'status' => 'error',
                'message' => 'Email already verified.'
            ], 400);
        }

        $id_token = $user->id_user;

        if ($user->id_user < 10) {
            $id_token = '0' . $user->id_user;
        } else {
            $id_token = substr($user->id_user, 0, 2);
        }

        $data = [
            'id_user' => $user->id_user,
            'nama' => $user->nama,
            'email' => $user->email,
            'tanggal_lahir' => $user->tanggal_lahir,
            'no_hp' => $user->no_hp,
            'token' => $user->id_user . md5($user->email . $user->nama),
            'digit' => substr($user->no_hp, -4) . $id_token
        ];

        Mail::to($user->email)->send(new MailVerification($data));

        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil mengirim ulang email verifikasi.'
        ], 200);
    }

    public function showData()
    {
        $user = User::find(Auth::user()->id_user);

        $user = [
            'id' => $user->id_user,
            'nama' => $user->nama,
            'email' => $user->email,
            'tanggal_lahir' => $user->tanggal_lahir,
            'no_hp' => $user->no_hp,
            'saldo' => $user->saldo,
            'poin' => $user->poin,
            'email_verified_at' => $user->email_verified_at,
            'role' => 'User'
        ];

        if ($user == null) {
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

    public function changeProfile(Request $request)
    {
        try {
            $id = Auth::user()->id_user;
            if ($id == null) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Unauthorized'
                ], 401);
            }
            $validator = Validator::make(
                $request->all(),
                [
                    'nama' => 'max:255',
                    'email' => 'email|unique:users,email,' . $id . ',id_user',
                    'tanggal_lahir' => 'date',
                    'no_hp' => 'numeric'
                ],
                [
                    'nama.max' => 'Nama maksimal 255 karakter!',
                    'email.email' => 'Email tidak valid!',
                    'email.unique' => 'Email sudah terdaftar!',
                    'tanggal_lahir.date' => 'Tanggal lahir tidak valid!',
                    'no_hp.numeric' => 'Nomor HP harus berupa angka!'
                ]
            );

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => $validator->errors()
                ], 400);
            }

            $user = User::find($id);

            if ($user == null) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'User not found.'
                ], 404);
            }

            if ($request->email != $user->email) {
                if (User::where('email', $request->email)->first() != null) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Email already registered.'
                    ], 400);
                } else {
                    User::where('id_user', $id)->update(
                        $request->only(['nama', 'email', 'tanggal_lahir', 'no_hp'])
                    );
                    return response()->json([
                        'status' => 'success',
                        'message' => 'User profile updated successfully.'
                    ], 200);
                }
            } else {
                User::where('id_user', $id)->update(
                    $request->only(['nama', 'email', 'tanggal_lahir', 'no_hp'])
                );
                return response()->json([
                    'status' => 'success',
                    'message' => 'User profile updated successfully.'
                ], 200);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error: ' . $e->getMessage()
            ], 400);
        }
    }

    public function createToken(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ], 400);
        }
        $user = User::where('email', $request->email)->first();
        if ($user == null) {
            return response()->json([
                'status' => 'error',
                'message' => 'Email not registered.'
            ], 404);
        }
        try {
            $newToken = Str::random(100);
            $exist = DB::table('password_reset_tokens')->where('email', $user->email)->first();

            if ($exist) {
                DB::table('password_reset_tokens')->where('email', $user->email)->Update([
                    'token' => $newToken,
                    'created_at' => now()
                ]);
            } else {
                DB::table('password_reset_tokens')->Insert([
                    'email' => $user->email,
                    'token' => $newToken,
                    'created_at' => now()
                ]);
            }
            $details = [
                'name' => $user->nama,
                'url' => request()->ip() . ':' . request()->getPort() . '/api/customer/reset-password/activate/' . $newToken,
            ];

            Mail::to($user->email)->send(new MailSend($details));

            return response()->json([
                'status' => 'success',
                'message' => 'Verification to reset password has been sent to your email.'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error: ' . $e->getMessage()
            ], 400);
        }
    }

    public function activateToken(String $token)
    {
        $verify_token = DB::table('password_reset_tokens')->where('token', $token)->first();
        if (!$verify_token || $verify_token->token != $token) {
            return view('verificationFailed');
        }
        DB::table('password_reset_tokens')->where('token', $token)->update([
            'is_active' => true
        ]);
        $link = 'http://127.0.0.1:3000/forgot-password/change-password?token=' . $token . '&email=' . $verify_token->email;
        return view('verificationSuccess', compact('link'));
    }

    public function validateToken(String $token)
    {
        $verify_token = DB::table('password_reset_tokens')->where('token', $token)->first();
        if (!$verify_token || $verify_token->token != $token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid token'
            ], 404);
        }
        if (!$verify_token->is_active) {
            return response()->json([
                'status' => 'error',
                'message' => 'Token is not active'
            ], 400);
        }
        return response()->json([
            'status' => 'success',
            'message' => 'Token is valid'
        ], 200);
    }

    public function resetPassword(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'password' => 'required|min:8',
                'confirm_password' => 'required|same:password',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => $validator->errors()
                ], 400);
            }

            $user = User::where('email', $request->email)->first();
            if ($user == null) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Email not registered.'
                ], 404);
            }
            $token = DB::table('password_reset_tokens')->where('email', $user->email)->first();
            if (!$token) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Invalid token'
                ], 404);
            } else if (!$token->is_active) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Token is not active'
                ], 400);
            }

            $user->update([
                'password' => Hash::make($request->password)
            ]);

            DB::table('password_reset_tokens')->where('email', $user->email)->delete();
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

    public function historyTransaction()
    {
        $user = User::find(Auth::user()->id_user);

        if ($user == null) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized'
            ], 401);
        }
        try {
            $id = Auth::user()->id_user;
            $data = Pesanan::where('id_user', $id)
                ->where(function ($query) {
                    $query->where('status_transaksi', 'Pesanan Sudah Selesai')
                        ->orWhere('status_transaksi', 'Pesanan Dibatalkan');
                })->orderBy('tanggal_pesanan', 'desc')
                ->get()->load('detailPesanan.Produk', 'detailPesanan.Hampers', 'detailPesanan.Produk.Kategori');

            return response()->json([
                'status' => 'success',
                'message' => 'Transaction history fetched successfully.',
                'data' => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error: ' . $e->getMessage()
            ], 400);
        }
    }

    public function getPesananOnProgress(){
        $user = User::find(Auth::user()->id_user);

        if ($user == null) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized'
            ], 401);
        }
        try {
            $id = Auth::user()->id_user;
            $data = Pesanan::where('id_user', $id)
                ->where('status_transaksi', '!=', 'Pesanan Sudah Selesai')->where('status_transaksi', '!=', 'Pesanan Dibatalkan')
                ->orderBy('tanggal_pesanan', 'asc')
                ->get()->load('detailPesanan.Produk', 'detailPesanan.Hampers', 'detailPesanan.Produk.Kategori');

            return response()->json([
                'status' => 'success',
                'message' => 'Transaction history fetched successfully.',
                'data' => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error: ' . $e->getMessage()
            ], 400);
        }
    }

    public function confirmPesanan(Request $request, $id)
    {
        $user = User::find(Auth::user()->id_user);

        if ($user == null) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized'
            ], 401);
        }
        try {
            $pesanan = Pesanan::find($id);
            if ($pesanan == null) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Pesanan not found.'
                ], 404);
            }
            $pesanan->update([
                'status_transaksi' => 'Pesanan Sudah Selesai'
            ]);
            return response()->json([
                'status' => 'success',
                'message' => 'Transaction updated successfully.'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error: ' . $e->getMessage()
            ], 400);
        }
    }

    public function getHistoryPesananByStatus(Request $request)
    {
        $user = User::find(Auth::user()->id_user);
        if ($user == null) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized'
            ], 401);
        }
        if (!$request->has('status')) {
            return response()->json([
                'status' => 'error',
                'message' => 'Status is required.'
            ], 400);
        }
        try {
            $id = Auth::user()->id_user;
            $data = Pesanan::where('id_user', $id)
                ->where('status_transaksi', $request->status)->get()->load('detailPesanan.Produk', 'detailPesanan.Hampers', 'detailPesanan.Produk.Kategori');

            return response()->json([
                'status' => 'success',
                'message' => 'Transaction history fetched successfully.',
                'data' => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error: ' . $e->getMessage()
            ], 400);
        }
    }

    /*
    ===============================================
    |              Admin Access Only              |
    ===============================================
    */
    public function searchDataCustomer(Request $request)
    {
        try {
            $searchkey = $request->query('query');
            $customer = User::where('nama', 'like', '%' . $searchkey . '%')
                                ->orWhere('email', 'like', '%' . $searchkey . '%')
                                ->orWhere('no_hp', 'like', '%' . $searchkey . '%')
                                ->select('id_user', 'nama', 'email', 'no_hp')->get();
            if (count($customer) == 0) {
                throw new \Exception();
            }
            return response()->json([
                'status' => true,
                'message' => 'Success get data customer',
                'data' => $customer
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Customer not found',
                'error' => $th->getMessage(),
                'data' => [],
            ], 404);
        }
    }

    public function getHistoryPesananCustomer($id)
    {
        try {

            $history = Pesanan::with(['detailPesanan' => function ($query) {
                $query->select('id_pesanan', 'id_produk', 'id_hampers', 'jumlah', 'subtotal')
                    ->with(['Produk' => function ($query) {
                        $query->select('id_produk', 'nama_produk',  'harga_produk');
                    }, 'Hampers' => function ($query) {
                        $query->select('id_hampers', 'nama_hampers', 'harga_hampers');
                    }]);
            }])
                ->where('id_user', $id)
                ->where(function ($query) {
                    $query->where('status_transaksi', 'Pesanan Sudah Selesai')
                        ->orWhere('status_transaksi', 'Pesanan Dibatalkan');
                })
                ->get();


            if (count($history) == 0) {
                throw new \Exception();
            }
            return response()->json([
                'status' => true,
                'message' => 'Success get history pesanan customer',
                'data' => $history
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Pesanan not found',
                'error' => $th->getMessage(),
                'data' => []
            ], 404);
        }
    }

}
