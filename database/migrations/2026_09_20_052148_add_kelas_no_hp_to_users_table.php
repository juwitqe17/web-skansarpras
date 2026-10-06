<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'kelas')) {
                $table->string('kelas')->nullable()->after('jurusan_id');
            }

            if (!Schema::hasColumn('users', 'no_hp')) {
                $table->string('no_hp')->nullable()->after('kelas');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'no_hp')) {
                $table->dropColumn('no_hp');
            }

            if (Schema::hasColumn('users', 'kelas')) {
                $table->dropColumn('kelas');
            }
        });
    }
};