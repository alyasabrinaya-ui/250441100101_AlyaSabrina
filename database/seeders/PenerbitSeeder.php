<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Penerbit;

class PenerbitSeeder extends Seeder
{
    public function run(): void
    {
        Penerbit::create([
            'nama' => 'Gramedia',
            'alamat' => 'Jakarta'
        ]);

        Penerbit::create([
            'nama' => 'Erlangga',
            'alamat' => 'Jakarta'
        ]);
    }
}