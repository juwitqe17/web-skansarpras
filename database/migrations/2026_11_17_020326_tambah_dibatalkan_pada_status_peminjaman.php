<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Semua nilai lama + 'dibatalkan'
        DB::statement("ALTER TABLE peminjaman MODIFY status ENUM('menunggu','disetujui','ditolak','sedang_dipinjam','selesai','terlambat','dibatalkan') NOT NULL DEFAULT 'menunggu'");
    }

    public function down(): void
    {
        // Data 'dibatalkan' dipindah dulu agar rollback tidak gagal
        DB::table('peminjaman')->where('status', 'dibatalkan')->update(['status' => 'ditolak']);

        DB::statement("ALTER TABLE peminjaman MODIFY status ENUM('menunggu','disetujui','ditolak','sedang_dipinjam','selesai','terlambat') NOT NULL DEFAULT 'menunggu'");
    }
};