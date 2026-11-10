@extends('layouts.app')

@section('title', 'Riwayat Peminjaman')

@section('content')
    <div class="page-head">
        <h1>Riwayat Peminjaman</h1>
        <p>Atas nama: <strong>{{ $anggota->nama }}</strong></p>
    </div>

    <section class="panel">
        <div class="table-wrap">
            <table class="tabel">
                <thead>
                    <tr><th>No</th><th>Buku</th><th>Tgl Pinjam</th><th>Tgl Kembali</th><th>Status</th></tr>
                </thead>
                <tbody>
                    @forelse ($daftar as $p)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $p->buku->judul ?? '-' }}</td>
                            <td>{{ $p->tanggal_pinjam }}</td>
                            <td>{{ $p->tanggal_kembali ?? '-' }}</td>
                            <td><span class="status status-{{ $p->status }}">{{ $p->status }}</span></td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="tabel-info">Belum ada riwayat peminjaman.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
@endsection