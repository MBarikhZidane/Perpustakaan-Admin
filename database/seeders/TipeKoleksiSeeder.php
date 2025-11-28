<?php

namespace Database\Seeders;

use App\Models\TipeKoleksi;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TipeKoleksiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TipeKoleksi::factory()->count(5)->create();
    }
}
