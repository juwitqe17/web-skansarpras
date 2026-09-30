<?php

namespace App\Http\Controllers\Peminjam;

use App\Http\Controllers\Controller;
use App\Models\Pengembalian;

class PengembalianController extends Controller
{
    public function index()
    {
        $pengembalians = Pengembalian::with([
            'peminjaman.detailPeminjamans.sarana',
            'admin',
        ])
            ->whereHas('peminjaman', function ($query) {
                $query->where('user_id', auth()->id());
            })
            ->latest('tanggal_pengembalian')
            ->paginate(10);

        return view(
            'peminjam.pengembalian.index',
            compact('pengembalians')
        );
    }

    public function show(Pengembalian $pengembalian)
    {
        abort_unless(
            $pengembalian->peminjaman->user_id === auth()->id(),
            403
        );

        $pengembalian->load([
            'peminjaman.detailPeminjamans.sarana',
            'admin',
        ]);

        return view(
            'peminjam.pengembalian.show',
            compact('pengembalian')
        );
    }
}