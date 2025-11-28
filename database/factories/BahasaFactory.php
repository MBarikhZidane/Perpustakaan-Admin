<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Bahasa>
 */
class BahasaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
         return [
            'kode_bahasa' => $this->faker->unique()->languageCode(),
            'nama_bahasa' => $this->faker->languageCode(),
        ];
    }
}
