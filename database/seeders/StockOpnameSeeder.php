<?php

namespace Database\Seeders;

use App\Models\StockOpname;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class StockOpnameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        StockOpname::factory()->count(5)->create();
    }
}
