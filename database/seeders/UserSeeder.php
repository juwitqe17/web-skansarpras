<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin Sarpras',
            'email' => 'admin@sarpras.test',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'jurusan_id' => null,
            'kelas' => null,
            'no_hp' => '081234567890',
        ]);

        User::create([
            'name' => 'Juwita',
            'email' => 'siswa@sarpras.test',
            'password' => Hash::make('password123'),
            'role' => 'peminjam',
            'jurusan_id' => 1,
            'kelas' => 'XII RPL 1',
            'no_hp' => '081234567891',
        ]);
    }
}