<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TransaksiController;

Route::get('/', [BarangController::class,'index']);

Route::get('/login', [AuthController::class,'show']);
Route::post('/login', [AuthController::class,'login']);
Route::get('/logout', [AuthController::class,'logout']);

Route::get('/tambah', [BarangController::class,'create']);
Route::post('/tambah', [BarangController::class,'store']);

Route::get('/edit/{id}', [BarangController::class,'edit']);
Route::post('/edit', [BarangController::class,'update']);

Route::get('/hapus/{id}', [BarangController::class,'delete']);

Route::get('/transaksi', [TransaksiController::class,'index']);
Route::post('/transaksi/tambah', [TransaksiController::class,'tambah']);
Route::post('/transaksi/hapus', [TransaksiController::class,'hapus']);
Route::post('/transaksi/checkout', [TransaksiController::class,'checkout']);