<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use App\Models\Presensi;
use App\Models\Karyawan;
use Illuminate\Support\Facades\Validator;

class PresensiController extends Controller
{
    public $validator_exception = [
        'tanggal.required' => 'Tanggal harus diisi!',
        'tanggal.date' => 'Tanggal tidak valid!'
    ];

    public function getAllPresensi()
    {
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully fetch presensi data.',
            'data' => Presensi::all()->load('Karyawan')
        ], 200);
    }

    public function getPresensi(Date $tanggal)
    {
        if (Presensi::where('tanggal', $tanggal)->first() == null) {
            return response()->json([
                'status' => 'error',
                'message' => 'Presensi not found.'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Successfully fetch presensi data.',
            'data' => Presensi::where('tanggal', $tanggal)->get()
        ], 200);
    }

    public function createPresensi(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'tanggal' => 'required|date'
            ], $this->validator_exception);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => $validator->errors()
                ], 400);
            }

            $karyawan = Karyawan::all();
            foreach ($karyawan as $k) {
                Presensi::create([
                    'id_karyawan' => $k->id_karyawan,
                    'tanggal' => $request->tanggal,
                    'status' => 'Masuk'
                ]);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Presensi created successfully.'
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error: ' . $e->getMessage()
            ], 400);
        }
    }

    public function updatePresensi(Request $request, string $id_presensi)
    {
        if (Presensi::find($id_presensi) == null) {
            return response()->json([
                'status' => 'error',
                'message' => 'Presensi not found.'
            ], 404);
        }
        
        try {
            $validator = Validator::make($request->all(), [
                'status' => 'required'
            ],
            [
                'status.required' => 'Status harus diisi!'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => $validator->errors()
                ], 400);
            }

            Presensi::find($id_presensi)->update($request->only('status'));

            return response()->json([
                'status' => 'success',
                'message' => 'Presensi updated successfully.'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error: ' . $e->getMessage()
            ], 400);
        }
    }

    public function deletePresensi(string $id_presensi)
    {
        if (Presensi::find($id_presensi) == null) {
            return response()->json([
                'status' => 'error',
                'message' => 'Presensi not found.'
            ], 404);
        }

        try{
            Presensi::find($id_presensi)->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Presensi deleted successfully.'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error: ' . $e->getMessage()
            ], 400);
        }
    }
}
