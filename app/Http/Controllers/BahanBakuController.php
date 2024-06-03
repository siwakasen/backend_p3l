<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BahanBaku;
use App\Models\Pesanan;
use Illuminate\Support\Facades\Validator;

class BahanBakuController extends Controller
{
    public $validator_exception = [
        'nama_bahan_baku.required' => 'Nama bahan baku harus diisi!',
        'nama_bahan_baku.max' => 'Nama bahan baku maksimal 255 karakter!',
        'stok.required' => 'Stok harus diisi!',
        'stok.numeric' => 'Stok harus berupa angka!',
        'stok.min' => 'Stok minimal 0!',
        'satuan.required' => 'Satuan harus diisi!',
        'satuan.max' => 'Satuan maksimal 255 karakter!'
    ];
    public function getAllBahanBaku()
    {
        try {
            //code...
            $bahan_baku = BahanBaku::all();
            if (!$bahan_baku) {
                throw new \Exception();
            }
            return response()->json([
                'status' => true,
                'message' => 'Berhasil mengambil semua data bahan baku',
                'data' => $bahan_baku
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'status' => false,
                'message' => 'Data bahan baku tidak ditemukan',
                'data' => []
            ], 404);
        }
    }

    public function getBahanBaku($id)
    {
        try {
            //code...
            $bahan_baku = BahanBaku::find($id);
            if (!$bahan_baku) {
                throw new \Exception();
            }
            return response()->json([
                'status' => true,
                'message' => 'Berhasil mengambil data bahan baku',
                'data' => $bahan_baku
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'status' => false,
                'message' => 'Data bahan baku tidak ditemukan',
                'data' => []
            ], 404);
        }
    }

    public function searchBahanBaku(Request $request)
    {
        try {
            //code...
            $searchkey = $request->query('query');
            $data = BahanBaku::where('nama_bahan_baku', 'like', "%$searchkey%")
                ->orWhere('satuan', 'like', "%$searchkey%")
                ->orWhere('stok', 'like', "%$searchkey%")
                ->get();
            if (count($data) == 0) {
                throw new \Exception();
            }
            return response()->json([
                'status' => true,
                'message' => 'Berhasil mencari data bahan baku',
                'data' => $data
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'status' => false,
                'message' => 'Data bahan baku tidak ditemukan',
                'data' => []
            ], 404);
        }
    }

