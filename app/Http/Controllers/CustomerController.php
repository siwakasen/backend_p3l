<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Pesanan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\MailSend;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

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
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error: ' . $e->getMessage()
            ], 400);
        }
    }

    public function showData()
    {
        $id = Auth::user()->id_user;
        if ($id == null) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized'
            ], 401);
        }
        $user = User::find($id);

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
                    'nama' => 'required|max:255',
                    'email' => 'required|email|unique:users,email,' . $id . ',id_user',
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
                }
            } else {
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
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error: ' . $e->getMessage()
            ], 400);
        }
    }
  
    public function createToken(string $id){
        $user = User::find($id);
        if($user == null) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found.'
            ], 404);
        }
        try{
            $newToken=Str::random(100);
            $exist=DB::table('password_reset_tokens')->where('email',$user->email)->first();
            if($exist){
                DB::table('password_reset_tokens')->where('email',$user->email)->Update([
                    'token'=>$newToken,
                    'created_at'=>now()
                ]);
            }else{
                DB::table('password_reset_tokens')->Insert([
                    'email'=>$user->email,
                    'token'=>$newToken,
                    'created_at'=>now()
                ]);
            }
            $details=[
                'name'=>$user->nama,
                'url'=>request()->getHttpHost().'/customer/front-end-next/'.$newToken,
                'token'=>$newToken
            ];

            Mail::to($user->email)->send(new MailSend($details));

            return response()->json([
                'status' => 'success',
                'message' => 'Reset password link has been sent to your email.'
            ], 200);

        }catch(\Exception $e){
            return response()->json([
                'status' => 'error',
                'message' => 'Error: ' . $e->getMessage()
            ], 400);
        }
    }

    public function resetPassword(Request $request, string $id){ 
        $user=User::find($id);
        try {
            $validator = Validator::make($request->all(), [
                'password' => 'required|min:8',
                'confirm_password' => 'required|same:password',
            ]);
            
            if($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => $validator->errors()
                ], 400);
            }
            $email = $user->email;
            $token = $request->token;
            $password = $request->password;

            $resetToken = DB::table('password_reset_tokens')->where('email',$email)->first();
            if(!$resetToken || $resetToken->token != $token ){
                return response()->json([
                    'status' => 'error',
                    'message' => 'Invalid or expired token'
                ], 400);
            }
            DB::table('users')->where('email', $email)->update([
                'password' => Hash::make($request->password),
            ]);
            DB::table('password_reset_tokens')->where('email', $email)->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Password updated successfully.'
            ], 200);

        } catch(\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error: ' . $e->getMessage()
            ], 400);
        }
    }

    public function historyTransaction()
    {
        $id = Auth::user()->id_user;
        if ($id == null) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized'
            ], 401);
        }
        try {
            $data = Pesanan::where('id_user', $id)->get();

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

    public function searchTransaction(Request $request)
    {
        $id = Auth::user()->id_user;
        if ($id == null) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized'
            ], 401);
        }
        $user = User::find($id);

        if ($user == null) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found.'
            ], 404);
        }
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    'nama_produk' => 'required'
                ],
                [
                    'nama_produk.required' => 'Nama produk harus diisi!'
                ]
            );

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => $validator->errors()
                ], 400);
            }

            $data = Pesanan::where('id_user', $id)->where('nama_produk', 'like', '%' . $request->nama_produk . '%')->get();

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
            $customer = User::where('nama', 'like', '%' . $searchkey . '%')->get();
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
                'error' => $th->getMessage()
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
                ->where('status_transaksi', 'Pesanan Sudah Selesai')
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
                'error' => $th->getMessage()
            ], 404);
        }
    }
}
