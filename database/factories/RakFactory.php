<?php

namespace Database\Factories;

use App\Models\Lokasi;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Rak>
 */
class RakFactory extends Factory
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
            'kode_rak' => $this->faker->unique()->bothify('RAK##'),
            'nama_rak' => $this->faker->word(),
            'lokasi_id' => Lokasi::factory()->create()->kode_lokasi,
        ];
    }
}
