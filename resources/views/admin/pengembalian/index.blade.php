@extends('layouts.admin')

@section('page-content')
<div class="space-y-6">

    <!-- Header Section -->
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Manajemen Pengembalian</h1>
        <p class="text-sm text-gray-500 mt-1">Manajemen pengembalian barang yang telah dipinjam & pengecekan kondisi barang.</p>
    </div>

    <!-- Search Input & Status Filter -->
    <form method="GET" action="{{ route('admin.pengembalian.index') }}" class="bg-white p-3 rounded-xl border border-gray-200 shadow-sm flex flex-col sm:flex-row gap-3">
        <div class="relative flex-1">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </span>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama peminjam..." class="w-full bg-gray-50 text-xs pl-9 pr-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:border-emerald-600 text-gray-600 placeholder-gray-400">
        </div>

        <div class="w-full sm:w-44">
            <select name="status" onchange="this.form.submit()" class="w-full bg-gray-50 text-xs text-gray-500 border border-gray-200 rounded-lg px-3 py-2.5 focus:outline-none focus:border-emerald-600 cursor-pointer">
                <option value="">Semua Status</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="proses" {{ request('status') == 'proses' ? 'selected' : '' }}>Proses</option>
                <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
            </select>
        </div>
    </form>

    <!-- Table Section Card -->
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
                        <tr class="hover:bg-gray-50 transition">
                            <!-- Tanggal Pengembalian -->
                            <td class="py-4 px-4 align-top">
                                <p class="font-bold text-gray-900">
                                    {{ $pengembalian->tanggal_pengembalian ? \Carbon\Carbon::parse($pengembalian->tanggal_pengembalian)->translatedFormat('d F Y') : '-' }}
                                </p>
                                <p class="text-[11px] text-gray-400 mt-0.5">
                                    {{ $pengembalian->tanggal_pengembalian ? \Carbon\Carbon::parse($pengembalian->tanggal_pengembalian)->format('H:i') . ' WIB' : '' }}
                                </p>
                            </td>

                            <!-- Identitas Peminjam -->
                            <td class="py-4 px-4 align-top space-y-0.5">
                                <p class="font-bold text-gray-900">{{ $pengembalian->peminjaman->user->name ?? '-' }}</p>
                                <p class="text-[11px] text-gray-400">Email: <span class="underline">{{ $pengembalian->peminjaman->user->email ?? '-' }}</span></p>
                                <p class="text-[11px] font-semibold text-[#0b3323]">
                                    Jurusan: {{ $pengembalian->peminjaman->user->jurusan->nama_jurusan ?? $pengembalian->peminjaman->user->jurusan->nama ?? '-' }}
                                </p>
                            </td>

                            <!-- Sarana Prasarana (Iterasi Detail Peminjaman) -->
                            <td class="py-4 px-4 align-top">
                                <ul class="space-y-1">
                                    @forelse($pengembalian->peminjaman->detailPeminjamans ?? [] as $detail)
                                        <li class="font-semibold text-gray-800">
                                            • {{ $detail->sarana->nama_sarana ?? $detail->sarana->nama ?? 'Sarana/Barang' }} 
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
<td class="py-4 px-4 align-top text-center">
    @switch($pengembalian->status)
        @case('selesai')
            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-semibold bg-emerald-50 text-emerald-600 border border-emerald-200">
                Selesai
            </span>
            @break
        @case('sedang_berlangsung')
            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-semibold bg-sky-50 text-sky-500 border border-sky-200">
                Sedang Berlangsung
            </span>
            @break
        @case('terlambat')
            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-semibold bg-rose-50 text-rose-600 border border-rose-200">
                Terlambat
            </span>
            @break
        @default
            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-semibold bg-amber-50 text-amber-600 border border-amber-200">
                Menunggu Verifikasi
            </span>
    @endswitch
</td>

                            <!-- Aksi -->
<!-- Aksi -->
<td class="py-4 px-4 align-top text-center">
    @if(strtolower($pengembalian->status) == 'selesai')
        <!-- Jika sudah selesai, tampilkan tombol Detail -->
        <a href="{{ route('admin.pengembalian.show', $pengembalian->id) }}" class="inline-block px-3.5 py-1.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-md text-xs font-medium transition border border-gray-200">
            Detail
        </a>
    @else
        <!-- Jika belum selesai / menunggu verifikasi, tampilkan tombol Verifikasi -->
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