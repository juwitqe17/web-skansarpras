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
        Schema::create('jadwal_penggunaans', function (Blueprint $table) {
            $table->id();

            $table->foreignId('peminjaman_id')->constrained('peminjaman')->cascadeOnDelete();
            $table->date('tanggal');
            $table->time('waktu_mulai');
            $table->time('waktu_selesai');
            $table->enum('status', [
                'berlangsung',
                'selesai'
            ])->default('berlangsung');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_penggunaans');
    }
};
