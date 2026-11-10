@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
    <div class="page-head">
        <h1>Dashboard Admin</h1>
        <p>Selamat datang, {{ auth()->user()->name }}.</p>
    </div>

    <section class="panel">
        <h2>Menu Admin</h2>
        <div class="aksi-menu">
            @can('kelola data buku')<a href="{{ route('buku.index') }}" class="btn btn-primary">Kelola Buku</a>@endcan
            @can('kelola data pengguna')<a href="{{ route('admin.pengguna.index') }}" class="btn btn-primary">Kelola Pengguna & Role</a>@endcan
            @can('kelola peminjaman')<a href="{{ route('peminjaman.index') }}" class="btn btn-primary">Data Peminjaman</a>@endcan
            @can('kelola pengembalian')<a href="{{ route('pengembalian.index') }}" class="btn btn-primary">Data Pengembalian</a>@endcan
            @can('lihat laporan perpustakaan')<a href="{{ route('laporan.index') }}" class="btn btn-primary">Laporan</a>@endcan
        </div>
    </section>
@endsection