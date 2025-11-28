<?php

namespace Database\Factories;

use App\Models\Topik;
use App\Models\Bibliografi;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BibliografiTopik>
 */
class BibliografiTopikFactory extends Factory
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
            'topik_id' => Topik::factory(),
            'tipe' => $this->faker->randomElement(['P', 'S', 'E']),
            'level' => $this->faker->randomElement([null, '1', '2', '3']),
            'kategori' => $this->faker->randomElement([null, 'A', 'B', 'C']),
        ];
    }
}
