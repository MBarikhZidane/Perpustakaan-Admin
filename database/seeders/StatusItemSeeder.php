<?php

namespace Database\Seeders;

use App\Models\StatusItem;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class StatusItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        StatusItem::factory()->count(4)->create();
    }
}
