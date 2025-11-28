<?php

namespace Database\Factories;

use App\Models\Item;
use App\Models\Anggota;
use App\Models\Bibliografi;
use App\Models\TipeAnggota;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TransaksiPemesanan>
 */
class TransaksiPemesananFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'member_id' => Anggota::factory()->create()->member_id,
            'bibliografi_id' => Bibliografi::factory(),
            'kode_item' => $this->faker->optional()->passthrough(function () {
                return Item::factory()->create()->kode_item;
            }),
            'reserve_date' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'tipe_member_id' => TipeAnggota::factory(),
            'is_mendapatkan' => $this->faker->boolean(),
        ];
    }
}
