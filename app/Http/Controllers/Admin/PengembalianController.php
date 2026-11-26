<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JadwalPenggunaan;
use App\Models\Jurusan;
use App\Models\Pengembalian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

        // Filter berdasarkan Departemen / Jurusan aktif
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

        // Ambil daftar jurusan aktif untuk pilihan di dropdown filter
        $jurusans = Jurusan::where('status', 'aktif')
            ->orderBy('nama_jurusan')
            ->get();

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
        $pengembalian->load([
            'peminjaman.user.jurusan',
            'peminjaman.detailPeminjamans.sarana',
        ]);

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

        $validated = $request->validate([
            'kondisi_pengembalian' => 'required|string|max:100',
            'kelayakan'            => 'nullable|array',
            'kelayakan.*'          => 'string|max:100',
            'catatan'              => 'nullable|string|max:1000',
        ]);

        DB::transaction(function () use ($validated, $pengembalian) {
            // Ubah array checklist kelayakan menjadi teks agar aman di kolom string/text maupun cast array
            $kelayakanText = !empty($validated['kelayakan'])
                ? implode(', ', $validated['kelayakan'])
                : null;

            $isKondisiBaik = $validated['kondisi_pengembalian'] === 'baik';

            // 1. Update status tabel pengembalian menjadi selesai
            $pengembalian->update([
                'admin_id'             => auth()->id(),
                'tanggal_pengembalian' => now(),
                'kondisi_pengembalian' => $validated['kondisi_pengembalian'],
                'kelayakan'            => $kelayakanText,
                'catatan'              => $validated['catatan'] ?? null,
                'status'               => 'selesai',
            ]);

            // 2. Otomatis update status peminjaman menjadi selesai
            if ($pengembalian->peminjaman) {
                $pengembalian->peminjaman->update([
                    'status' => 'selesai',
                ]);
            }

            // 3. Kembalikan stok jumlah_tersedia ke sarana jika kondisi baik
            $pengembalian->loadMissing('peminjaman.detailPeminjamans.sarana');
            if ($pengembalian->peminjaman && $isKondisiBaik) {
                foreach ($pengembalian->peminjaman->detailPeminjamans as $detail) {
                    if (!$detail->sarana) {
                        continue;
                    }

                    $sisaKuotaBisaKembali = max(0, $detail->sarana->jumlah - $detail->sarana->jumlah_tersedia);
                    $tambahStok = min($detail->jumlah, $sisaKuotaBisaKembali);

                    if ($tambahStok > 0) {
                        $detail->sarana->increment('jumlah_tersedia', $tambahStok);
                    }
                }
            }

            // 4. Ubah status jadwal_penggunaans terkait menjadi selesai
            if (!empty($pengembalian->peminjaman_id)) {
                JadwalPenggunaan::where('peminjaman_id', $pengembalian->peminjaman_id)
                    ->update([
                        'status' => 'selesai',
                    ]);
            }
        });

        return redirect()
            ->route('admin.pengembalian.index')
            ->with('success', 'Pengembalian barang berhasil diverifikasi, stok diperbarui, dan status jadwal menjadi selesai.');
    }
}