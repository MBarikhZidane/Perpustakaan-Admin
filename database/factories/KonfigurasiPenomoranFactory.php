<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\KonfigurasiPenomoran>
 */
class KonfigurasiPenomoranFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'idz' => $this->faker->bothify('IDZ##'),
            'kode_group' => $this->faker->unique()->bothify('GRP##'),
            'nama_group' => $this->faker->sentence(2),
            'konter' => $this->faker->numberBetween(0, 100),
        ];
    }
}
