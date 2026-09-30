<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JadwalPenggunaan;
use App\Models\Jurusan;
use Illuminate\Http\Request;

class JadwalPenggunaanController extends Controller
{
    public function index(Request $request)
    {
        $query = JadwalPenggunaan::with([
            'peminjaman.user.jurusan',
            'sarana.jurusan',
        ]);

        if ($request->filled('jurusan_id')) {
            $query->whereHas('sarana', function ($q) use ($request) {
                $q->where('jurusan_id', $request->jurusan_id);
            });
        }

        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal', $request->tanggal);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $jadwals = $query
            ->orderBy('tanggal')
            ->orderBy('waktu_mulai')
            ->paginate(10)
            ->withQueryString();

        $jurusans = Jurusan::where('status', 'aktif')
            ->orderBy('nama_jurusan')
            ->get();

        return view(
            'admin.jadwal.index',
            compact('jadwals', 'jurusans')
        );
    }

    public function show(JadwalPenggunaan $jadwalPenggunaan)
    {
        $jadwalPenggunaan->load([
            'peminjaman.user.jurusan',
            'sarana.jurusan',
        ]);

        return view(
            'admin.jadwal.show',
            compact('jadwalPenggunaan')
        );
    }
}