<?php

namespace Database\Seeders;

use App\Models\Bahasa;
use App\Models\Frekuensi;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class FrekuensiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Bahasa::factory()->count(3)->create();
        Frekuensi::factory()->count(5)->create();
    }
}
