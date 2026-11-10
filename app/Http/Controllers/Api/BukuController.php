<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BukuResource;
use App\Models\Buku;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    public function index(Request $request)
    {
        $query = Buku::with('kategori')
            ->withCount('peminjamans')
            ->orderBy('id');

        if ($request->filled('cari')) {
            $cari = $request->query('cari');
            $query->where(function ($q) use ($cari) {
                $q->where('judul', 'like', "%{$cari}%")
                  ->orWhere('penulis', 'like', "%{$cari}%");
            });
        }

        if ($request->filled('kategori')) {
            $query->where('kategori_id', $request->query('kategori'));
        }

        if ($request->filled('tahun')) {
            $query->where('tahun_terbit', $request->query('tahun'));
        }

        $buku = $query->paginate(10)->withQueryString();

        return response()->json([
            'data' => BukuResource::collection($buku->items()),
            'meta' => [
                'current_page'  => $buku->currentPage(),
                'last_page'     => $buku->lastPage(),
                'per_page'      => $buku->perPage(),
                'total'         => $buku->total(),
                'next_page_url' => $buku->nextPageUrl(),
                'prev_page_url' => $buku->previousPageUrl(),
            ],
        ], 200);
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->aturan(), $this->pesan(), $this->nama());

        $buku = Buku::create($data);

        return response()->json(['data' => $buku], 201);
    }

    public function show($id)
    {
        $buku = Buku::with(['kategori', 'peminjamans'])->find($id);

        if (! $buku) {
            return response()->json(['message' => 'not found'], 404);
        }

        return response()->json(['data' => $buku], 200);
    }

    public function update(Request $request, $id)
    {
        $buku = Buku::find($id);

        if (! $buku) {
            return response()->json(['message' => 'not found'], 404);
        }

        $data = $request->validate($this->aturan(true), $this->pesan(), $this->nama());

        $buku->update($data);

        return response()->json(['data' => $buku], 200);
    }

    public function destroy($id)
    {
        $buku = Buku::find($id);

        if (! $buku) {
            return response()->json(['message' => 'not found'], 404);
        }

        $buku->delete();

        return response()->json(['message' => 'Buku berhasil dihapus'], 200);
    }

    private function aturan(bool $update = false): array
    {
        $awal = $update ? 'sometimes' : 'required';

        return [
            'kategori_id'  => [$awal, 'exists:kategoris,id'],
            'judul'        => [$awal, 'string', 'min:3', 'max:150'],
            'penulis'      => [$awal, 'string', 'min:3', 'max:100'],
            'tahun_terbit' => [$awal, 'integer', 'between:1900,' . date('Y')],
        ];
    }

    private function pesan(): array
    {
        return [
            'kategori_id.required'  => 'Kategori wajib diisi.',
            'kategori_id.exists'    => 'Kategori yang dipilih tidak valid.',
            'judul.required'        => 'Judul buku wajib diisi.',
            'judul.min'             => 'Judul buku minimal 3 karakter.',
            'judul.max'             => 'Judul buku maksimal 150 karakter.',
            'penulis.required'      => 'Penulis wajib diisi.',
            'penulis.min'           => 'Penulis minimal 3 karakter.',
            'penulis.max'           => 'Penulis maksimal 100 karakter.',
            'tahun_terbit.required' => 'Tahun terbit wajib diisi.',
            'tahun_terbit.integer'  => 'Tahun terbit harus berupa bilangan bulat.',
            'tahun_terbit.between'  => 'Tahun terbit harus antara 1900 sampai ' . date('Y') . '.',
        ];
    }

    private function nama(): array
    {
        return [
            'kategori_id'  => 'kategori',
            'tahun_terbit' => 'tahun terbit',
        ];
    }
}