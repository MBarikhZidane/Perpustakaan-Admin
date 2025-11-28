<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BibliografiPenulis;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BibliografiPenulisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Bibliografi::factory()->count(2)->create();
        \App\Models\Penulis::factory()->count(2)->create();
        BibliografiPenulis::factory()->count(10)->create();
    }
}
