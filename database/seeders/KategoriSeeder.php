<?php

namespace Database\Seeders;

use App\Models\Kategori;
use Illuminate\Database\Seeder;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
      
        Kategori::factory()
            ->count(5)
            ->sequence(
                ['nama' => 'Keuangan'],
                ['nama' => 'Sastra'],
                ['nama' => 'Novel'],
                ['nama' => 'Pemrograman'],
                ['nama' => 'Psikologi'],
            )
            ->create();
    }
}