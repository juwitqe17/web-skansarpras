@extends('layouts.admin')

@section('page-content')
<div class="space-y-6">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-[#0b3323]">Manajemen Departemen</h1>
            <p class="text-sm text-gray-400 mt-0.5">Lorem ipsum dolor sit amet, consectetur adipiscing.</p>
        </div>
        <div>
            <button type="button" class="inline-flex items-center space-x-2 bg-[#0b3323] hover:bg-emerald-900 text-white font-medium px-4 py-2.5 rounded-lg text-sm transition shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                <span>Tambah Departemen</span>
            </button>
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
                    <span class="text-3xl font-bold text-gray-900">10</span>
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
                    <span class="text-3xl font-bold text-gray-900">890</span>
                    <span class="text-xs text-gray-500 font-medium">unit</span>
                </div>
                <p class="text-[11px] text-gray-400">89% unit layak pakai</p>
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
                    <span class="text-3xl font-bold text-gray-900">1.010</span>
                    <span class="text-xs text-gray-500 font-medium">barang</span>
                </div>
                <p class="text-[11px] text-gray-400">89% unit layak pakai</p>
            </div>
        </div>
    </div>

    <!-- Filter & Search Bar -->
    <div class="bg-white p-3 rounded-2xl border border-gray-200 shadow-sm flex flex-col sm:flex-row gap-3">
        <div class="relative flex-1">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-gray-400">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </span>
            <input type="text" placeholder="Cari Departemen / Jurusan" class="w-full bg-gray-50 text-xs pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl focus:outline-none focus:border-emerald-600 text-gray-700 placeholder-gray-400">
        </div>

        <div class="flex gap-2">
            <div class="w-36">
                <select class="w-full bg-gray-50 text-xs text-gray-500 border border-gray-200 rounded-xl px-3 py-2.5 focus:outline-none focus:border-emerald-600 cursor-pointer">
                    <option value="">Teknologi</option>
                    <option value="1">Seni & Ekonomi Kreatif</option>
                    <option value="2">Pertanian</option>
                    <option value="3">Teknik</option>
                </select>
            </div>
            <div class="w-32">
                <select class="w-full bg-gray-50 text-xs text-gray-500 border border-gray-200 rounded-xl px-3 py-2.5 focus:outline-none focus:border-emerald-600 cursor-pointer">
                    <option value="">Status</option>
                    <option value="aktif">Aktif</option>
                    <option value="tidak_aktif">Tidak Aktif</option>
                </select>
            </div>
        </div>
    </div>

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
                    
                    <!-- Row 1: RPL -->
                    <tr class="hover:bg-gray-50 transition">
                        <td class="py-4 px-6 align-middle">
                            <span class="inline-block px-3 py-1 bg-amber-100 text-amber-800 font-bold rounded-full text-xs">
                                RPL
                            </span>
                        </td>
                        <td class="py-4 px-6 align-middle font-medium text-gray-900">
                            Rekayasa Perangkat Lunak
                        </td>
                        <td class="py-4 px-6 align-middle text-gray-600">
                            48 unit
                        </td>
                        <td class="py-4 px-6 align-middle">
                            <span class="inline-block px-3 py-1 bg-emerald-100 text-emerald-600 font-semibold rounded-full text-[11px]">
                                Aktif
                            </span>
                        </td>
                        <td class="py-4 px-6 align-middle text-center">
                            <div class="flex items-center justify-center space-x-3 text-gray-400">
                                <button type="button" class="hover:text-gray-600 transition" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                    </svg>
                                </button>
                                <button type="button" class="hover:text-red-500 transition" title="Hapus">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <!-- Row 2: DKV -->
                    <tr class="hover:bg-gray-50 transition">
                        <td class="py-4 px-6 align-middle">
                            <span class="inline-block px-3 py-1 bg-amber-100 text-amber-800 font-bold rounded-full text-xs">
                                DKV
                            </span>
                        </td>
                        <td class="py-4 px-6 align-middle font-medium text-gray-900">
                            Desain Komunikasi Visual
                        </td>
                        <td class="py-4 px-6 align-middle text-gray-600">
                            34 unit
                        </td>
                        <td class="py-4 px-6 align-middle">
                            <span class="inline-block px-3 py-1 bg-emerald-100 text-emerald-600 font-semibold rounded-full text-[11px]">
                                Aktif
                            </span>
                        </td>
                        <td class="py-4 px-6 align-middle text-center">
                            <div class="flex items-center justify-center space-x-3 text-gray-400">
                                <button type="button" class="hover:text-gray-600 transition" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                    </svg>
                                </button>
                                <button type="button" class="hover:text-red-500 transition" title="Hapus">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <!-- Row 3: ATPH -->
                    <tr class="hover:bg-gray-50 transition">
                        <td class="py-4 px-6 align-middle">
                            <span class="inline-block px-3 py-1 bg-emerald-100 text-emerald-800 font-bold rounded-full text-xs">
                                ATPH
                            </span>
                        </td>
                        <td class="py-4 px-6 align-middle font-medium text-gray-900">
                            Agribisnis Tanaman Pangan<br>dan Hortikultura
                        </td>
                        <td class="py-4 px-6 align-middle text-gray-600">
                            79 unit
                        </td>
                        <td class="py-4 px-6 align-middle">
                            <span class="inline-block px-3 py-1 bg-emerald-100 text-emerald-600 font-semibold rounded-full text-[11px]">
                                Aktif
                            </span>
                        </td>
                        <td class="py-4 px-6 align-middle text-center">
                            <div class="flex items-center justify-center space-x-3 text-gray-400">
                                <button type="button" class="hover:text-gray-600 transition" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                    </svg>
                                </button>
                                <button type="button" class="hover:text-red-500 transition" title="Hapus">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <!-- Row 4: TPM -->
                    <tr class="hover:bg-gray-50 transition">
                        <td class="py-4 px-6 align-middle">
                            <span class="inline-block px-3 py-1 bg-blue-100 text-blue-800 font-bold rounded-full text-xs">
                                TPM
                            </span>
                        </td>
                        <td class="py-4 px-6 align-middle font-medium text-gray-900">
                            Teknik Pemesinan
                        </td>
                        <td class="py-4 px-6 align-middle text-gray-600">
                            25 unit
                        </td>
                        <td class="py-4 px-6 align-middle">
                            <span class="inline-block px-3 py-1 bg-red-100 text-red-500 font-semibold rounded-full text-[11px]">
                                Tidak Aktif
                            </span>
                        </td>
                        <td class="py-4 px-6 align-middle text-center">
                            <div class="flex items-center justify-center space-x-3 text-gray-400">
                                <button type="button" class="hover:text-gray-600 transition" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                    </svg>
                                </button>
                                <button type="button" class="hover:text-red-500 transition" title="Hapus">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection