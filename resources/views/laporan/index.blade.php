@extends('layouts.app')

@section('title', 'Laporan Perpustakaan')

@section('content')
    <div class="page-head">
        <h1>Laporan Perpustakaan</h1>
    </div>

    <section class="panel">
        <h2>Jumlah Peminjaman per Status</h2>
        <div class="table-wrap">
            <table class="tabel">
                <thead><tr><th>Status</th><th>Jumlah</th></tr></thead>
                <tbody>
                    @foreach (['diajukan', 'dipinjam', 'dikembalikan'] as $status)
                        <tr><td>{{ $status }}</td><td>{{ $perStatus[$status] ?? 0 }}</td></tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>

    <section class="panel">
        <h2>Jumlah Peminjaman per Buku</h2>
        <div class="table-wrap">
            <table class="tabel">
                <thead><tr><th>Judul</th><th>Dipinjam</th></tr></thead>
                <tbody>
                    @foreach ($perBuku as $b)
                        <tr><td>{{ $b->judul }}</td><td>{{ $b->peminjamans_count }}x</td></tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>
@endsection