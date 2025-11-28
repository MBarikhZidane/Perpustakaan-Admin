<?php

namespace Database\Seeders;

use App\Models\Bibliografi;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BibliografiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Gmd::factory()->count(2)->create();
        \App\Models\Bahasa::factory()->count(2)->create();
        \App\Models\TipeKoleksi::factory()->count(2)->create();
        \App\Models\Frekuensi::factory()->count(2)->create();
        Bibliografi::factory()->count(10)->create();
    }
}
