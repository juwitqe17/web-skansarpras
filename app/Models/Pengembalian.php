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
        'catatan',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_pengembalian' => 'datetime',
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