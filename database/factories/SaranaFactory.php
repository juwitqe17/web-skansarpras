<?php

namespace Database\Factories;

use App\Models\Jurusan;
use Illuminate\Database\Eloquent\Factories\Factory;

class SaranaFactory extends Factory
{
    public function definition(): array
    {
        $jumlah = $this->faker->numberBetween(5, 50);
        $tersedia = $this->faker->numberBetween(0, $jumlah);

        return [
            'jurusan_id' => Jurusan::inRandomOrder()->first()->id ?? Jurusan::factory(),
            'kode_sarana' => strtoupper($this->faker->bothify('???-###')),
            'nama_sarana' => $this->faker->words(3, true),
            'jumlah' => $jumlah,
            'jumlah_tersedia' => $tersedia,
            'kondisi' => $this->faker->randomElement(['baik', 'rusak_ringan', 'rusak_berat']),
            'status' => 'tersedia',
            'lokasi' => 'Lab ' . $this->faker->randomDigitNotNull(),
            'deskripsi' => $this->faker->sentence(),
            'gambar' => null,
        ];
    }
}
