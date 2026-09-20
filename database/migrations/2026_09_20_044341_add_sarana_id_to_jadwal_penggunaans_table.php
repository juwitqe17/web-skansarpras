<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('jadwal_penggunaans', function (Blueprint $table) {
            $table->foreignId('sarana_id')
                ->after('peminjaman_id')
                ->constrained('saranas')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('jadwal_penggunaans', function (Blueprint $table) {
            $table->dropForeign(['sarana_id']);
            $table->dropColumn('sarana_id');
        });
    }
};