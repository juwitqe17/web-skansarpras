<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sarana;     // Sesuaikan dengan nama model Sarana/Barang kamu
use App\Models\Peminjaman; // Sesuaikan dengan nama model Peminjaman/Pengajuan kamu
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
{
    $totalSarana = Sarana::sum('jumlah');
    $saranaTersedia = Sarana::where('status', 'tersedia')->sum('jumlah');
    $sedangDipinjam = Peminjaman::where('status', 'dipinjam')->count();
    $pengajuanMenunggu = Peminjaman::where('status', 'menunggu')->count();

    // Data grafik untuk 3 bulan terakhir
    $bulan = ['Juni', 'Juli', 'Agustus'];
    $jumlahPeminjam = [0, 0, 0]; // Sesuaikan dengan logika query kamu
    $sisaStok = [$saranaTersedia, $saranaTersedia, $saranaTersedia];

    return view('admin.dashboard', compact(
        'totalSarana',
        'saranaTersedia',
        'sedangDipinjam',
        'pengajuanMenunggu',
        'bulan',
        'jumlahPeminjam',
        'sisaStok'
    ));
}
}