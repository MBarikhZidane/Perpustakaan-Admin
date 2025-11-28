<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TipeAnggota>
 */
class TipeAnggotaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama_tipe' => $this->faker->unique()->word(),
            'limit_peminjaman' => $this->faker->numberBetween(1, 10),
            'periode_peminjaman' => $this->faker->numberBetween(7, 30),
            'is_boleh_pesan' => $this->faker->boolean(),
            'limit_pemesanan' => $this->faker->numberBetween(1, 5),
            'periode_member' => $this->faker->numberBetween(30, 365),
            'limit_pinjam_ulang' => $this->faker->numberBetween(0, 3),
            'denda_per_hari' => $this->faker->randomFloat(2, 5000, 10000),
            'masa_tenggang' => $this->faker->numberBetween(0, 5),
            'is_siswa' => $this->faker->boolean(),
            'is_guru' => $this->faker->boolean(),
            'is_karyawan' => $this->faker->boolean(),
            'is_external' => $this->faker->boolean(),
        ];
    }
}
