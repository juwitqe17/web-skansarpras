<?php

// Simpan sebagai: app/Console/Commands/IngatkanPeminjaman.php

namespace App\Console\Commands;

use App\Models\Peminjaman;
use App\Notifications\NotifikasiPeminjaman;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class IngatkanPeminjaman extends Command
{
    protected $signature = 'peminjaman:ingatkan';

    protected $description = 'Kirim notifikasi tenggat pengembalian dan keterlambatan ke peminjam';

    // Jam di form peminjaman diisi dalam WIB, jadi perbandingan waktu juga memakai WIB
    private const ZONA = 'Asia/Jakarta';

    // Status peminjaman yang dianggap masih berjalan. Ubah di sini jika alur status Anda berbeda.
    private const STATUS_BERJALAN = ['disetujui', 'sedang_dipinjam', 'terlambat'];

    private const MENIT_PENGINGAT = 30; // pengingat dikirim 30 menit sebelum tenggat
    private const MENIT_TOLERANSI = 15; // lewat tenggat 15 menit = dianggap terlambat

    public function handle(): int
    {
        $sekarang = Carbon::now(self::ZONA);

        $daftar = Peminjaman::with(['user', 'detailPeminjamans.sarana'])
            ->whereIn('status', self::STATUS_BERJALAN)
            ->whereRaw(
                'TIMESTAMP(tanggal_peminjaman, waktu_selesai) <= ?',
                [$sekarang->copy()->addMinutes(self::MENIT_PENGINGAT)->toDateTimeString()]
            )
            ->whereRaw(
                'TIMESTAMP(tanggal_peminjaman, waktu_selesai) >= ?',
                [$sekarang->copy()->subDays(7)->toDateTimeString()]
            )
            ->get();

        $terkirim = 0;

        foreach ($daftar as $p) {
            if (! $p->user) {
                continue;
            }

            $batas = Carbon::parse(
                Carbon::parse($p->tanggal_peminjaman)->toDateString() . ' ' . $p->waktu_selesai,
                self::ZONA
            );

            // Hanya tahap yang sedang berlaku yang dikirim (tahap yang terlewat tidak dikirim susulan)
            $jenis = match (true) {
                $sekarang->gte($batas->copy()->addMinutes(self::MENIT_TOLERANSI)) => 'terlambat',
                $sekarang->gte($batas)                                            => 'tenggat',
                default                                                           => 'pengingat',
            };

            if ($this->sudahDikirim($p, $jenis)) {
                continue;
            }

            $p->user->notify(NotifikasiPeminjaman::dari($jenis, $p));
            $terkirim++;
        }

        $this->info("{$terkirim} notifikasi terkirim.");

        return self::SUCCESS;
    }

    private function sudahDikirim(Peminjaman $p, string $jenis): bool
    {
        return DB::table('notifications')
            ->where('type', NotifikasiPeminjaman::class)
            ->where('notifiable_id', $p->user_id)
            ->where('data->jenis', $jenis)
            ->where('data->peminjaman_id', $p->id)
            ->exists();
    }
}