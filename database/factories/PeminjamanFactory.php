<?php

namespace Database\Factories;

use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Peminjaman;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

/**
 * @extends Factory<Peminjaman>
 */
class PeminjamanFactory extends Factory
{
        public function definition(): array
    {
        $tanggalPinjam = Carbon::instance(fake()->dateTimeBetween('-1 month', 'now'));

        $tanggalKembali = fake()->boolean(70)
            ? $tanggalPinjam->copy()->addDays(fake()->numberBetween(1, 14))->toDateString()
            : null;

        return [
            'anggota_id'      => Anggota::inRandomOrder()->value('id'),
            'buku_id'         => Buku::inRandomOrder()->value('id'),
            'tanggal_pinjam'  => $tanggalPinjam->toDateString(),
            'tanggal_kembali' => $tanggalKembali,
            'status'          => $tanggalKembali ? 'dikembalikan' : 'dipinjam',
        ];

    }
}