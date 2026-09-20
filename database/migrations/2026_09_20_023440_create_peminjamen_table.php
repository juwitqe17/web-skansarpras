<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('peminjaman', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->date('tanggal_pengajuan');
            $table->date('tanggal_peminjaman');
            //$table->date('tanggal_pengembalian');
            $table->time('waktu_mulai');
            $table->time('waktu_selesai');
            $table->text('keperluan');
            $table->enum('status', [
                'menunggu',
                'disetujui',
                'ditolak',
                'sedang_dipinjam',
                'selesai',
                'terlambat'
            ])->default('menunggu');
            $table->text('catatan')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjamen');
    }
};
