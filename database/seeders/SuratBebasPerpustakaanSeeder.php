<?php

namespace Database\Seeders;

use App\Models\Anggota;
use Illuminate\Database\Seeder;
use App\Models\SuratBebasPerpustakaan;
use App\Models\TujuanBebasPerpustakaan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SuratBebasPerpustakaanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Anggota::factory()->count(3)->create();
        TujuanBebasPerpustakaan::factory()->count(3)->create();
        SuratBebasPerpustakaan::factory()->count(5)->create();
    }
}
