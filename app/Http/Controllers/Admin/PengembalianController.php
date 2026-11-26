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

    // Filter berdasarkan Pencarian Nama Peminjam
    if ($request->filled('search')) {
        $search = $request->search;
        $query->whereHas('peminjaman.user', function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%");
        });
    }

    // Filter berdasarkan Status
    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    // Filter berdasarkan Departemen / Jurusan baru
    if ($request->filled('jurusan_id')) {
        $jurusanId = $request->jurusan_id;
        $query->whereHas('peminjaman.user', function ($q) use ($jurusanId) {
            $q->where('jurusan_id', $jurusanId);
        });
    }

    $pengembalians = $query
        ->latest('tanggal_pengembalian')
        ->paginate(10)
        ->withQueryString();

    // Ambil daftar jurusan untuk pilihan di dropdown filter
    $jurusans = \App\Models\Jurusan::all(); 

    return view(
        'admin.pengembalian.index',
        compact('pengembalians', 'jurusans')
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
        if ($pengembalian->status === 'selesai') {
            return redirect()
                ->route('admin.pengembalian.index')
                ->with('error', 'Pengembalian ini sudah diverifikasi sebelumnya.');
        }

        $request->validate([
            'kondisi_pengembalian' => 'required',
            'kelayakan'            => 'nullable|array',
            'catatan'              => 'nullable|string',
        ]);

        \Illuminate\Support\Facades\DB::transaction(function () use ($request, $pengembalian) {
            // 1. Update status tabel pengembalian menjadi selesai
            $pengembalian->update([
                'kondisi_pengembalian' => $request->kondisi_pengembalian,
                'kelayakan'            => $request->kelayakan,
                'catatan'              => $request->catatan,
                'status'               => 'selesai',
            ]);

            // 2. OTOMATIS UPDATE STATUS PEMINJAMAN MENJADI SELESAI
            $pengembalian->peminjaman()->update([
                'status' => 'selesai',
            ]);

            // 3. Kembalikan stok jumlah_tersedia ke sarana
            $pengembalian->loadMissing('peminjaman.detailPeminjamans.sarana');
            if ($pengembalian->peminjaman) {
                foreach ($pengembalian->peminjaman->detailPeminjamans as $detail) {
                    if (!$detail->sarana) {
                        continue;
                    }

                    // Cegah jumlah_tersedia melebihi total jumlah unit barang
                    $sisaKuotaBisaKembali = max(0, $detail->sarana->jumlah - $detail->sarana->jumlah_tersedia);
                    $tambahStok = min($detail->jumlah, $sisaKuotaBisaKembali);

                    if ($tambahStok > 0) {
                        $detail->sarana->increment('jumlah_tersedia', $tambahStok);
                    }
                }
            }
        });

        return redirect()->route('admin.pengembalian.index')->with('success', 'Pengembalian barang berhasil diverifikasi dan status peminjaman menjadi selesai.');
    }
}