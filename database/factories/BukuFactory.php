<?php

namespace Database\Factories;

use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Buku>
 */
class BukuFactory extends Factory
{
    public function definition(): array
    {
        return [
            'kategori_id'  => Kategori::inRandomOrder()->value('id'),
            'judul'        => ucwords(fake()->words(3, true)),
            'penulis'      => fake()->name(),
            'tahun_terbit' => fake()->numberBetween(1980, 2025),
        ];
    }
}