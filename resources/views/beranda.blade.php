@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
    <section class="hero">
        <span class="hero-label">WELCOME, BOOKWORM!</span>
        <h1>Temukan buku favoritmu di <em>BACAINAJA</em></h1>
        <p>Jelajahi koleksi buku, temukan bacaan favoritmu,
dan biarkan setiap halaman membawamu ke petualangan baru.</p>
        <a href="{{ route('buku.index') }}" class="btn btn-accent">Lihat Daftar Buku</a>
    </section>

    <section class="features">
        <div class="feature">
            <h3>Mau Baca Apa Hari Ini?</h3>
            <p>Dari yang bikin baper sampai yang bikin pintar, tinggal pilih.</p>
        </div>
        <div class="feature">
            <h3>Kenalan Dulu Sama Bukunya</h3>
            <p>Cek penulis, tahun, dan kategorinya sebelum jatuh cinta.</p>
        </div>
        <div class="feature">
            <h3>Nggak Pakai Lama</h3>
            <p>Buka, scroll, ketemu bacaan favoritmu..</p>
        </div>
    </section>
@endsection