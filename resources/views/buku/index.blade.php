@extends('layouts.app')

@section('title', 'Daftar Buku')

@section('content')
    <div class="page-head">
        <h1>Daftar Buku</h1>
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
                <li>{!! $b->judul !!}</li>
            @endforeach
        </ul>
    </section>
    
    <section class="panel">
        @can('kelola data buku')
         
    
        <h2 id="judul-form">Tambah Buku</h2>

        <form id="form-buku" novalidate>
            <div class="form-grid">
                <div class="field">
                    <label for="kategori_id">Kategori</label>
                    <select id="kategori_id" name="kategori_id">
                        <option value="">-- Pilih kategori --</option>
                        @foreach ($daftarKategori as $kategori)
                            <option value="{{ $kategori->id }}">{{ $kategori->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="field">
                    <label for="judul">Judul</label>
                    <input type="text" id="judul" name="judul" placeholder="Judul buku">
                </div>
                <div class="field">
                    <label for="penulis">Penulis</label>
                    <input type="text" id="penulis" name="penulis" placeholder="Nama penulis">
                </div>
                <div class="field">
                    <label for="tahun_terbit">Tahun Terbit</label>
                    <input type="number" id="tahun_terbit" name="tahun_terbit" placeholder="Contoh: 2020">
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" id="btn-simpan" class="btn btn-primary">Tambah Buku</button>
                <button type="button" id="btn-batal" class="btn btn-reset" hidden>Batal</button>
            </div>
        </form>
    </section>
    @endcan

    <script>
               const API_URL       = @json(url('/api/buku'));
        const BISA_KELOLA   = @json(auth()->user()->can('kelola data buku'));
        const CSRF_TOKEN    = document.querySelector('meta[name="csrf-token"]').content;
        const HEADER_ACCEPT = { 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF_TOKEN };
        const HEADER_JSON   = { 'Accept': 'application/json', 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF_TOKEN };

        const form       = document.getElementById('form-buku');
        const elPesan    = document.getElementById('pesan');
        const judulForm  = document.getElementById('judul-form');
        const btnSimpan  = document.getElementById('btn-simpan');
        const btnBatal   = document.getElementById('btn-batal');
        const tbody      = document.getElementById('tabel-body');
        const btnPrev    = document.getElementById('btn-prev');
        const btnNext    = document.getElementById('btn-next');
        const infoHal    = document.getElementById('info-halaman');

        let halamanSekarang = 1;
        let idDiubah = null;
        let timerPesan = null;

     
        function tampilPesan(teks, tipe) {
    clearTimeout(timerPesan);
    elPesan.textContent = teks;
    elPesan.className = 'alert alert-' + tipe;
    elPesan.hidden = false;

    if (tipe === 'sukses') {
        timerPesan = setTimeout(sembunyikanPesan, 3000);
    }
}

        function sembunyikanPesan() {
            elPesan.hidden = true;
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

        function buatTombol(teks, kelas, aksi) {
            const btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'btn btn-sm ' + kelas;
            btn.textContent = teks;
            btn.addEventListener('click', aksi);
            return btn;
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
                tdAksi.append(
                    buatTombol('Ubah', 'btn-warning', () => mulaiUbah(buku)),
                    buatTombol('Hapus', 'btn-danger', () => hapusBuku(buku))
                );
            }

            tr.appendChild(tdAksi);
            tbody.appendChild(tr);
        });
    }

    infoHal.textContent = `Halaman ${meta.current_page} dari ${meta.last_page} (${meta.total} buku)`;
    btnPrev.disabled = meta.current_page <= 1;
    btnNext.disabled = meta.current_page >= meta.last_page;
}


      
        async function muatBuku(halaman = 1, keAkhir = false) {
            try {
                const response = await fetch(`${API_URL}?page=${halaman}`, { headers: HEADER_ACCEPT });
                if (!response.ok) {
                    throw new Error(await ambilPesanError(response));
                }

                               const hasil = await response.json();

               
                if (keAkhir && hasil.meta.current_page < hasil.meta.last_page) {
                    return muatBuku(hasil.meta.last_page);
                }

             
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

    
        function resetForm() {
            form.reset();
            idDiubah = null;
            judulForm.textContent = 'Tambah Buku';
            btnSimpan.textContent = 'Tambah Buku';
            btnBatal.hidden = true;
        }

        function mulaiUbah(buku) {
            idDiubah = buku.id;
            form.elements.kategori_id.value  = buku.id_kategori;
            form.elements.judul.value        = buku.judul;
            form.elements.penulis.value      = buku.penulis;
            form.elements.tahun_terbit.value = buku.tahun;

            judulForm.textContent = 'Ubah Buku';
            btnSimpan.textContent = 'Simpan Perubahan';
            btnBatal.hidden = false;

            sembunyikanPesan();
            form.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }

            if (BISA_KELOLA) form.addEventListener('submit', async (e) => {
            e.preventDefault();

            const sedangUbah = idDiubah !== null;
            const url        = sedangUbah ? `${API_URL}/${idDiubah}` : API_URL;
            const payload    = {
                kategori_id:  form.elements.kategori_id.value,
                judul:        form.elements.judul.value.trim(),
                penulis:      form.elements.penulis.value.trim(),
                tahun_terbit: form.elements.tahun_terbit.value,
            };

            btnSimpan.disabled = true;
            try {
             
                const response = await fetch(url, {
                    method: sedangUbah ? 'PUT' : 'POST',
                    headers: HEADER_JSON,
                    body: JSON.stringify(payload),
                });

                if (!response.ok) {
                    throw new Error(await ambilPesanError(response));
                }

                tampilPesan(sedangUbah ? 'Buku berhasil diperbarui.' : 'Buku berhasil ditambahkan.', 'sukses');
                resetForm();
              await muatBuku(sedangUbah ? halamanSekarang : 1, !sedangUbah);
            } catch (err) {
                tampilPesan(pesanDariError(err), 'gagal');
            } finally {
                btnSimpan.disabled = false;
            }
        });

        if (BISA_KELOLA) btnBatal.addEventListener('click', () => {
            resetForm();
            sembunyikanPesan();
        });

       
        async function hapusBuku(buku) {
            if (!confirm(`Yakin ingin menghapus buku "${buku.judul}"?`)) {
                return;
            }

            try {
                const response = await fetch(`${API_URL}/${buku.id}`, {
                    method: 'DELETE',
                    headers: HEADER_ACCEPT,
                });

                if (!response.ok) {
                    throw new Error(await ambilPesanError(response));
                }

                if (idDiubah === buku.id) {
                    resetForm();
                }
                tampilPesan('Buku berhasil dihapus.', 'sukses');
                await muatBuku(halamanSekarang);
            } catch (err) {
                tampilPesan(pesanDariError(err), 'gagal');
            }
        }

      
        btnPrev.addEventListener('click', () => muatBuku(halamanSekarang - 1));
        btnNext.addEventListener('click', () => muatBuku(halamanSekarang + 1));

        muatBuku(1);
    </script>
@endsection