@extends('layouts.app')

@section('title', 'Data Pengembalian')

@section('content')
    <div class="page-head">
        <h1>Data Pengembalian</h1>
        <p>Buku yang sedang dipinjam.</p>
    </div>

    <section class="panel">
        <div class="table-wrap">
            <table class="tabel">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Peminjam</th>
                        <th>Buku</th>
                        <th>Tgl Pinjam</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($daftar as $p)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $p->anggota->nama ?? '-' }}</td>
                            <td>{{ $p->buku->judul ?? '-' }}</td>
                            <td>{{ $p->tanggal_pinjam }}</td>
                            <td>
                                @can('mencatat pengembalian buku')
                                    <form method="POST" action="{{ route('pengembalian.update', $p) }}">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="btn btn-sm btn-primary">Catat Pengembalian</button>
                                    </form>
                                @endcan
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="tabel-info">Tidak ada buku yang sedang dipinjam.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
@endsection