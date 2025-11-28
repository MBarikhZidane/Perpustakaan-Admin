<?php

namespace Database\Seeders;

use App\Models\Item;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Bibliografi::factory()->count(3)->create();
        \App\Models\Lokasi::factory()->count(3)->create();
        \App\Models\Rak::factory()->count(3)->create();
        \App\Models\TipeKoleksi::factory()->count(3)->create();
        \App\Models\StatusItem::factory()->count(3)->create();
        \App\Models\Supplier::factory()->count(3)->create();
        Item::factory()->count(20)->create();
    }
}
