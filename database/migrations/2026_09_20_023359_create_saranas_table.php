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
        Schema::create('saranas', function (Blueprint $table) {
            $table->id();

            $table->foreignId('jurusan_id')->constrained('jurusans')->cascadeOnDelete();
            $table->string('nama_sarana');
            $table->string('kode_sarana',50)->unique();
            $table->unsignedInteger('jumlah')->default(0);
            $table->unsignedInteger('jumlah_tersedia')->default(0);
            $table->enum('kondisi', [
                'baik',
                'rusak_ringan',
                'rusak_berat'
            ])->default('baik');
            $table->enum('status', [
                'tersedia',
                'tidak_tersedia'
            ]);
            $table->string('lokasi')->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('gambar')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('saranas');
    }
};
