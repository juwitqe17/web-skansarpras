@extends('layouts.admin')

@section('page-content')
@php
    $peminjaman = $pengembalian->peminjaman;
    $isSelesai = ($pengembalian->status ?? '') === 'selesai';

    // Hitung batas waktu dari tanggal_peminjaman + waktu_selesai di tabel peminjamans
    $batasWaktu = null;
    if ($peminjaman && !empty($peminjaman->tanggal_peminjaman)) {
        $tglStr = \Carbon\Carbon::parse($peminjaman->tanggal_peminjaman)->format('Y-m-d');
        $jamStr = !empty($peminjaman->waktu_selesai)
            ? \Carbon\Carbon::parse($peminjaman->waktu_selesai)->format('H:i:s')
            : '23:59:59';
        $batasWaktu = \Carbon\Carbon::parse("{$tglStr} {$jamStr}");
    }

    // Waktu kembali aktual (jika sudah selesai pakai updated_at/tanggal_pengembalian, jika belum berarti belum kembali)
    $waktuKembaliAktual = $isSelesai
        ? \Carbon\Carbon::parse($pengembalian->updated_at ?? $pengembalian->tanggal_pengembalian)
        : null;

    // Cek apakah sudah melewati batas waktu
    $isTelat = false;
    if ($batasWaktu) {
        if ($waktuKembaliAktual) {
            $isTelat = $waktuKembaliAktual->gt($batasWaktu);
        } else {
            $isTelat = now()->gt($batasWaktu);
        }
    }
    if (($peminjaman->status ?? '') === 'terlambat') {
        $isTelat = true;
    }

    $kelayakan = is_array($pengembalian->kelayakan ?? null) ? $pengembalian->kelayakan : [];
@endphp

