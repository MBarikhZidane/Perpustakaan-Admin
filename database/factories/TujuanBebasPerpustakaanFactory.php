<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TujuanBebasPerpustakaan>
 */
class TujuanBebasPerpustakaanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
          return [
            'kode_tujuan' => $this->faker->unique()->bothify('TJP##'),
            'nama_tujuan' => $this->faker->sentence(3),
            'idz' => $this->faker->bothify('IDZ##'),
        ];
    }
}
