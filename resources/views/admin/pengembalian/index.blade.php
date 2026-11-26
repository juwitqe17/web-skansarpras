@extends('layouts.admin')

@section('page-content')
<div class="space-y-6">

    <!-- Header Section -->
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Manajemen Pengembalian</h1>
        <p class="text-sm text-gray-500 mt-1">Manajemen pengembalian barang yang telah dipinjam & pengecekan kondisi barang.</p>
    </div>

    <!-- SATU FORM UTAMA UNTUK SEMUA FILTER -->
    <form method="GET" action="{{ route('admin.pengembalian.index') }}" class="space-y-4">

        <!-- Card Filter Departemen / Jurusan -->
        <div class="bg-white p-5 rounded-2xl border border-gray-200/90 shadow-sm flex flex-col md:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-3.5">
                <div class="p-3 bg-gray-100 text-gray-700 rounded-xl">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-xs font-extrabold text-gray-900 uppercase tracking-wider">Pilih Kategori Departemen / Jurusan</h3>
                    <p class="text-[11px] text-gray-400 mt-0.5">Data sarana & prasarana akan disaring sesuai dengan departemen.</p>
                </div>
            </div>

            <div class="w-full md:w-72">
                <select name="jurusan_id" onchange="this.form.submit()" class="w-full bg-gray-50 text-xs text-gray-700 font-medium border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:border-emerald-600 cursor-pointer shadow-2xs">
                    <option value="">Pilih Departemen / Jurusan</option>
                    @foreach($jurusans ?? [] as $jurusan)
                        <option value="{{ $jurusan->id }}" {{ request('jurusan_id') == $jurusan->id ? 'selected' : '' }}>
                            {{ $jurusan->nama_jurusan ?? $jurusan->nama }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Search Input & Status Filter -->
        <div class="bg-white p-3 rounded-xl border border-gray-200 shadow-sm flex flex-col sm:flex-row gap-3">
            <div class="relative flex-1">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </span>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama peminjam..." class="w-full bg-gray-50 text-xs pl-9 pr-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:border-emerald-600 text-gray-600 placeholder-gray-400">
            </div>

            <div class="w-full sm:w-48">
                <select name="status" onchange="this.form.submit()" class="w-full bg-gray-50 text-xs text-gray-500 border border-gray-200 rounded-lg px-3 py-2.5 focus:outline-none focus:border-emerald-600 cursor-pointer">
                    <option value="">Semua Status</option>
                    <option value="menunggu_verifikasi" {{ request('status') == 'menunggu_verifikasi' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                    <option value="sedang_berlangsung" {{ request('status') == 'sedang_berlangsung' ? 'selected' : '' }}>Sedang Berlangsung</option>
                    <option value="terlambat" {{ request('status') == 'terlambat' ? 'selected' : '' }}>Terlambat</option>
                    <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                </select>
            </div>
        </div>

    </form>

    <!-- Table Section Card (KEMBALI DIMUNCULKAN) -->
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
        <!-- Table Title Header -->
        <div class="p-4 border-b border-gray-100 flex items-center space-x-3">
            <div class="p-2 bg-[#0b3323] text-white rounded-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 4H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-2m-4-1v8m0 0l3-3m-3 3L9 8m-5 5h2.586a1 1 0 01.707.293l2.414 2.414a1 1 0 00.707.293h3.172a1 1 0 00.707-.293l2.414-2.414a1 1 0 01.707-.293H20"></path>
                </svg>
            </div>
            <h3 class="text-base font-bold text-gray-900">Daftar Pengembalian Barang</h3>
        </div>

        <!-- Table Data -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-[#0b3323] text-white text-[11px] font-semibold uppercase tracking-wider">
                        <th class="py-3.5 px-4">TANGGAL PENGEMBALIAN</th>
                        <th class="py-3.5 px-4">IDENTITAS PEMINJAM</th>
                        <th class="py-3.5 px-4">SARANA & PRASARANA</th>
                        <th class="py-3.5 px-4">PETUGAS/ADMIN</th>
                        <th class="py-3.5 px-4 text-center">STATUS</th>
                        <th class="py-3.5 px-4 text-center">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-xs text-gray-600">
                @forelse($pengembalians as $pengembalian)
                    @php
                        $peminjaman = $pengembalian->peminjaman;
                        $isSelesai = strtolower((string) ($pengembalian->status ?? '')) === 'selesai';

                        // Hitung batas waktu dari tanggal_peminjaman + waktu_selesai di tabel peminjamans
                        $batasWaktu = null;
                        if ($peminjaman && !empty($peminjaman->tanggal_peminjaman)) {
                            $tglStr = \Carbon\Carbon::parse($peminjaman->tanggal_peminjaman)->format('Y-m-d');
                            $jamStr = !empty($peminjaman->waktu_selesai)
                                ? \Carbon\Carbon::parse($peminjaman->waktu_selesai)->format('H:i:s')
                                : '23:59:59';
                            $batasWaktu = \Carbon\Carbon::parse("{$tglStr} {$jamStr}");
                        }

                        // Cek apakah melewati batas waktu (selama belum selesai)
                        $isTerlambat = !$isSelesai && (
                            strtolower((string) ($pengembalian->status ?? '')) === 'terlambat'
                            || strtolower((string) ($peminjaman->status ?? '')) === 'terlambat'
                            || ($batasWaktu ? now()->gt($batasWaktu) : false)
                        );
                    @endphp

                    <tr class="{{ $isTerlambat ? 'bg-rose-50/40 hover:bg-rose-50/70' : 'hover:bg-gray-50' }} transition">
                        <!-- Tanggal Pengembalian / Batas Jadwal -->
                        <td class="py-4 px-4 align-top">
                            <p class="font-bold text-gray-900">
                                {{ $pengembalian->tanggal_pengembalian ? \Carbon\Carbon::parse($pengembalian->tanggal_pengembalian)->translatedFormat('d F Y') : '-' }}
                            </p>
                            <p class="text-[11px] text-gray-400 mt-0.5">
                                {{ $pengembalian->tanggal_pengembalian ? \Carbon\Carbon::parse($pengembalian->tanggal_pengembalian)->format('H:i') . ' WIB' : '' }}
                            </p>
                            @if($batasWaktu)
                                <p class="text-[10px] mt-1 {{ $isTerlambat ? 'text-rose-600 font-semibold' : 'text-gray-400' }}">
                                    Batas: {{ $batasWaktu->translatedFormat('d M Y, H.i') }} WIB
                                </p>
                            @endif
                        </td>

                        <!-- Identitas Peminjam -->
                        <td class="py-4 px-4 align-top space-y-0.5">
                            <p class="font-bold text-gray-900">{{ $peminjaman->user->name ?? '-' }}</p>
                            <p class="text-[11px] text-gray-400">Email: <span class="underline">{{ $peminjaman->user->email ?? '-' }}</span></p>
                            <p class="text-[11px] font-semibold text-[#0b3323]">
                                Jurusan: {{ $peminjaman->user->jurusan->nama_jurusan ?? $peminjaman->user->jurusan->nama ?? '-' }}
                            </p>
                        </td>

                        <!-- Sarana Prasarana -->
                        <td class="py-4 px-4 align-top">
                            <ul class="space-y-1">
                                @forelse($peminjaman->detailPeminjamans ?? [] as $detail)
                                    <li class="font-semibold text-gray-800">
                                        - {{ $detail->sarana->nama_sarana ?? $detail->sarana->nama ?? 'Sarana/Barang' }}
                                        <span class="text-gray-500 font-normal">({{ $detail->jumlah ?? 1 }} Unit)</span>
                                    </li>
                                @empty
                                    <li class="text-gray-400 italic">Tidak ada detail barang</li>
                                @endforelse
                            </ul>
                        </td>

                        <!-- Admin / Petugas -->
                        <td class="py-4 px-4 align-top">
                            <p class="font-medium text-gray-800">{{ $pengembalian->admin->name ?? '-' }}</p>
                        </td>

                        <!-- Kolom Status -->
                        <td class="py-4 px-4 align-top text-center space-y-1">
                            @if($isSelesai)
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-semibold bg-emerald-50 text-emerald-600 border border-emerald-200">
                                    Selesai
                                </span>
                            @elseif($isTerlambat)
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-semibold bg-rose-50 text-rose-600 border border-rose-200">
                                    Terlambat
                                </span>
                            @else
                                @switch($pengembalian->status)
                                    @case('sedang_berlangsung')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-semibold bg-sky-50 text-sky-500 border border-sky-200">
                                            Sedang Berlangsung
                                        </span>
                                        @break
                                    @default
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-semibold bg-amber-50 text-amber-600 border border-amber-200">
                                            Menunggu Verifikasi
                                        </span>
                                @endswitch
                            @endif
                        </td>

                        <!-- Aksi -->
                        <td class="py-4 px-4 align-top text-center">
                            @if($isSelesai)
                                <a href="{{ route('admin.pengembalian.show', $pengembalian->id) }}" class="inline-block px-3.5 py-1.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-md text-xs font-medium transition border border-gray-200">
                                    Detail
                                </a>
                            @else
                                <a href="{{ route('admin.pengembalian.verify', $pengembalian->id) }}" class="inline-block px-3.5 py-1.5 bg-[#0b3323] hover:bg-emerald-900 text-white rounded-md text-xs font-medium transition shadow-sm">
                                    Verifikasi
                                </a>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-8 text-center text-gray-500">
                            Tidak ada data pengembalian yang ditemukan.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <!-- Table Pagination Footer -->
        <div class="p-4 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-gray-500">
            <p>
                Menampilkan <span class="font-semibold text-gray-800">{{ $pengembalians->firstItem() ?? 0 }}</span>
                sampai <span class="font-semibold text-gray-800">{{ $pengembalians->lastItem() ?? 0 }}</span>
                dari <span class="font-semibold text-gray-800">{{ $pengembalians->total() }}</span> data
            </p>
            <div>
                {{ $pengembalians->links() }}
            </div>
        </div>
    </div>

</div>
@endsection