<div class="space-y-6 text-gray-800">

    <!-- Header Page & Tombol Kembali / Verifikasi -->
    <div class="flex flex-wrap items-center justify-between gap-3">
        <h1 class="text-3xl font-extrabold text-[#0A261D] tracking-tight">Detail Pengembalian</h1>

        <div class="flex items-center gap-2">
            @if(!$isSelesai && \Illuminate\Support\Facades\Route::has('admin.pengembalian.verify'))
                <a href="{{ route('admin.pengembalian.verify', $pengembalian->id) }}" class="inline-flex items-center px-4 py-2 rounded-xl text-xs font-semibold text-white bg-[#0A261D] hover:bg-[#134232] transition shadow-2xs">
                    Verifikasi Pengembalian
                </a>
            @endif

            <a href="{{ route('admin.pengembalian.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-xl text-xs font-semibold text-gray-700 bg-white hover:bg-gray-50 transition shadow-2xs">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali
            </a>
        </div>
    </div>

    <!-- Banner Peringatan Jika Melewati Tenggat Waktu -->
    @if($isTelat)
        <div class="bg-red-50 border border-red-200 text-red-800 rounded-2xl p-4 flex items-center gap-3 text-xs">
            <span class="px-2.5 py-1 bg-red-600 text-white text-[10px] font-extrabold rounded-md uppercase shrink-0">
                Terlambat
            </span>
            <p class="font-medium">
                Pengembalian telat dari waktu yang ditentukan
                @if($batasWaktu)
                    (batas jadwal: <span class="font-bold">{{ $batasWaktu->translatedFormat('d M Y, H.i') }} WIB</span>).
                @endif
            </p>
        </div>
    @endif

    <!-- Card Pembungkus Utama -->
    <div class="bg-white border border-gray-200/90 rounded-3xl p-6 sm:p-8 shadow-sm space-y-6">

        <!-- Baris 1: Tiga Card Atas (Peminjam, Barang, Waktu Kembali) -->
        <div style="display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 1rem;">

            <!-- 1. Card Peminjam -->
            <div class="bg-white border border-gray-200/80 rounded-2xl p-4 flex flex-col justify-between space-y-3 shadow-2xs">
                <span class="text-[10px] font-extrabold text-gray-400 uppercase tracking-wider">PEMINJAM</span>
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 rounded-xl bg-[#d1fae5] text-[#065f46] font-extrabold flex items-center justify-center text-sm shrink-0">
                        {{ strtoupper(substr($peminjaman->user->name ?? 'PM', 0, 2)) }}
                    </div>
                    <div class="overflow-hidden">
                        <h4 class="text-xs font-bold text-gray-900 truncate">{{ $peminjaman->user->name ?? '-' }}</h4>
                        <p class="text-[11px] text-gray-400 truncate">Email: <span class="text-gray-600">{{ $peminjaman->user->email ?? '-' }}</span></p>
                        <p class="text-[11px] text-gray-400">Kelas/Dept: <span class="text-gray-600">{{ $peminjaman->user->kelas ?? ($peminjaman->user->jurusan->nama_jurusan ?? '-') }}</span></p>
                    </div>
                </div>
            </div>

            <!-- 2. Card Barang yang Dipinjam -->
            <div class="bg-white border border-gray-200/80 rounded-2xl p-4 flex flex-col justify-between space-y-3 shadow-2xs">
                <span class="text-[10px] font-extrabold text-gray-400 uppercase tracking-wider">BARANG YANG DIPINJAM</span>
                <div class="space-y-2">
                    @forelse($peminjaman->detailPeminjamans ?? [] as $detail)
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-white border border-gray-200 overflow-hidden flex items-center justify-center shrink-0">
                                @if(!empty($detail->sarana->gambar))
                                    <img src="{{ asset('storage/' . $detail->sarana->gambar) }}" alt="Barang" class="w-full h-full object-cover">
                                @else
                                    <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                @endif
                            </div>
                            <div class="overflow-hidden">
                                <h4 class="text-xs font-bold text-gray-900 truncate">{{ $detail->sarana->nama_sarana ?? 'Sarana' }}</h4>
                                <p class="text-[11px] text-gray-500 font-medium">{{ $detail->jumlah ?? 1 }} Unit</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-xs text-gray-400">Tidak ada detail barang.</p>
                    @endforelse
                </div>
            </div>

            <!-- 3. Card Waktu Kembali -->
            <div class="bg-white border border-gray-200/80 rounded-2xl p-4 flex flex-col justify-between space-y-3 shadow-2xs">
                <div class="flex items-center justify-between gap-2">
                    <span class="text-[10px] font-extrabold text-gray-400 uppercase tracking-wider">WAKTU KEMBALI</span>
                    @if($isTelat)
                        <span class="px-2.5 py-0.5 bg-red-100 text-red-700 text-[10px] font-bold rounded-md">
                            Terlambat
                        </span>
                    @elseif($isSelesai)
                        <span class="px-2.5 py-0.5 bg-emerald-100 text-emerald-800 text-[10px] font-bold rounded-md">
                            Tepat Waktu
                        </span>
                    @else
                        <span class="px-2.5 py-0.5 bg-amber-100 text-amber-800 text-[10px] font-bold rounded-md">
                            Belum Kembali
                        </span>
                    @endif
                </div>
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl {{ $isTelat ? 'bg-red-100 text-red-700' : 'bg-[#d1fae5] text-[#065f46]' }} flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div class="overflow-hidden">
                        <h4 class="text-xs font-extrabold text-gray-900 truncate">
                            @if($waktuKembaliAktual)
                                {{ $waktuKembaliAktual->translatedFormat('d F Y, H.i') }} WIB
                            @else
                                Belum dikembalikan
                            @endif
                        </h4>
                        <p class="text-[10px] text-gray-400 mt-0.5 truncate">
                            Batas: {{ $batasWaktu ? $batasWaktu->translatedFormat('d M Y, H.i') . ' WIB' : '-' }}
                        </p>
                    </div>
                </div>
            </div>

        </div>

        <!-- Baris 2: Status Akhir -->
        <div class="bg-white border border-gray-200/80 rounded-2xl p-4 sm:p-5 flex items-center justify-between gap-3 shadow-2xs">
            <div class="flex items-center gap-3.5">
                <div class="w-9 h-9 rounded-xl {{ $isSelesai ? 'bg-[#0A261D]' : 'bg-amber-500' }} text-white flex items-center justify-center shrink-0 shadow-2xs">
                    @if($isSelesai)
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    @else
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    @endif
                </div>
                <div>
                    <h3 class="text-xs sm:text-sm font-extrabold text-gray-900">
                        Status Akhir:
                        <span class="font-normal">
                            {{ $isSelesai ? ucfirst($pengembalian->kondisi_pengembalian ?? 'Selesai') : 'Menunggu proses verifikasi pengembalian' }}
                        </span>
                    </h3>
                </div>
            </div>

            @if($isSelesai)
                <span class="px-3 py-1 bg-[#d1fae5] text-[#065f46] text-[10px] font-extrabold rounded-md tracking-wide">
                    TERVERIFIKASI
                </span>
            @else
                <span class="px-3 py-1 bg-amber-100 text-amber-800 text-[10px] font-extrabold rounded-md tracking-wide">
                    BELUM DIVERIFIKASI
                </span>
            @endif
        </div>

        <!-- Baris 3: Catatan Petugas -->
        <div class="bg-white border border-gray-200/80 rounded-2xl p-5 space-y-2 shadow-2xs">
            <div class="flex items-center gap-2 text-gray-900 text-xs font-extrabold">
                <svg class="w-4 h-4 text-[#0A261D]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                <span class="tracking-wider uppercase text-[11px]">CATATAN PETUGAS</span>
            </div>
            <p class="text-xs text-gray-600 leading-relaxed pl-6">
                {{ $pengembalian->catatan ?: ($isSelesai ? 'Tidak ada catatan tambahan.' : 'Belum ada catatan verifikasi petugas.') }}
            </p>
        </div>

        <!-- Baris 4: Tiga Kotak Indikator Bawah -->
        <div style="display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 1rem;">

            <div class="bg-white border border-gray-200/80 rounded-2xl p-4 text-center space-y-1 shadow-2xs">
                <p class="text-[11px] font-semibold text-gray-400">Komponen Fisik</p>
                @if(!$isSelesai && empty($kelayakan))
                    <p class="text-xs font-semibold text-gray-400">Belum diperiksa</p>
                @else
                    <p class="text-xs font-bold {{ in_array('aksesoris_lengkap', $kelayakan) ? 'text-gray-900' : 'text-rose-500' }}">
                        {{ in_array('aksesoris_lengkap', $kelayakan) ? 'Lengkap' : 'Tidak Lengkap' }}
                    </p>
                @endif
            </div>

            <div class="bg-white border border-gray-200/80 rounded-2xl p-4 text-center space-y-1 shadow-2xs">
                <p class="text-[11px] font-semibold text-gray-400">Fungsi Unit</p>
                @if(!$isSelesai && empty($kelayakan))
                    <p class="text-xs font-semibold text-gray-400">Belum diperiksa</p>
                @else
                    <p class="text-xs font-bold {{ in_array('fungsi_normal', $kelayakan) ? 'text-gray-900' : 'text-rose-500' }}">
                        {{ in_array('fungsi_normal', $kelayakan) ? 'Normal' : 'Tidak Normal' }}
                    </p>
                @endif
            </div>

            <div class="bg-white border border-gray-200/80 rounded-2xl p-4 text-center space-y-1 shadow-2xs">
                <p class="text-[11px] font-semibold text-gray-400">Kebersihan</p>
                @if(!$isSelesai && empty($kelayakan))
                    <p class="text-xs font-semibold text-gray-400">Belum diperiksa</p>
                @else
                    <p class="text-xs font-bold {{ in_array('fisik_bersih', $kelayakan) ? 'text-gray-900' : 'text-rose-500' }}">
                        {{ in_array('fisik_bersih', $kelayakan) ? 'Bersih' : 'Kurang Bersih' }}
                    </p>
                @endif
            </div>

        </div>

    </div>
</div>
@endsection
