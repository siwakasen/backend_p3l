<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return response()->json([
        'status' => 'error',
        'message' => 'You are not authorized to access this page'
    ], 401);
})->name('login');
