<?php

namespace Database\Factories;

use App\Models\Anggota;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TransaksiDenda>
 */
class TransaksiDendaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'tanggal' => $this->faker->date(),
            'member_id' => Anggota::factory()->create()->member_id,
            'debet' => $this->faker->randomFloat(2, 0, 100000),
            'kredit' => $this->faker->randomFloat(2, 0, 100000),
            'keterangan' => $this->faker->sentence(),
            'status' => $this->faker->randomElement(['Paid', 'Unpaid', 'Pending']),
        ];
    }
}
