<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JadwalPenggunaan;
use App\Models\Jurusan;
use Illuminate\Http\Request;
use Carbon\Carbon;

class JadwalPenggunaanController extends Controller
{
    public function index(Request $request)
    {
        $bulan = $request->filled('bulan')
            ? Carbon::createFromFormat('Y-m', $request->bulan)
            : now();

        $query = JadwalPenggunaan::with([
            'sarana.jurusan',
            'peminjaman.user',
        ]);

        // Filter jurusan
        if ($request->filled('jurusan_id')) {
            $query->whereHas('sarana', function ($q) use ($request) {
                $q->where('jurusan_id', $request->jurusan_id);
            });
        }

        // Filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search sarana / peminjam
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->whereHas('sarana', function ($q) use ($search) {
                    $q->where('nama_sarana', 'like', "%{$search}%")
                      ->orWhere('kode_sarana', 'like', "%{$search}%");
                })
                ->orWhereHas('peminjaman.user', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                });
            });
        }

        // Ambil jadwal dalam bulan yang sedang ditampilkan
        $jadwals = $query
            ->whereBetween('tanggal', [
                $bulan->copy()->startOfMonth(),
                $bulan->copy()->endOfMonth(),
            ])
            ->orderBy('tanggal')
            ->orderBy('waktu_mulai')
            ->get();

        $jurusans = Jurusan::where('status', 'aktif')
            ->orderBy('nama_jurusan')
            ->get();

        return view('admin.jadwal.index', [
            'jadwals' => $jadwals,
            'jurusans' => $jurusans,
            'bulan' => $bulan,
            'selectedJurusan' => $request->jurusan_id,
            'selectedStatus' => $request->status,
            'search' => $request->search,
        ]);
    }

    
}
