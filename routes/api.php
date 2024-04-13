<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DetailHampersController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\HampersController;
use App\Http\Controllers\PembelianBahanBakuController;
use App\Http\Controllers\BahanBakuController;
use App\Http\Controllers\PenitipController;
use App\Http\Controllers\PengeluaranLainController;
use App\Http\Controllers\CustomerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
});

Route::prefix('produk')->group(function () {
    Route::put('/{id}', [ProdukController::class, 'updateProduk'])->middleware('auth:sanctum', 'ability:admin');
    Route::post('/', [ProdukController::class, 'insertProduk'])->middleware('auth:sanctum', 'ability:admin');
    Route::delete('/{id}', [ProdukController::class, 'deleteProduk'])->middleware('auth:sanctum', 'ability:admin');
    Route::get('/search', [ProdukController::class, 'searchProduk']);
    Route::get('/{id}', [ProdukController::class, 'getProduk']);
    Route::get('/', [ProdukController::class, 'getAllProduk']);
});

Route::prefix('hampers')->group(function () {
    Route::get('/search', [HampersController::class, 'searchHampers']);
    Route::get('/', [HampersController::class, 'getAllHampers']);
    Route::get('/{id}', [HampersController::class, 'getHampers']);
    Route::put('/{id}', [HampersController::class, 'updateHampers'])->middleware('auth:sanctum', 'ability:admin');
    Route::post('/', [HampersController::class, 'insertHampers'])->middleware('auth:sanctum', 'ability:admin');
    Route::delete('/{id}', [HampersController::class, 'deleteHampers'])->middleware('auth:sanctum', 'ability:admin');
});

Route::prefix('detail-hampers')->group(function () {
    Route::get('/search', [DetailHampersController::class, 'searchDetailHampers']);
    Route::get('/', [DetailHampersController::class, 'getAllDetailHampers']);
    Route::get('/{id}', [DetailHampersController::class, 'getDetailHampers']);
    Route::post('/', [DetailHampersController::class, 'insertDetailHampers']);
    Route::delete('/{id}', [DetailHampersController::class, 'deleteDetailHampers']);
});

Route::prefix('pembelian-bahan-baku')->group(function () {
    Route::get('/search', [PembelianBahanBakuController::class, 'searchPembelianBahanBaku']);
    Route::get('/', [PembelianBahanBakuController::class, 'getAllPembelianBahanBaku']);
    Route::get('/{id}', [PembelianBahanBakuController::class, 'getPembelianBahanBaku']);
    Route::post('/', [PembelianBahanBakuController::class, 'insertPembelianBahanBaku']);
    Route::delete('/{id}', [PembelianBahanBakuController::class, 'deletePembelianBahanBaku']);
    Route::put('/{id}', [PembelianBahanBakuController::class, 'updatePembelianBahanBaku']);
});

Route::prefix('bahan-baku')->group(function (){
    Route::get('/', [BahanBakuController::class, 'getAllBahanBaku']);
    Route::get('/search', [BahanBakuController::class, 'searchBahanBaku']);
    Route::get('/{id}', [BahanBakuController::class, 'getBahanBaku']);
    Route::post('/', [BahanBakuController::class, 'insertBahanBaku'])->middleware('auth:sanctum', 'ability:admin');
    Route::delete('/{id}', [BahanBakuController::class, 'deleteBahanBaku'])->middleware('auth:sanctum', 'ability:admin');
    Route::put('/{id}', [BahanBakuController::class, 'updateBahanBaku'])->middleware('auth:sanctum', 'ability:admin');
});

Route::prefix('penitip')->group(function (){
    Route::get('/', [PenitipController::class, 'getAllPenitip']);
    Route::get('/search', [PenitipController::class, 'searchPenitip']);
    Route::get('/{id}', [PenitipController::class, 'getPenitip']);
    Route::post('/', [PenitipController::class, 'insertPenitip'])->middleware('auth:sanctum', 'ability:manajer-operasional');
    Route::put('/{id}', [PenitipController::class, 'updatePenitip'])->middleware('auth:sanctum', 'ability:manajer-operasional');
    Route::delete('/{id}', [PenitipController::class, 'deletePenitip'])->middleware('auth:sanctum', 'ability:manajer-operasional');
});
Route::prefix('pengeluaran-lain')->group(function (){
    Route::get('/', [PengeluaranLainController::class, 'getAllPengeluaranLain']);
    Route::get('/search', [PengeluaranLainController::class, 'searchPengeluaranLain']);
    Route::get('/{id}', [PengeluaranLainController::class, 'getPengeluaranLain']);
    Route::post('/', [PengeluaranLainController::class, 'insertPengeluaranLain'])->middleware('auth:sanctum', 'ability:manajer-operasional');
    Route::put('/{id}', [PengeluaranLainController::class, 'updatePengeluaranLain'])->middleware('auth:sanctum', 'ability:manajer-operasional');
    Route::delete('/{id}', [PengeluaranLainController::class, 'deletePengeluaranLain'])->middleware('auth:sanctum', 'ability:manajer-operasional');
});

Route::prefix('data-customer')->group(function (){
    Route::get('/searchData', [CustomerController::class, 'searchDataCustomer'])->middleware('auth:sanctum', 'ability:admin');
    Route::get('/getDataHistory', [CustomerController::class, 'getHistoryPesananCustomer'])->middleware('auth:sanctum', 'ability:admin');
});
