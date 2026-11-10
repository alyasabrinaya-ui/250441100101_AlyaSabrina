<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PeminjamanController extends Controller
{

    public function index(): View
    {
        return view('peminjaman.index', [
            'daftar' => Peminjaman::with(['anggota', 'buku'])->orderByDesc('id')->get(),
        ]);
    }

    public function show($id): View
    {
        $peminjaman = Peminjaman::findOrFail($id);

        return view('peminjaman.show', ['peminjaman' => $peminjaman]);
    }
    
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'buku_id' => ['required', 'exists:bukus,id'],
        ]);

      
        $request->user()->buatAnggota()->peminjamans()->create([
            'buku_id'        => $data['buku_id'],
            'tanggal_pinjam' => now()->toDateString(),
            'status'         => 'diajukan',
        ]);

        return back()->with('sukses', 'Pengajuan peminjaman berhasil dikirim.');
    }

   
    public function setujui(Peminjaman $peminjaman): RedirectResponse
    {
        $peminjaman->update(['status' => 'dipinjam', 'tanggal_pinjam' => now()->toDateString()]);

        return back()->with('sukses', 'Peminjaman disetujui.');
    }
}