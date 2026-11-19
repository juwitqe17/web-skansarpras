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

    <!-- Alert Notification -->
    @if(session('success'))
        <div class="p-4 text-sm text-emerald-800 bg-emerald-50 border border-emerald-200 rounded-xl">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="p-4 text-sm text-red-800 bg-red-50 border border-red-200 rounded-xl">
            {{ session('error') }}
        </div>
    @endif
    @if($errors->has('file_excel'))
        <div class="p-4 text-sm text-red-800 bg-red-50 border border-red-200 rounded-xl">
            {{ $errors->first('file_excel') }}
        </div>
    @endif

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
        <!-- Control Bar (Search, Filter, Excel Dropdown, Add) -->
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
                    <option value="">Semua Kondisi</option>
                    <option value="baik" {{ request('kondisi') == 'baik' ? 'selected' : '' }}>Baik</option>
                    <option value="rusak_ringan" {{ request('kondisi') == 'rusak_ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                    <option value="rusak_berat" {{ request('kondisi') == 'rusak_berat' ? 'selected' : '' }}>Rusak Berat</option>
                </select>

                <!-- Filter Status -->
                <select name="status" onchange="this.form.submit()" class="bg-gray-50 border border-gray-200 text-sm rounded-xl px-3 py-2 text-gray-600 focus:ring-2 focus:ring-emerald-800">
                    <option value="">Status</option>
                    <option value="tersedia" {{ request('status') == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                    <option value="dipinjam" {{ request('status') == 'dipinjam' ? 'selected' : '' }}>Tidak Tersedia</option>
                </select>
            </form>

            <div class="flex items-center gap-3">
                <!-- Dropdown Button Excel (Ekspor / Impor) -->
                <div class="relative" id="excelDropdownWrapper">
                    <button type="button" onclick="toggleExcelDropdown()" 
                            class="inline-flex items-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium px-4 py-2 rounded-xl border border-gray-200 transition">
                        <svg class="w-4 h-4 text-emerald-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Excel
                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>

                    <!-- Menu Dropdown -->
                    <div id="excelDropdownMenu" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-gray-100 py-1.5 z-30">
                        <a href="{{ route('admin.sarana.export', ['jurusan_id' => request('jurusan_id')]) }}" 
                           class="flex items-center gap-2.5 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition">
                            <svg class="w-4 h-4 text-emerald-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                            Ekspor Data
                        </a>
                        <button type="button" onclick="openImportModal()" 
                                class="w-full flex items-center gap-2.5 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition text-left">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                            Impor Data
                        </button>
                    </div>
                </div>

                <!-- Tombol Tambah Sarana -->
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
                                        {{ ucfirst(str_replace('_', ' ', $item->kondisi)) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('admin.sarana.edit', $item->id) }}" class="p-1.5 text-gray-500 hover:text-emerald-800 rounded-lg hover:bg-gray-100">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        </a>
                                        <button
                                            type="button"
                                            onclick="openDeleteModal(
                                                {{ $item->id }},
                                                @js($item->nama_sarana),
                                                @js($item->kode_sarana),
                                                @js($item->jumlah),
                                                @js($item->jumlah_tersedia),
                                                @js($item->kondisi),
                                                @js($item->gambar ? asset('storage/' . $item->gambar) : null)
                                            )"
                                            class="rounded-lg p-1.5 text-gray-500 hover:bg-gray-100 hover:text-red-600"
                                        >
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
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
                @include('admin.sarana.partials.delete-modal')
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

        <!-- Modal Pop-up Impor Sarana -->
        <div id="importModal" class="fixed inset-0 z-50 hidden overflow-y-auto" role="dialog" aria-modal="true">
            <div class="fixed inset-0 bg-gray-900/50 backdrop-blur-xs transition-opacity" onclick="closeImportModal()"></div>

            <div class="flex min-h-full items-center justify-center p-4">
                <div class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-xl transition-all sm:w-full sm:max-w-lg border border-gray-100">
                    <form action="{{ route('admin.sarana.import') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-5">
                        @csrf
                        <input type="hidden" name="jurusan_id" value="{{ $selectedJurusan->id }}">

                        <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                            <div>
                                <h3 class="text-lg font-bold text-gray-900">Impor Data Sarana & Prasarana</h3>
                                <p class="text-xs text-gray-500">Jurusan tujuan: <strong class="text-emerald-800">{{ $selectedJurusan->nama_jurusan }}</strong></p>
                            </div>
                            <button type="button" onclick="closeImportModal()" class="text-gray-400 hover:text-gray-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            </button>
                        </div>

                        <!-- Panduan & Download Template -->
                        <div class="p-4 bg-emerald-50/70 border border-emerald-100 rounded-xl text-xs text-emerald-900 space-y-2">
                            <p class="font-semibold">Petunjuk Impor:</p>
                            <ul class="list-disc pl-4 space-y-1 text-emerald-800">
                                <li>Gunakan file berformat <strong>.CSV</strong> (Save As CSV dari Excel).</li>
                                <li>Urutan kolom: <code class="bg-white px-1 py-0.5 rounded">kode_sarana, nama_sarana, jumlah, kondisi, status, lokasi, deskripsi</code></li>
                                <li>Nilai kolom <em>kondisi</em>: <code class="bg-white px-1 py-0.5 rounded">baik</code>, <code class="bg-white px-1 py-0.5 rounded">rusak_ringan</code>, atau <code class="bg-white px-1 py-0.5 rounded">rusak_berat</code>.</li>
                            </ul>
                            <div class="pt-1">
                                <a href="{{ route('admin.sarana.template') }}" class="inline-flex items-center gap-1.5 font-semibold text-emerald-900 underline hover:text-emerald-700">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                    Unduh Contoh Template CSV
                                </a>
                            </div>
                        </div>

                        <!-- Input File -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Pilih File CSV</label>
                            <input type="file" name="file_excel" accept=".csv" required
                                   class="w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-800 hover:file:bg-emerald-100 border border-gray-200 rounded-xl p-1.5">
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex justify-end gap-3 pt-2 border-t border-gray-100">
                            <button type="button" onclick="closeImportModal()" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-xl transition">
                                Batal
                            </button>
                            <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-[#0f2e24] hover:bg-[#163f32] rounded-xl transition">
                                Mulai Impor
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>

<script>
    function toggleExcelDropdown() {
        document.getElementById('excelDropdownMenu').classList.toggle('hidden');
    }

    function openImportModal() {
        document.getElementById('excelDropdownMenu').classList.add('hidden');
        document.getElementById('importModal').classList.remove('hidden');
    }

    function closeImportModal() {
        document.getElementById('importModal').classList.add('hidden');
    }

    document.addEventListener('click', function(event) {
        const wrapper = document.getElementById('excelDropdownWrapper');
        const menu = document.getElementById('excelDropdownMenu');
        if (wrapper && !wrapper.contains(event.target)) {
            menu.classList.add('hidden');
        }
    });

    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeImportModal();
        }
    });
</script>
@endsection