<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KonfigurasiPenomoran;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class KonfigurasiPenomoranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        KonfigurasiPenomoran::factory()->count(5)->create();
    }
}
