<?php

namespace Database\Seeders;

use App\Models\Anggota;
use App\Models\TipeAnggota;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AnggotaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TipeAnggota::factory()->count(3)->create();
        Anggota::factory()->count(10)->create();
    }
}
