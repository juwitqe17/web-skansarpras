<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Persetujuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengajuanController extends Controller
{
    /**
     * Daftar semua pengajuan.
     */
    public function index(Request $request)
    {
        $query = Peminjaman::with([
            'user.jurusan',
            'detailPeminjamans.sarana',
            'persetujuans.admin',
        ]);

        // Search
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($userQuery) use ($search) {
                    $userQuery
                        ->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                })
                ->orWhere('keperluan', 'like', "%{$search}%");
            });
        }

        // Filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $pengajuans = $query
            ->latest('tanggal_pengajuan')
            ->paginate(10)
            ->withQueryString();

        return view('admin.pengajuan.index', compact('pengajuans'));
    }

    /**
     * Detail pengajuan.
     */
    public function show(Peminjaman $peminjaman)
    {
        $peminjaman->load([
            'user.jurusan',
            'detailPeminjamans.sarana',
            'persetujuans.admin',
            'jadwalPenggunaans.sarana',
            'pengembalian',
        ]);

        return view('admin.pengajuan.show', compact('peminjaman'));
    }

    /**
     * Setujui pengajuan.
     */
    public function approve(Peminjaman $peminjaman)
    {
        if ($peminjaman->status !== 'menunggu') {
            return redirect()
                ->back()
                ->with('error', 'Pengajuan ini sudah diproses.');
        }

        DB::transaction(function () use ($peminjaman) {

            $peminjaman->update([
                'status' => 'disetujui',
            ]);

            Persetujuan::create([
                'peminjaman_id' => $peminjaman->id,
                'admin_id' => auth()->id(),
                'status' => 'disetujui',
                'tanggal_persetujuan' => now(),
                'alasan' => null,
            ]);
        });

        return redirect()
            ->back()
            ->with('success', 'Pengajuan berhasil disetujui.');
    }

    /**
     * Tolak pengajuan.
     */
    public function reject(Request $request, Peminjaman $peminjaman)
    {
        $validated = $request->validate([
            'alasan' => 'required|string|max:500',
        ]);

        if ($peminjaman->status !== 'menunggu') {
            return redirect()
                ->back()
                ->with('error', 'Pengajuan ini sudah diproses.');
        }

        DB::transaction(function () use ($peminjaman, $validated) {

            $peminjaman->update([
                'status' => 'ditolak',
            ]);

            Persetujuan::create([
                'peminjaman_id' => $peminjaman->id,
                'admin_id' => auth()->id(),
                'status' => 'ditolak',
                'tanggal_persetujuan' => now(),
                'alasan' => $validated['alasan'],
            ]);
        });

        return redirect()
            ->back()
            ->with('success', 'Pengajuan berhasil ditolak.');
    }
}
