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

class CustomerController extends Controller
{
    /*
    ===============================================
    |              Customer Access Only           |
    ===============================================
    */
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

            $user = User::create([
                'nama' => $request->nama,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'tanggal_lahir' => $request->tanggal_lahir,
                'no_hp' => $request->no_hp
            ]);
            
            $data = [
                'id_user' => $user->id_user,
                'nama' => $user->nama,
                'email' => $user->email,
                'tanggal_lahir' => $user->tanggal_lahir,
                'no_hp' => $user->no_hp,
                'token' => $user->id_user.md5($user->email.$user->nama)
            ];

            Mail::to($request->email)->send(new MailVerification($data));

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

    public function verify($token) {
        $user = User::where('id_user', substr($token, 0, -32))->first();

        if($user == null) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found.'
            ], 404);
        }

        if($token == $user->id_user.md5($user->email.$user->nama)) {
            $user->update([
                'email_verified_at' => date('Y-m-d H:i:s')
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Email verified successfully.'
            ], 200);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Invalid token.'
        ], 400);
    }

    public function resendEmail(Request $request) {
        $user = User::where('email', $request->email)->first();

        if($user == null) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found.'
            ], 404);
        }

        if($user->email_verified_at != null) {
            return response()->json([
                'status' => 'error',
                'message' => 'Email already verified.'
            ], 400);
        }

        $data = [
            'id_user' => $user->id_user,
            'nama' => $user->nama,
            'email' => $user->email,
            'tanggal_lahir' => $user->tanggal_lahir,
            'no_hp' => $user->no_hp,
            'token' => $user->id_user.md5($user->email.$user->nama)
        ];

        Mail::to($request->email)->send(new MailVerification($data));

        return response()->json([
            'status' => 'success',
            'message' => 'Email verification sent successfully.'
        ], 200);
    }

    public function showData() {
        $user = User::find(Auth::user()->id_user);
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

    public function changeProfile(Request $request) {
        try{
            $id = Auth::user()->id_user;
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

    public function historyTransaction() {
        $user = User::find(Auth::user()->id_user);

        if($user == null) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found.'
            ], 404);
        }
        try {
            $id = Auth::user()->id_user;
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

    public function searchTransaction(Request $request, ) {
        $user = User::find(Auth::user()->id_user);

        if($user == null) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found.'
            ], 404);
        }
        try {
            $id = Auth::user()->id_user;
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


    /*
    ===============================================
    |              Admin Access Only              |
    ===============================================
    */
    public function searchDataCustomer(Request $request){
        try {
            $searchkey = $request->query('query');
            $customer = User::where('nama', 'like', '%'.$searchkey.'%')->get();
            if(!$customer){
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
                'data' => null
            ], 404);
        }
    }

    public function getHistoryPesananCustomer($id){
        try {
            
            $history = Pesanan::with(['detailPesanan' => function ($query) {
                $query->select('id_pesanan','id_produk','id_hampers', 'jumlah','subtotal')
                ->with(['Produk' => function ($query) {
                    $query->select('id_produk', 'nama_produk',  'harga_produk');
                },'Hampers' => function ($query) {
                    $query->select('id_hampers', 'nama_hampers', 'harga_hampers');
                }]);
            }])
            ->where('id_user', $id)
            ->where('status_transaksi', 'Pesanan Sudah Selesai')
            ->get();

            
            if(count($history) == 0){
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
                'data' => null
            ], 404);
        }
    }
}
