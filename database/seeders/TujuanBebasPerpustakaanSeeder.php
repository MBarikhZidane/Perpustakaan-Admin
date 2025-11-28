<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TujuanBebasPerpustakaan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TujuanBebasPerpustakaanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TujuanBebasPerpustakaan::factory()->count(5)->create();
    }
}
