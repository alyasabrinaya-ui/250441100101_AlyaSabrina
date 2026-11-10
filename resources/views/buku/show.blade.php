@extends('layouts.app')

@section('title', $buku ? $buku['judul'] : 'Buku Tidak Ditemukan')

@section('content')
    @if ($buku)
        <a href="{{ route('buku.index') }}" class="back-link">← Kembali ke Daftar Buku</a>

        <div class="detail">
            <div class="detail-cover book-cover cover-{{ $buku['id'] % 5 }}">
                <span class="badge">{{ $buku['kategori'] }}</span>
                <span class="cover-initial">{{ strtoupper(substr($buku['judul'], 0, 1)) }}</span>
            </div>

            <div class="detail-info">
                <h1>{{ $buku['judul'] }}</h1>
                <dl class="detail-list">
                    <div><dt>ID Buku</dt><dd>#{{ $buku['id'] }}</dd></div>
                    <div><dt>Penulis</dt><dd>{{ $buku['penulis'] }}</dd></div>
                    <div><dt>Tahun Terbit</dt><dd>{{ $buku['tahun_terbit'] }}</dd></div>
                    <div><dt>Kategori</dt><dd>{{ $buku['kategori'] }}</dd></div>
                </dl>
                    <div class="detail-actions">
                    @can('mengajukan peminjaman buku')
                        <form method="POST" action="{{ route('peminjaman.store') }}">
                            @csrf
                            <input type="hidden" name="buku_id" value="{{ $buku['id'] }}">
                            <button type="submit" class="btn btn-accent">Ajukan Peminjaman</button>
                        </form>
                    @endcan
                    <a href="{{ route('buku.index') }}" class="btn btn-primary">Lihat Buku Lainnya</a>
                </div>
            </div>
        </div>
    @else
        <div class="empty">
            <h2>Buku tidak ditemukan</h2>
            <p>Buku dengan ID <strong>{{ $id }}</strong> tidak ada di perpustakaan kami.</p>
            <a href="{{ route('buku.index') }}" class="btn btn-primary">Kembali ke Daftar Buku</a>
        </div>
    @endif
@endsection