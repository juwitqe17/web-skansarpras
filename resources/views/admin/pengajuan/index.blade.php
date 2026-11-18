@extends('layouts.admin')

<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

@section('page-content')
<div x-data="{ 
    openModal: false, 
    loading: false, 
    data: {},
    fetchDetail(id) {
        this.openModal = true;
        this.loading = true;
        fetch(`/admin/pengajuan/${id}`)
            .then(res => res.json())
            .then(resData => {
                this.data = resData;
                this.loading = false;
            })
            .catch(() => {
                alert('Gagal mengambil data detail');
                this.openModal = false;
                this.loading = false;
            });
    }
}" class="space-y-6 text-gray-800">

    <!-- Header Page -->
    <div>
        <h1 class="text-3xl font-bold text-gray-900">Manajemen Pengajuan</h1>
        <p class="mt-1 text-sm text-gray-400">Persetujuan dan pemantauan pengajuan sarana & prasarana.</p>
    </div>

    <!-- Alert Notifikasi -->
    @if (session('success'))
        <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs rounded-xl flex justify-between items-center">
            <span>{{ session('success') }}</span>
            <button onclick="this.parentElement.remove()" class="text-emerald-700 font-bold">&times;</button>
        </div>
    @endif

    @if (session('error'))
        <div class="p-4 bg-red-50 border border-red-200 text-red-700 text-xs rounded-xl flex justify-between items-center">
            <span>{{ session('error') }}</span>
            <button onclick="this.parentElement.remove()" class="text-red-700 font-bold">&times;</button>
        </div>
    @endif

    <!-- Form Filter & Statistik Utama (Sesuai Gambar) -->
    <form method="GET" action="{{ route('admin.pengajuan.index') }}" id="filterForm">
        <!-- Simpan nilai status & search agar tetap terbawa saat filter jurusan berubah -->
        <input type="hidden" name="status" value="{{ request('status') }}">
        <input type="hidden" name="search" value="{{ request('search') }}">

        <div class="bg-white p-5 rounded-2xl border border-gray-200 shadow-sm space-y-5">
            
            <!-- Baris Pilih Kategori Departemen / Jurusan -->
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 pb-4 border-b border-gray-100">
                <div class="flex items-center space-x-3">
                    <div class="p-2.5 bg-gray-100 rounded-xl text-gray-700">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-900 text-sm">Pilih Kategori Departemen / Jurusan</h3>
                        <p class="text-xs text-gray-400">Data sarana & prasarana akan disaring sesuai dengan departemen.</p>
                    </div>
                </div>

                <div class="w-full sm:w-72">
                    <select name="jurusan_id" onchange="this.form.submit()" class="w-full text-xs text-gray-700 bg-gray-50 border border-gray-200 rounded-xl px-3.5 py-2.5 focus:outline-none focus:border-emerald-600 font-medium">
                        <option value="">Semua Departemen / Jurusan</option>
                        @foreach($jurusans as $jurusan)
                            <option value="{{ $jurusan->id }}" {{ request('jurusan_id') == $jurusan->id ? 'selected' : '' }}>
                                {{ $jurusan->nama_jurusan }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Grid Statistik (4 Cards) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Card 1: Jumlah Pengajuan -->
                <div class="p-4 rounded-xl border border-gray-200 bg-white flex flex-col justify-between space-y-2">
                    <span class="text-xs font-semibold text-gray-500">Jumlah Pengajuan</span>
                    <div class="flex items-end justify-between">
                        <span class="text-2xl font-black text-gray-900">{{ $totalPengajuan }}</span>
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    </div>
                </div>

                <!-- Card 2: Disetujui Hari Ini -->
                <div class="p-4 rounded-xl border border-gray-200 bg-white flex flex-col justify-between space-y-2">
                    <span class="text-xs font-semibold text-gray-500">Disetujui Hari ini</span>
                    <div class="flex items-end justify-between">
                        <span class="text-2xl font-black text-gray-900">{{ $disetujuiHariIni }}</span>
                        <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                </div>

                <!-- Card 3: Ditolak/Dibatalkan -->
                <div class="p-4 rounded-xl border border-gray-200 bg-white flex flex-col justify-between space-y-2">
                    <span class="text-xs font-semibold text-gray-500">Ditolak/Dibatalkan</span>
                    <div class="flex items-end justify-between">
                        <span class="text-2xl font-black text-gray-900">{{ $ditolakCount }}</span>
                        <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                </div>

                <!-- Card 4: Menunggu -->
                <div class="p-4 rounded-xl border border-gray-200 bg-white flex flex-col justify-between space-y-2">
                    <span class="text-xs font-semibold text-gray-500">Menunggu</span>
                    <div class="flex items-end justify-between">
                        <span class="text-2xl font-black text-gray-900">{{ $menungguCount }}</span>
                        <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                </div>
            </div>

        </div>
    </form>

    <!-- Search & Status Filter Controls -->
    <form method="GET" action="{{ route('admin.pengajuan.index') }}" class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm flex flex-col sm:flex-row gap-3">
        <!-- Pertahankan jurusan_id jika sedang difilter -->
        <input type="hidden" name="jurusan_id" value="{{ request('jurusan_id') }}">

        <div class="relative flex-1">
            <svg class="w-4 h-4 text-gray-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari no. pengajuan, pemohon, atau keperluan..." class="w-full text-xs pl-9 pr-3 py-2 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:border-emerald-600">
        </div>

        <div class="w-full sm:w-48">
            <select name="status" onchange="this.form.submit()" class="w-full text-xs text-gray-600 bg-gray-50 border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:border-emerald-600">
                <option value="">Status</option>
                <option value="menunggu" {{ request('status') == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                <option value="disetujui" {{ request('status') == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
            </select>
        </div>
    </form>

    <!-- Main Table Container Card -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
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
                        <th class="p-3 font-semibold">SARANA & PRASARANA</th>
                        <th class="p-3 font-semibold">STATUS</th>
                        <th class="p-3 font-semibold text-center">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-xs text-gray-700">
                    @forelse($pengajuans as $item)
                        <tr class="hover:bg-gray-50/50">
                            <!-- ID & Tanggal Pengajuan -->
                            <td class="p-3 align-top">
                                <span class="font-bold text-gray-900">#{{ $item->id }}</span>
                                <div class="text-[11px] text-gray-400 mt-1">
                                    {{ \Carbon\Carbon::parse($item->tanggal_pengajuan)->translatedFormat('d F Y') }}
                                </div>
                            </td>

                            <!-- Pemohon, Jurusan & Keperluan -->
                            <td class="p-3 align-top space-y-1">
                                <div class="font-bold text-gray-900">{{ $item->user->name ?? 'User Hilang' }}</div>
                                <div class="text-[11px] text-gray-400">{{ $item->user->email ?? '-' }}</div>
                                <div class="text-[11px] text-emerald-700 font-medium">
                                    Jurusan: {{ $item->user->jurusan->nama_jurusan ?? '-' }}
                                </div>
                                <div class="inline-block bg-gray-100 text-gray-600 text-[10px] px-2 py-0.5 rounded mt-1">
                                    Keperluan: {{ $item->keperluan }}
                                </div>
                            </td>

                            <!-- Detail Sarana -->
                            <td class="p-3 align-top">
                                <ul class="list-disc list-inside space-y-1">
                                    @forelse($item->detailPeminjamans as $detail)
                                        <li>
                                            <span class="font-semibold text-gray-800">{{ $detail->sarana->nama_sarana ?? 'Sarana' }}</span> 
                                            <span class="text-gray-500">({{ $detail->jumlah }} Unit)</span>
                                        </li>
                                    @empty
                                        <span class="text-gray-400 italic">Tidak ada sarana</span>
                                    @endforelse
                                </ul>
                            </td>

                            <!-- Status Badge -->
                            <td class="p-3 align-top">
                                @if($item->status == 'menunggu')
                                    <span class="bg-amber-100 text-amber-800 text-[10px] font-semibold px-2 py-1 rounded-full inline-flex items-center gap-1">
                                        <span class="w-1.5 h-1.5 bg-amber-500 rounded-full"></span> Menunggu
                                    </span>
                                @elseif($item->status == 'disetujui')
                                    <span class="bg-emerald-100 text-emerald-800 text-[10px] font-semibold px-2 py-1 rounded-full inline-flex items-center gap-1">
                                        <svg class="w-3 h-3 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> Disetujui
                                    </span>
                                @elseif($item->status == 'selesai')
                                    <span class="bg-blue-100 text-blue-800 text-[10px] font-semibold px-2 py-1 rounded-full inline-flex items-center gap-1">
                                        <svg class="w-3 h-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> Selesai
                                    </span>
                                @else
                                    <span class="bg-red-100 text-red-700 text-[10px] font-semibold px-2 py-1 rounded-full inline-flex items-center gap-1">
                                        <svg class="w-3 h-3 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg> Ditolak
                                    </span>
                                @endif
                            </td>

                            <!-- Aksi -->
                            <td class="p-3 align-top text-center">
                                <div class="flex items-center justify-center space-x-1">
                                    <!-- Tombol Detail -->
                                    <button @click="fetchDetail({{ $item->id }})" type="button" class="border border-gray-300 text-gray-700 text-[10px] font-medium px-2.5 py-1 rounded hover:bg-gray-100 transition-colors">
                                        Detail
                                    </button>

                                    @if($item->status == 'menunggu')
                                        <!-- Form Setujui -->
                                        <form action="{{ route('admin.pengajuan.approve', $item->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" onclick="return confirm('Apakah Anda yakin ingin menyetujui pengajuan ini?')" class="bg-[#0F392B] text-white text-[10px] font-medium px-2.5 py-1 rounded hover:bg-emerald-800 transition-colors">
                                                Setujui
                                            </button>
                                        </form>

                                        <!-- Tombol Tolak -->
                                        <button onclick="openRejectModal('{{ route('admin.pengajuan.reject', $item->id) }}')" class="border border-red-400 text-red-500 text-[10px] font-medium px-2.5 py-1 rounded hover:bg-red-50 transition-colors">
                                            Tolak
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-5 text-center text-gray-400 text-xs">Belum ada data pengajuan yang ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination Footer -->
        <div class="p-4 border-t border-gray-100 flex flex-col sm:flex-row justify-between items-center gap-3 text-xs text-gray-500">
            <div>
                Menampilkan <span class="font-medium text-gray-700">{{ $pengajuans->firstItem() ?? 0 }}</span> sampai <span class="font-medium text-gray-700">{{ $pengajuans->lastItem() ?? 0 }}</span> dari <span class="font-medium text-gray-700">{{ $pengajuans->total() }}</span> data
            </div>
            <div>
                {{ $pengajuans->links() }}
            </div>
        </div>
    </div>

    <!-- Modal Pop-up Alasan Penolakan -->
    <div id="rejectModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-xl max-w-md w-full p-5 space-y-4 shadow-xl">
            <h3 class="font-bold text-gray-900 text-sm">Alasan Penolakan Pengajuan</h3>
            <form id="rejectForm" method="POST" class="space-y-3">
                @csrf
                <div>
                    <textarea name="alasan" rows="3" required placeholder="Tuliskan alasan penolakan..." class="w-full text-xs p-3 border border-gray-300 rounded-lg focus:outline-none focus:border-red-500"></textarea>
                </div>
                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="closeRejectModal()" class="px-3 py-1.5 border border-gray-300 text-xs rounded-lg text-gray-600 hover:bg-gray-50">Batal</button>
                    <button type="submit" class="px-3 py-1.5 bg-red-600 text-white text-xs rounded-lg hover:bg-red-700">Kirim Penolakan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- ================= MODAL POP-UP DETAIL (ALPINE.JS) ================= -->
    <div x-show="openModal" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 backdrop-blur-xs p-4 overflow-y-auto"
         style="display: none;">

        <div @click.away="openModal = false" 
             class="bg-white rounded-3xl shadow-2xl border border-slate-200/80 w-full max-w-2xl max-h-[90vh] overflow-y-auto p-6 sm:p-8 space-y-6 my-auto relative">
            
            <!-- Indicator Loading -->
            <div x-show="loading" class="py-12 text-center space-y-3">
                <div class="inline-block w-8 h-8 border-4 border-emerald-600 border-t-transparent rounded-full animate-spin"></div>
                <p class="text-xs text-slate-500 font-medium">Memuat detail pengajuan...</p>
            </div>

            <!-- Konten Modal -->
            <div x-show="!loading" class="space-y-6">
                <!-- Header Status Badge -->
                <div class="space-y-3">
                    <div>
                        <span class="inline-flex items-center gap-1.5 px-3.5 py-1 rounded-full text-xs font-bold border capitalize"
                              :class="{
                                'bg-amber-100 text-amber-800 border-amber-200': data.status == 'menunggu',
                                'bg-emerald-100 text-emerald-800 border-emerald-200': data.status == 'disetujui',
                                'bg-blue-100 text-blue-800 border-blue-200': data.status == 'selesai',
                                'bg-red-100 text-red-700 border-red-200': data.status == 'ditolak'
                              }">
                            <span x-text="data.status_label"></span>
                        </span>
                    </div>

                    <div class="space-y-1">
                        <h2 class="text-xl sm:text-2xl font-black text-[#0f3022] tracking-tight">
                            Detail Lengkap Permohonan Peminjaman Aset
                        </h2>
                        <div class="text-xs font-medium text-slate-500 flex items-center gap-2 flex-wrap pt-0.5">
                            <span class="inline-flex items-center gap-1.5">
                                Diajukan pada <strong class="text-slate-900 font-bold" x-text="data.created_at"></strong>
                            </span>
                            <span class="text-slate-300">•</span>
                            <span>Oleh <strong class="text-slate-900 font-bold" x-text="data.user_name"></strong></span>
                        </div>
                    </div>
                </div>

                <hr class="border-slate-100">

                <!-- Section 1: Identitas Peminjam -->
                <div class="bg-[#f0f4f5] border border-slate-200/60 rounded-2xl p-4 space-y-3">
                    <div class="flex items-center gap-2 text-[#0f3022] text-[11px] font-extrabold uppercase tracking-wider">
                        <span>IDENTITAS PEMINJAM</span>
                    </div>

                    <div class="bg-white p-3.5 rounded-xl border border-slate-200/80 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 shadow-xs">
                        <div class="flex items-center gap-3">
                            <div class="w-11 h-11 rounded-xl bg-[#d1fae5] text-[#065f46] font-extrabold flex items-center justify-center text-sm shrink-0" x-text="data.user_name ? data.user_name.substring(0, 2).toUpperCase() : 'BS'"></div>
                            <div>
                                <h4 class="text-xs font-bold text-slate-900" x-text="data.user_name"></h4>
                                <p class="text-[11px] text-slate-400">Email: <span x-text="data.user_email"></span></p>
                                <p class="text-[11px] text-slate-400">Kelas: <span x-text="data.user_kelas"></span></p>
                            </div>
                        </div>

                        <div class="bg-[#f8fafc] border border-slate-200/80 rounded-lg p-1.5 flex items-center gap-2 text-xs">
                            <span class="text-[11px] text-slate-500 font-medium pl-1">Kontak Peminjam</span>
                            <a :href="'https://wa.me/' + (data.user_hp ? data.user_hp.replace(/[^0-9]/g, '') : '')" target="_blank" class="bg-[#0f3022] hover:bg-emerald-900 text-white text-[11px] px-3 py-1.5 rounded-md font-medium inline-flex items-center gap-1.5 transition">
                                <span x-text="'+' + data.user_hp"></span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Section 2: Keperluan & Jadwal Penggunaan -->
                <div x-show="data.status !== 'ditolak'" class="bg-[#f0f4f5] border border-slate-200/60 rounded-2xl p-4 space-y-3">
                    <div class="flex items-center gap-2 text-[#0f3022] text-[11px] font-extrabold uppercase tracking-wider">
                        <span>KEPERLUAN & JADWAL PENGGUNAAN</span>
                    </div>

                    <div class="bg-white p-4 rounded-xl border border-slate-200/80 space-y-3 shadow-xs">
                        <div>
                            <p class="text-[10px] uppercase font-bold text-slate-400 tracking-wider">TUJUAN PENGGUNAAN FASILITAS:</p>
                            <p class="text-xs font-extrabold text-slate-900 mt-0.5" x-text="data.keperluan"></p>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5 pt-1">
                            <div class="bg-[#f8fafc] p-2.5 rounded-lg border border-slate-200/70">
                                <p class="text-[10px] font-semibold text-slate-400">Waktu Peminjaman:</p>
                                <p class="text-xs font-bold text-slate-800"><span x-text="data.tanggal_peminjaman"></span> (<span x-text="data.waktu"></span>)</p>
                            </div>
                            <div class="bg-[#f8fafc] p-2.5 rounded-lg border border-slate-200/70">
                                <p class="text-[10px] font-semibold text-slate-400">Lokasi:</p>
                                <p class="text-xs font-bold text-slate-800" x-text="data.lokasi"></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section 3: Barang Yang Diajukan -->
                <div class="bg-[#f0f4f5] border border-slate-200/60 rounded-2xl p-4 space-y-3">
                    <div class="flex items-center gap-2 text-[#0f3022] text-[11px] font-extrabold uppercase tracking-wider">
                        <span>BARANG YANG DIAJUKAN</span>
                    </div>

                    <template x-for="item in data.items" :key="item.nama">
                        <div class="bg-white p-3 rounded-xl border border-slate-200/80 flex items-center justify-between gap-3 shadow-xs mb-2">
                            <div class="flex items-center gap-3">
                                <div class="w-14 h-14 rounded-xl bg-slate-100 border border-slate-200 overflow-hidden flex items-center justify-center shrink-0">
                                    <img :src="item.gambar" :alt="item.nama" class="w-full h-full object-cover">
                                </div>
                                <div>
                                    <h4 class="text-xs font-extrabold text-slate-900" x-text="item.nama"></h4>
                                    <p class="text-[11px] text-slate-400 mt-0.5">Kode: <span x-text="item.kode"></span></p>
                                </div>
                            </div>
                            <span class="px-3.5 py-1.5 bg-[#e2e8f0]/60 text-slate-800 text-xs font-extrabold rounded-lg border border-slate-200/50">
                                <span x-text="item.jumlah"></span> Unit
                            </span>
                        </div>
                    </template>
                </div>

                <!-- Section 4: Kotak Alasan Penolakan -->
                <div x-show="data.status === 'ditolak'" class="bg-red-50 border border-red-200 rounded-2xl p-4 space-y-2">
                    <p class="text-[11px] font-extrabold text-red-600 uppercase tracking-wider">ALASAN:</p>
                    <div class="bg-white p-3.5 rounded-xl border border-red-200 text-xs font-medium text-slate-800" x-text="data.alasan_tolak ?? 'Tidak ada alasan yang diberikan.'"></div>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center justify-between pt-3">
                    <button @click="openModal = false" type="button" class="px-5 py-2.5 border border-slate-300 hover:bg-slate-50 text-slate-700 text-xs font-bold rounded-xl transition shadow-xs">
                        Batal
                    </button>

                    <div x-show="data.status === 'menunggu'" class="flex items-center gap-2.5">
                        <form :action="data.reject_url" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" onclick="return confirm('Yakin ingin menolak pengajuan ini?')" class="px-4 py-2.5 bg-[#ff4d4d] hover:bg-red-600 text-white text-xs font-bold rounded-xl transition shadow-xs inline-flex items-center gap-1.5">
                                Tolak
                            </button>
                        </form>

                        <form :action="data.approve_url" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" onclick="return confirm('Yakin ingin menyetujui pengajuan ini?')" class="px-4 py-2.5 bg-[#0f3022] hover:bg-emerald-950 text-white text-xs font-bold rounded-xl transition shadow-xs inline-flex items-center gap-1.5">
                                Setujui
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
    function openRejectModal(actionUrl) {
        document.getElementById('rejectForm').action = actionUrl;
        document.getElementById('rejectModal').classList.remove('hidden');
        document.getElementById('rejectModal').classList.add('flex');
    }

    function closeRejectModal() {
        document.getElementById('rejectModal').classList.add('hidden');
        document.getElementById('rejectModal').classList.remove('flex');
    }
</script>
@endsection