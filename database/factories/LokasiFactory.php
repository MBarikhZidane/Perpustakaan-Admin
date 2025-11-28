<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Lokasi>
 */
class LokasiFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'kode_lokasi' => $this->faker->unique()->bothify('LOK###??'),
            'nama_lokasi' => $this->faker->city(),
            'is_sgd' => $this->faker->boolean(),
        ];
    }
}
