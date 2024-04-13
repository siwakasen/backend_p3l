<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\ResepController;
use App\Http\Controllers\PresensiController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\HampersController;
use App\Http\Controllers\LimitProdukController;
use App\Http\Controllers\PembelianBahanBakuController;
use App\Http\Controllers\BahanBakuController;
use App\Http\Controllers\PenitipController;
use App\Http\Controllers\PengeluaranLainController;

/*
=======================================================
|                   Public View                       |
=======================================================
*/

Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
});

/*
=======================================================
|                   Administrator                     |
=======================================================
*/
Route::prefix('administrator')->group(function () {
    /*
    =======================================================
    |                   Roles Management                  |
    =======================================================
    */
    Route::prefix('roles')->group(function () {
        Route::get('/', [RolesController::class, 'getAllRole']);
        Route::get('/{id}', [RolesController::class, 'getRole']);
        Route::post('/', [RolesController::class, 'insertRole'])->middleware('auth:sanctum', 'ability:owner');
        Route::put('/{id}', [RolesController::class, 'updateRole'])->middleware('auth:sanctum', 'ability:owner');
        Route::delete('/{id}', [RolesController::class, 'deleteRole'])->middleware('auth:sanctum', 'ability:owner');
    });

    /*
    =======================================================
    |                   Karyawan Management               |
    =======================================================
    */
    Route::prefix('karyawan')->group(function () {
        Route::get('/', [KaryawanController::class, 'getAllKaryawan']);
        Route::get('/{id}', [KaryawanController::class, 'getKaryawan']);
        Route::post('/', [KaryawanController::class, 'insertKaryawan'])->middleware('auth:sanctum', 'ability:manajer-operasional', 'ability:owner');
        Route::put('/{id}', [KaryawanController::class, 'updateKaryawan'])->middleware('auth:sanctum', 'ability:manajer-operasional', 'ability:owner');
        Route::delete('/{id}', [KaryawanController::class, 'deleteKaryawan'])->middleware('auth:sanctum', 'ability:manajer-operasional', 'ability:owner');
    });

    /*
    =======================================================
    |                   Resep Management                  |
    =======================================================
    */
    Route::prefix('resep')->group(function () {
        Route::get('/', [ResepController::class, 'getAllResep']);
        Route::get('/{id}', [ResepController::class, 'getResep']);
        Route::post('/', [ResepController::class, 'insertResep'])->middleware('auth:sanctum', 'ability:admin');
        Route::put('/{id}', [ResepController::class, 'updateResep']);
        Route::delete('/{id}', [ResepController::class, 'deleteResep'])->middleware('auth:sanctum', 'ability:admin');
    });

    /*
    =======================================================
    |                   Presensi Management               |
    =======================================================
    */
    Route::prefix('presensi')->group(function () {
        Route::get('/', [PresensiController::class, 'getAllPresensi']);
        Route::get('/{tanggal}', [PresensiController::class, 'getPresensi']);
        Route::post('/', [PresensiController::class, 'createPresensi'])->middleware('auth:sanctum', 'ability:manajer-operasional');
        Route::put('/{id}', [PresensiController::class, 'updatePresensi'])->middleware('auth:sanctum', 'ability:manajer-operasional');
        Route::delete('/{id}', [PresensiController::class, 'deletePresensi'])->middleware('auth:sanctum', 'ability:manajer-operasional');
    });

    /*
    =======================================================
    |                   Produk Management                 |
    =======================================================
    */
    Route::prefix('produk')->group(function () {
        Route::put('/{id}', [ProdukController::class, 'updateProduk'])->middleware('auth:sanctum', 'ability:admin');
        Route::post('/', [ProdukController::class, 'insertProduk'])->middleware('auth:sanctum', 'ability:admin');
        Route::delete('/{id}', [ProdukController::class, 'deleteProduk'])->middleware('auth:sanctum', 'ability:admin');
        Route::get('/search', [ProdukController::class, 'searchProduk']);
        Route::get('/{id}', [ProdukController::class, 'getProduk']);
        Route::get('/', [ProdukController::class, 'getAllProduk']);
    });


    /*
    =======================================================
    |                   Hampers Management                |
    =======================================================
    */
    Route::prefix('hampers')->group(function () {
        Route::get('/search', [HampersController::class, 'searchHampers']);
        Route::get('/', [HampersController::class, 'getAllHampers']);
        Route::get('/{id}', [HampersController::class, 'getHampers']);
        Route::put('/{id}', [HampersController::class, 'updateHampers'])->middleware('auth:sanctum', 'ability:admin');
        Route::post('/', [HampersController::class, 'insertHampers'])->middleware('auth:sanctum', 'ability:admin');
        Route::delete('/{id}', [HampersController::class, 'deleteHampers'])->middleware('auth:sanctum', 'ability:admin');
    });

    /*
    =======================================================
    |                   Limit-Product Management          |
    =======================================================
    */
    Route::prefix('limit-produk')->group(function () {
        Route::get('/{id}', [LimitProdukController::class, 'getLimitProduk']);
        Route::get('/', [LimitProdukController::class, 'getAllLimitProduct']);
        Route::put('/{id}', [LimitProdukController::class, 'udpateLimitProduk'])->middleware('auth:sanctum', 'ability:admin');
        Route::post('/', [LimitProdukController::class, 'insertLimitProduk'])->middleware('auth:sanctum', 'ability:admin');
        Route::delete('/{id}', [LimitProdukController::class, 'deleteLimitProduk'])->middleware('auth:sanctum', 'ability:admin');
    });
});

/*
=======================================================
|                   Manajer Operasional                |
=======================================================
*/
Route::prefix('manajer-operasional')->group(function () {
    /*
    =======================================================
    |           Management Pembelian Bahan Baku           |
    =======================================================
    */
    Route::prefix('pembelian-bahan-baku')->group(function () {
        Route::get('/search', [PembelianBahanBakuController::class, 'searchPembelianBahanBaku']);
        Route::get('/', [PembelianBahanBakuController::class, 'getAllPembelianBahanBaku']);
        Route::get('/{id}', [PembelianBahanBakuController::class, 'getPembelianBahanBaku']);
        Route::post('/', [PembelianBahanBakuController::class, 'insertPembelianBahanBaku'])->middleware('auth:sanctum', 'ability:manajer-operasional');
        Route::delete('/{id}', [PembelianBahanBakuController::class, 'deletePembelianBahanBaku'])->middleware('auth:sanctum', 'ability:manajer-operasional');
        Route::put('/{id}', [PembelianBahanBakuController::class, 'updatePembelianBahanBaku'])->middleware('auth:sanctum', 'ability:manajer-operasional');
    });
});
