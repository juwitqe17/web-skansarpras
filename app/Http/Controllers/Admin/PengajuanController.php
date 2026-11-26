<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Persetujuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Notifications\PengajuanDiproses;

class PengajuanController extends Controller
{
    /**
     * Daftar semua pengajuan.
     */
    public function index(Request $request)
    {
        // Query dasar untuk tabel peminjaman
        $query = Peminjaman::with([
            'user.jurusan',
            'detailPeminjamans.sarana',
            'persetujuans.admin',
        ]);

        // Filter berdasarkan Jurusan / Departemen
        if ($request->filled('jurusan_id')) {$query->whereHas('user', function ($q) use ($request) {
                $q->where('jurusan_id',$request->jurusan_id);
            });
        }

        // Search
        if ($request->filled('search')) {
            $search =$request->search;
            $query->where(function ($q) use ($search) {$q->whereHas('user', function ($userQuery) use ($search) {
                    $userQuery->where('name', 'like', "\%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                })
                ->orWhere('keperluan', 'like', "%{$search}%")
                ->orWhere('id', 'like', "%{$search}%");
            });
        }

        // Filter status
        if ($request->filled('status')) {
            $query->where('status',$request->status);
        }

        // Ambil data pengajuans dengan pagination
        $pengajuans =$query->latest('tanggal_pengajuan')->paginate(10)->withQueryString();

        // Data untuk Statistik Cards (bisa difilter berdasarkan jurusan juga jika dipilih)
        $statQuery = Peminjaman::query();
        if ($request->filled('jurusan_id')) {$statQuery->whereHas('user', function ($q) use ($request) {
                $q->where('jurusan_id',$request->jurusan_id);
            });
        }

        $totalPengajuan = (clone$statQuery)->count();
        $disetujuiHariIni = (clone$statQuery)->where('status', 'disetujui')
                                            ->whereDate('updated_at', today())
                                            ->count();
        $ditolakCount = (clone$statQuery)->where('status', 'ditolak')->count();
        $menungguCount = (clone$statQuery)->where('status', 'menunggu')->count();

        // Ambil daftar jurusan untuk dropdown pilihan
        $jurusans = \App\Models\Jurusan::all();

        return view('admin.pengajuan.index', compact(
            'pengajuans',
            'jurusans',
            'totalPengajuan',
            'disetujuiHariIni',
            'ditolakCount',
            'menungguCount'
        ));
    }

    /**
     * Detail pengajuan.
     */
    public function show($id)
    {
        $peminjaman = Peminjaman::with([
            'user',
            'detailPeminjamans.sarana',
            'persetujuans'
        ])->findOrFail($id);

        // Ambil alasan penolakan terbaru jika statusnya ditolak
        $latestPersetujuan = $peminjaman->persetujuans()->latest('tanggal_persetujuan')->first();
        $alasanTolak = ($peminjaman->status === 'ditolak' && $latestPersetujuan) ? $latestPersetujuan->alasan : null;

        return response()->json([
            'id' => $peminjaman->id,
            'status' => $peminjaman->status, // 'menunggu', 'disetujui', atau 'ditolak'
            'status_label' => ucfirst($peminjaman->status),
            'user_name' => $peminjaman->user->name ?? 'Peminjam',
            'user_email' => $peminjaman->user->email ?? '-',
            'user_kelas' => $peminjaman->user->kelas ?? '-',
            'user_hp' => $peminjaman->user->no_hp ?? '-',
            'keperluan' => $peminjaman->keperluan,
            'created_at' => \Carbon\Carbon::parse($peminjaman->created_at)->translatedFormat('d F Y • H.i'),
            'tanggal_peminjaman' => \Carbon\Carbon::parse($peminjaman->tanggal_peminjaman)->translatedFormat('l, d F Y'),
            'waktu' => \Carbon\Carbon::parse($peminjaman->waktu_mulai)->format('H.i') . ' - ' . \Carbon\Carbon::parse($peminjaman->waktu_selesai)->format('H.i') . ' WIB',
            'lokasi' => $peminjaman->detailPeminjamans->first()->sarana->lokasi ?? '-',
            'alasan_tolak' => $alasanTolak,
            'items' => $peminjaman->detailPeminjamans->map(function($detail) {
                return [
                    'nama' => $detail->sarana->nama_sarana ?? 'Barang',
                    'kode' => $detail->sarana->kode_sarana ?? '-',
                    'jumlah' => $detail->jumlah,
                    'gambar' => $detail->sarana->gambar //? asset('storage/' . $detail->sarana->gambar) : 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?w=150&auto=format&fit=crop&q=80'
                ];
            }),
            'approve_url' => route('admin.pengajuan.approve', $peminjaman->id),
            'reject_url' => route('admin.pengajuan.reject', $peminjaman->id),
        ]);

        
        
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

            // Kurangi stok jumlah_tersedia & buat jadwal penggunaan per barang
            $peminjaman->loadMissing('detailPeminjamans.sarana');
            foreach ($peminjaman->detailPeminjamans as $detail) {
                if (!$detail->sarana) {
                    continue;
                }

                if ($detail->sarana->jumlah_tersedia < $detail->jumlah) {
                    throw new \RuntimeException("Stok {$detail->sarana->nama_sarana} tidak mencukupi.");
                }

                $detail->sarana->decrement('jumlah_tersedia', $detail->jumlah);

                \App\Models\JadwalPenggunaan::create([
                    'peminjaman_id' => $peminjaman->id,
                    'sarana_id'     => $detail->sarana_id,
                    'tanggal'       => $peminjaman->tanggal_peminjaman,
                    'waktu_mulai'   => $peminjaman->waktu_mulai,
                    'waktu_selesai' => $peminjaman->waktu_selesai,
                    'status'        => 'berlangsung', // sesuaikan jika kolom status di jadwal_penggunaans memakai nilai/enum berbeda
                ]);
            }

            Persetujuan::create([
                'peminjaman_id'       => $peminjaman->id,
                'admin_id'            => auth()->id(),
                'status'              => 'disetujui',
                'tanggal_persetujuan' => now(),
                'alasan'              => null,
            ]);

            // Tambahkan 'kelayakan' => null di sini
            \App\Models\Pengembalian::create([
                'peminjaman_id'        => $peminjaman->id,
                'admin_id'             => auth()->id(),
                'tanggal_pengembalian' => now(),
                'kelayakan'            => null, // <--- Agar tidak error saat insert awal
                'status'               => 'menunggu_verifikasi',
            ]);
        });

        return redirect()
            ->back()
            ->with('success', 'Pengajuan berhasil disetujui dan masuk ke manajemen pengembalian & jadwal penggunaan.');
    }

    /**
     * Tolak pengajuan.
     */
    public function reject(Request $request, Peminjaman $peminjaman)
    {
        // Alasan wajib diketik oleh admin
        $data = $request->validate([
            'alasan' => ['required', 'string', 'min:5', 'max:500'],
        ], [
            'alasan.required' => 'Alasan penolakan wajib diisi.',
            'alasan.min'      => 'Alasan penolakan minimal 5 karakter.',
            'alasan.max'      => 'Alasan penolakan maksimal 500 karakter.',
        ]);

        // Hanya pengajuan yang masih menunggu yang boleh ditolak
        if ($peminjaman->status !== 'menunggu') {
            return back()->with('error', 'Hanya pengajuan yang masih menunggu yang bisa ditolak.');
        }

        // Simpan status dan alasan. Alasan inilah yang dibaca halaman detail peminjam.
        $peminjaman->forceFill([
            'status'  => 'ditolak',
            'catatan' => $data['alasan'],
        ])->save();

        // >>> Jika method reject Anda yang lama juga mencatat persetujuan
        //     (tabel persetujuans, admin_id, dll), pertahankan bagian itu di sini. <<<

        // Notifikasi ke peminjam dikirim otomatis oleh PeminjamanObserver
        // saat status berubah menjadi 'ditolak' (lengkap dengan alasannya).

        return redirect()->route('admin.pengajuan.show', $peminjaman)
            ->with('success', 'Pengajuan ditolak dan alasannya sudah dikirim ke peminjam.');
    }
}
