<?php

namespace Database\Factories;

use App\Models\Item;
use App\Models\Anggota;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Peminjaman>
 */
class PeminjamanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $loanDate = $this->faker->dateTimeBetween('-1 year', 'now');
        $dueDate = (clone $loanDate)->modify('+7 days');

        return [
            'member_id' => Anggota::factory()->create()->member_id,
            'kode_item' => Item::factory()->create()->kode_item,
            'loan_date' => $loanDate->format('Y-m-d'),
            'duedate' => $dueDate->format('Y-m-d'),
            'return_date' => $this->faker->optional()->date(),
            'is_return' => $this->faker->boolean(),
        ];
    }
}
