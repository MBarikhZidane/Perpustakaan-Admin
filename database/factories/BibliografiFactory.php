<?php

namespace Database\Factories;

use App\Models\Gmd;
use App\Models\Bahasa;
use App\Models\Penerbit;
use App\Models\Frekuensi;
use App\Models\TipeKoleksi;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Bibliografi>
 */
class BibliografiFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'judul' => $this->faker->sentence(3),
            'edisi' => $this->faker->randomElement([null, '1st', '2nd', '3rd']),
            'isbn_issn' => $this->faker->isbn13(),
            'tahun_terbit' => $this->faker->year(),
            'collation' => $this->faker->sentence(2),
            'judul_seri' => $this->faker->sentence(3),
            'call_number' => $this->faker->bothify('CN##'),
            'gmd_id' => Gmd::factory(),
            'bahasa_id' => Bahasa::inRandomOrder()->value('kode_bahasa'),
            'tipe_koleksi_id' => TipeKoleksi::factory(),
            'penerbit_id' => Penerbit::factory(),
            'klasifikasi' => $this->faker->randomElement(['000', '100', '200', '300', '400', '500', '600', '700', '800', '900']),
            'catatan' => $this->faker->sentence(),
            'spec_detail_info' => $this->faker->sentence(),
            'frekuensi_id' => Frekuensi::factory(),
            'is_etalase_hide' => $this->faker->boolean(),
            'is_promosi' => $this->faker->boolean(),
            'gambar' => $this->faker->imageUrl(640, 480, 'books', true),
            'volume' => $this->faker->randomElement([null, 'Vol. 1', 'Vol. 2', 'Vol. 3']),
            'status_marker' => $this->faker->boolean(),
        ];
    }
}
