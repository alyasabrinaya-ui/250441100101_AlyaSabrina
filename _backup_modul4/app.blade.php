<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
            <a href="{{ route('buku.index') }}" class="{{ request()->routeIs('buku.*') ? 'active' : '' }}">Daftar Buku</a>
        </div>
    </nav>

    <main>
        <div class="container">
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