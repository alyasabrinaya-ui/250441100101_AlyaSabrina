@extends('layouts.app')

@section('title', $user->exists ? 'Ubah Pengguna' : 'Tambah Pengguna')

@section('content')
    <div class="page-head">
        <h1>{{ $user->exists ? 'Ubah Pengguna' : 'Tambah Pengguna' }}</h1>
    </div>

    <section class="panel">
        <form method="POST" action="{{ $user->exists ? route('admin.pengguna.update', $user) : route('admin.pengguna.store') }}" novalidate>
            @csrf
            @if ($user->exists) @method('PUT') @endif

            <div class="form-grid">
                <div class="field">
                    <label for="name">Nama</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}">
                    @error('name') <p class="field-error">{{ $message }}</p> @enderror
                </div>

                <div class="field">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}">
                    @error('email') <p class="field-error">{{ $message }}</p> @enderror
                </div>

                @unless ($user->exists)
                    @can('kelola role pengguna')
                        <div class="field">
                            <label for="role">Role</label>
                            <select id="role" name="role">
                                @foreach ($roles as $r)
                                    <option value="{{ $r }}" @selected(old('role', 'siswa') === $r)>{{ $r }}</option>
                                @endforeach
                            </select>
                            @error('role') <p class="field-error">{{ $message }}</p> @enderror
                        </div>
                    @endcan
                @endunless

                <div class="field">
                    <label for="password">Password {{ $user->exists ? '(kosongkan jika tidak diganti)' : '' }}</label>
                    <input type="password" id="password" name="password">
                    @error('password') <p class="field-error">{{ $message }}</p> @enderror
                </div>

                <div class="field">
                    <label for="password_confirmation">Konfirmasi Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation">
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('admin.pengguna.index') }}" class="btn btn-reset">Batal</a>
            </div>
        </form>
    </section>
@endsection