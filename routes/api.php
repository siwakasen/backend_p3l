<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\ResepController;
use App\Http\Controllers\PresensiController;
use App\Http\Controllers\CustomerController;

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
});

/*
=======================================================
|                   Customer                          |
=======================================================
*/
Route::prefix('customer')->group(function () {
    /*
    =======================================================
    |                       Auth                          |
    =======================================================
    */
    Route::prefix('auth')->group(function () {
        Route::post('/register', [CustomerController::class, 'register']);
    });
    /*
    =======================================================
    |                       Profile                       |
    =======================================================
    */
    Route::prefix('profile')->group(function () {
        Route::get('/{id}', [CustomerController::class, 'showData']);
        Route::put('/{id}', [CustomerController::class, 'changeProfile']);
    });
    /*
    =======================================================
    |                       History                       |
    =======================================================
    */
    Route::prefix('history')->group(function () {
        Route::get('/{id}', [CustomerController::class, 'historyTransaction']);
        Route::post('/{id}', [CustomerController::class, 'searchTransaction']);
    });
});
