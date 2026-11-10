@extends('layouts.app')

@section('title', 'Daftar')

@section('content')
    <div class="auth-wrap">
        <div class="page-head">
            <h1>Daftar Akun</h1>
            <p>Akun baru otomatis berperan sebagai Siswa.</p>
        </div>

        <section class="panel">
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="field">
                    <label for="name">Nama</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus placeholder="Nama lengkap">
                    @error('name') <p class="field-error">{{ $message }}</p> @enderror
                </div>

                <div class="field">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required placeholder="nama@email.com">
                    @error('email') <p class="field-error">{{ $message }}</p> @enderror
                </div>

                <div class="field">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required placeholder="Minimal 8 karakter">
                    @error('password') <p class="field-error">{{ $message }}</p> @enderror
                </div>

                <div class="field">
                    <label for="password_confirmation">Konfirmasi Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required placeholder="Ulangi password">
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Daftar</button>
                    <a href="{{ route('login') }}" class="btn btn-reset">Sudah punya akun?</a>
                </div>
            </form>
        </section>
    </div>
@endsection