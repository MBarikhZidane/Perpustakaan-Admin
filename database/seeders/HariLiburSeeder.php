<?php

namespace Database\Seeders;

use App\Models\HariLibur;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class HariLiburSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        HariLibur::factory()->count(10)->create();
    }
}
