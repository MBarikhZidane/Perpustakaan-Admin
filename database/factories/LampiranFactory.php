<?php

namespace Database\Factories;

use App\Models\Bibliografi;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Lampiran>
 */
class LampiranFactory extends Factory
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
            'judul' => $this->faker->sentence(3),
            'nama_file' => $this->faker->lexify('file????.pdf'),
            'deskripsi' => $this->faker->sentence(),
            'tipe_akses' => $this->faker->randomElement(['Public', 'Private']),
        ];
    }
}
