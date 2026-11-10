<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Peminjaman;
use Illuminate\View\View;

class LaporanController extends Controller
{
    public function index(): View
    {
        return view('laporan.index', [
            'perStatus' => Peminjaman::selectRaw('status, count(*) as jumlah')->groupBy('status')->pluck('jumlah', 'status'),
            'perBuku'   => Buku::select('id', 'judul')->withCount('peminjamans')->orderByDesc('peminjamans_count')->get(),
        ]);
    }
}