<?php

namespace Database\Seeders;

use App\Models\TransaksiDenda;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TransaksiDendaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Anggota::factory()->count(3)->create();
        TransaksiDenda::factory()->count(20)->create();
    }
}
