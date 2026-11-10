@extends('layouts.app')

@section('title', $buku->exists ? 'Ubah Buku' : 'Tambah Buku')

@section('content')
    <a href="{{ route('buku.index') }}" class="back-link">← Kembali ke Daftar Buku</a>

    <section class="panel">
        <h2>{{ $buku->exists ? 'Ubah Buku' : 'Tambah Buku' }}</h2>

        <form method="POST" action="{{ $buku->exists ? route('buku.update', $buku) : route('buku.store') }}">
            @csrf
            @if ($buku->exists)
                @method('PUT')
            @endif

            <div class="form-grid">
                <div class="field">
                    <label for="kategori_id">Kategori</label>
                    <select id="kategori_id" name="kategori_id">
                        <option value="">-- Pilih kategori --</option>
                        @foreach ($daftarKategori as $kategori)
                            <option value="{{ $kategori->id }}" @selected(old('kategori_id', $buku->kategori_id) == $kategori->id)>
                                {{ $kategori->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('kategori_id') <p class="field-error">{{ $message }}</p> @enderror
                </div>

                <div class="field">
                    <label for="judul">Judul</label>
                    <input type="text" id="judul" name="judul" value="{{ old('judul', $buku->judul) }}" placeholder="Judul buku">
                    @error('judul') <p class="field-error">{{ $message }}</p> @enderror
                </div>

                <div class="field">
                    <label for="penulis">Penulis</label>
                    <input type="text" id="penulis" name="penulis" value="{{ old('penulis', $buku->penulis) }}" placeholder="Nama penulis">
                    @error('penulis') <p class="field-error">{{ $message }}</p> @enderror
                </div>

                <div class="field">
                    <label for="tahun_terbit">Tahun Terbit</label>
                    <input type="number" id="tahun_terbit" name="tahun_terbit" value="{{ old('tahun_terbit', $buku->tahun_terbit) }}" placeholder="Contoh: 2020">
                    @error('tahun_terbit') <p class="field-error">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">{{ $buku->exists ? 'Simpan Perubahan' : 'Tambah Buku' }}</button>
                <a href="{{ route('buku.index') }}" class="btn btn-reset">Batal</a>
            </div>
        </form>
    </section>
@endsection