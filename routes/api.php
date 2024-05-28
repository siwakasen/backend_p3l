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
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PenitipController;
use App\Http\Controllers\PengeluaranLainController;
use App\Http\Controllers\PesananController;
use App\Http\Middleware\TokenValidation;

/*
=======================================================
|                   Public View                       |
=======================================================
*/

Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [CustomerController::class, 'register']);
    Route::post('/email-check', [CustomerController::class, 'emailCheck']);
    Route::get('/validate-token/{token}', [CustomerController::class, 'checkTokenValidity']);
    Route::post('/verify/{token}', [CustomerController::class, 'verify']);
    Route::post('/kirim-ulang-email', [CustomerController::class, 'resendEmail']);
    Route::get('/token', [AuthController::class, 'checkToken'])->middleware('auth:sanctum');
});

/*
=======================================================
|                   Administrator                     |
=======================================================
*/
Route::prefix('administrator')->group(function () {
    /*
    =======================================================
    |                    Dashboard Data                   |
    =======================================================
    */
    Route::get('/', [DashboardController::class, 'index'])->middleware('auth:sanctum', 'ability:admin,manajer-operasional,owner');
    /*
    =======================================================
    |                   Roles Management                  |
    =======================================================
    */
    Route::prefix('roles')->group(function () {
        Route::get('/', [RolesController::class, 'getAllRole'])->middleware('auth:sanctum', 'ability:manajer-operasional,owner');
        Route::get('/{id}', [RolesController::class, 'getRole'])->middleware('auth:sanctum', 'ability:manajer-operasional,owner');
        Route::post('/', [RolesController::class, 'insertRole'])->middleware('auth:sanctum', 'ability:manajer-operasional,owner');
        Route::put('/{id}', [RolesController::class, 'updateRole'])->middleware('auth:sanctum', 'ability:manajer-operasional,owner');
        Route::delete('/{id}', [RolesController::class, 'deleteRole'])->middleware('auth:sanctum', 'ability:manajer-operasional,owner');
    });

    /*
    =======================================================
    |                   Karyawan Management               |
    =======================================================
    */
    Route::prefix('karyawan')->group(function () {
        Route::get('/', [KaryawanController::class, 'getAllKaryawan'])->middleware('auth:sanctum', 'ability:manajer-operasional,owner');
        Route::get('/{id}', [KaryawanController::class, 'getKaryawan'])->middleware('auth:sanctum', 'ability:manajer-operasional,owner');
        Route::post('/', [KaryawanController::class, 'insertKaryawan'])->middleware('auth:sanctum', 'ability:manajer-operasional,owner');
        Route::put('/{id}', [KaryawanController::class, 'updateKaryawan'])->middleware('auth:sanctum', 'ability:manajer-operasional,owner');
        Route::delete('/{id}', [KaryawanController::class, 'deleteKaryawan'])->middleware('auth:sanctum', 'ability:manajer-operasional,owner');
    });

    /*
    =======================================================
    |                   Resep Management                  |
    =======================================================
    */
    Route::prefix('resep')->group(function () {
        Route::get('/', [ResepController::class, 'getAllResep'])->middleware('auth:sanctum', 'ability:admin');
        Route::get('/{id}', [ResepController::class, 'getResep'])->middleware('auth:sanctum', 'ability:admin');
        Route::post('/', [ResepController::class, 'insertResep'])->middleware('auth:sanctum', 'ability:admin');
        Route::put('/{id}', [ResepController::class, 'updateResep'])->middleware('auth:sanctum', 'ability:admin');
        Route::delete('/{id}', [ResepController::class, 'deleteResep'])->middleware('auth:sanctum', 'ability:admin');
    });

    /*
    =======================================================
    |                   Presensi Management               |
    =======================================================
    */
    Route::prefix('presensi')->group(function () {
        Route::get('/', [PresensiController::class, 'getAllPresensi'])->middleware('auth:sanctum', 'ability:manajer-operasional');
        Route::get('/{tanggal}', [PresensiController::class, 'getPresensi'])->middleware('auth:sanctum', 'ability:manajer-operasional');
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
        Route::get('/search', [ProdukController::class, 'searchProduk'])->middleware('auth:sanctum', 'ability:admin');
        Route::get('/{id}', [ProdukController::class, 'getProduk'])->middleware('auth:sanctum', 'ability:admin');
        Route::get('/', [ProdukController::class, 'getAllProduk'])->middleware('auth:sanctum', 'ability:admin');
    });


    /*
    =======================================================
    |                   Hampers Management                |
    =======================================================
    */
    Route::prefix('hampers')->group(function () {
        Route::get('/search', [HampersController::class, 'searchHampers'])->middleware('auth:sanctum', 'ability:admin');
        Route::get('/', [HampersController::class, 'getAllHampers'])->middleware('auth:sanctum', 'ability:admin');
        Route::get('/{id}', [HampersController::class, 'getHampers'])->middleware('auth:sanctum', 'ability:admin');
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
        Route::get('/{id}', [LimitProdukController::class, 'getLimitProduk'])->middleware('auth:sanctum', 'ability:admin');
        Route::get('/', [LimitProdukController::class, 'getAllLimitProduct'])->middleware('auth:sanctum', 'ability:admin');
        Route::put('/{id}', [LimitProdukController::class, 'updateLimitProduk'])->middleware('auth:sanctum', 'ability:admin');
        Route::post('/', [LimitProdukController::class, 'insertLimitProduk'])->middleware('auth:sanctum', 'ability:admin');
        Route::delete('/{id}', [LimitProdukController::class, 'deleteLimitProduk'])->middleware('auth:sanctum', 'ability:admin');
    });

    /*
    =======================================================
    |           Management Pembelian Bahan Baku           |
    =======================================================
    */
    Route::prefix('pembelian-bahan-baku')->group(function () {
        Route::get('/search', [PembelianBahanBakuController::class, 'searchPembelianBahanBaku'])->middleware('auth:sanctum', 'ability:manajer-operasional');
        Route::get('/', [PembelianBahanBakuController::class, 'getAllPembelianBahanBaku'])->middleware('auth:sanctum', 'ability:manajer-operasional');
        Route::get('/{id}', [PembelianBahanBakuController::class, 'getPembelianBahanBaku'])->middleware('auth:sanctum', 'ability:manajer-operasional');
        Route::post('/', [PembelianBahanBakuController::class, 'insertPembelianBahanBaku'])->middleware('auth:sanctum', 'ability:manajer-operasional');
        Route::delete('/{id}', [PembelianBahanBakuController::class, 'deletePembelianBahanBaku'])->middleware('auth:sanctum', 'ability:manajer-operasional');
        Route::put('/{id}', [PembelianBahanBakuController::class, 'updatePembelianBahanBaku'])->middleware('auth:sanctum', 'ability:manajer-operasional');
    });

    /*
    =======================================================
    |                   Bahan Baku Management             |
    =======================================================
    */
    Route::prefix('bahan-baku')->group(function () {
        Route::get('/', [BahanBakuController::class, 'getAllBahanBaku'])->middleware('auth:sanctum', 'ability:admin,manajer-operasional');
        Route::get('/search', [BahanBakuController::class, 'searchBahanBaku'])->middleware('auth:sanctum', 'ability:admin,manajer-operasional');
        Route::get('/{id}', [BahanBakuController::class, 'getBahanBaku'])->middleware('auth:sanctum', 'ability:admin,manajer-operasional');
        Route::post('/', [BahanBakuController::class, 'insertBahanBaku'])->middleware('auth:sanctum', 'ability:admin');
        Route::delete('/{id}', [BahanBakuController::class, 'deleteBahanBaku'])->middleware('auth:sanctum', 'ability:admin');
        Route::put('/{id}', [BahanBakuController::class, 'updateBahanBaku'])->middleware('auth:sanctum', 'ability:admin');
    });

    /*
    =======================================================
    |                 Penitip Management                  |
    =======================================================
    */
    Route::prefix('penitip')->group(function () {
        Route::get('/', [PenitipController::class, 'getAllPenitip'])->middleware('auth:sanctum', 'ability:manajer-operasional,admin');
        Route::get('/search', [PenitipController::class, 'searchPenitip'])->middleware('auth:sanctum', 'ability:manajer-operasional,admin');
        Route::get('/{id}', [PenitipController::class, 'getPenitip'])->middleware('auth:sanctum', 'ability:manajer-operasional,admin');
        Route::post('/', [PenitipController::class, 'insertPenitip'])->middleware('auth:sanctum', 'ability:manajer-operasional');
        Route::put('/{id}', [PenitipController::class, 'updatePenitip'])->middleware('auth:sanctum', 'ability:manajer-operasional');
        Route::delete('/{id}', [PenitipController::class, 'deletePenitip'])->middleware('auth:sanctum', 'ability:manajer-operasional');
    });

    /*
    =======================================================
    |                Pengeluaran Lain Management          |
    =======================================================
    */
    Route::prefix('pengeluaran-lain')->group(function () {
        Route::get('/', [PengeluaranLainController::class, 'getAllPengeluaranLain'])->middleware('auth:sanctum', 'ability:manajer-operasional');
        Route::get('/search', [PengeluaranLainController::class, 'searchPengeluaranLain'])->middleware('auth:sanctum', 'ability:manajer-operasional');
        Route::get('/{id}', [PengeluaranLainController::class, 'getPengeluaranLain'])->middleware('auth:sanctum', 'ability:manajer-operasional');
        Route::post('/', [PengeluaranLainController::class, 'insertPengeluaranLain'])->middleware('auth:sanctum', 'ability:manajer-operasional');
        Route::put('/{id}', [PengeluaranLainController::class, 'updatePengeluaranLain'])->middleware('auth:sanctum', 'ability:manajer-operasional');
        Route::put('/status/{id}', [PengeluaranLainController::class, 'restorePengeluaranLain'])->middleware('auth:sanctum', 'ability:manajer-operasional');
        Route::delete('/{id}', [PengeluaranLainController::class, 'deletePengeluaranLain'])->middleware('auth:sanctum', 'ability:manajer-operasional');
    });

    /*
    =======================================================
    |                Detail Hampers Management            |
    =======================================================
    */
    Route::prefix('data-customer')->group(function () {
        Route::get('/searchData', [CustomerController::class, 'searchDataCustomer'])->middleware('auth:sanctum', 'ability:admin');
        Route::get('/getDataHistory/{id}', [CustomerController::class, 'getHistoryPesananCustomer'])->middleware('auth:sanctum', 'ability:admin');
    });

    /*
    =======================================================
    |                   Personal Profile                  |
    =======================================================
    */
    Route::prefix('change-password')->group(function () {
        Route::put('/{id}', [AuthController::class, 'changePassword'])->middleware('auth:sanctum', 'ability:admin,manajer-operasional,owner');
    });
    
    Route::prefix('/pesanan')->group(function () {
        Route::get('/valid', [PesananController::class, 'getPesananValid'])->middleware('auth:sanctum', 'ability:manajer-operasional');
        Route::put('/konfirmasi/{id}', [PesananController::class, 'confirmPesanan'])->middleware('auth:sanctum', 'ability:manajer-operasional');
        Route::get('/bahan-baku-kurang', [PesananController::class, 'bahanBakuKurang'])->middleware('auth:sanctum', 'ability:manajer-operasional');

    });

    /*
    =======================================================
    |                   Kategori Produk                   |
    =======================================================
    */
    Route::prefix('kategori')->group(function () {
        Route::get('/', [KategoriController::class, 'getAllKategori'])->middleware('auth:sanctum', 'ability:admin,user');
        Route::get('/{id}', [KategoriController::class, 'getKategori'])->middleware('auth:sanctum', 'ability:admin,user');
        Route::post('/', [KategoriController::class, 'insertKategori'])->middleware('auth:sanctum', 'ability:admin');
        Route::put('/{id}', [KategoriController::class, 'updateKategori'])->middleware('auth:sanctum', 'ability:admin');
        Route::delete('/{id}', [KategoriController::class, 'deleteKategori'])->middleware('auth:sanctum', 'ability:admin');
    });
});

