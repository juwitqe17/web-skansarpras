<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengembalian;
use Illuminate\Http\Request;

class PengembalianController extends Controller
{
    /**
     * Daftar pengembalian.
     */
    public function index(Request $request)
    {
        $query = Pengembalian::with([
            'peminjaman.user.jurusan',
            'peminjaman.detailPeminjamans.sarana',
            'admin',
        ]);

        if ($request->filled('search')) {
            $search = $request->search;

            $query->whereHas('peminjaman.user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $pengembalians = $query
            ->latest('tanggal_pengembalian')
            ->paginate(10)
            ->withQueryString();

        return view(
            'admin.pengembalian.index',
            compact('pengembalians')
        );
    }

    /**
     * Detail pengembalian.
     */
    public function show(Pengembalian $pengembalian)
    {
        $pengembalian->load([
            'peminjaman.user.jurusan',
            'peminjaman.detailPeminjamans.sarana',
            'admin',
        ]);

        return view(
            'admin.pengembalian.show',
            compact('pengembalian')
        );
    }

    /**
     * Proses pengembalian.
     */
    public function process(Request $request, Pengembalian $pengembalian)
    {
        $validated = $request->validate([
            'kondisi_pengembalian' => 'required|string',
            'catatan' => 'nullable|string',
        ]);

        if ($pengembalian->status === 'selesai') {
            return redirect()
                ->back()
                ->with('error', 'Pengembalian ini sudah diproses.');
        }

        $pengembalian->update([
            'admin_id' => auth()->id(),
            'tanggal_pengembalian' => now(),
            'kondisi_pengembalian' => $validated['kondisi_pengembalian'],
            'status' => 'selesai',
            'catatan' => $validated['catatan'] ?? null,
        ]);

        return redirect()
            ->back()
            ->with('success', 'Pengembalian berhasil diproses.');
    }
}
