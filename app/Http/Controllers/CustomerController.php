<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
Use App\Models\Pesanan;
use App\Models\DetailPesanan;
use App\Models\Produk;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    //ability: admin
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

    public function getHistoryPesananCustomer(Request $request){
        try {
            $searchkey = $request->query('query');
            $history = Pesanan::with(['detailPesanan' => function ($query) {
                $query->select('id_pesanan','id_produk','id_hampers', 'jumlah','subtotal')
                ->with(['Produk' => function ($query) {
                    $query->select('id_produk', 'nama_produk',  'harga_produk');
                },'Hampers' => function ($query) {
                    $query->select('id_hampers', 'nama_hampers', 'harga_hampers');
                }])
                ->without('id_pesanan');
            },'user'=> function ($query) {
                $query->select('id_user', 'nama','email','no_hp');
            }])
            ->whereHas('user', function ($query) use ($searchkey) {
                $query->where('nama', 'like', '%'.$searchkey.'%');
            })
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
