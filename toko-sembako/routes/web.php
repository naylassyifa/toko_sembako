<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BarangController;

Route::get('/', function () {
    return redirect('/barang');
});

Route::get('/barang', [BarangController::class, 'index']);

Route::get('/tambah', [BarangController::class, 'create']);
Route::post('/tambah', [BarangController::class, 'store'])->name('barang.store');

Route::get('/edit/{id}', [BarangController::class, 'edit']);
Route::post('/update', [BarangController::class, 'update']);

Route::get('/hapus/{id}', [BarangController::class, 'delete']);