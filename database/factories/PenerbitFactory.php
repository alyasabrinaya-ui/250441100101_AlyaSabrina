<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PenerbitFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nama' => fake()->company(),
            'alamat' => fake()->address(),
        ];
    }
}