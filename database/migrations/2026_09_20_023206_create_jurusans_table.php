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
        Schema::create('jurusans', function (Blueprint $table) {
            $table->id();

            $table->string('nama_jurusan');
            $table->string('kode_jurusan', 20)->unique();
            $table->string('kompetensi_keahlian')->nullable();
            $table->enum('status', [
                'aktif',
                'tidak_aktif'
            ])->default('aktif');
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
        Schema::dropIfExists('jurusans');
    }
};
