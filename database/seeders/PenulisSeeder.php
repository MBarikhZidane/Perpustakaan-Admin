<?php

namespace Database\Seeders;

use App\Models\Penulis;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PenulisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Penulis::factory()->count(10)->create();
    }
}
