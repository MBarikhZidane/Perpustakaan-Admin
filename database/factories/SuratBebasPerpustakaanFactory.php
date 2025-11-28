<?php

namespace Database\Factories;

use App\Models\Anggota;
use App\Models\TujuanBebasPerpustakaan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SuratBebasPerpustakaan>
 */
class SuratBebasPerpustakaanFactory extends Factory
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
            'tanggal' => $this->faker->date(),
            'member_id' => Anggota::factory()->create()->member_id,
            'tujuan_id' => TujuanBebasPerpustakaan::factory(),
            'nomor_surat' => $this->faker->bothify('SURAT##'),
            'id_penerima' => $this->faker->uuid(),
        ];
    }
}
