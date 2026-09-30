<?php

namespace Database\Seeders;

use App\Models\Jurusan;
use App\Models\Sarana;
use Illuminate\Database\Seeder;

class JurusanAndSaranaSeeder extends Seeder
{
    public function run(): void
    {
        $jurusans = [
            [
                'nama_jurusan' => 'Rekayasa Perangkat Lunak',
                'kode_jurusan' => 'RPL',
                'kompetensi_keahlian' => 'Pengembangan Perangkat Lunak dan Gim',
                'status' => 'aktif',
                'deskripsi' => 'Jurusan pemrograman dan rekayasa lunak.',
            ],
            [
                'nama_jurusan' => 'Teknik Komputer dan Jaringan',
                'kode_jurusan' => 'TKJ',
                'kompetensi_keahlian' => 'Teknik Jaringan Komputer dan Telekomunikasi',
                'status' => 'aktif',
                'deskripsi' => 'Jurusan jaringan dan infrastruktur IT.',
            ],
            [
                'nama_jurusan' => 'Tata Boga',
                'kode_jurusan' => 'TB',
                'kompetensi_keahlian' => 'Kuliner dan Pengolahan Makanan',
                'status' => 'aktif',
                'deskripsi' => 'Jurusan pengolahan dan penyajian makanan.',
            ],
        ];

        foreach ($jurusans as $dataJurusan) {
            // Menggunakan firstOrCreate berdasarkan 'kode_jurusan' agar tidak bentrok Unique Constraint
            $jurusan = Jurusan::firstOrCreate(
                ['kode_jurusan' => $dataJurusan['kode_jurusan']],
                $dataJurusan
            );

            // Isi Sarana jika belum ada
            if ($jurusan->kode_jurusan === 'RPL') {
                Sarana::firstOrCreate(
                    ['kode_sarana' => 'RPL-NET-048'],
                    [
                        'jurusan_id' => $jurusan->id,
                        'nama_sarana' => 'Laptop ASUS ROG Strix G15',
                        'jumlah' => 48,
                        'jumlah_tersedia' => 40,
                        'kondisi' => 'baik',
                        'status' => 'tersedia',
                        'lokasi' => 'Lab Komputer RPL 1',
                        'deskripsi' => 'Ryzen 7 6800H, RTX 3060, 16GB DDR5, SSD 512GB',
                    ]
                );

                Sarana::firstOrCreate(
                    ['kode_sarana' => 'RPL-MON-012'],
                    [
                        'jurusan_id' => $jurusan->id,
                        'nama_sarana' => 'Monitor LG 24 Inch IPS',
                        'jumlah' => 15,
                        'jumlah_tersedia' => 12,
                        'kondisi' => 'baik',
                        'status' => 'tersedia',
                        'lokasi' => 'Lab Komputer RPL 2',
                        'deskripsi' => '1080p 75Hz Ergonomic Stand',
                    ]
                );
            } else {
                // Tambahkan sarana random jika jurusan belum memiliki sarana
                if ($jurusan->sarana()->count() === 0) {
                    Sarana::factory()->count(5)->create([
                        'jurusan_id' => $jurusan->id
                    ]);
                }
            }
        }
    }
}
