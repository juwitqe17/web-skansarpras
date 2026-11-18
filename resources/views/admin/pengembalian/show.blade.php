@extends('layouts.admin')

@section('page-content')
<div class="space-y-6 text-gray-800">
    
    <!-- Header Page & Tombol Kembali -->
    <div class="flex items-center justify-between">
        <h1 class="text-3xl font-extrabold text-[#0A261D] tracking-tight">Detail Pengembalian</h1>

        <a href="{{ route('admin.pengembalian.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-xl text-xs font-semibold text-gray-700 bg-white hover:bg-gray-50 transition shadow-2xs">
            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali
        </a>
    </div>

    <!-- Card Pembungkus Utama -->
    <div class="bg-white border border-gray-200/90 rounded-3xl p-6 sm:p-8 shadow-sm space-y-6">

        <!-- Baris 1: Tiga Card Atas (Peminjam, Barang, Waktu Kembali) -->
        <div style="display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 1rem;">
            
            <!-- 1. Card Peminjam -->
            <div class="bg-white border border-gray-200/80 rounded-2xl p-4 flex flex-col justify-between space-y-3 shadow-2xs">
                <span class="text-[10px] font-extrabold text-gray-400 uppercase tracking-wider">PEMINJAM</span>
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 rounded-xl bg-[#d1fae5] text-[#065f46] font-extrabold flex items-center justify-center text-sm shrink-0">
                        {{ strtoupper(substr($pengembalian->peminjaman->user->name ?? 'BS', 0, 2)) }}
                    </div>
                    <div class="overflow-hidden">
                        <h4 class="text-xs font-bold text-gray-900 truncate">{{ $pengembalian->peminjaman->user->name ?? 'Budi Santoso' }}</h4>
                        <p class="text-[11px] text-gray-400 truncate">Email: <span class="text-gray-600">{{ $pengembalian->peminjaman->user->email ?? '-' }}</span></p>
                        <p class="text-[11px] text-gray-400">Kelas: <span class="text-gray-600">{{ $pengembalian->peminjaman->user->kelas ?? 'XII-RPL' }}</span></p>
                    </div>
                </div>
            </div>

            <!-- 2. Card Barang yang Dipinjam -->
            <div class="bg-white border border-gray-200/80 rounded-2xl p-4 flex flex-col justify-between space-y-3 shadow-2xs">
                <span class="text-[10px] font-extrabold text-gray-400 uppercase tracking-wider">BARANG YANG DIPINJAM</span>
                <div class="space-y-1">
                    @forelse($pengembalian->peminjaman->detailPeminjamans as $detail)
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-white border border-gray-200 overflow-hidden flex items-center justify-center shrink-0">
                                @if(isset($detail->sarana->gambar))
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
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-white border border-gray-200 flex items-center justify-center shrink-0">
                                <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            </div>
                            <div>
                                <h4 class="text-xs font-bold text-gray-900">Proyektor EPSON</h4>
                                <p class="text-[11px] text-gray-500 font-medium">2 Unit</p>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- 3. Card Waktu Kembali -->
            <div class="bg-white border border-gray-200/80 rounded-2xl p-4 flex flex-col justify-between space-y-3 shadow-2xs">
                <div class="flex items-center justify-between">
                    <span class="text-[10px] font-extrabold text-gray-400 uppercase tracking-wider">WAKTU KEMBALI</span>
                    <span class="px-2.5 py-0.5 bg-emerald-100 text-emerald-800 text-[10px] font-bold rounded-md">
                        {{ ucfirst($pengembalian->status ?? 'Tepat Waktu') }}
                    </span>
                </div>
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-[#d1fae5] text-[#065f46] flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div class="overflow-hidden">
                        <h4 class="text-xs font-extrabold text-gray-900 truncate">
                            {{ \Carbon\Carbon::parse($pengembalian->tanggal_pengembalian ?? now())->translatedFormat('d F Y, H.i') }} WIB
                        </h4>
                        <p class="text-[10px] text-gray-400 mt-0.5 truncate">
                            Batas: 14 Agustus 2026, 14.00 WIB
                        </p>
                    </div>
                </div>
            </div>

        </div>

        <!-- Baris 2: Status Akhir -->
        <div class="bg-white border border-gray-200/80 rounded-2xl p-4 sm:p-5 flex items-center justify-between gap-3 shadow-2xs">
            <div class="flex items-center gap-3.5">
                <div class="w-9 h-9 rounded-xl bg-[#0A261D] text-white flex items-center justify-center shrink-0 shadow-2xs">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                </div>
                <div>
                    <h3 class="text-xs sm:text-sm font-extrabold text-gray-900">
                        Status Akhir: <span class="font-normal">{{ ucfirst($pengembalian->kondisi_pengembalian ?? 'Baik & Lengkap') }}</span>
                    </h3>
                </div>
            </div>
            <span class="px-3 py-1 bg-[#d1fae5] text-[#065f46] text-[10px] font-extrabold rounded-md tracking-wide">
                TERVERIFIKASI
            </span>
        </div>

        <!-- Baris 3: Catatan Petugas -->
        <div class="bg-white border border-gray-200/80 rounded-2xl p-5 space-y-2 shadow-2xs">
            <div class="flex items-center gap-2 text-gray-900 text-xs font-extrabold">
                <svg class="w-4 h-4 text-[#0A261D]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                <span class="tracking-wider uppercase text-[11px]">CATATAN PETUGAS</span>
            </div>
            <p class="text-xs text-gray-600 leading-relaxed pl-6">
                {{ $pengembalian->catatan ?? 'Barang diterima dalam kondisi bersih, tas dan kelengkapan kabel power serta VGA bawaan lengkap, proyektor menyala normal.' }}
            </p>
        </div>

        <!-- Baris 4: Tiga Kotak Indikator Bawah (Dinamis sesuai centangan) -->
        @php
            $kelayakan = $pengembalian->kelayakan ?? [];
        @endphp
        <div style="display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 1rem;">
            
            <div class="bg-white border border-gray-200/80 rounded-2xl p-4 text-center space-y-1 shadow-2xs">
                <p class="text-[11px] font-semibold text-gray-400">Komponen Fisik</p>
                <p class="text-xs font-bold {{ in_array('aksesoris_lengkap', $kelayakan) ? 'text-gray-900' : 'text-rose-500' }}">
                    {{ in_array('aksesoris_lengkap', $kelayakan) ? 'Lengkap' : 'Tidak Lengkap' }}
                </p>
            </div>

            <div class="bg-white border border-gray-200/80 rounded-2xl p-4 text-center space-y-1 shadow-2xs">
                <p class="text-[11px] font-semibold text-gray-400">Fungsi Unit</p>
                <p class="text-xs font-bold {{ in_array('fungsi_normal', $kelayakan) ? 'text-gray-900' : 'text-rose-500' }}">
                    {{ in_array('fungsi_normal', $kelayakan) ? 'Normal' : 'Tidak Normal' }}
                </p>
            </div>

            <div class="bg-white border border-gray-200/80 rounded-2xl p-4 text-center space-y-1 shadow-2xs">
                <p class="text-[11px] font-semibold text-gray-400">Kebersihan</p>
                <p class="text-xs font-bold {{ in_array('fisik_bersih', $kelayakan) ? 'text-gray-900' : 'text-rose-500' }}">
                    {{ in_array('fisik_bersih', $kelayakan) ? 'Bersih' : 'Kurang Bersih' }}
                </p>
            </div>

        </div>

    </div>
</div>
@endsection