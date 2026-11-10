@props(['buku'])

<article class="book-card">
    <div class="book-cover cover-{{ $buku['id'] % 5 }}">
        @isset($badge)
            <span class="badge">{{ $badge }}</span>
        @endisset
        <span class="cover-initial">{{ strtoupper(substr($buku['judul'], 0, 1)) }}</span>
    </div>

    <div class="book-body">
        <h3 class="book-title">{{ $buku['judul'] }}</h3>
        <p class="book-meta">penulis : {{ $buku['penulis'] }}</p>
        <p class="book-meta">tahun : {{ $buku['tahun_terbit'] }}</p>

        @if (! $slot->isEmpty())
            <div class="book-extra">{{ $slot }}</div>
        @endif

        <a href="{{ route('buku.show', $buku['id']) }}" class="btn btn-primary">Lihat Detail </a>
    </div>
</article>