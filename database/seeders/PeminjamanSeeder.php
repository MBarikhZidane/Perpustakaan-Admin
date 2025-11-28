<?php

namespace Database\Seeders;

use App\Models\Peminjaman;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PeminjamanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Anggota::factory()->count(3)->create();
        \App\Models\Item::factory()->count(3)->create();
        Peminjaman::factory()->count(20)->create();
    }
}
