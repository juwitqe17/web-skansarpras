@extends('layouts.admin')

@section('page-content')
<div class="space-y-6 text-gray-800">
    <!-- Header Page -->
    <div>
        <h1 class="text-3xl font-bold text-gray-900">Manajemen Pengajuan</h1>
        <p class="mt-1 text-sm text-gray-400">Lorem ipsum dolor sit amet, consectetur adipiscing.</p>
    </div>

    <!-- Filter & Summary Section Card -->
    <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-sm space-y-5">
        <!-- Top Bar Filter Departemen -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 pb-2 border-b border-gray-100">
            <div class="flex items-center space-x-3">
                <div class="p-2.5 bg-gray-100 rounded-lg text-gray-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-sm font-semibold text-gray-900">Pilih Kategori Departemen / Jurusan</h2>
                    <p class="text-xs text-gray-400">Data sarana & prasarana akan disaring sesuai dengan departemen.</p>
                </div>
            </div>
            
            <div class="w-full sm:w-64">
                <select class="w-full text-xs text-gray-600 bg-gray-50 border border-gray-200 rounded-lg px-3 py-2.5 focus:outline-none focus:border-emerald-600">
                    <option value="">Pilih Departemen / Jurusan</option>
                    <option value="1">Rekayasa Perangkat Lunak</option>
                    <option value="2">Teknik Komputer & Jaringan</option>
                </select>
            </div>
        </div>

        <!-- 4 Cards Counter -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Card 1: Jumlah Pengajuan -->
            <div class="bg-white border border-gray-200 rounded-xl p-4 flex justify-between items-center">
                <div>
                    <span class="text-xs font-semibold text-gray-600">Jumlah Pengajuan</span>
                    <div class="text-3xl font-bold text-gray-900 mt-1">33</div>
                </div>
                <div class="text-gray-400">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
            </div>

            <!-- Card 2: Disetujui Hari ini -->
            <div class="bg-white border border-gray-200 rounded-xl p-4 flex justify-between items-center">
                <div>
                    <span class="text-xs font-semibold text-gray-600">Disetujui Hari ini</span>
                    <div class="text-3xl font-bold text-gray-900 mt-1">12</div>
                </div>
                <div class="text-gray-400">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>

            <!-- Card 3: Ditolak/Dibatalkan -->
            <div class="bg-white border border-gray-200 rounded-xl p-4 flex justify-between items-center">
                <div>
                    <span class="text-xs font-semibold text-gray-600">Ditolak/Dibatalkan</span>
                    <div class="text-3xl font-bold text-gray-900 mt-1">5</div>
                </div>
                <div class="text-gray-400">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>

            <!-- Card 4: Menunggu -->
            <div class="bg-white border border-gray-200 rounded-xl p-4 flex justify-between items-center">
                <div>
                    <span class="text-xs font-semibold text-gray-600">Menunggu</span>
                    <div class="text-3xl font-bold text-gray-900 mt-1">15</div>
                </div>
                <div class="text-gray-400">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Search & Filter Controls -->
    <div class="bg-white p-3 rounded-xl border border-gray-200 shadow-sm flex flex-col sm:flex-row gap-3">
        <div class="relative flex-1">
            <svg class="w-4 h-4 text-gray-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <input type="text" placeholder="Cari no.pengajuan, pemohon, ..." class="w-full text-xs pl-9 pr-3 py-2 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:border-emerald-600">
        </div>
        <div class="w-full sm:w-40">
            <select class="w-full text-xs text-gray-500 bg-gray-50 border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:border-emerald-600">
                <option value="">Status</option>
                <option value="menunggu">Menunggu</option>
                <option value="disetujui">Disetujui</option>
                <option value="ditolak">Ditolak</option>
            </select>
        </div>
    </div>

    <!-- Main Table Container Card -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        <!-- Card Table Header -->
        <div class="p-4 border-b border-gray-100 flex items-center space-x-2">
            <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
            </svg>
            <h3 class="font-bold text-gray-900 text-sm">Persetujuan Pengajuan dan Peminjaman</h3>
        </div>

        <!-- Table View -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-[#0A261D] text-white text-[11px] uppercase tracking-wider">
                        <th class="p-3 font-semibold">NO. PENGAJUAN / TANGGAL</th>
                        <th class="p-3 font-semibold">PEMOHON & KEPERLUAN</th>
                        <th class="p-3 font-semibold">SARANA PRASARANA & JUMLAH</th>
                        <th class="p-3 font-semibold">WAKTU PENGGUNAAN & LOKASI</th>
                        <th class="p-3 font-semibold">STATUS</th>
                        <th class="p-3 font-semibold text-center">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-xs text-gray-700">
                    
                    <!-- Row 1: Menunggu -->
                    <tr class="hover:bg-gray-50/50">
                        <td class="p-3 align-top">
                            <span class="font-bold text-gray-900">5</span>
                            <div class="text-[11px] text-gray-400 mt-1">14 Agustus 2026, 08.15</div>
                        </td>
                        <td class="p-3 align-top space-y-1">
                            <div class="font-bold text-gray-900">Budi Santoso</div>
                            <div class="text-[11px] text-gray-400">Email: budisantoso.2034@smkn1purwosari.sch.id</div>
                            <div class="inline-block bg-gray-100 text-gray-500 text-[10px] px-2 py-0.5 rounded">
                                Keperluan: Pembelajaran mata pelajaran IPAS di Kelas
                            </div>
                        </td>
                        <td class="p-3 align-top">
                            <div class="font-bold text-gray-900">Proyektor EPSON</div>
                            <div class="text-[11px] text-gray-400 mt-0.5">Jumlah: 2 Unit</div>
                        </td>
                        <td class="p-3 align-top">
                            <div class="font-bold text-gray-900">14 Agustus 2026</div>
                            <div class="text-[11px] text-gray-400">08.00 - 14.00 (6 Jam)</div>
                            <div class="text-[11px] text-amber-600 font-medium">Lokasi: Gedung G-201</div>
                        </td>
                        <td class="p-3 align-top">
                            <span class="bg-amber-100 text-amber-800 text-[10px] font-semibold px-2 py-1 rounded-full inline-flex items-center gap-1">
                                <span class="w-1.5 h-1.5 bg-amber-500 rounded-full"></span> Menunggu
                            </span>
                        </td>
                        <td class="p-3 align-top text-center">
                            <div class="flex items-center justify-center space-x-1">
                                <button class="bg-[#0F392B] text-white text-[10px] font-medium px-2.5 py-1 rounded hover:bg-emerald-800 transition-colors">Setujui</button>
                                <button class="border border-red-400 text-red-500 text-[10px] font-medium px-2.5 py-1 rounded hover:bg-red-50 transition-colors">Tolak</button>
                                <button class="text-gray-400 hover:text-gray-600 p-1">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"/></svg>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <!-- Row 2: Disetujui -->
                    <tr class="hover:bg-gray-50/50">
                        <td class="p-3 align-top">
                            <span class="font-bold text-gray-900">4</span>
                            <div class="text-[11px] text-gray-400 mt-1">14 Agustus 2026, 08.15</div>
                        </td>
                        <td class="p-3 align-top space-y-1">
                            <div class="font-bold text-gray-900">Budi Santoso</div>
                            <div class="text-[11px] text-gray-400">Email: budisantoso.2034@smkn1purwosari.sch.id</div>
                            <div class="inline-block bg-gray-100 text-gray-500 text-[10px] px-2 py-0.5 rounded">
                                Keperluan: Pembelajaran mata pelajaran IPAS di Kelas
                            </div>
                        </td>
                        <td class="p-3 align-top">
                            <div class="font-bold text-gray-900">Proyektor EPSON</div>
                            <div class="text-[11px] text-gray-400 mt-0.5">Jumlah: 2 Unit</div>
                        </td>
                        <td class="p-3 align-top">
                            <div class="font-bold text-gray-900">14 Agustus 2026</div>
                            <div class="text-[11px] text-gray-400">08.00 - 14.00 (6 Jam)</div>
                            <div class="text-[11px] text-amber-600 font-medium">Lokasi: Gedung G-201</div>
                        </td>
                        <td class="p-3 align-top">
                            <span class="bg-emerald-100 text-emerald-800 text-[10px] font-semibold px-2 py-1 rounded-full inline-flex items-center gap-1">
                                <svg class="w-3 h-3 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> Disetujui
                            </span>
                        </td>
                        <td class="p-3 align-top text-center">
                            <button class="border border-gray-300 text-gray-700 text-[10px] font-medium px-3 py-1 rounded hover:bg-gray-50 transition-colors">Detail</button>
                        </td>
                    </tr>

                    <!-- Row 3: Ditolak -->
                    <tr class="hover:bg-gray-50/50">
                        <td class="p-3 align-top">
                            <span class="font-bold text-gray-900">3</span>
                            <div class="text-[11px] text-gray-400 mt-1">14 Agustus 2026, 08.15</div>
                        </td>
                        <td class="p-3 align-top space-y-1">
                            <div class="font-bold text-gray-900">Budi Santoso</div>
                            <div class="text-[11px] text-gray-400">Email: budisantoso.2034@smkn1purwosari.sch.id</div>
                            <div class="inline-block bg-gray-100 text-gray-500 text-[10px] px-2 py-0.5 rounded">
                                Keperluan: Pembelajaran mata pelajaran IPAS di Kelas
                            </div>
                        </td>
                        <td class="p-3 align-top">
                            <div class="font-bold text-gray-900">Proyektor EPSON</div>
                            <div class="text-[11px] text-gray-400 mt-0.5">Jumlah: 2 Unit</div>
                        </td>
                        <td class="p-3 align-top">
                            <div class="font-bold text-gray-900">14 Agustus 2026</div>
                            <div class="text-[11px] text-gray-400">08.00 - 14.00 (6 Jam)</div>
                            <div class="text-[11px] text-amber-600 font-medium">Lokasi: Gedung G-201</div>
                        </td>
                        <td class="p-3 align-top">
                            <span class="bg-red-100 text-red-700 text-[10px] font-semibold px-2 py-1 rounded-full inline-flex items-center gap-1">
                                <svg class="w-3 h-3 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg> Ditolak
                            </span>
                        </td>
                        <td class="p-3 align-top text-center">
                            <button class="border border-gray-300 text-gray-700 text-[10px] font-medium px-3 py-1 rounded hover:bg-gray-50 transition-colors">Detail</button>
                        </td>
                    </tr>

                    <!-- Row 4: Menunggu -->
                    <tr class="hover:bg-gray-50/50">
                        <td class="p-3 align-top">
                            <span class="font-bold text-gray-900">2</span>
                            <div class="text-[11px] text-gray-400 mt-1">14 Agustus 2026, 08.15</div>
                        </td>
                        <td class="p-3 align-top space-y-1">
                            <div class="font-bold text-gray-900">Budi Santoso</div>
                            <div class="text-[11px] text-gray-400">Email: budisantoso.2034@smkn1purwosari.sch.id</div>
                            <div class="inline-block bg-gray-100 text-gray-500 text-[10px] px-2 py-0.5 rounded">
                                Keperluan: Pembelajaran mata pelajaran IPAS di Kelas
                            </div>
                        </td>
                        <td class="p-3 align-top">
                            <div class="font-bold text-gray-900">Proyektor EPSON</div>
                            <div class="text-[11px] text-gray-400 mt-0.5">Jumlah: 2 Unit</div>
                        </td>
                        <td class="p-3 align-top">
                            <div class="font-bold text-gray-900">14 Agustus 2026</div>
                            <div class="text-[11px] text-gray-400">08.00 - 14.00 (6 Jam)</div>
                            <div class="text-[11px] text-amber-600 font-medium">Lokasi: Gedung G-201</div>
                        </td>
                        <td class="p-3 align-top">
                            <span class="bg-amber-100 text-amber-800 text-[10px] font-semibold px-2 py-1 rounded-full inline-flex items-center gap-1">
                                <span class="w-1.5 h-1.5 bg-amber-500 rounded-full"></span> Menunggu
                            </span>
                        </td>
                        <td class="p-3 align-top text-center">
                            <div class="flex items-center justify-center space-x-1">
                                <button class="bg-[#0F392B] text-white text-[10px] font-medium px-2.5 py-1 rounded hover:bg-emerald-800 transition-colors">Setujui</button>
                                <button class="border border-red-400 text-red-500 text-[10px] font-medium px-2.5 py-1 rounded hover:bg-red-50 transition-colors">Tolak</button>
                                <button class="text-gray-400 hover:text-gray-600 p-1">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"/></svg>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <!-- Row 5: Menunggu -->
                    <tr class="hover:bg-gray-50/50">
                        <td class="p-3 align-top">
                            <span class="font-bold text-gray-900">1</span>
                            <div class="text-[11px] text-gray-400 mt-1">14 Agustus 2026, 08.15</div>
                        </td>
                        <td class="p-3 align-top space-y-1">
                            <div class="font-bold text-gray-900">Budi Santoso</div>
                            <div class="text-[11px] text-gray-400">Email: budisantoso.2034@smkn1purwosari.sch.id</div>
                            <div class="inline-block bg-gray-100 text-gray-500 text-[10px] px-2 py-0.5 rounded">
                                Keperluan: Pembelajaran mata pelajaran IPAS di Kelas
                            </div>
                        </td>
                        <td class="p-3 align-top">
                            <div class="font-bold text-gray-900">Proyektor EPSON</div>
                            <div class="text-[11px] text-gray-400 mt-0.5">Jumlah: 2 Unit</div>
                        </td>
                        <td class="p-3 align-top">
                            <div class="font-bold text-gray-900">14 Agustus 2026</div>
                            <div class="text-[11px] text-gray-400">08.00 - 14.00 (6 Jam)</div>
                            <div class="text-[11px] text-amber-600 font-medium">Lokasi: Gedung G-201</div>
                        </td>
                        <td class="p-3 align-top">
                            <span class="bg-amber-100 text-amber-800 text-[10px] font-semibold px-2 py-1 rounded-full inline-flex items-center gap-1">
                                <span class="w-1.5 h-1.5 bg-amber-500 rounded-full"></span> Menunggu
                            </span>
                        </td>
                        <td class="p-3 align-top text-center">
                            <div class="flex items-center justify-center space-x-1">
                                <button class="bg-[#0F392B] text-white text-[10px] font-medium px-2.5 py-1 rounded hover:bg-emerald-800 transition-colors">Setujui</button>
                                <button class="border border-red-400 text-red-500 text-[10px] font-medium px-2.5 py-1 rounded hover:bg-red-50 transition-colors">Tolak</button>
                                <button class="text-gray-400 hover:text-gray-600 p-1">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"/></svg>
                                </button>
                            </div>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>

        <!-- Table Pagination Footer -->
        <div class="p-4 border-t border-gray-100 flex flex-col sm:flex-row justify-between items-center gap-3 text-xs text-gray-500">
            <div>
                Menampilkan <span class="font-medium text-gray-700">1</span> sampai <span class="font-medium text-gray-700">5</span> dari <span class="font-medium text-gray-700">32</span> data
            </div>
            <div class="flex items-center space-x-1">
                <button class="px-3 py-1 bg-gray-50 border border-gray-200 rounded text-gray-400 hover:bg-gray-100 transition-colors disabled:opacity-50" disabled>Sebelumnya</button>
                <button class="px-2.5 py-1 bg-[#0F392B] text-white font-medium rounded">1</button>
                <button class="px-2.5 py-1 border border-gray-200 text-gray-700 rounded hover:bg-gray-50">2</button>
                <button class="px-2.5 py-1 border border-gray-200 text-gray-700 rounded hover:bg-gray-50">3</button>
                <button class="px-3 py-1 border border-gray-200 text-gray-700 rounded hover:bg-gray-50 transition-colors">Selanjutnya</button>
            </div>
        </div>
    </div>
</div>
@endsection