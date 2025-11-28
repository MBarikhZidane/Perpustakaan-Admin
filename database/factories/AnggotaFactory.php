<?php

namespace Database\Factories;

use App\Models\TipeAnggota;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Anggota>
 */
class AnggotaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'member_id' => $this->faker->unique()->regexify('[A-Z0-9]{10}'),
            'nama' => $this->faker->name(),
            'tipe_anggota_id' => TipeAnggota::factory(),
            'kelas' => function () {
                $tingkat = $this->faker->randomElement(['X', 'XI', 'XII']);
                $jurusan = $this->faker->randomElement(['RPL', 'TPM', 'TKJ', 'TSM', 'DKV']);
                $nomor   = $this->faker->numberBetween(1, 9);

                return "{$tingkat} {$jurusan} {$nomor}";
            },
            'alamat' => $this->faker->address(),
            'telepon' => $this->faker->phoneNumber(),
            'is_pending' => $this->faker->boolean(),
            'status_marker' => $this->faker->boolean(),
        ];
    }
}
