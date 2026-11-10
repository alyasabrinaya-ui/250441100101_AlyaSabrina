@extends('layouts.app')

@section('title', 'Daftar Buku')

@section('content')
    <div class="page-head">
        <h1>Daftar Buku</h1>
        @can('kelola-buku')
            <a href="{{ route('buku.create') }}" class="btn btn-primary" style="margin-top: .75rem;">+ Tambah Buku</a>
        @endcan
    </div>

    <div id="pesan" class="alert" hidden></div>

    <section class="panel">
        <div class="table-wrap">
            <table class="tabel-buku">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kategori</th>
                        <th>Judul</th>
                        <th>Penulis</th>
                        <th>Tahun Terbit</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="tabel-body">
                    <tr><td colspan="6" class="tabel-info">Memuat data...</td></tr>
                </tbody>
            </table>
        </div>

        <div class="pager">
            <button type="button" id="btn-prev" class="btn btn-reset">&laquo; Sebelumnya</button>
            <span id="info-halaman"></span>
            <button type="button" id="btn-next" class="btn btn-reset">Berikutnya &raquo;</button>
        </div>
    </section>

    <section class="panel">
        <h2>Buku Terbaru</h2>
        <ul>
            @foreach ($bukuTerbaru as $b)
                <li>{{ $b->judul }}</li>
            @endforeach
        </ul>
    </section>

    @can('kelola-buku')
        <form id="form-hapus" method="POST" hidden>
            @csrf
            @method('DELETE')
        </form>
    @endcan

    <script>
        const API_URL       = @json(url('/api/buku'));
        const BISA_KELOLA   = @can('kelola-buku') true @else false @endcan;
        const HEADER_ACCEPT = { 'Accept': 'application/json' };

        const elPesan = document.getElementById('pesan');
        const tbody   = document.getElementById('tabel-body');
        const btnPrev = document.getElementById('btn-prev');
        const btnNext = document.getElementById('btn-next');
        const infoHal = document.getElementById('info-halaman');

        let halamanSekarang = 1;
        let timerPesan = null;

        function tampilPesan(teks, tipe) {
            clearTimeout(timerPesan);
            elPesan.textContent = teks;
            elPesan.className = 'alert alert-' + tipe;
            elPesan.hidden = false;

            if (tipe === 'sukses') {
                timerPesan = setTimeout(() => { elPesan.hidden = true; }, 3000);
            }
        }

        async function ambilPesanError(response) {
            let body = {};
            try { body = await response.json(); } catch (e) { /* respons bukan JSON */ }

            if (response.status === 422 && body.errors) {
                return Object.values(body.errors).flat().join('\n');
            }
            return body.message || `Permintaan gagal (HTTP ${response.status}).`;
        }

        function pesanDariError(err) {
            if (err instanceof TypeError) {
                return 'API tidak dapat diakses. Pastikan server Laravel berjalan.';
            }
            return err.message;
        }

        function isiTabelKosong(teks) {
            const tr = document.createElement('tr');
            const td = document.createElement('td');
            td.colSpan = 6;
            td.className = 'tabel-info';
            td.textContent = teks;
            tr.appendChild(td);
            tbody.replaceChildren(tr);
        }

        function renderTabel(data, meta) {
            if (data.length === 0) {
                isiTabelKosong('Belum ada data buku.');
            } else {
                tbody.replaceChildren();

                data.forEach((buku, i) => {
                    const tr = document.createElement('tr');
                    const nomor = (meta.current_page - 1) * meta.per_page + i + 1;

                    [nomor, buku.kategori, buku.judul, buku.penulis, buku.tahun].forEach((isi, idx) => {
                        const td = document.createElement('td');

                        if (idx === 1) {
                            const chip = document.createElement('span');
                            chip.className = 'chip';
                            chip.textContent = isi;
                            td.appendChild(chip);
                        } else {
                            td.textContent = isi;
                        }

                        tr.appendChild(td);
                    });

                    const tdAksi = document.createElement('td');
                    tdAksi.className = 'aksi';

                    const btnDetail = document.createElement('a');
                    btnDetail.href = `/buku/${buku.id}`;
                    btnDetail.className = 'btn btn-sm btn-primary';
                    btnDetail.textContent = 'Detail';
                    tdAksi.appendChild(btnDetail);

                    if (BISA_KELOLA) {
                        const btnUbah = document.createElement('a');
                        btnUbah.href = `/buku/${buku.id}/edit`;
                        btnUbah.className = 'btn btn-sm btn-warning';
                        btnUbah.textContent = 'Ubah';

                        const btnHapus = document.createElement('button');
                        btnHapus.type = 'button';
                        btnHapus.className = 'btn btn-sm btn-danger';
                        btnHapus.textContent = 'Hapus';
                        btnHapus.addEventListener('click', () => hapusBuku(buku));

                        tdAksi.append(btnUbah, btnHapus);
                    }

                    tr.appendChild(tdAksi);
                    tbody.appendChild(tr);
                });
            }

            infoHal.textContent = `Halaman ${meta.current_page} dari ${meta.last_page} (${meta.total} buku)`;
            btnPrev.disabled = meta.current_page <= 1;
            btnNext.disabled = meta.current_page >= meta.last_page;
        }

        async function muatBuku(halaman = 1) {
            try {
                const response = await fetch(`${API_URL}?page=${halaman}`, { headers: HEADER_ACCEPT });
                if (!response.ok) {
                    throw new Error(await ambilPesanError(response));
                }

                const hasil = await response.json();

                if (hasil.data.length === 0 && halaman > 1) {
                    return muatBuku(halaman - 1);
                }

                halamanSekarang = hasil.meta.current_page;
                renderTabel(hasil.data, hasil.meta);
            } catch (err) {
                tampilPesan('Gagal memuat data buku. ' + pesanDariError(err), 'gagal');
                isiTabelKosong('Data buku tidak dapat ditampilkan.');
            }
        }

        function hapusBuku(buku) {
            if (!confirm(`Yakin ingin menghapus buku "${buku.judul}"?`)) {
                return;
            }

            const formHapus = document.getElementById('form-hapus');
            formHapus.action = `/buku/${buku.id}`;
            formHapus.submit();
        }

        btnPrev.addEventListener('click', () => muatBuku(halamanSekarang - 1));
        btnNext.addEventListener('click', () => muatBuku(halamanSekarang + 1));

        muatBuku(1);
    </script>
@endsection