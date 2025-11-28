<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TransaksiPemesanan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TransaksiPemesananSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Anggota::factory()->count(3)->create();
        \App\Models\Bibliografi::factory()->count(3)->create();
        \App\Models\Item::factory()->count(3)->create();
        \App\Models\TipeAnggota::factory()->count(3)->create();
        TransaksiPemesanan::factory()->count(15)->create();
    }
}
