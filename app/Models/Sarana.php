<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sarana extends Model
{
    use HasFactory;

    protected $fillable = [
        'jurusan_id',
        'nama_sarana',
        'kode_sarana',
        'jumlah',
        'jumlah_tersedia',
        'kondisi',
        'status',
        'lokasi',
        'deskripsi',
        'gambar',
    ];

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class);
    }

    public function detailPeminjamans()
    {
        return $this->hasMany(DetailPeminjaman::class, 'sarana_id');
    }

    public function jadwalPenggunaans()
    {
        return $this->hasMany(JadwalPenggunaan::class, 'sarana_id');
    }
}