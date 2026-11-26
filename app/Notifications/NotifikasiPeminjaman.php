<?php

// Simpan sebagai: app/Notifications/NotifikasiPeminjaman.php

namespace App\Notifications;

use App\Models\Peminjaman;
use Carbon\Carbon;
use Illuminate\Notifications\Notification;

class NotifikasiPeminjaman extends Notification
{
    /**
     * @param string      $jenis        disetujui | ditolak | pengingat | tenggat | terlambat | selesai
     * @param string      $judul        Judul singkat di dropdown
     * @param string      $pesan        Isi pesan
     * @param int|null    $peminjamanId Dipakai agar pengingat tidak terkirim dobel
     * @param string|null $url          Tujuan saat notifikasi diklik (path relatif)
     */
    public function __construct(
        public string $jenis,
        public string $judul,
        public string $pesan,
        public ?int $peminjamanId = null,
        public ?string $url = null,
    ) {}

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toDatabase($notifiable): array
    {
        return [
            'jenis'         => $this->jenis,
            'judul'         => $this->judul,
            'pesan'         => $this->pesan,
            'peminjaman_id' => $this->peminjamanId,
            'url'           => $this->url,
        ];
    }

    /** Menyusun notifikasi lengkap (judul dan pesan) untuk satu peminjaman. */
    public static function dari(string $jenis, Peminjaman $p): self
    {
        $nama = self::namaSarana($p);
        $mulai = substr((string) $p->waktu_mulai, 0, 5);
        $selesai = substr((string) $p->waktu_selesai, 0, 5);
        $tanggal = Carbon::parse($p->tanggal_peminjaman)->locale('id')->translatedFormat('d F Y');
        $alasan = filled($p->catatan) ? " Alasan: {$p->catatan}" : '';

        [$judul, $pesan] = match ($jenis) {
            'disetujui' => ['Pengajuan disetujui', "Pengajuan peminjaman {$nama} pada {$tanggal} pukul {$mulai}–{$selesai} telah disetujui. Silakan ambil barang sesuai jadwal."],
            'ditolak'   => ['Pengajuan ditolak', "Pengajuan peminjaman {$nama} ditolak.{$alasan}"],
            'pengingat' => ['Tenggat pengembalian sebentar lagi', "Peminjaman {$nama} berakhir pukul {$selesai}. Siapkan barang untuk dikembalikan."],
            'tenggat'   => ['Waktunya mengembalikan barang', "Tenggat peminjaman {$nama} sudah tiba (pukul {$selesai}). Kembalikan barang ke toolman sekarang."],
            'terlambat' => ['Pengembalian terlambat', "Peminjaman {$nama} sudah melewati tenggat pukul {$selesai}. Segera kembalikan barang ke toolman."],
            'selesai'   => ['Peminjaman selesai', "Peminjaman {$nama} telah selesai. Terima kasih sudah mengembalikan barang."],
            default     => ['Notifikasi', "Ada pembaruan pada peminjaman {$nama}."],
        };

        return new self($jenis, $judul, $pesan, $p->id, route('peminjam.riwayat.show', $p, false));
    }

    public static function namaSarana(Peminjaman $p): string
    {
        return $p->detailPeminjamans
            ->map(fn ($d) => $d->sarana->nama_sarana ?? null)
            ->filter()
            ->join(', ') ?: 'barang';
    }
}