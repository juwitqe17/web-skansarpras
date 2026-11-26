<?php

// Simpan sebagai: app/Observers/PeminjamanObserver.php (buat folder Observers jika belum ada)

namespace App\Observers;

use App\Models\Peminjaman;
use App\Notifications\NotifikasiPeminjaman;

class PeminjamanObserver
{
    /**
     * Dipanggil otomatis setiap kali data peminjaman disimpan.
     * Notifikasi dikirim hanya saat status BERUBAH, jadi kode admin yang sudah ada
     * tidak perlu diubah.
     */
    public function updated(Peminjaman $peminjaman): void
    {
        if (! $peminjaman->wasChanged('status')) {
            return;
        }

        $jenis = match ($peminjaman->status) {
            'disetujui' => 'disetujui',
            'ditolak'   => 'ditolak',
            'selesai'   => 'selesai',
            default     => null,
        };

        if ($jenis && $peminjaman->user) {
            $peminjaman->user->notify(NotifikasiPeminjaman::dari($jenis, $peminjaman));
        }
    }
}