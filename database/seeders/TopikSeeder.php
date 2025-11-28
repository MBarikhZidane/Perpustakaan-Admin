<?php

namespace Database\Seeders;

use App\Models\Topik;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TopikSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Topik::factory()->count(10)->create();
    }
}
