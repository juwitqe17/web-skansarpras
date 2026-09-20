<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalPenggunaan extends Model
{
    use HasFactory;

    protected $fillable = [
        'peminjaman_id',
        'sarana_id',
        'tanggal',
        'waktu_mulai',
        'waktu_selesai',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'tanggal' => 'date',
        ];
    }

    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class);
    }

    public function sarana()
    {
        return $this->belongsTo(Sarana::class);
    }
}
