<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_jurusan',
        'kode_jurusan',
        'kompetensi_keahlian',
        'status',
        'deskripsi',
        'gambar',
    ];

   public function users()
    {
        return $this->hasMany(User::class);
    }

    public function sarana()
    {
        return $this->hasMany(Sarana::class);
    }
}
