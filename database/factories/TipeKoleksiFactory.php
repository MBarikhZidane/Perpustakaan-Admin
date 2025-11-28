<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TipeKoleksi>
 */
class TipeKoleksiFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'idz' => $this->faker->bothify('TK##'),
            'nama_tipe_koleksi' => $this->faker->randomElement(['Book', 'Magazine', 'Thesis', 'CD', 'DVD']),
            'urutan' => (string) $this->faker->numberBetween(0, 9),
            'kd_group_konter' => $this->faker->bothify('GC##'),
            'prefix' => $this->faker->randomElement([null, 'BK', 'MG']),
            'nama_group_konter' => $this->faker->sentence(2),
        ];
    }
}
