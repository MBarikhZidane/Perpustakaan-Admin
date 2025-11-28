<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\StatusItem>
 */
class StatusItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'kode_status' => $this->faker->unique()->bothify('ST##'),
            'nama_status' => $this->faker->randomElement(['Available', 'Loaned', 'Reserved', 'Lost']),
            'aturan' => $this->faker->sentence(),
            'is_not_dipinjamkan' => $this->faker->boolean(),
            'is_skip_stockopname' => $this->faker->boolean(),
        ];
    }
}
