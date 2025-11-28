<?php

namespace Database\Seeders;

use App\Models\Lampiran;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class LampiranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Bibliografi::factory()->count(3)->create();
        Lampiran::factory()->count(10)->create();
    }
}
