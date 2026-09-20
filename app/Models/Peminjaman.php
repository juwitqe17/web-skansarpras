<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    protected $table = 'peminjaman';
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjaman';

    protected $fillable = [
        'user_id',
        'tanggal_pengajuan',
        'tanggal_peminjaman',
        'waktu_mulai',
        'waktu_selesai',
        'keperluan',
        'status',
        'catatan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function detailPeminjamans()
    {
        return $this->hasMany(DetailPeminjaman::class, 'peminjaman_id');
    }

    public function persetujuans()
    {
        return $this->hasMany(Persetujuan::class, 'peminjaman_id');
    }

    public function jadwalPenggunaans()
    {
        return $this->hasMany(JadwalPenggunaan::class, 'peminjaman_id');
    }

    public function pengembalian()
    {
        return $this->hasOne(Pengembalian::class, 'peminjaman_id');
    }
}