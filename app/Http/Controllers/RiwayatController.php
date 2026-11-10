<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class RiwayatController extends Controller
{
    public function show(Anggota $anggota): View
    {
        
        Gate::authorize('viewRiwayat', $anggota);

        return view('riwayat.show', [
            'anggota' => $anggota,
            'daftar'  => $anggota->peminjamans()->with('buku')->orderByDesc('id')->get(),
        ]);
    }
}