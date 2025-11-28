<?php

namespace Database\Factories;

use App\Models\Gmd;
use App\Models\TipeAnggota;
use App\Models\TipeKoleksi;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AturanPeminjaman>
 */
class AturanPeminjamanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'member_type_id' => TipeAnggota::factory(),
            'coll_type_id' => TipeKoleksi::factory(),
            'gmd_id' => Gmd::factory(),
            'loan_limit' => $this->faker->numberBetween(1, 10),
            'loan_periode' => $this->faker->numberBetween(7, 30),
            'reborrow_limit' => $this->faker->numberBetween(0, 3),
            'fine_each_day' => $this->faker->randomFloat(2, 1000, 10000),
            'grace_periode' => $this->faker->numberBetween(0, 5),
        ];
    }
}
