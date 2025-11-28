<?php

namespace Database\Factories;

use App\Models\Penulis;
use App\Models\Bibliografi;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BibliografiPenulis>
 */
class BibliografiPenulisFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'bibliografi_id' => Bibliografi::factory(),
            'penulis_id' => Penulis::factory(),
            'tipe' => $this->faker->randomElement(['P', 'S', 'E']),
            'level' => $this->faker->randomElement([null, '1', '2', '3']),
            'kategori' => $this->faker->randomElement([null, 'A', 'B', 'C']),
        ];
    }
}
