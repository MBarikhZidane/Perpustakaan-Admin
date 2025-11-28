<?php

namespace Database\Seeders;

use App\Models\Rak;
use App\Models\Lokasi;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RakSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Lokasi::factory()->count(3)->create();
        Rak::factory()->count(10)->create();
    }
}
