<?php

namespace Database\Seeders;

use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Database\Seeder;

class BukuSeeder extends Seeder
{
    public function run(): void
    {
        
        $kategori = Kategori::pluck('id', 'nama');

       
        $dataBuku = [
            ['judul' => 'The Psychology of Money',          'penulis' => 'Morgan Housel',                 'tahun_terbit' => 2020, 'kategori' => 'Keuangan'],
            ['judul' => 'Bumi Manusia',                     'penulis' => 'Pramoedya Ananta Toer',         'tahun_terbit' => 1980, 'kategori' => 'Sastra'],
            ['judul' => 'Cantik Itu Luka',                  'penulis' => 'Eka Kurniawan',                 'tahun_terbit' => 2002, 'kategori' => 'Novel'],
            ['judul' => 'Clean Code',                       'penulis' => 'Robert C. Martin',              'tahun_terbit' => 2008, 'kategori' => 'Pemrograman'],
            ['judul' => 'Berani Tidak Disukai',             'penulis' => 'Ichiro Kishimi & Fumitake Koga', 'tahun_terbit' => 2013, 'kategori' => 'Psikologi'],
            ['judul' => 'Laut Bercerita',                   'penulis' => 'Leila S. Chudori',              'tahun_terbit' => 2017, 'kategori' => 'Novel'],
            ['judul' => 'Nanti Kita Cerita Tentang Hari Ini', 'penulis' => 'Marchella F.P.',              'tahun_terbit' => 2018, 'kategori' => 'Novel'],
            ['judul' => 'The Pragmatic Programme',          'penulis' => 'David Thomas & Andrew Hunt',    'tahun_terbit' => 2017, 'kategori' => 'Pemrograman'],
        ];

    
        $baris = array_map(fn ($buku) => [
            'kategori_id'  => $kategori[$buku['kategori']],
            'judul'        => $buku['judul'],
            'penulis'      => $buku['penulis'],
            'tahun_terbit' => $buku['tahun_terbit'],
        ], $dataBuku);

     
        Buku::factory()
            ->count(count($baris))
            ->sequence(...$baris)
            ->create();
    }
}