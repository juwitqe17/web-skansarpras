<?php

namespace App\Http\Controllers\Peminjam;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Sarana;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengajuanController extends Controller
{
    public function index()
    {
        $pengajuans = Peminjaman::with([
            'detailPeminjamans.sarana',
            'persetujuans',
        ])
            ->where('user_id', auth()->id())
            ->latest('tanggal_pengajuan')
            ->paginate(10);

        return view(
            'peminjam.pengajuan.index',
            compact('pengajuans')
        );
    }

    public function create(Request $request)
    {
        $sarana = null;

        if ($request->filled('sarana_id')) {
            $sarana = Sarana::where('id', $request->sarana_id)
                ->where('jurusan_id', auth()->user()->jurusan_id)
                ->firstOrFail();
        }

        $saranas = Sarana::where('jurusan_id', auth()->user()->jurusan_id)
            ->where('status', 'tersedia')
            ->where('jumlah_tersedia', '>', 0)
            ->orderBy('nama_sarana')
            ->get();

        return view(
            'peminjam.pengajuan.create',
            compact('saranas', 'sarana')
        );
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal_peminjaman' => 'required|date',
            'waktu_mulai' => 'required',
            'waktu_selesai' => 'required|after:waktu_mulai',
            'keperluan' => 'required|string|max:500',
            'catatan' => 'nullable|string|max:500',

            'sarana_id' => 'required|exists:saranas,id',
            'jumlah' => 'required|integer|min:1',
            'keterangan' => 'nullable|string|max:500',
        ]);

        $sarana = Sarana::where('id', $validated['sarana_id'])
            ->where('jurusan_id', auth()->user()->jurusan_id)
            ->firstOrFail();

        if ($validated['jumlah'] > $sarana->jumlah_tersedia) {
            return back()
                ->withInput()
                ->withErrors([
                    'jumlah' => 'Jumlah sarana yang diminta melebihi jumlah yang tersedia.'
                ]);
        }

        DB::transaction(function () use ($validated) {

            $peminjaman = Peminjaman::create([
                'user_id' => auth()->id(),
                'tanggal_pengajuan' => now(),
                'tanggal_peminjaman' => $validated['tanggal_peminjaman'],
                'waktu_mulai' => $validated['waktu_mulai'],
                'waktu_selesai' => $validated['waktu_selesai'],
                'keperluan' => $validated['keperluan'],
                'status' => 'menunggu',
                'catatan' => $validated['catatan'] ?? null,
            ]);

            $peminjaman->detailPeminjamans()->create([
                'sarana_id' => $validated['sarana_id'],
                'jumlah' => $validated['jumlah'],
                'keterangan' => $validated['keterangan'] ?? null,
            ]);
        });

        return redirect()
            ->route('peminjam.pengajuan.index')
            ->with('success', 'Pengajuan berhasil dikirim.');
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
            'jadwalPenggunaans.sarana',
            'pengembalian',
        ]);

        return view(
            'peminjam.pengajuan.show',
            compact('peminjaman')
        );
    }

    public function cancel(Peminjaman $peminjaman)
    {
        abort_unless(
            $peminjaman->user_id === auth()->id(),
            403
        );

        if ($peminjaman->status !== 'menunggu') {
            return back()
                ->with('error', 'Pengajuan yang sudah diproses tidak dapat dibatalkan.');
        }

        $peminjaman->update([
            'status' => 'dibatalkan',
        ]);

        return back()
            ->with('success', 'Pengajuan berhasil dibatalkan.');
    }
}