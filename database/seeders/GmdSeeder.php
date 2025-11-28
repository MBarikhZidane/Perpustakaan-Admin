<?php

namespace Database\Seeders;

use App\Models\Gmd;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class GmdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Gmd::factory()->count(4)->create();
    }
}