/*
=======================================================
|                   Customer                          |
=======================================================
*/
Route::prefix('customer')->group(function () {
    /*
    =======================================================
    |                       Profile                       |
    =======================================================
    */
    Route::prefix('profile')->group(function () {
        Route::get('/', [CustomerController::class, 'showData'])->middleware('auth:sanctum', 'ability:user');
        Route::put('/', [CustomerController::class, 'changeProfile'])->middleware('auth:sanctum', 'ability:user');
    });

    Route::prefix('reset-password')->group(function () {
        Route::post('/create-token', [CustomerController::class, 'createToken']);
        Route::get('/activate/{token}', [CustomerController::class, 'activateToken']);
        Route::get('/validate/{token}', [CustomerController::class, 'validateToken']);
        Route::post('/submit-reset', [CustomerController::class, 'resetPassword']);
    });

    /*
    =======================================================
    |                       History                       |
    =======================================================
    */
    Route::prefix('history')->group(function () {
        Route::get('/', [CustomerController::class, 'historyTransaction'])->middleware('auth:sanctum', 'ability:user');
    });

    /*
    =======================================================
    |                       Pesanan                       |
    =======================================================
    */
    Route::prefix('pesanan')->group(function () {
        Route::get('/belum-bayar', [PesananController::class, 'getPesananBelumDibayar'])->middleware('auth:sanctum', 'ability:user');
        Route::post('/bayar/{id}', [PesananController::class, 'bayarPesanan'])->middleware('auth:sanctum', 'ability:user');
    });
});
