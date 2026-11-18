<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pengembalian extends Model
{
    use HasFactory;

    protected $fillable = [
        'peminjaman_id',
        'admin_id',
        'tanggal_pengembalian',
        'kondisi_pengembalian',
        'status',
        'kelayakan', // <--- Tambahkan ini agar bisa disimpan ke database
        'catatan',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_pengembalian' => 'datetime',
            'kelayakan'            => 'array', // <--- Tambahkan ini agar otomatis dibaca sebagai array/JSON
        ];
    }

    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class);
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}