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
     * Menampilkan form verifikasi pengembalian.
     */
    public function verify(Pengembalian $pengembalian)
    {
        return view('admin.pengembalian.verify', compact('pengembalian'));
    }

    /**
     * Memproses dan menyimpan data verifikasi pengembalian.
     */
    public function process(Request $request, Pengembalian $pengembalian)
    {
        $request->validate([
            'kondisi_pengembalian' => 'required',
            'catatan'              => 'nullable|string',
        ]);

        $pengembalian->update([
            'kondisi_pengembalian' => $request->kondisi_pengembalian,
            'catatan'              => $request->catatan,
            'status'               => 'selesai', // Status otomatis jadi 'selesai' setelah diverifikasi
        ]);

        return redirect()->route('admin.pengembalian.index')->with('success', 'Pengembalian barang berhasil diverifikasi.');
    }
}