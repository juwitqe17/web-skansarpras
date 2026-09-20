<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Persetujuan extends Model
{
    use HasFactory;

    protected $fillable = [
        'peminjaman_id',
        'admin_id',
        'status',
        'tanggal_persetujuan',
        'alasan',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_persetujuan' => 'datetime',
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