    public function insertBahanBaku(Request $request)
    {
        try {
            //code...
            $data =  $request->all();
            $validate = Validator::make($data, [
                'nama_bahan_baku' => 'required|max:255',
                'stok' => 'required|numeric|min:0',
                'satuan' => 'required|max:255',
            ], $this->validator_exception);

            if ($validate->fails()) {
                throw new \Exception('invalid-input');
            }
            $bahan_baku = BahanBaku::create($data);
            return response()->json([
                'status' => true,
                'message' => 'Berhasil menambah data bahan baku',
                'data' => $bahan_baku
            ], 200);
        } catch (\Throwable $th) {
            //throw $th;
            if ($th->getMessage() == 'invalid-input') {
                return response()->json([
                    'status' => false,
                    'message' => $validate->errors(),
                ], 400);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Gagal menambah data bahan baku',
                    'error' => $th->getMessage()
                ], 400);
            }
        }
    }

    public function updateBahanBaku(Request $request, $id)
    {
        try {
            //code...
            $bahan_baku = BahanBaku::find($id);
            if (!$bahan_baku) {
                throw new \Exception('not-found');
            }
            $data =  $request->all();
            $validate = Validator::make($data, [
                'nama_bahan_baku' => 'required|max:255',
                'stok' => 'required|numeric|min:0',
                'satuan' => 'required|max:255',
            ], $this->validator_exception);
            if ($validate->fails()) {
                throw new \Exception('invalid-input');
            }

            $bahan_baku->update($data);
            return response()->json([
                'status' => true,
                'message' => 'Berhasil mengubah data bahan baku',
                'data' => $bahan_baku,
            ], 200);
        } catch (\Throwable $th) {
            //throw $th;
            if ($th->getMessage() == 'not-found') {
                return response()->json([
                    'status' => false,
                    'message' => 'Data bahan baku tidak ditemukan',
                ], 404);
            } else if ($th->getMessage() == 'invalid-input') {
                return response()->json([
                    'status' => false,
                    'message' => $validate->errors(),
                ], 400);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Gagal mengubah data bahan baku',
                    'error' => $th->getMessage()
                ], 400);
            }
        }
    }

    public function deleteBahanBaku($id)
    {
        try {

            $bahan_baku = BahanBaku::find($id);
            if (!$bahan_baku) {
                throw new \Exception('not-found');
            }
            $bahan_baku->delete();
            return response()->json([
                'status' => true,
                'message' => 'Berhasil menghapus data bahan baku',
                'data' => $bahan_baku
            ], 200);
        } catch (\Throwable $th) {
            //throw $th;
            if ($th->getMessage() == 'not-found') {
                return response()->json([
                    'status' => false,
                    'message' => 'Data bahan baku tidak ditemukan',
                ], 404);
            } else {
                if (str_contains($th->getMessage(), 'foreign key constraint fails')) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Bahan baku tidak dapat dihapus karena digunakan pada hampers/produk',
                    ], 400);
                }
                return response()->json([
                    'status' => false,
                    'message' => 'Gagal menghapus data bahan baku',
                    'error' => $th->getMessage()
                ], 400);
            }
        }
    }

    public function laporanStokBahanBaku()
    {
        try {

            $bahan_baku = BahanBaku::all();
            if (!$bahan_baku) {
                throw new \Exception();
            }
            $data = [];

            foreach ($bahan_baku as $key => $value) {
                $data[$key]['id_bahan_baku'] = $value->id_bahan_baku;
                $data[$key]['nama_bahan_baku'] = $value->nama_bahan_baku;
                $data[$key]['stok'] = $value->stok;
                $data[$key]['satuan'] = $value->satuan;
            }

            return response()->json([
                'status' => true,
                'message' => 'Berhasil mengambil laporan stok bahan baku',
                'data' => $data
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Laporan stok bahan baku tidak ditemukan',
                'data' => []
            ], 404);
        }
    }

    public function pemakaianBahanBakuPesananDiterima(Request $request)
    {
        try {
            $input = $request->input('data');
            $pesanan = [];

            foreach ($input as $item) {
                $pesanan[] = Pesanan::where('id_pesanan', $item)->with([
                    'detailPesanan.produk.resep.detailResep',
                    'detailPesanan.hampers.detailHampers.produk.resep.detailResep'
                ])->first();
            }

            $bahanBakuUsage = [];

            foreach ($pesanan as $order) {
                foreach ($order->detailPesanan as $detail) {
                    if ($detail->produk && $detail->produk->resep) {
                        foreach ($detail->produk->resep->detailResep as $detailResep) {
                            if (isset($bahanBakuUsage[$detailResep->id_bahan_baku])) {
                                $bahanBakuUsage[$detailResep->id_bahan_baku] += $detailResep->jumlah * $detail->jumlah;
                            } else {
                                $bahanBakuUsage[$detailResep->id_bahan_baku] = $detailResep->jumlah * $detail->jumlah;
                            }
                        }
                    }

                    if ($detail->hampers != null && $detail->hampers->detailHampers != null) {
                        foreach ($detail->hampers->detailHampers as $hampersDetail) {
                            if ($hampersDetail->produk && $hampersDetail->produk->resep) {
                                foreach ($hampersDetail->produk->resep->detailResep as $detailResep) {
                                    if (isset($bahanBakuUsage[$detailResep->id_bahan_baku])) {
                                        $bahanBakuUsage[$detailResep->id_bahan_baku] += $detailResep->jumlah * $detail->jumlah;
                                    } else {
                                        $bahanBakuUsage[$detailResep->id_bahan_baku] = $detailResep->jumlah * $detail->jumlah;
                                    }
                                }
                            }
                        }
                    }
                }
            }

            $result = [];
            foreach ($bahanBakuUsage as $idBahanBaku => $jumlah) {
                $bahanBaku = BahanBaku::find($idBahanBaku);

                $result[] = [
                    'id_bahan_baku' => $idBahanBaku,
                    'nama_bahan_baku' => $bahanBaku->nama_bahan_baku,
                    'satuan' => $bahanBaku->satuan,
                    'jumlah' => $jumlah,
                    'stok' => $bahanBaku->stok,
                    'status' => $bahanBaku->stok >= $jumlah ? 'Tersedia' : 'Kurang'
                ];
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Successfully fetch pemakaian bahan baku pesanan diterima data.',
                'data' => $result
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch pemakaian bahan baku pesanan diterima data.',
                'error' => $th->getMessage()
            ], 500);
        }
    }
}
