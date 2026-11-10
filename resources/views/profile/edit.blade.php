@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
    <div class="page-head">
        <h1>Profil Saya</h1>
        <p>Role: <span class="chip">{{ $user->getRoleNames()->implode(', ') }}</span></p>
    </div>

    <section class="panel">
        <form method="POST" action="{{ route('profile.update') }}" novalidate>
            @csrf
            @method('PATCH')

            <div class="form-grid">
                <div class="field">
                    <label for="name">Nama</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                    @error('name') <p class="field-error">{{ $message }}</p> @enderror
                </div>

                <div class="field">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                    @error('email') <p class="field-error">{{ $message }}</p> @enderror
                </div>
            </div>

            @can('ubah profil sendiri')
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            @endcan
        </form>
    </section>
@endsection