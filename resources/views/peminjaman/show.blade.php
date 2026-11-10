@extends('layouts.app')

@section('title', 'Detail Peminjaman')

@section('content')
    <div class="page-head">
        <h1>Detail Peminjaman #{{ $peminjaman->id }}</h1>
    </div>

    <section class="panel">
        <dl class="detail-list">
            <div><dt>Peminjam</dt><dd>{{ $peminjaman->anggota->nama ?? '-' }}</dd></div>
            <div><dt>Buku</dt><dd>{{ $peminjaman->buku->judul ?? '-' }}</dd></div>
            <div><dt>Tgl Pinjam</dt><dd>{{ $peminjaman->tanggal_pinjam }}</dd></div>
            <div><dt>Tgl Kembali</dt><dd>{{ $peminjaman->tanggal_kembali ?? '-' }}</dd></div>
            <div>
                <dt>Status</dt>
                <dd><span class="status status-{{ $peminjaman->status }}">{{ $peminjaman->status }}</span></dd>
            </div>
        </dl>
    </section>
@endsection