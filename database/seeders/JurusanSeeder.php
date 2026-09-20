<?php

namespace Database\Seeders;

use App\Models\Jurusan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JurusanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Jurusan::create([
            'nama_jurusan' => 'Rekayasa Perangkat Lunak',
            'kode_jurusan' => 'RPL',
            'kompetensi_keahlian' => 'Pengembangan Perangkat Lunak dan Gim',
            'deskripsi' => 'Kategori sarana dan prasarana untuk jurusan Rekayasa Perangkat Lunak.',
        ]);

        Jurusan::create([
            'nama_jurusan' => 'Agriteknologi Tanaman Pangan dan Hortikultura',
            'kode_jurusan' => 'ATPH',
            'kompetensi_keahlian' => 'Agriteknologi Tanaman Pangan dan Hortikultura',
            'deskripsi' => 'Kategori sarana dan prasarana untuk jurusan ATPH.',
        ]);

        Jurusan::create([
            'nama_jurusan' => 'Desain Komunikasi Visual',
            'kode_jurusan' => 'DKV',
            'kompetensi_keahlian' => 'Desain Komunikasi Visual',
            'deskripsi' => 'Kategori sarana dan prasarana untuk jurusan DKV.',
        ]);

        Jurusan::create([
            'nama_jurusan' => 'Teknik Kendaraan Ringan',
            'kode_jurusan' => 'TKR',
            'kompetensi_keahlian' => 'Teknik Kendaraan Ringan',
            'deskripsi' => 'Kategori sarana dan prasarana untuk jurusan TKR.',
        ]);
    }
}
