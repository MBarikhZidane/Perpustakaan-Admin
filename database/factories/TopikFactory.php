<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Topik>
 */
class TopikFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
       return [
            'nama_topik' => $this->faker->word(),
            'tipe_topik' => $this->faker->randomElement(['Topic', 'Geographic', 'Name', 'Temporal', 'Genre', 'Occupation']),
            'kategori_topik' => $this->faker->randomElement(['Primary', 'Additional']),
        ];
    }
}
