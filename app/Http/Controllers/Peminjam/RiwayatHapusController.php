<?php

// Simpan sebagai: app/Http/Controllers/Peminjam/RiwayatHapusController.php

namespace App\Http\Controllers\Peminjam;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;

class RiwayatHapusController extends Controller
{
    // Hanya pengajuan yang sudah berakhir yang boleh dihapus dari riwayat
    private const BOLEH_DIHAPUS = ['ditolak', 'dibatalkan', 'selesai'];

    /**
     * Hapus satu pengajuan dari riwayat milik user.
     * Data tidak benar-benar dihapus: hanya disembunyikan dari riwayat peminjam,
     * sehingga data admin (laporan, jadwal, stok) tetap utuh.
     */
    public function destroy(Peminjaman $peminjaman)
    {
        abort_unless((int) $peminjaman->user_id === (int) auth()->id(), 403);

        if (! in_array($peminjaman->status, self::BOLEH_DIHAPUS, true)) {
            return redirect()->route('peminjam.riwayat.index')
                ->with('error', 'Pengajuan yang masih berjalan tidak bisa dihapus. Batalkan dulu jika masih menunggu.');
        }

        // updated_at tidak diubah agar urutan data di sisi admin tidak bergeser
        Peminjaman::withoutTimestamps(function () use ($peminjaman) {
            $peminjaman->forceFill(['dihapus_peminjam_at' => now()])->save();
        });

        return redirect()->route('peminjam.riwayat.index')
            ->with('success', 'Pengajuan dihapus dari riwayat.');
    }

    /**
     * Hapus sekaligus semua riwayat user yang sudah selesai, ditolak, atau dibatalkan.
     */
    public function bersihkan()
    {
        $jumlah = Peminjaman::withoutTimestamps(function () {
            return Peminjaman::where('user_id', auth()->id())
                ->whereIn('status', self::BOLEH_DIHAPUS)
                ->whereNull('dihapus_peminjam_at')
                ->update(['dihapus_peminjam_at' => now()]);
        });

        return redirect()->route('peminjam.riwayat.index')
            ->with('success', $jumlah > 0
                ? "{$jumlah} riwayat berhasil dihapus."
                : 'Tidak ada riwayat yang bisa dihapus.');
    }
}