@extends('layouts.app')

@section('title', 'Data Peminjaman')

@section('content')
    <div class="page-head">
        <h1>Data Peminjaman</h1>
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
                        <th>Tgl Kembali</th>
                        <th>Status</th>
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
                            <td>{{ $p->tanggal_kembali ?? '-' }}</td>
                            <td><span class="status status-{{ $p->status }}">{{ $p->status }}</span></td>
                            <td>
                                @if ($p->status === 'diajukan')
                                    @can('memproses persetujuan peminjaman')
                                        <form method="POST" action="{{ route('peminjaman.setujui', $p) }}">
                                            @csrf @method('PATCH')
                                            <button type="submit" class="btn btn-sm btn-primary">Setujui</button>
                                        </form>
                                    @endcan
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="tabel-info">Belum ada data peminjaman.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
@endsection