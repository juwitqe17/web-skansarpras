<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Penanda "dihapus dari riwayat peminjam". Data peminjaman tetap ada untuk admin.
        Schema::table('peminjaman', function (Blueprint $table) {
            $table->timestamp('dihapus_peminjam_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('peminjaman', function (Blueprint $table) {
            $table->dropColumn('dihapus_peminjam_at');
        });
    }
};