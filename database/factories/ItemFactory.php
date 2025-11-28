<?php

namespace Database\Factories;

use App\Models\Rak;
use App\Models\Lokasi;
use App\Models\Supplier;
use App\Models\StatusItem;
use App\Models\Bibliografi;
use App\Models\TipeKoleksi;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Item>
 */
class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'kode_item' => $this->faker->unique()->bothify('ITM####'),
            'bibliografi_id' => Bibliografi::factory(),
            'call_number' => $this->faker->bothify('CN##'),
            'kode_inventori' => $this->faker->bothify('INV####'),
            'lokasi_id' => Lokasi::factory()->create()->kode_lokasi,
            'rak_id' => Rak::factory(),
            'tipe_koleksi_id' => TipeKoleksi::factory(),
            'status_id' => StatusItem::factory(),
            'nmr_order' => $this->faker->optional()->bothify('ORD####'),
            'tgl_order' => $this->faker->optional()->date(),
            'tgl_penerimaan' => $this->faker->optional()->date(),
            'supplier_id' => Supplier::factory(),
            'source' => $this->faker->optional()->word(),
            'invoice' => $this->faker->optional()->bothify('INV####'),
            'tgl_invoice' => $this->faker->optional()->date(),
            'harga' => $this->faker->randomFloat(2, 10000, 200000),
            'harga_currency' => $this->faker->randomElement(['IDR', 'USD', 'EUR']),
            'is_fotocopy' => $this->faker->boolean(),
            'status_marker' => $this->faker->boolean(),
        ];
    }
}
