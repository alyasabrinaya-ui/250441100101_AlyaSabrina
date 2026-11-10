<?php

use App\Http\Controllers\Api\BukuController;
use App\Http\Controllers\Api\RekapController;
use Illuminate\Support\Facades\Route;


Route::middleware(['web', 'auth'])->group(function () {

    Route::get('/rekap/buku-per-kategori', [RekapController::class, 'bukuPerKategori'])
        ->middleware('permission:lihat laporan perpustakaan');
    Route::get('/rekap/peminjaman-per-buku', [RekapController::class, 'peminjamanPerBuku'])
        ->middleware('permission:lihat laporan perpustakaan');


    Route::apiResource('buku', BukuController::class)->only(['index', 'show'])
        ->middleware('permission:lihat daftar buku')->names('api.buku');

  
    Route::apiResource('buku', BukuController::class)->only(['store', 'update', 'destroy'])
        ->middleware('can:kelola-buku')->names('api.buku');
});