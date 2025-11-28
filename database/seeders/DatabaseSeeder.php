<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'nama_pengguna' => 'YOMI',
                'username' => 'YOMI',
                'password' => Hash::make('YOMI'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        $this->call([
            AnggotaSeeder::class,
            AturanPeminjamanSeeder::class,
            BahasaSeeder::class,
            BibliografiPenulisSeeder::class,
            BibliografiSeeder::class,
            BibliografiTopikSeeder::class,
            FrekuensiSeeder::class,
            GmdSeeder::class,
            HariLiburSeeder::class,
            ItemSeeder::class,
            KonfigurasiPenomoranSeeder::class,
            LampiranSeeder::class,
            LokasiSeeder::class,
            PeminjamanSeeder::class,
            PenerbitSeeder::class,
            PenulisSeeder::class,
            RakSeeder::class,
            StatusItemSeeder::class,
            StockOpnameSeeder::class,
            SupplierSeeder::class,
            SuratBebasPerpustakaanSeeder::class,
            TempatPenerbitSeeder::class,
            TipeAnggotaSeeder::class,
            TipeKoleksiSeeder::class,
            TopikSeeder::class,
            TransaksiDendaSeeder::class,
            TransaksiPemesananSeeder::class,
            TujuanBebasPerpustakaanSeeder::class,
        ]);
    }
}
