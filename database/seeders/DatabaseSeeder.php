<?php

namespace Database\Seeders;

use App\Models\DetailPeminjaman;
use App\Models\JadwalPenggunaan;
use App\Models\Jurusan;
use App\Models\Pengembalian;
use App\Models\Peminjaman;
use App\Models\Persetujuan;
use App\Models\Sarana;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | 1. JURUSAN
        |--------------------------------------------------------------------------
        */

<<<<<<< HEAD
        $rpl = Jurusan::updateOrCreate(
            ['kode_jurusan' => 'RPL'],
            [
                'nama_jurusan' => 'Rekayasa Perangkat Lunak',
                'kompetensi_keahlian' => 'Pengembangan Perangkat Lunak dan Gim',
                'status' => 'aktif',
                'deskripsi' => 'Jurusan yang mempelajari pengembangan perangkat lunak, aplikasi web, mobile, dan teknologi digital.',
                'gambar' => null,
            ]
        );

        $tkj = Jurusan::updateOrCreate(
            ['kode_jurusan' => 'TKJ'],
            [
                'nama_jurusan' => 'Teknik Komputer dan Jaringan',
                'kompetensi_keahlian' => 'Teknik Komputer dan Jaringan',
                'status' => 'aktif',
                'deskripsi' => 'Jurusan yang mempelajari komputer, jaringan, server, dan infrastruktur teknologi informasi.',
                'gambar' => null,
            ]
        );

        $atph = Jurusan::updateOrCreate(
            ['kode_jurusan' => 'ATPH'],
            [
                'nama_jurusan' => 'Agribisnis Tanaman Pangan dan Hortikultura',
                'kompetensi_keahlian' => 'Agribisnis Tanaman Pangan dan Hortikultura',
                'status' => 'aktif',
                'deskripsi' => 'Jurusan yang mempelajari budidaya tanaman pangan dan hortikultura.',
                'gambar' => null,
            ]
        );

        $dkv = Jurusan::updateOrCreate(
            ['kode_jurusan' => 'DKV'],
            [
                'nama_jurusan' => 'Desain Komunikasi Visual',
                'kompetensi_keahlian' => 'Desain Komunikasi Visual',
                'status' => 'aktif',
                'deskripsi' => 'Jurusan yang mempelajari desain grafis, ilustrasi, fotografi, dan komunikasi visual.',
                'gambar' => null,
            ]
        );

        $tkr = Jurusan::updateOrCreate(
            ['kode_jurusan' => 'TKR'],
            [
                'nama_jurusan' => 'Teknik Kendaraan Ringan',
                'kompetensi_keahlian' => 'Teknik Kendaraan Ringan',
                'status' => 'aktif',
                'deskripsi' => 'Jurusan yang mempelajari perawatan dan perbaikan kendaraan ringan.',
                'gambar' => null,
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | 2. USER
        |--------------------------------------------------------------------------
        */

        $admin = User::updateOrCreate(
            ['email' => 'admin@sarpras.test'],
            [
                'name' => 'Admin Sarpras',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'jurusan_id' => null,
                'kelas' => null,
                'no_hp' => '081234567890',
            ]
        );

        $siswaRpl = User::updateOrCreate(
            ['email' => 'siswa.rpl@sarpras.test'],
            [
                'name' => 'Juwita',
                'password' => Hash::make('password123'),
                'role' => 'peminjam',
                'jurusan_id' => $rpl->id,
                'kelas' => 'XII RPL 1',
                'no_hp' => '081234567891',
            ]
        );

        $siswaTkj = User::updateOrCreate(
            ['email' => 'siswa.tkj@sarpras.test'],
            [
                'name' => 'Siswa TKJ',
                'password' => Hash::make('password123'),
                'role' => 'peminjam',
                'jurusan_id' => $tkj->id,
                'kelas' => 'XII TKJ 1',
                'no_hp' => '081234567892',
            ]
        );

        $siswaAtph = User::updateOrCreate(
            ['email' => 'siswa.atph@sarpras.test'],
            [
                'name' => 'Siswa ATPH',
                'password' => Hash::make('password123'),
                'role' => 'peminjam',
                'jurusan_id' => $atph->id,
                'kelas' => 'XII ATPH 1',
                'no_hp' => '081234567893',
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | 3. SARANA
        |--------------------------------------------------------------------------
        */

        $laptop = Sarana::updateOrCreate(
            ['kode_sarana' => 'RPL-LAP-001'],
            [
                'jurusan_id' => $rpl->id,
                'nama_sarana' => 'Laptop ASUS ROG Strix G15',
                'jumlah' => 20,
                'jumlah_tersedia' => 15,
                'kondisi' => 'baik',
                'status' => 'tersedia',
                'lokasi' => 'Lab Komputer RPL 1',
                'deskripsi' => 'Laptop untuk kegiatan pembelajaran pemrograman dan pengembangan aplikasi.',
                'gambar' => null,
            ]
        );

        $monitor = Sarana::updateOrCreate(
            ['kode_sarana' => 'RPL-MON-001'],
            [
                'jurusan_id' => $rpl->id,
                'nama_sarana' => 'Monitor LG 24 Inch',
                'jumlah' => 20,
                'jumlah_tersedia' => 18,
                'kondisi' => 'baik',
                'status' => 'tersedia',
                'lokasi' => 'Lab Komputer RPL 1',
                'deskripsi' => 'Monitor untuk kegiatan praktik komputer.',
                'gambar' => null,
            ]
        );

        $proyektor = Sarana::updateOrCreate(
            ['kode_sarana' => 'RPL-PRO-001'],
            [
                'jurusan_id' => $rpl->id,
                'nama_sarana' => 'Proyektor Epson',
                'jumlah' => 5,
                'jumlah_tersedia' => 4,
                'kondisi' => 'baik',
                'status' => 'tersedia',
                'lokasi' => 'Lab Komputer RPL 1',
                'deskripsi' => 'Proyektor untuk presentasi dan kegiatan pembelajaran.',
                'gambar' => null,
            ]
        );

        $router = Sarana::updateOrCreate(
            ['kode_sarana' => 'TKJ-RTR-001'],
            [
                'jurusan_id' => $tkj->id,
                'nama_sarana' => 'Router MikroTik',
                'jumlah' => 15,
                'jumlah_tersedia' => 10,
                'kondisi' => 'baik',
                'status' => 'tersedia',
                'lokasi' => 'Lab Jaringan TKJ',
                'deskripsi' => 'Router untuk praktik jaringan komputer.',
                'gambar' => null,
            ]
        );

        $switch = Sarana::updateOrCreate(
            ['kode_sarana' => 'TKJ-SWT-001'],
            [
                'jurusan_id' => $tkj->id,
                'nama_sarana' => 'Switch 24 Port',
                'jumlah' => 10,
                'jumlah_tersedia' => 8,
                'kondisi' => 'baik',
                'status' => 'tersedia',
                'lokasi' => 'Lab Jaringan TKJ',
                'deskripsi' => 'Switch jaringan untuk kegiatan praktik.',
                'gambar' => null,
            ]
        );

        $kamera = Sarana::updateOrCreate(
            ['kode_sarana' => 'DKV-KAM-001'],
            [
                'jurusan_id' => $dkv->id,
                'nama_sarana' => 'Kamera DSLR Canon',
                'jumlah' => 8,
                'jumlah_tersedia' => 6,
                'kondisi' => 'baik',
                'status' => 'tersedia',
                'lokasi' => 'Studio DKV',
                'deskripsi' => 'Kamera untuk kegiatan fotografi dan produksi visual.',
                'gambar' => null,
            ]
        );

        $tripod = Sarana::updateOrCreate(
            ['kode_sarana' => 'DKV-TRI-001'],
            [
                'jurusan_id' => $dkv->id,
                'nama_sarana' => 'Tripod Kamera',
                'jumlah' => 10,
                'jumlah_tersedia' => 9,
                'kondisi' => 'baik',
                'status' => 'tersedia',
                'lokasi' => 'Studio DKV',
                'deskripsi' => 'Tripod untuk mendukung kegiatan fotografi dan video.',
                'gambar' => null,
            ]
        );

        $atphTool = Sarana::updateOrCreate(
            ['kode_sarana' => 'ATPH-ALAT-001'],
            [
                'jurusan_id' => $atph->id,
                'nama_sarana' => 'Alat Penyemprot Tanaman',
                'jumlah' => 10,
                'jumlah_tersedia' => 8,
                'kondisi' => 'baik',
                'status' => 'tersedia',
                'lokasi' => 'Gudang ATPH',
                'deskripsi' => 'Peralatan untuk kegiatan praktik budidaya tanaman.',
                'gambar' => null,
            ]
        );

        $dongkrak = Sarana::updateOrCreate(
            ['kode_sarana' => 'TKR-DGK-001'],
            [
                'jurusan_id' => $tkr->id,
                'nama_sarana' => 'Dongkrak Hidrolik',
                'jumlah' => 6,
                'jumlah_tersedia' => 5,
                'kondisi' => 'baik',
                'status' => 'tersedia',
                'lokasi' => 'Bengkel TKR',
                'deskripsi' => 'Peralatan praktik perawatan kendaraan.',
                'gambar' => null,
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | 4. PEMINJAMAN - MENUNGGU
        |--------------------------------------------------------------------------
        */

        $pengajuanMenunggu = Peminjaman::updateOrCreate(
            [
                'user_id' => $siswaRpl->id,
                'tanggal_peminjaman' => now()->addDays(2)->toDateString(),
                'keperluan' => 'Praktik pemrograman aplikasi web',
            ],
            [
                'tanggal_pengajuan' => now(),
                'waktu_mulai' => '08:00',
                'waktu_selesai' => '10:00',
                'status' => 'menunggu',
                'catatan' => 'Digunakan untuk kegiatan praktik kelas.',
            ]
        );

        DetailPeminjaman::updateOrCreate(
            [
                'peminjaman_id' => $pengajuanMenunggu->id,
                'sarana_id' => $laptop->id,
            ],
            [
                'jumlah' => 2,
                'keterangan' => 'Untuk kelompok praktik.',
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | 5. PEMINJAMAN - DISETUJUI
        |--------------------------------------------------------------------------
        */

        $pengajuanDisetujui = Peminjaman::updateOrCreate(
            [
                'user_id' => $siswaRpl->id,
                'tanggal_peminjaman' => now()->addDays(3)->toDateString(),
                'keperluan' => 'Presentasi project',
            ],
            [
                'tanggal_pengajuan' => now()->subDays(1),
                'waktu_mulai' => '10:00',
                'waktu_selesai' => '12:00',
                'status' => 'disetujui',
                'catatan' => 'Digunakan untuk presentasi project.',
            ]
        );

        DetailPeminjaman::updateOrCreate(
            [
                'peminjaman_id' => $pengajuanDisetujui->id,
                'sarana_id' => $proyektor->id,
            ],
            [
                'jumlah' => 1,
                'keterangan' => 'Untuk presentasi.',
            ]
        );

        Persetujuan::updateOrCreate(
            [
                'peminjaman_id' => $pengajuanDisetujui->id,
            ],
            [
                'admin_id' => $admin->id,
                'status' => 'disetujui',
                'tanggal_persetujuan' => now()->subHours(5),
                'alasan' => 'Pengajuan disetujui.',
            ]
        );

        JadwalPenggunaan::updateOrCreate(
            [
                'peminjaman_id' => $pengajuanDisetujui->id,
                'sarana_id' => $proyektor->id,
            ],
            [
                'tanggal' => $pengajuanDisetujui->tanggal_peminjaman,
                'waktu_mulai' => $pengajuanDisetujui->waktu_mulai,
                'waktu_selesai' => $pengajuanDisetujui->waktu_selesai,
                'status' => 'berlangsung',
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | 6. PEMINJAMAN - DITOLAK
        |--------------------------------------------------------------------------
        */

        $pengajuanDitolak = Peminjaman::updateOrCreate(
            [
                'user_id' => $siswaTkj->id,
                'tanggal_peminjaman' => now()->addDays(4)->toDateString(),
                'keperluan' => 'Praktik jaringan komputer',
            ],
            [
                'tanggal_pengajuan' => now()->subDays(2),
                'waktu_mulai' => '13:00',
                'waktu_selesai' => '15:00',
                'status' => 'ditolak',
                'catatan' => 'Penggunaan untuk kegiatan praktik.',
            ]
        );

        DetailPeminjaman::updateOrCreate(
            [
                'peminjaman_id' => $pengajuanDitolak->id,
                'sarana_id' => $router->id,
            ],
            [
                'jumlah' => 3,
                'keterangan' => 'Untuk praktik jaringan.',
            ]
        );

        Persetujuan::updateOrCreate(
            [
                'peminjaman_id' => $pengajuanDitolak->id,
            ],
            [
                'admin_id' => $admin->id,
                'status' => 'ditolak',
                'tanggal_persetujuan' => now()->subDay(),
                'alasan' => 'Sarana sedang digunakan untuk kegiatan lain.',
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | 7. PEMINJAMAN - SELESAI
        |--------------------------------------------------------------------------
        */

        $pengajuanSelesai = Peminjaman::updateOrCreate(
            [
                'user_id' => $siswaRpl->id,
                'tanggal_peminjaman' => now()->subDays(5)->toDateString(),
                'keperluan' => 'Praktik desain aplikasi',
            ],
            [
                'tanggal_pengajuan' => now()->subDays(7),
                'waktu_mulai' => '08:00',
                'waktu_selesai' => '11:00',
                'status' => 'selesai',
                'catatan' => 'Penggunaan telah selesai.',
            ]
        );

        DetailPeminjaman::updateOrCreate(
            [
                'peminjaman_id' => $pengajuanSelesai->id,
                'sarana_id' => $monitor->id,
            ],
            [
                'jumlah' => 2,
                'keterangan' => 'Untuk praktik desain.',
            ]
        );

        Persetujuan::updateOrCreate(
            [
                'peminjaman_id' => $pengajuanSelesai->id,
            ],
            [
                'admin_id' => $admin->id,
                'status' => 'disetujui',
                'tanggal_persetujuan' => now()->subDays(6),
                'alasan' => 'Pengajuan disetujui.',
            ]
        );

        JadwalPenggunaan::updateOrCreate(
            [
                'peminjaman_id' => $pengajuanSelesai->id,
                'sarana_id' => $monitor->id,
            ],
            [
                'tanggal' => $pengajuanSelesai->tanggal_peminjaman,
                'waktu_mulai' => $pengajuanSelesai->waktu_mulai,
                'waktu_selesai' => $pengajuanSelesai->waktu_selesai,
                'status' => 'selesai',
            ]
        );

        Pengembalian::updateOrCreate(
            [
                'peminjaman_id' => $pengajuanSelesai->id,
            ],
            [
                'admin_id' => $admin->id,
                'tanggal_pengembalian' => now()->subDays(4),
                'kondisi_pengembalian' => 'baik',
                'status' => 'sesuai',
                'catatan' => 'Barang dikembalikan dalam kondisi baik.',
            ]
        );
=======
        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
>>>>>>> a2ae9526f8a48fe898a2ee22d648b47783f846fc
    }
}