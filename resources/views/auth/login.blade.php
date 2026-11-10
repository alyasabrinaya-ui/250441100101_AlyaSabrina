@extends('layouts.app')

@section('title', 'Login')

@section('content')
    <div class="auth-wrap">
        <div class="page-head">
            <h1>Login</h1>
            <p>Masuk untuk mengakses perpustakaan.</p>
        </div>

        <section class="panel">
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="field">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus placeholder="nama@email.com">
                    @error('email') <p class="field-error">{{ $message }}</p> @enderror
                </div>

                <div class="field">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required placeholder="Password">
                    @error('password') <p class="field-error">{{ $message }}</p> @enderror
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Login</button>
                    <a href="{{ route('register') }}" class="btn btn-reset">Belum punya akun?</a>
                </div>
            </form>
        </section>
    </div>
@endsection