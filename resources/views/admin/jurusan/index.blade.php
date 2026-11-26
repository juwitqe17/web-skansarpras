@extends('layouts.admin')

@section('page-content')
<div class="space-y-6">

    <!-- Flash Alert Status -->
    @if(session('success'))
        <div class="p-4 mb-4 text-sm text-emerald-800 rounded-xl bg-emerald-50 border border-emerald-200" role="alert">
            <span class="font-medium">Berhasil!</span> {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="p-4 mb-4 text-sm text-red-800 rounded-xl bg-red-50 border border-red-200" role="alert">
            <span class="font-medium">Gagal!</span> {{ session('error') }}
        </div>
    @endif

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Manajemen Departemen</h1>
            <p class="text-sm text-gray-500 mt-1">Kelola data jurusan dan ketersediaan sarana prasarana.</p>
        </div>
        <div>
            <a href="{{ route('admin.jurusan.create') }}" class="inline-flex items-center space-x-2 bg-[#0b3323] hover:bg-emerald-900 text-white font-medium px-4 py-2.5 rounded-lg text-sm transition shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                <span>Tambah Departemen</span>
            </a>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <!-- Card 1: Total Departemen -->
        <div class="bg-white p-5 rounded-2xl border border-gray-200 shadow-sm flex items-start justify-between">
            <div class="space-y-2">
                <div class="flex items-center space-x-2 text-gray-700">
                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                    <span class="text-xs font-semibold text-gray-700">Total Departemen</span>
                </div>
                <div class="flex items-baseline space-x-1.5">
                    <span class="text-3xl font-bold text-gray-900">{{ $totalJurusan ?? 0 }}</span>
                    <span class="text-xs text-gray-500 font-medium">Jurusan</span>
                </div>
            </div>
        </div>

        <!-- Card 2: Akumulasi Unit -->
        <div class="bg-white p-5 rounded-2xl border border-gray-200 shadow-sm flex items-start justify-between">
            <div class="space-y-2">
                <div class="flex items-center space-x-2 text-gray-700">
                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                    <span class="text-xs font-semibold text-gray-700">Akumulasi Unit</span>
                </div>
                <div class="flex items-baseline space-x-1.5">
                    <span class="text-3xl font-bold text-gray-900">{{ number_format($akumulasiUnit ?? 0, 0, ',', '.') }}</span>
                    <span class="text-xs text-gray-500 font-medium">unit</span>
                </div>
            </div>
        </div>

        <!-- Card 3: Sedang Dipinjam -->
        <div class="bg-white p-5 rounded-2xl border border-gray-200 shadow-sm flex items-start justify-between">
            <div class="space-y-2">
                <div class="flex items-center space-x-2 text-gray-700">
                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                    <span class="text-xs font-semibold text-gray-700">Sedang Dipinjam</span>
                </div>
                <div class="flex items-baseline space-x-1.5">
                    <span class="text-3xl font-bold text-gray-900">{{ number_format($sedangDipinjam ?? 0, 0, ',', '.') }}</span>
                    <span class="text-xs text-gray-500 font-medium">barang</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter & Search Bar -->
    <form method="GET" action="{{ route('admin.jurusan.index') }}" class="bg-white p-3 rounded-2xl border border-gray-200 shadow-sm flex flex-col sm:flex-row gap-3">
        <div class="relative flex-1">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-gray-400">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </span>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Departemen / Jurusan / Kompetensi" class="w-full bg-gray-50 text-xs pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl focus:outline-none focus:border-emerald-600 text-gray-700 placeholder-gray-400">
        </div>

        <div class="flex gap-2">
            <div class="w-36">
                <select name="status" onchange="this.form.submit()" class="w-full bg-gray-50 text-xs text-gray-600 border border-gray-200 rounded-xl px-3 py-2.5 focus:outline-none focus:border-emerald-600 cursor-pointer">
                    <option value="">Semua Status</option>
                    <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="tidak_aktif" {{ request('status') == 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                </select>
            </div>
        </div>
    </form>

    <!-- Table Section -->
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-[#0b3323] text-white text-xs font-semibold">
                        <th class="py-4 px-6">Kode</th>
                        <th class="py-4 px-6">Nama Jurusan</th>
                        <th class="py-4 px-6">Jumlah Sarana (unit)</th>
                        <th class="py-4 px-6">Status</th>
                        <th class="py-4 px-6 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-xs text-gray-700">
                    @forelse($jurusans as $item)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="py-4 px-6 align-middle">
                                @php
                                    $kode = strtoupper($item->kode_jurusan ?? '');
                                    $nama = strtolower($item->nama_jurusan ?? '');

                                    // Logika Klasifikasi Warna
                                    if (str_contains($nama, 'tani') || str_contains($nama, 'pangan') || str_contains($nama, 'agri') || in_array($kode, ['ATPH', 'AP', 'APT'])) {
                                        // Pertanian -> Hijau
                                        $badgeColor = 'bg-emerald-100 text-emerald-800';
                                    } elseif (str_contains($nama, 'informatika') || str_contains($nama, 'komputer') || str_contains($nama, 'rekayasa') || str_contains($nama, 'visual') || in_array($kode, ['RPL', 'TKJ', 'IT', 'SIJA', 'DKV'])) {
                                        // IT -> Kuning
                                        $badgeColor = 'bg-amber-100 text-amber-800';
                                    } elseif (str_contains($nama, 'mesin') || str_contains($nama, 'otomotif') || str_contains($nama, 'las') || in_array($kode, ['TKR', 'TSM', 'TPM', 'TM'])) {
                                        // Mesin -> Biru
                                        $badgeColor = 'bg-blue-100 text-blue-800';
                                    } else {
                                        // Default -> Gray
                                        $badgeColor = 'bg-gray-100 text-gray-800';
                                    }
                                @endphp

                                <span class="inline-block px-3 py-1 font-bold rounded-full text-xs {{ $badgeColor }}">
                                    {{ $item->kode_jurusan }}
                                </span>
                            </td>
                            <td class="py-4 px-6 align-middle font-medium text-gray-900">
                                {{ $item->nama_jurusan }}
                                <div class="text-[11px] text-gray-400 font-normal">{{ $item->kompetensi_keahlian }}</div>
                            </td>
                            <td class="py-4 px-6 align-middle text-gray-600">
                                {{ number_format($item->sarana_sum_jumlah ?? 0, 0, ',', '.') }} unit
                            </td>
                            <td class="py-4 px-6 align-middle">
                                @if($item->status == 'aktif')
                                    <span class="inline-block px-3 py-1 bg-emerald-100 text-emerald-600 font-semibold rounded-full text-[11px]">
                                        Aktif
                                    </span>
                                @else
                                    <span class="inline-block px-3 py-1 bg-red-100 text-red-500 font-semibold rounded-full text-[11px]">
                                        Tidak Aktif
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-6 align-middle text-center">
                                <div class="flex items-center justify-center space-x-4 text-gray-500">
                                    <!-- Edit -->
                                    <a href="{{ route('admin.jurusan.edit', $item->id) }}" class="hover:text-gray-800 transition" title="Edit">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                        </svg>
                                    </a>
                                    <!-- Hapus -->
                                    <form action="{{ route('admin.jurusan.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus jurusan ini?')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="hover:text-red-600 transition" title="Hapus">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-8 text-center text-gray-400">
                                Tidak ada data jurusan ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($jurusans->hasPages())
            <div class="p-4 border-t border-gray-100">
                {{ $jurusans->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
