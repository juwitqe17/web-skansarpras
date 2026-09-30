<?php

namespace App\Http\Controllers\Peminjam;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class RiwayatController extends Controller
{
    public function index(Request $request)
    {
        $query = Peminjaman::with([
            'detailPeminjamans.sarana',
            'persetujuans.admin',
            'pengembalian',
        ])->where('user_id', auth()->id());

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $riwayats = $query
            ->latest('tanggal_peminjaman')
            ->paginate(10)
            ->withQueryString();

        return view(
            'peminjam.riwayat.index',
            compact('riwayats')
        );
    }

    public function show(Peminjaman $peminjaman)
    {
        abort_unless(
            $peminjaman->user_id === auth()->id(),
            403
        );

        $peminjaman->load([
            'detailPeminjamans.sarana',
            'persetujuans.admin',
            'pengembalian',
            'jadwalPenggunaans.sarana',
        ]);

        return view(
            'peminjam.riwayat.show',
            compact('peminjaman')
        );
    }
}