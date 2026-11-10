@extends('layouts.app')

@section('title', 'Dashboard Petugas')

@section('content')
    <div class="page-head">
        <h1>Dashboard Petugas</h1>
        <p>Selamat datang, {{ auth()->user()->name }}.</p>
    </div>

    <section class="panel">
        <h2>Menu Petugas</h2>
        <div class="aksi-menu">
            @can('kelola data buku')<a href="{{ route('buku.index') }}" class="btn btn-primary">Kelola Buku</a>@endcan
            @can('kelola peminjaman')<a href="{{ route('peminjaman.index') }}" class="btn btn-primary">Proses Peminjaman</a>@endcan
            @can('kelola pengembalian')<a href="{{ route('pengembalian.index') }}" class="btn btn-primary">Proses Pengembalian</a>@endcan
            @can('lihat laporan perpustakaan')<a href="{{ route('laporan.index') }}" class="btn btn-primary">Laporan</a>@endcan
        </div>
    </section>
@endsection