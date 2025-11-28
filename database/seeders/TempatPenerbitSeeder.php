<?php

namespace Database\Seeders;

use App\Models\TempatPenerbit;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TempatPenerbitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TempatPenerbit::factory()->count(5)->create();
    }
}
