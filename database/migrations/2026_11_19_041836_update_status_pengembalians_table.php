
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    
    public function up(): void
    {
        // 1. Tambahkan pilihan ENUM baru terlebih dahulu
        DB::statement("
            ALTER TABLE pengembalians
            MODIFY status ENUM(
                'sesuai',
                'rusak',
                'terlambat',
                'menunggu_verifikasi',
                'selesai'
            ) NOT NULL DEFAULT 'menunggu_verifikasi'
        ");

        // 2. Ubah status lama setelah ENUM diperbarui
        DB::table('pengembalians')
            ->where('status', 'sesuai')
            ->update(['status' => 'selesai']);

        // 3. Rapikan pilihan ENUM
        DB::statement("
            ALTER TABLE pengembalians
            MODIFY status ENUM(
                'menunggu_verifikasi',
                'selesai'
            ) NOT NULL DEFAULT 'menunggu_verifikasi'
        ");
    }

    public function down(): void
    {
        DB::table('pengembalians')
            ->where('status', 'selesai')
            ->update(['status' => 'sesuai']);

        DB::statement("
            ALTER TABLE pengembalians
            MODIFY status ENUM(
                'sesuai',
                'rusak',
                'terlambat'
            ) NOT NULL DEFAULT 'sesuai'
        ");
    }
};
