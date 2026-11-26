<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Sarana;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Statistik Utama (Cards Atas)
        $totalSarana = (int) Sarana::sum('jumlah');
        $saranaTersedia = (int) Sarana::sum('jumlah_tersedia');
        $sedangDipinjam = max(0, $totalSarana - $saranaTersedia);
        $pengajuanMenunggu = Peminjaman::where('status', 'menunggu')->count();

        // 2. Kondisi Sarpras (sesuaikan dengan nilai enum kondisi di tabel saranas)
        $kondisiRusak = Sarana::whereIn('kondisi', ['rusak_ringan', 'rusak_berat'])->sum('jumlah');
        $kondisiPerbaikan = Sarana::where('status', 'perbaikan')->sum('jumlah');
        $kondisiHilang = Sarana::where('status', 'hilang')->sum('jumlah');

        // 3. Tenggat Pengembalian (Peminjaman berstatus disetujui yang belum selesai)
       $tenggatPengembalian = Peminjaman::with(['user', 'detailPeminjamans.sarana', 'pengembalian'])
        ->whereIn('status', ['disetujui', 'sedang_dipinjam', 'terlambat'])
        ->whereDoesntHave('pengembalian', function ($q) {
            $q->where('status', 'selesai');
        })
        ->orderBy('tanggal_peminjaman', 'asc')
        ->orderBy('waktu_selesai', 'asc')
        ->take(4)
        ->get();

        // 4. Aktivitas Terbaru (5 pengajuan/peminjaman terakhir)
        $aktivitasTerbaru = Peminjaman::with(['user', 'detailPeminjamans.sarana'])
            ->latest()
            ->take(5)
            ->get();

        // 5. Data Chart 3 Bulan Terakhir
        $bulan = [];
        $jumlahPeminjam = [];
        $sisaStok = [];

        for ($i = 2; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $bulan[] = $date->translatedFormat('F');

            $peminjamBulanIni = Peminjaman::whereYear('tanggal_peminjaman', $date->year)
                ->whereMonth('tanggal_peminjaman', $date->month)
                ->whereIn('status', ['disetujui', 'selesai'])
                ->count();

            $jumlahPeminjam[] = $peminjamBulanIni;
            $sisaStok[] = $saranaTersedia;
        }

        return view('admin.dashboard', compact(
            'totalSarana',
            'saranaTersedia',
            'sedangDipinjam',
            'pengajuanMenunggu',
            'kondisiRusak',
            'kondisiPerbaikan',
            'kondisiHilang',
            'tenggatPengembalian',
            'aktivitasTerbaru',
            'bulan',
            'jumlahPeminjam',
            'sisaStok'
        ));
    }
}
