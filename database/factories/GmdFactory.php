<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Gmd>
 */
class GmdFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'kode_gmd' => $this->faker->unique()->bothify('GMD-?#?#'),
            'nama_gmd' => $this->faker->randomElement(['Text', 'Audio', 'Video', 'Multimedia']),
        ];
    }
}
