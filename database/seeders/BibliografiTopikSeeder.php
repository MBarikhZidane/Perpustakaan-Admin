<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BibliografiTopik;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BibliografiTopikSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Bibliografi::factory()->count(2)->create();
        \App\Models\Topik::factory()->count(2)->create();
        BibliografiTopik::factory()->count(10)->create();
    }
}
