<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AturanPeminjaman;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AturanPeminjamanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\TipeAnggota::factory()->count(3)->create();
        \App\Models\TipeKoleksi::factory()->count(3)->create();
        \App\Models\Gmd::factory()->count(3)->create();
        AturanPeminjaman::factory()->count(10)->create();
    }
}
