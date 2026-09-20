<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::rename('detail_peminjamen', 'detail_peminjaman');
    }

    public function down(): void
    {
        Schema::rename('detail_peminjaman', 'detail_peminjamen');
    }
};