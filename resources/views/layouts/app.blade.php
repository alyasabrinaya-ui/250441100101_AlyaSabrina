<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Beranda') | Perpustakaan Digital</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

    @vite('resources/css/app.css')
</head>
<body>

    <header class="site-header">
        <div class="container header-inner">
            <a href="{{ route('home') }}" class="brand"> BACAIN<span>AJA</span></a>
            <p class="tagline">Your digital library, but make it fun.</p>
        </div>
    </header>

    <nav class="navbar">
        <div class="container nav-inner">
            <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Beranda</a>

            @auth
                @can('akses dashboard admin')
                    <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">Dashboard Admin</a>
                @endcan
                @can('akses dashboard petugas')
                    <a href="{{ route('petugas.dashboard') }}" class="{{ request()->routeIs('petugas.dashboard') ? 'active' : '' }}">Dashboard Petugas</a>
                @endcan
                @can('lihat daftar buku')
                    <a href="{{ route('buku.index') }}" class="{{ request()->routeIs('buku.*') ? 'active' : '' }}">Daftar Buku</a>
                @endcan
                @can('kelola peminjaman')
                    <a href="{{ route('peminjaman.index') }}" class="{{ request()->routeIs('peminjaman.*') ? 'active' : '' }}">Peminjaman</a>
                @endcan
                @can('kelola pengembalian')
                    <a href="{{ route('pengembalian.index') }}" class="{{ request()->routeIs('pengembalian.*') ? 'active' : '' }}">Pengembalian</a>
                @endcan
                @can('lihat laporan perpustakaan')
                    <a href="{{ route('laporan.index') }}" class="{{ request()->routeIs('laporan.*') ? 'active' : '' }}">Laporan</a>
                @endcan
                @can('kelola data pengguna')
                    <a href="{{ route('admin.pengguna.index') }}" class="{{ request()->routeIs('admin.pengguna.*') ? 'active' : '' }}">Pengguna</a>
                @endcan
                @if (auth()->user()->anggota)
                    @can('melihat riwayat peminjaman sendiri')
                        <a href="{{ route('riwayat.show', auth()->user()->anggota) }}" class="{{ request()->routeIs('riwayat.*') ? 'active' : '' }}">Riwayat Saya</a>
                    @endcan
                @endif

                <div class="nav-right">
                    @can('lihat profil sendiri')
                        <a href="{{ route('profile.edit') }}" class="{{ request()->routeIs('profile.*') ? 'active' : '' }}">{{ auth()->user()->name }}</a>
                    @endcan
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="nav-logout">Logout</button>
                    </form>
                </div>
            @else
                <div class="nav-right">
                    <a href="{{ route('login') }}" class="{{ request()->routeIs('login') ? 'active' : '' }}">Login</a>
                    <a href="{{ route('register') }}" class="{{ request()->routeIs('register') ? 'active' : '' }}">Daftar</a>
                </div>
            @endauth
        </div>
    </nav>

    <main>
        <div class="container">
            @if (session('sukses'))
                <div class="alert alert-sukses">{{ session('sukses') }}</div>
            @endif
            @if (session('gagal'))
                <div class="alert alert-gagal">{{ session('gagal') }}</div>
            @endif

            @yield('content')
        </div>
    </main>

    <footer class="site-footer">
        <div class="container">
            <p>&copy; {{ date('Y') }} BACAINAJA</p>
        </div>
    </footer>

</body>
</html>