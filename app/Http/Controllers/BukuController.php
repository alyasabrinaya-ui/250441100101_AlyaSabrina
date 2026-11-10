<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BukuController extends Controller
{
    private function formatBuku(Buku $buku): array
    {
        return [
            'id'           => $buku->id,
            'judul'        => $buku->judul,
            'penulis'      => $buku->penulis,
            'tahun_terbit' => (int) $buku->tahun_terbit,
            'kategori'     => $buku->kategori->nama ?? '-',
        ];
    }

    public function index()
    {
        return view('buku.index', [
            'daftarKategori' => Kategori::orderBy('nama')->get(['id', 'nama']),
            'bukuTerbaru'    => Buku::orderByDesc('id')->take(5)->get(['id', 'judul']),
        ]);
    }

    public function show($id)
    {
        $record = Buku::with('kategori')->find((int) $id);
        $buku   = $record ? $this->formatBuku($record) : null;

        return response()->view('buku.show', [
            'buku' => $buku,
            'id'   => $id,
        ], $buku ? 200 : 404);
    }

    // A2 (rentan): nilai judul digabung langsung ke string SQL
    public function cari(Request $request)
    {
        $judul = $request->query('judul');

        $hasil = DB::select('SELECT * FROM bukus WHERE judul = ?', [$judul]);

        return response()->json($hasil);
    }

    // A3 (rentan): dipanggil lewat GET tanpa token CSRF
    public function destroy(Buku $buku)
    {
        if ($buku->peminjamans()->exists()) {
            return redirect()->route('buku.index')
                ->with('gagal', 'Buku masih punya riwayat peminjaman, tidak bisa dihapus.');
        }

        $buku->delete();

        return redirect()->route('buku.index')->with('sukses', 'Buku berhasil dihapus.');
    }
}