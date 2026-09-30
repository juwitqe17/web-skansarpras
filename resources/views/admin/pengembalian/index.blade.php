@extends('layouts.admin')

@section('page-content')
<div class="space-y-6">

    <!-- Header Section -->
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Manajemen Pengembalian</h1>
        <p class="text-sm text-gray-500 mt-1">Manajemen pengembalian barang yang telah dipinjam & pengecekan kondisi barang.</p>
    </div>

    <!-- Filter Departemen & Summary Cards Container -->
    <div class="bg-white p-5 rounded-2xl border border-gray-200 shadow-sm space-y-5">
        
        <!-- Top Bar Filter Departemen -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 pb-2">
            <div class="flex items-center space-x-3">
                <div class="p-2.5 bg-gray-100 rounded-lg text-gray-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-sm font-semibold text-gray-900">Pilih Kategori Departemen / Jurusan</h2>
                    <p class="text-xs text-gray-500">Data sarana & prasarana akan disaring sesuai dengan departemen.</p>
                </div>
            </div>

            <div class="w-full sm:w-64">
                <select class="w-full text-xs text-gray-500 bg-gray-50 border border-gray-200 rounded-lg px-3 py-2.5 focus:outline-none focus:border-emerald-600 cursor-pointer">
                    <option value="">Pilih Departemen / Jurusan</option>
                    <option value="1">Rekayasa Perangkat Lunak</option>
                    <option value="2">Teknik Komputer & Jaringan</option>
                    <option value="3">Multimedia / DKV</option>
                </select>
            </div>
        </div>

        <!-- 3 Cards Summary Counter -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <!-- Card 1: Sedang Berlangsung -->
            <div class="p-4 bg-white rounded-xl border border-gray-200 flex justify-between items-center">
                <div>
                    <p class="text-xs font-semibold text-gray-800">Sedang Berlangsung</p>
                    <h3 class="text-3xl font-black text-gray-900 mt-1">12</h3>
                </div>
                <div class="p-2 text-gray-800">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>

            <!-- Card 2: Terlambat -->
            <div class="p-4 bg-white rounded-xl border border-gray-200 flex justify-between items-center">
                <div>
                    <p class="text-xs font-semibold text-gray-800">Terlambat</p>
                    <h3 class="text-3xl font-black text-gray-900 mt-1">5</h3>
                </div>
                <div class="p-2 text-gray-800">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
            </div>

            <!-- Card 3: Selesai hari ini -->
            <div class="p-4 bg-white rounded-xl border border-gray-200 flex justify-between items-center">
                <div>
                    <p class="text-xs font-semibold text-gray-800">Selesai hari ini</p>
                    <h3 class="text-3xl font-black text-gray-900 mt-1">15</h3>
                </div>
                <div class="p-2 text-gray-800">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
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
            <input type="text" placeholder="Cari no.pengajuan, pemohon, ..." class="w-full bg-gray-50 text-xs pl-9 pr-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:border-emerald-600 text-gray-600 placeholder-gray-400">
        </div>

        <div class="w-full sm:w-36">
            <select class="w-full bg-gray-50 text-xs text-gray-500 border border-gray-200 rounded-lg px-3 py-2.5 focus:outline-none focus:border-emerald-600 cursor-pointer">
                <option value="">Status</option>
                <option value="menunggu">Menunggu Verifikasi</option>
                <option value="berlangsung">Sedang Berlangsung</option>
                <option value="terlambat">Terlambat</option>
                <option value="selesai">Selesai</option>
            </select>
        </div>
    </div>

    <!-- Table Section Card -->
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
        <!-- Table Title Header -->
        <div class="p-4 border-b border-gray-100 flex items-center space-x-3">
            <div class="p-2 bg-[#0b3323] text-white rounded-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 4H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-2m-4-1v8m0 0l3-3m-3 3L9 8m-5 5h2.586a1 1 0 01.707.293l2.414 2.414a1 1 0 00.707.293h3.172a1 1 0 00.707-.293l2.414-2.414a1 1 0 01.707-.293H20"></path>
                </svg>
            </div>
            <h3 class="text-base font-bold text-gray-900">Daftar Peminjam & Pengembalian</h3>
        </div>

        <!-- Table Data -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-[#0b3323] text-white text-[11px] font-semibold uppercase tracking-wider">
                        <th class="py-3.5 px-4">NO. PENGAJUAN / TANGGAL</th>
                        <th class="py-3.5 px-4">IDENTITAS PEMINJAM</th>
                        <th class="py-3.5 px-4">SARANA PRASARANA & JUMLAH</th>
                        <th class="py-3.5 px-4">JADWAL PEMINJAMAN</th>
                        <th class="py-3.5 px-4 text-center">STATUS</th>
                        <th class="py-3.5 px-4 text-center">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-xs text-gray-600">
                    
                    <!-- Row 1: Menunggu Verifikasi -->
                    <tr class="hover:bg-gray-50 transition">
                        <td class="py-4 px-4 align-top">
                            <p class="font-bold text-gray-900">5</p>
                            <p class="text-[11px] text-gray-400 mt-1">14 Agustus 2026, 08.15</p>
                        </td>
                        <td class="py-4 px-4 align-top space-y-0.5">
                            <p class="font-bold text-gray-900">Budi Santoso</p>
                            <p class="text-[11px] text-gray-400">Email: <span class="underline">budisantoso.2024@smkn1purwosari.sch.id</span></p>
                            <p class="text-[11px] font-semibold text-[#0b3323]">Kelas: XII RPL</p>
                        </td>
                        <td class="py-4 px-4 align-top">
                            <p class="font-bold text-gray-900">Proyektor EPSON</p>
                            <p class="text-[11px] text-gray-400 mt-1">Jumlah: 2 Unit</p>
                        </td>
                        <td class="py-4 px-4 align-top space-y-2">
                            <div>
                                <p class="font-semibold text-gray-900">Pinjam</p>
                                <p class="text-[11px] text-gray-400">14 Agustus 2026, 08.00 WIB</p>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900">Kembali</p>
                                <p class="text-[11px] text-gray-400">14 Agustus 2026, 14.00 WIB</p>
                            </div>
                        </td>
                        <td class="py-4 px-4 align-top text-center">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-semibold bg-amber-50 text-amber-600 border border-amber-200">
                                <span class="w-1.5 h-1.5 mr-1.5 bg-amber-500 rounded-full"></span>
                                Menunggu Verifikasi
                            </span>
                        </td>
                        <td class="py-4 px-4 align-top text-center">
                            <button type="button" class="px-3.5 py-1.5 bg-[#0b3323] hover:bg-emerald-900 text-white rounded-md text-xs font-medium transition shadow-sm">
                                Verifikasi
                            </button>
                        </td>
                    </tr>

                    <!-- Row 2: Sedang Berlangsung -->
                    <tr class="hover:bg-gray-50 transition">
                        <td class="py-4 px-4 align-top">
                            <p class="font-bold text-gray-900">4</p>
                            <p class="text-[11px] text-gray-400 mt-1">14 Agustus 2026, 08.15</p>
                        </td>
                        <td class="py-4 px-4 align-top space-y-0.5">
                            <p class="font-bold text-gray-900">Budi Santoso</p>
                            <p class="text-[11px] text-gray-400">Email: <span class="underline">budisantoso.2024@smkn1purwosari.sch.id</span></p>
                            <p class="text-[11px] font-semibold text-[#0b3323]">Kelas: XII RPL</p>
                        </td>
                        <td class="py-4 px-4 align-top">
                            <p class="font-bold text-gray-900">Proyektor EPSON</p>
                            <p class="text-[11px] text-gray-400 mt-1">Jumlah: 2 Unit</p>
                        </td>
                        <td class="py-4 px-4 align-top space-y-2">
                            <div>
                                <p class="font-semibold text-gray-900">Pinjam</p>
                                <p class="text-[11px] text-gray-400">14 Agustus 2026, 08.00 WIB</p>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900">Kembali</p>
                                <p class="text-[11px] text-gray-400">14 Agustus 2026, 14.00 WIB</p>
                            </div>
                        </td>
                        <td class="py-4 px-4 align-top text-center">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-semibold bg-sky-50 text-sky-500 border border-sky-200">
                                <span class="w-1.5 h-1.5 mr-1.5 bg-sky-500 rounded-full"></span>
                                Sedang Berlangsung
                            </span>
                        </td>
                        <td class="py-4 px-4 align-top text-center">
                            <button type="button" class="px-3.5 py-1.5 bg-[#0b3323] hover:bg-emerald-900 text-white rounded-md text-xs font-medium transition shadow-sm">
                                Verifikasi
                            </button>
                        </td>
                    </tr>

                    <!-- Row 3: Terlambat -->
                    <tr class="hover:bg-gray-50 transition">
                        <td class="py-4 px-4 align-top">
                            <p class="font-bold text-gray-900">4</p>
                            <p class="text-[11px] text-gray-400 mt-1">14 Agustus 2026, 08.15</p>
                        </td>
                        <td class="py-4 px-4 align-top space-y-0.5">
                            <p class="font-bold text-gray-900">Budi Santoso</p>
                            <p class="text-[11px] text-gray-400">Email: <span class="underline">budisantoso.2024@smkn1purwosari.sch.id</span></p>
                            <p class="text-[11px] font-semibold text-[#0b3323]">Kelas: XII RPL</p>
                        </td>
                        <td class="py-4 px-4 align-top">
                            <p class="font-bold text-gray-900">Proyektor EPSON</p>
                            <p class="text-[11px] text-gray-400 mt-1">Jumlah: 2 Unit</p>
                        </td>
                        <td class="py-4 px-4 align-top space-y-2">
                            <div>
                                <p class="font-semibold text-gray-900">Pinjam</p>
                                <p class="text-[11px] text-gray-400">14 Agustus 2026, 08.00 WIB</p>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900">Kembali</p>
                                <p class="text-[11px] text-red-500 font-semibold">14 Agustus 2026, 14.00 WIB</p>
                            </div>
                        </td>
                        <td class="py-4 px-4 align-top text-center">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-semibold bg-red-50 text-red-500 border border-red-200">
                                <span class="w-1.5 h-1.5 mr-1.5 bg-red-500 rounded-full"></span>
                                Terlambat
                            </span>
                        </td>
                        <td class="py-4 px-4 align-top text-center">
                            <button type="button" class="px-3.5 py-1.5 bg-[#0b3323] hover:bg-emerald-900 text-white rounded-md text-xs font-medium transition shadow-sm">
                                Verifikasi
                            </button>
                        </td>
                    </tr>

                    <!-- Row 4: Selesai -->
                    <tr class="hover:bg-gray-50 transition">
                        <td class="py-4 px-4 align-top">
                            <p class="font-bold text-gray-900">4</p>
                            <p class="text-[11px] text-gray-400 mt-1">14 Agustus 2026, 08.15</p>
                        </td>
                        <td class="py-4 px-4 align-top space-y-0.5">
                            <p class="font-bold text-gray-900">Budi Santoso</p>
                            <p class="text-[11px] text-gray-400">Email: <span class="underline">budisantoso.2024@smkn1purwosari.sch.id</span></p>
                            <p class="text-[11px] font-semibold text-[#0b3323]">Kelas: XII RPL</p>
                        </td>
                        <td class="py-4 px-4 align-top">
                            <p class="font-bold text-gray-900">Proyektor EPSON</p>
                            <p class="text-[11px] text-gray-400 mt-1">Jumlah: 2 Unit</p>
                        </td>
                        <td class="py-4 px-4 align-top space-y-2">
                            <div>
                                <p class="font-semibold text-gray-900">Pinjam</p>
                                <p class="text-[11px] text-gray-400">14 Agustus 2026, 08.00 WIB</p>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900">Kembali</p>
                                <p class="text-[11px] text-gray-400">14 Agustus 2026, 14.00 WIB</p>
                            </div>
                        </td>
                        <td class="py-4 px-4 align-top text-center">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-semibold bg-emerald-50 text-emerald-600 border border-emerald-200">
                                <svg class="w-3 h-3 mr-1 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Selesai
                            </span>
                        </td>
                        <td class="py-4 px-4 align-top text-center">
                            <button type="button" class="px-3.5 py-1.5 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 rounded-md text-xs font-medium transition shadow-sm">
                                Detail
                            </button>
                        </td>
                    </tr>

                    <!-- Row 5: Selesai -->
                    <tr class="hover:bg-gray-50 transition">
                        <td class="py-4 px-4 align-top">
                            <p class="font-bold text-gray-900">1</p>
                            <p class="text-[11px] text-gray-400 mt-1">14 Agustus 2026, 08.15</p>
                        </td>
                        <td class="py-4 px-4 align-top space-y-0.5">
                            <p class="font-bold text-gray-900">Budi Santoso</p>
                            <p class="text-[11px] text-gray-400">Email: <span class="underline">budisantoso.2024@smkn1purwosari.sch.id</span></p>
                            <p class="text-[11px] font-semibold text-[#0b3323]">Kelas: XII RPL</p>
                        </td>
                        <td class="py-4 px-4 align-top">
                            <p class="font-bold text-gray-900">Proyektor EPSON</p>
                            <p class="text-[11px] text-gray-400 mt-1">Jumlah: 2 Unit</p>
                        </td>
                        <td class="py-4 px-4 align-top space-y-2">
                            <div>
                                <p class="font-semibold text-gray-900">Pinjam</p>
                                <p class="text-[11px] text-gray-400">14 Agustus 2026, 08.00 WIB</p>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900">Kembali</p>
                                <p class="text-[11px] text-gray-400">14 Agustus 2026, 14.00 WIB</p>
                            </div>
                        </td>
                        <td class="py-4 px-4 align-top text-center">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-semibold bg-emerald-50 text-emerald-600 border border-emerald-200">
                                <svg class="w-3 h-3 mr-1 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Selesai
                            </span>
                        </td>
                        <td class="py-4 px-4 align-top text-center">
                            <button type="button" class="px-3.5 py-1.5 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 rounded-md text-xs font-medium transition shadow-sm">
                                Detail
                            </button>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>

        <!-- Table Pagination Footer -->
        <div class="p-4 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-gray-500">
            <p>Menampilkan <span class="font-semibold text-gray-800">1</span> sampai <span class="font-semibold text-gray-800">5</span> dari <span class="font-semibold text-gray-800">32</span> data</p>
            <div class="flex items-center space-x-1">
                <button class="px-3 py-1.5 rounded-lg border border-gray-200 bg-white text-gray-400 cursor-not-allowed">Sebelumnya</button>
                <button class="px-3 py-1.5 rounded-lg bg-[#0b3323] text-white font-semibold">1</button>
                <button class="px-3 py-1.5 rounded-lg border border-gray-200 bg-white hover:bg-gray-50 text-gray-600">2</button>
                <button class="px-3 py-1.5 rounded-lg border border-gray-200 bg-white hover:bg-gray-50 text-gray-600">3</button>
                <button class="px-3 py-1.5 rounded-lg border border-gray-200 bg-white hover:bg-gray-50 text-gray-600">Selanjutnya</button>
            </div>
        </div>
    </div>

</div>
@endsection