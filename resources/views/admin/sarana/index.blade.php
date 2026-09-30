@extends('layouts.admin')

@section('page-content')
<div class="space-y-6">
    <!-- Header Page -->
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Manajemen Sarana & Prasarana</h1>
        <p class="mt-1 text-sm text-gray-500">
            Inventaris peralatan dan perangkat kejuruan. Pilih kategori jurusan terlebih dahulu sebelum mengelola data sarana.
        </p>
    </div>

    <!-- Filter Departemen / Jurusan Card -->
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="p-3 bg-gray-100 rounded-xl text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m0 0h5m-5 0v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-base font-semibold text-gray-900">Pilih Kategori Departemen / Jurusan</h2>
                    <p class="text-xs text-gray-500">Data sarana & prasarana akan disaring sesuai dengan departemen.</p>
                </div>
            </div>

            <!-- Dropdown Filter Jurusan -->
            <form method="GET" action="{{ route('admin.sarana.index') }}" class="w-full sm:w-72">
                <select name="jurusan_id" onchange="this.form.submit()" class="w-full bg-gray-50 border border-gray-200 text-gray-700 text-sm rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-emerald-800 focus:border-emerald-800 transition">
                    <option value="">Pilih Departemen / Jurusan</option>
                    @foreach($jurusans as $jrs)
                        <option value="{{ $jrs->id }}" {{ request('jurusan_id') == $jrs->id ? 'selected' : '' }}>
                            {{ $jrs->nama_jurusan }}
                        </option>
                    @endforeach
                </select>
            </form>
        </div>

        <!-- Metric Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Total Unit -->
            <div class="p-4 rounded-xl border border-gray-200 bg-white">
                <div class="flex items-center gap-2 text-xs font-medium text-gray-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    Total Unit Barang
                </div>
                <div class="mt-2 flex items-baseline gap-2">
                    <span class="text-2xl font-bold text-gray-900">{{ $selectedJurusan ? $stats['total'] : 0 }}</span>
                    <span class="text-xs text-gray-500">unit</span>
                </div>
                <p class="mt-1 text-xs text-gray-400">
                    {{ $selectedJurusan ? 'Unit di jurusan ' . $selectedJurusan->kode_jurusan . '.' : '-' }}
                </p>
            </div>

            <!-- Unit Tersedia -->
            <div class="p-4 rounded-xl border border-gray-200 bg-white">
                <div class="flex items-center gap-2 text-xs font-medium text-gray-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Unit yang Tersedia
                </div>
                <div class="mt-2 flex items-baseline gap-2">
                    <span class="text-2xl font-bold text-gray-900">{{ $selectedJurusan ? $stats['available'] : 0 }}</span>
                    <span class="text-xs text-gray-500">unit</span>
                </div>
                <p class="mt-1 text-xs text-gray-400">
                    {{ $selectedJurusan ? $stats['available_percentage'] . '% unit layak pakai.' : '-' }}
                </p>
            </div>

            <!-- Perlu Perhatian -->
            <div class="p-4 rounded-xl border border-gray-200 bg-white">
                <div class="flex items-center gap-2 text-xs font-medium text-red-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    Perlu Perhatian!
                </div>
                <div class="mt-2 flex items-baseline gap-2">
                    <span class="text-2xl font-bold text-gray-900">{{ $selectedJurusan ? $stats['maintenance'] : 0 }}</span>
                    <span class="text-xs text-gray-500">unit</span>
                </div>
                <p class="mt-1 text-xs text-gray-400">
                    {{ $selectedJurusan ? 'Unit perlu perbaikan.' : '-' }}
                </p>
            </div>

            <!-- Jurusan Saat Ini Card -->
            <div class="p-4 rounded-xl {{ $selectedJurusan ? 'bg-[#0f2e24] text-white' : 'bg-gray-700 text-gray-200' }}">
                <div class="flex items-center gap-2 text-xs font-medium opacity-80">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m0 0h5m-5 0v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    Jurusan Saat Ini
                </div>
                <div class="mt-2 text-2xl font-bold uppercase tracking-wider">
                    {{ $selectedJurusan ? $selectedJurusan->kode_jurusan : '-' }}
                </div>
                <p class="mt-1 text-xs opacity-75">
                    {{ $selectedJurusan ? $selectedJurusan->nama_jurusan : '-' }}
                </p>
            </div>
        </div>
    </div>

    @if($selectedJurusan)
        <!-- Control Bar (Search, Filter, Export, Add) -->
        <div class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100 flex flex-wrap items-center justify-between gap-3">
            <form method="GET" action="{{ route('admin.sarana.index') }}" class="flex flex-wrap items-center gap-3 flex-1">
                <input type="hidden" name="jurusan_id" value="{{ request('jurusan_id') }}">

                <!-- Search Input -->
                <div class="relative flex-1 min-w-[200px]">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Sarana / Prasarana" class="w-full pl-9 pr-4 py-2 bg-gray-50 border border-gray-200 text-sm rounded-xl focus:ring-2 focus:ring-emerald-800">
                </div>

                <!-- Filter Kondisi -->
                <select name="kondisi" onchange="this.form.submit()" class="bg-gray-50 border border-gray-200 text-sm rounded-xl px-3 py-2 text-gray-600 focus:ring-2 focus:ring-emerald-800">
                    <option value="">Kondisi</option>
                    <option value="baik" {{ request('kondisi') == 'baik' ? 'selected' : '' }}>Baik</option>
                    <option value="rusak_ringan" {{ request('kondisi') == 'rusak_ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                    <option value="rusak_berat" {{ request('kondisi') == 'rusak_berat' ? 'selected' : '' }}>Rusak Berat</option>
                </select>

                <!-- Filter Status -->
                <select name="status" onchange="this.form.submit()" class="bg-gray-50 border border-gray-200 text-sm rounded-xl px-3 py-2 text-gray-600 focus:ring-2 focus:ring-emerald-800">
                    <option value="">Status</option>
                    <option value="tersedia" {{ request('status') == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                    <option value="dipinjam" {{ request('status') == 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                </select>
            </form>

            <div class="flex items-center gap-3">
                <a href="{{ route('admin.sarana.export', ['jurusan_id' => request('jurusan_id')]) }}" class="inline-flex items-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium px-4 py-2 rounded-xl transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Ekspor Excel
                </a>

                <a href="{{ route('admin.sarana.create', ['jurusan_id' => request('jurusan_id')]) }}" class="inline-flex items-center gap-2 bg-[#0f2e24] hover:bg-[#163f32] text-white text-sm font-medium px-4 py-2 rounded-xl transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Tambah Sarana {{ $selectedJurusan->kode_jurusan }}
                </a>
            </div>
        </div>

        <!-- Data Table -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-600">
                    <thead class="bg-[#0f2e24] text-white text-xs uppercase font-semibold tracking-wider">
                        <tr>
                            <th class="px-6 py-4">Kode Unit</th>
                            <th class="px-6 py-4">Gambar</th>
                            <th class="px-6 py-4">Nama Sarana</th>
                            <th class="px-6 py-4">Total (unit)</th>
                            <th class="px-6 py-4">Tersedia</th>
                            <th class="px-6 py-4">Kondisi</th>
                            <th class="px-6 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($items as $item)
                            <tr class="hover:bg-gray-50/50 transition">
                                <td class="px-6 py-4 font-bold text-gray-900 whitespace-nowrap">{{ $item->kode_sarana }}</td>
                                <td class="px-6 py-4">
                                    @if($item->gambar)
                                        <img src="{{ asset('storage/' . $item->gambar) }}" alt="{{ $item->nama_sarana }}" class="w-16 h-12 object-cover rounded-lg bg-gray-100">
                                    @else
                                        <div class="w-16 h-12 rounded-lg bg-gray-200 flex items-center justify-center text-xs text-gray-400">No Img</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-semibold text-gray-900">{{ $item->nama_sarana }}</div>
                                    <div class="text-xs text-gray-400 line-clamp-1">{{ $item->deskripsi }}</div>
                                </td>
                                <td class="px-6 py-4 font-semibold text-gray-900">{{ $item->jumlah }} Unit</td>
                                <td class="px-6 py-4 font-semibold text-gray-900">{{ $item->jumlah_tersedia }} Unit</td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $item->kondisi == 'baik' ? 'bg-emerald-100 text-emerald-800' : 'bg-red-100 text-red-800' }}">
                                        {{ ucfirst($item->kondisi) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('admin.sarana.edit', $item->id) }}" class="p-1.5 text-gray-500 hover:text-emerald-800 rounded-lg hover:bg-gray-100">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        </a>
                                        <form action="{{ route('admin.sarana.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus sarana ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-1.5 text-gray-500 hover:text-red-600 rounded-lg hover:bg-gray-100">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-8 text-center text-gray-400">
                                    Belum ada data sarana untuk jurusan {{ $selectedJurusan->nama_jurusan }}.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 bg-gray-50/50 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-gray-500">
                <div>
                    Menampilkan {{ $items->firstItem() ?? 0 }} - {{ $items->lastItem() ?? 0 }} dari {{ $items->total() }} sarana jurusan {{ $selectedJurusan->nama_jurusan }}
                </div>
                <div>
                    {{ $items->links() }}
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
