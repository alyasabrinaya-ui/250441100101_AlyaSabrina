<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PengembalianController extends Controller
{

    public function index(): View
    {
        return view('pengembalian.index', [
            'daftar' => Peminjaman::with(['anggota', 'buku'])->where('status', 'dipinjam')->orderBy('tanggal_pinjam')->get(),
        ]);
    }

    public function update(Peminjaman $peminjaman): RedirectResponse
    {
        $peminjaman->update(['status' => 'dikembalikan', 'tanggal_kembali' => now()->toDateString()]);

        return back()->with('sukses', 'Pengembalian buku berhasil dicatat.');
    }
}