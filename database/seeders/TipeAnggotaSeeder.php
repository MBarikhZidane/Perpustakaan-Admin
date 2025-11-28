<?php

namespace Database\Seeders;

use App\Models\TipeAnggota;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TipeAnggotaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TipeAnggota::factory()->count(5)->create();
    }
}
