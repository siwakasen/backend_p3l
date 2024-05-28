<?php

namespace App\Http\Controllers;

use App\Models\DetailHampers;
use App\Models\Hampers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class HampersController extends Controller
{
    public $validator_exception = [
        'nama_hampers.required' => 'Nama hampers harus diisi!',
        'nama_hampers.unique' => 'Nama hampers sudah terdaftar!',
        'nama_hampers.string' => 'Nama hampers harus berupa huruf!',
        'harga_hampers.required' => 'Harga hampers harus diisi!',
        'harga_hampers.numeric' => 'Harga hampers harus berupa angka!',
        'harga_hampers.gt' => 'Harga hampers harus lebih besar dari 0!',
        'deskripsi_hampers.required' => 'Deskripsi hampers harus diisi!',
        'deskripsi_hampers.string' => 'Deskripsi hampers harus berupa huruf!',
        'foto_hampers.required' => 'Foto hampers harus diisi!',
        'foto_hampers.mimes' => 'Foto hampers harus berupa file jpg, png, jpeg!',
        'foto_hampers.max' => 'Foto hampers maksimal 2MB!',
        'detail_hampers.required' => 'Detail hampers harus diisi!',
        'detail_hampers.array' => 'Detail hampers harus berupa array!',
        'status_hampers.boolean' => 'Status hampers harus berupa boolean'
    ];

    public function getAllHampers()
    {
        $hampers = Hampers::all();

        if (!$hampers) {
            return response()->json([
                'status' => false,
                'message' => 'Hampers not found',
                'data' => null
            ], 404);
        }

        $newHampers = [];
        foreach ($hampers as $hamper) {
            $bahan_baku = [];
            $produk = [];
            $detail_hampers = DetailHampers::where('id_hampers', $hamper->id_hampers)->get();
            foreach ($detail_hampers as $detail) {
                if (!$detail->BahanBaku) {
                    $produk[] = $detail->Produk;
                }
                if (!$detail->Produk) {
                    $bahan_baku[] = $detail->BahanBaku;
                }
            }
            $hamper['detail'] = [
                'produk' => $produk,
                'bahan_baku' => $bahan_baku,
            ];
            array_push($newHampers, $hamper);
        }

        return response()->json([
            'status' => true,
            'message' => 'Success retrive all hampers',
            'data' => $newHampers
        ]);
    }

    public function getHampers(String $id)
    {
        $hampers = Hampers::with('DetailHampers.Produk.limitProduk')->find($id);

        if (!$hampers) {
            return response()->json([
                'status' => false,
                'message' => 'Hampers not found',
                'data' => null
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Success retrive a hampers',
            'data' => $hampers
        ]);
    }

    public function updateHampers(Request $request, String $id)
    {
        $data = $request->all();
        $hampers = Hampers::find($id);
        if (!$hampers) {
            return response()->json([
                'status' => false,
                'message' => 'Hampers not found',
                'data' => null
            ], 404);
        }

        $validate = Validator::make($data, [
            'nama_hampers' => 'string|unique:hampers,nama_hampers,' . $id . ',id_hampers',
            'harga_hampers' => 'numeric|gt:0',
            'deskripsi_hampers' => 'string',
            'foto_hampers' => 'mimes:jpg,png,jpeg|max:2048',
            'detail_hampers' => 'array',
            'status_hampers' => 'boolean'
        ], $this->validator_exception);

        if ($validate->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid request',
                'errors' => $validate->errors()
            ], 400);
        }

        if (!is_null($request->file('foto_hampers'))) {
            Storage::disk('public')->delete($hampers->foto_hampers);
            $guessExtension = $request->file('foto_hampers')->guessExtension();
            if (!is_null($request->input('nama_hampers'))) {
                $path = $request->file('foto_hampers')->storeAs('hampers', Str::slug($data['nama_hampers']) . '.' . $guessExtension, 'public');
            } else {
                $path = $request->file('foto_hampers')->storeAs('hampers', Str::slug($hampers['nama_hampers']) . '.' . $guessExtension, 'public');
            }
            $data['foto_hampers'] = $path;
        }

        if (!is_null($request->input('nama_hampers')) && is_null($request->file('foto_hampers'))) {
            $filename = explode('/', $hampers->foto_hampers);
            $extension = explode('.', $filename[1]);
            $path = $filename[0] . '/' . Str::slug($data['nama_hampers']) . '.' . $extension[1];
            Storage::disk('public')->move($hampers->foto_hampers, $path);
            $data['foto_hampers'] = $path;
        }

        $hampers->update($data);

        if (isset($data['detail_hampers'])) {
            DetailHampers::where('id_hampers', $id)->delete();

            foreach ($data['detail_hampers'] as $detail) {
                DetailHampers::create([
                    'id_hampers' => $hampers->id_hampers,
                    'id_produk' => $detail['id_produk'] ?? null,
                    'id_bahan_baku' => $detail['id_bahan_baku'] ?? null,
                ]);
            }
        }

        $hampers = Hampers::find($hampers->id_hampers);
        $detail_hampers = DetailHampers::where('id_hampers', $hampers->id_hampers)->get();
        $payload = [
            'id_hampers' => $hampers->id_hampers,
            'nama_hampers' => $hampers->nama_hampers,
            'harga_hampers' => $hampers->harga_hampers,
            'deskripsi_hampers' => $hampers->deskripsi_hampers,
            'foto_hampers' => $hampers->foto_hampers,
            'status_hampers' => $hampers->status_hampers,
            'created_at' => $hampers->created_at,
            'updated_at' => $hampers->updated_at,
            'detail_hampers' => $detail_hampers,
        ];
        return response()->json([
            'status' => true,
            'message' => 'Success update hampers',
            'data' => $payload,
        ]);
    }

    public function insertHampers(Request $request)
    {
        $data = $request->all();
        $validate = Validator::make($data, [
            'nama_hampers' => 'required|string|unique:hampers',
            'harga_hampers' => 'required|numeric|gt:0',
            'deskripsi_hampers' => 'required|string',
            'foto_hampers' => 'required|mimes:jpg,png,jpeg|max:2048',
            'detail_hampers' => 'required|array',
        ], $this->validator_exception);

        if ($validate->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid request',
                'errors' => $validate->errors()
            ], 400);
        }

        $guessExtension = $request->file('foto_hampers')->guessExtension();
        $path = $request->file('foto_hampers')->storeAs('hampers', Str::slug($data['nama_hampers']) . '.' . $guessExtension, 'public');
        $data['foto_hampers'] = $path;

        $hampers = Hampers::create($data);

        foreach ($data['detail_hampers'] as $detail) {
            DetailHampers::create([
                'id_hampers' => $hampers->id_hampers,
                'id_produk' => $detail['id_produk'] ?? null,
                'id_bahan_baku' => $detail['id_bahan_baku'] ?? null,
            ]);
        }

        $hampers = Hampers::find($hampers->id_hampers);
        $detail_hampers = DetailHampers::where('id_hampers', $hampers->id_hampers)->get();
        $payload = [
            'id_hampers' => $hampers->id_hampers,
            'nama_hampers' => $hampers->nama_hampers,
            'harga_hampers' => $hampers->harga_hampers,
            'deskripsi_hampers' => $hampers->deskripsi_hampers,
            'foto_hampers' => $hampers->foto_hampers,
            'created_at' => $hampers->created_at,
            'updated_at' => $hampers->updated_at,
            'detail_hampers' => $detail_hampers,
        ];
        return response()->json([
            'status' => true,
            'message' => 'Success insert a hampers',
            'data' => $payload
        ], 201);
    }

    public function deleteHampers(Request $request, String $id)
    {
        $hampers = Hampers::find($id);
        if (!$hampers) {
            return response()->json([
                'status' => false,
                'message' => 'Hampers not found',
                'data' => null
            ], 404);
        }

        Storage::disk('public')->delete($hampers->foto_hampers);
        DetailHampers::where('id_hampers', $id)->delete();
        $hampers->delete();
        return response()->json([
            'status' => true,
            'message' => 'Success delete hampers',
            'data' => $hampers
        ]);
    }

    public function searchHampers(Request $request)
    {
        $keyword = $request->query('query');
        $date = $request->query('date');

        if (is_null($date)) {
            $hampers = Hampers::with('DetailHampers.Produk')->where('nama_hampers', 'like', "%$keyword%")->get();
        } else {
            $hampers = Hampers::with(['detailHampers.produk' => function ($query) use ($date) {
                $query->with(['limitProduk' => function ($query) use ($date) {
                    $query->whereDate('tanggal', $date);
                }]);
            }])->where('nama_hampers', 'like', "%$keyword%")->get();
        }

        if (count($hampers) == 0) {
            return response()->json([
                'status' => false,
                'message' => 'Hampers not found',
                'data' => $hampers
            ], 404);
        }

        $detailHampers = $hampers->first();
        $detailHampers = $detailHampers['detailHampers'];
        $produkHampers = $detailHampers->filter(function ($detail) {
            return $detail->produk;
        });

        $isNotProdukTititpan = $produkHampers->every(function ($item) {
            return $item->produk->kategori->id_kategori != 4;
        });

        if (!$isNotProdukTititpan) {
            $id_produk = $detailHampers->filter(function ($detail) {
                return $detail->produk && $detail->produk->id_kategori != 4;
            });
            $hampers->first()->id_produk = $id_produk->first()->produk->id_produk;
        } else {
            $lowestLimit = PHP_INT_MAX;
            $productIdWithLowestLimit = null;

            foreach ($produkHampers as $detail) {
                $produk = $detail['produk'];
                $limitProduk = $produk['limitProduk'];
                $currentLimit = 0;

                if (count($limitProduk) > 0) {
                    $currentLimit = $limitProduk[0]['limit'];
                }

                if ($currentLimit < $lowestLimit) {

                    $lowestLimit = $currentLimit;
                    $productIdWithLowestLimit = $produk['id_produk'];
                }
            }
            $hampers->first()->id_produk =  $productIdWithLowestLimit;
        }

        return response()->json([
            'status' => true,
            'message' => 'Success search hampers',
            'data' => $hampers,
        ]);
    }
}
