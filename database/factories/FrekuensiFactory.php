<?php

namespace Database\Factories;

use App\Models\Bahasa;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Frekuensi>
 */
class FrekuensiFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'frekuensi' => $this->faker->randomElement(['Daily', 'Weekly', 'Monthly', 'Yearly']),
            'language_prefix' => Bahasa::inRandomOrder()->value('kode_bahasa'),
            'time_increment' => $this->faker->numberBetween(1, 30),
            'time_unit' => $this->faker->randomElement(['days', 'weeks', 'months', 'years']),
        ];
    }
}
