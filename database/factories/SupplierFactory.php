<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Supplier>
 */
class SupplierFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama_supplier' => $this->faker->company(),
            'alamat' => $this->faker->address(),
            'kodepos' => $this->faker->postcode(),
            'telepon' => $this->faker->phoneNumber(),
            'kontak' => $this->faker->name(),
            'fax' => $this->faker->phoneNumber(),
            'account' => $this->faker->bankAccountNumber(),
            'email' => $this->faker->email(),
        ];
    }
}
