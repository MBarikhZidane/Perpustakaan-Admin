<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Penulis>
 */
class PenulisFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama' => $this->faker->name(),
            'tahun' => $this->faker->year(),
            'tipe' => $this->faker->randomElement(['Personal Name', 'Organization Body', 'Conference']),
            'kategori' => $this->faker->randomElement(['Primary Author', 'Additional Author', 'Editor', 'Translator', 'Director', 'Producer', 'Composer', 'Illustrator', 'Creator', 'Contributor Name']),
        ];
    }
}
