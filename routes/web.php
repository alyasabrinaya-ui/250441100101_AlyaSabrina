<?php

use App\Http\Controllers\Admin\PenggunaController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PengembalianController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RiwayatController;
use Illuminate\Support\Facades\Route;


Route::view('/', 'beranda')->name('home');

Route::middleware('auth')->group(function () {

  
    Route::get('/dashboard', function () {
        $user = auth()->user();

        if ($user->can('akses dashboard admin')) {
            return redirect()->route('admin.dashboard');
        }
        if ($user->can('akses dashboard petugas')) {
            return redirect()->route('petugas.dashboard');
        }

        return redirect()->route('buku.index'); 
    })->name('dashboard');


    Route::view('/admin/dashboard', 'dashboard.admin')
        ->middleware('permission:akses dashboard admin')->name('admin.dashboard');
    Route::view('/petugas/dashboard', 'dashboard.petugas')
        ->middleware('permission:akses dashboard petugas')->name('petugas.dashboard');

    Route::middleware('permission:lihat daftar buku')->group(function () {
        Route::get('/buku', [BukuController::class, 'index'])->name('buku.index');
        Route::get('/buku/{id}', [BukuController::class, 'show'])->name('buku.show');
    });

    // === Soal 1: sengaja dibuat rentan ===
    Route::get('/buku-cari', [BukuController::class, 'cari']);
    Route::get('/buku/{buku}/hapus', [BukuController::class, 'destroy']);
    Route::get('/peminjaman/{id}', [PeminjamanController::class, 'show']);

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->middleware('permission:lihat profil sendiri')->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])
        ->middleware('permission:ubah profil sendiri')->name('profile.update');

    Route::post('/peminjaman', [PeminjamanController::class, 'store'])
        ->middleware('permission:mengajukan peminjaman buku')->name('peminjaman.store');
    Route::get('/riwayat/{anggota}', [RiwayatController::class, 'show'])
        ->middleware('permission:melihat status peminjaman sendiri|melihat riwayat peminjaman sendiri')
        ->name('riwayat.show');


    Route::middleware('permission:kelola peminjaman')->group(function () {
        Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman.index');
        Route::patch('/peminjaman/{peminjaman}/setujui', [PeminjamanController::class, 'setujui'])
            ->middleware('permission:memproses persetujuan peminjaman')->name('peminjaman.setujui');
    });


    Route::middleware('permission:kelola pengembalian')->group(function () {
        Route::get('/pengembalian', [PengembalianController::class, 'index'])->name('pengembalian.index');
        Route::patch('/pengembalian/{peminjaman}', [PengembalianController::class, 'update'])
            ->middleware('permission:mencatat pengembalian buku')->name('pengembalian.update');
    });


    Route::get('/laporan', [LaporanController::class, 'index'])
        ->middleware('permission:lihat laporan perpustakaan')->name('laporan.index');


    Route::middleware('permission:kelola data pengguna')->prefix('admin/pengguna')->name('admin.pengguna.')->group(function () {
        Route::get('/', [PenggunaController::class, 'index'])->name('index');
        Route::get('/create', [PenggunaController::class, 'create'])->name('create');
        Route::post('/', [PenggunaController::class, 'store'])->name('store');
        Route::get('/{user}/edit', [PenggunaController::class, 'edit'])->name('edit');
        Route::put('/{user}', [PenggunaController::class, 'update'])->name('update');
        Route::delete('/{user}', [PenggunaController::class, 'destroy'])->name('destroy');
        Route::patch('/{user}/role', [PenggunaController::class, 'updateRole'])
            ->middleware('permission:kelola role pengguna')->name('role');
    });
});

require __DIR__.'/auth.php';