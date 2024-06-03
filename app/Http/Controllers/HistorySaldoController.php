<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\HistoriSaldo;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;


class HistorySaldoController extends Controller
{
    public function getHistorySaldo(Request $request)
    {
        $id_user = Auth::user()->id_user;
        $history_saldo = HistoriSaldo::where('id_user', $id_user)->get();
        if(count($history_saldo) == 0)
        {
            return response()->json([
                'status' => false,
                'message' => 'Belum ada riwayat penarikan saldo',
                'data' => [],
            ],400);
        }
        return response()->json([
            'status' => true,
            'message' => 'Riwayat penarikan saldo berhasil diambil',
            'data' => $history_saldo
        ],200);
    }

    public function getSaldo(){
        $user = Auth::user();
        if(!$user){
            return response()->json([
                'status' => false,
                'message' => 'User tidak ditemukan',
                'data' => 0,
            ],400);
        }
        return response()->json([
            'status' => true,
            'message' => 'Saldo berhasil diambil',
            'data' => $user->saldo
        ],200);
    }

    public function pengajuanTarikSaldo(Request $request){
        $user = Auth::user();
        $id_user = $user->id_user;
        
        $validator = Validator::make($request->all(), [
            'nominal_saldo' => 'required|numeric|min:10000',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => false,
                'message' => 'Gagal mengajukan penarikan saldo',
                'errors' => $validator->errors()
            ], 400);
        }
        if($user->saldo < $request->nominal_saldo){
            return response()->json([
                'status' => false,
                'message' => 'Saldo tidak mencukupi',
                'data' => [],
            ],400);
        }

        try {
            $newHistorySaldo = new HistoriSaldo();
            $newHistorySaldo->id_user = $id_user;
            $newHistorySaldo->nominal_saldo = $request->nominal_saldo;
            $newHistorySaldo->keterangan_transaksi = 'Mengajukan Penarikan Saldo';
            $newHistorySaldo->tanggal_pengajuan = Carbon::now()->toDateTimeString();
            $newHistorySaldo->save();
            
            return response()->json([
                'status' => true,
                'message' => 'Pengajuan penarikan saldo berhasil',
                'data' => $newHistorySaldo
            ],200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal mengajukan penarikan saldo',
                'errors' => $th->getMessage()
            ], 500);
        }
    }

    public function getPengajuanTarikSaldo(){
        $history_saldo = HistoriSaldo::with('user')->where('keterangan_transaksi', 'Mengajukan Penarikan Saldo')->get();
        if(count($history_saldo) == 0){
            return response()->json([
                'status' => false,
                'message' => 'Belum ada pengajuan penarikan saldo',
                'data' => [],
            ],400);
        }

        return response()->json([
            'status' => true,
            'message' => 'Pengajuan penarikan saldo berhasil diambil',
            'data' => $history_saldo
        ],200);
    }

    public function konfirmasiTransferSaldo($id){
        $history_saldo = HistoriSaldo::find($id);
        $user = User::find($history_saldo->id_user);
        if(!$history_saldo){
            return response()->json([
                'status' => false,
                'message' => 'Pengajuan penarikan saldo tidak ditemukan',
                'data' => [],
            ],400);
        }   
        if(!$user){
            return response()->json([
                'status' => false,
                'message' => 'User tidak ditemukan',
                'data' => [],
            ],400);
        }
        if($history_saldo->keterangan_transaksi != 'Mengajukan Penarikan Saldo'){
            return response()->json([
                'status' => false,
                'message' => 'Pengajuan penarikan saldo sudah dikonfirmasi',
                'data' => [],
            ],400);
        }
        try {
            $history_saldo->keterangan_transaksi = 'Saldo Sudah Ditransfer';
            $history_saldo->tanggal_konfirmasi = Carbon::now()->toDateTimeString();
            $history_saldo->save();

            $user->saldo -= $history_saldo->nominal_saldo;
            $user->save();
    
            return response()->json([
                'status' => true,
                'message' => 'Pengajuan penarikan saldo berhasil dikonfirmasi',
                'data' => $history_saldo
            ],200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal mengkonfirmasi pengajuan penarikan saldo',
                'data'=> [],
                'errors' => $th->getMessage()
            ], 500);
        }
    }
}

