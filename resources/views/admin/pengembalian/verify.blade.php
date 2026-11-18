@extends('layouts.admin')

@section('page-content')
<!-- CSS Khusus untuk Radio Button Kustom Sesuai Figma -->
<style>
    .radio-input:checked + .radio-box {
        border-color: #0A261D !important;
        background-color: #f0fdf4 !important;
    }
    .radio-input:checked + .radio-box .radio-circle {
        border-color: #0A261D !important;
    }
    .radio-input:checked + .radio-box .radio-dot {
        opacity: 1 !important;
    }
    .radio-input:checked + .radio-box .radio-text {
        color: #0A261D !important;
    }
</style>

<div class="space-y-6 text-gray-800">
    
    <!-- Header Page -->
    <div>
        <h1 class="text-3xl font-extrabold text-[#0A261D] tracking-tight">Verifikasi Pengembalian</h1>
        <p class="mt-1 text-xs text-gray-400">Verifikasi pengembalian pinjaman barang di bawah ini. Pastikan kondisi barang baik.</p>
    </div>

    <!-- Main Container Card -->
    <div class="bg-white border border-gray-200/90 rounded-3xl p-6 sm:p-8 shadow-sm space-y-6">

        <form action="{{ route('admin.pengembalian.process', $pengembalian->id) }}" method="POST">
            @csrf
            @method('PATCH')

            <!-- Baris 1: Tiga Card Informasi Atas (Berjajar ke Samping) -->
            <div style="display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 1rem;" class="mb-6">
                
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
                                        <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                        </svg>
                                    @endif
                                </div>
                                <div class="overflow-hidden">
                                    <h4 class="text-xs font-bold text-gray-900 truncate">{{ $detail->sarana->nama_sarana ?? 'Sarana' }}</h4>
                                    <p class="text-[11px] text-gray-500 font-medium">{{ $detail->jumlah ?? 1 }} Unit</p>
                                </div>
                            </div>
                        @empty
                            <p class="text-xs text-gray-400 italic">Tidak ada barang</p>
                        @endforelse
                    </div>
                </div>

                <!-- 3. Card Waktu Kembali -->
                <div class="bg-white border border-gray-200/80 rounded-2xl p-4 flex flex-col justify-between space-y-3 shadow-2xs">
                    <div class="flex items-center justify-between">
                        <span class="text-[10px] font-extrabold text-gray-400 uppercase tracking-wider">WAKTU KEMBALI</span>
                        <span class="px-2.5 py-0.5 bg-emerald-100 text-emerald-800 text-[10px] font-bold rounded-md">
                            Tepat Waktu
                        </span>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-[#d1fae5] text-[#065f46] flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
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

            <!-- Bagian Cek Kelayakan & Fisik -->
            <div class="space-y-3 mb-6">
                <label class="block text-[11px] font-extrabold text-gray-400 uppercase tracking-wider">CEK KELAYAKAN & FISIK</label>
                <div style="display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 1rem;">
                    
                    <label class="cursor-pointer bg-[#f8fafc] border border-gray-200/80 rounded-2xl p-3.5 flex items-center gap-3 hover:bg-gray-100/50 transition">
                        <input type="checkbox" name="kelayakan[]" value="aksesoris_lengkap" class="w-4 h-4 rounded text-[#0A261D] focus:ring-[#0A261D] border-gray-300">
                        <span class="text-xs font-bold text-gray-800">Unit & Aksesoris Lengkap</span>
                    </label>

                    <label class="cursor-pointer bg-[#f8fafc] border border-gray-200/80 rounded-2xl p-3.5 flex items-center gap-3 hover:bg-gray-100/50 transition">
                        <input type="checkbox" name="kelayakan[]" value="fungsi_normal" class="w-4 h-4 rounded text-[#0A261D] focus:ring-[#0A261D] border-gray-300">
                        <span class="text-xs font-bold text-gray-800">Fungsi Berjalan Normal</span>
                    </label>

                    <label class="cursor-pointer bg-[#f8fafc] border border-gray-200/80 rounded-2xl p-3.5 flex items-center gap-3 hover:bg-gray-100/50 transition">
                        <input type="checkbox" name="kelayakan[]" value="fisik_bersih" class="w-4 h-4 rounded text-[#0A261D] focus:ring-[#0A261D] border-gray-300">
                        <span class="text-xs font-bold text-gray-800">Fisik Utuh & Bersih</span>
                    </label>

                </div>
            </div>

            <!-- Bagian Status Kondisi Akhir Barang -->
            <div class="space-y-3 mb-6">
                <label class="block text-[11px] font-extrabold text-gray-400 uppercase tracking-wider">STATUS KONDISI AKHIR BARANG</label>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    
                    <label class="cursor-pointer relative block">
                        <input type="radio" name="kondisi_pengembalian" value="baik" class="radio-input absolute opacity-0 w-0 h-0" checked>
                        <div class="radio-box flex items-center gap-3 w-full px-4 py-3.5 rounded-2xl border-2 border-gray-200 bg-[#f8fafc] transition-all">
                            <div class="radio-circle w-4 h-4 rounded-full border-2 border-gray-300 flex items-center justify-center bg-white transition-all shrink-0">
                                <div class="radio-dot w-2 h-2 rounded-full bg-[#0A261D] opacity-0 transition-all"></div>
                            </div>
                            <span class="radio-text text-xs font-bold text-gray-700 transition-all">Baik & Lengkap</span>
                        </div>
                    </label>

                    <label class="cursor-pointer relative block">
                        <input type="radio" name="kondisi_pengembalian" value="rusak_ringan" class="radio-input absolute opacity-0 w-0 h-0">
                        <div class="radio-box flex items-center gap-3 w-full px-4 py-3.5 rounded-2xl border-2 border-gray-200 bg-[#f8fafc] transition-all">
                            <div class="radio-circle w-4 h-4 rounded-full border-2 border-gray-300 flex items-center justify-center bg-white transition-all shrink-0">
                                <div class="radio-dot w-2 h-2 rounded-full bg-[#0A261D] opacity-0 transition-all"></div>
                            </div>
                            <span class="radio-text text-xs font-bold text-gray-700 transition-all">Rusak / Hilang</span>
                        </div>
                    </label>

                </div>
            </div>

            <!-- Bagian Catatan Petugas -->
            <div class="space-y-2 mb-8">
                <label for="catatan" class="block text-[11px] font-extrabold text-gray-400 uppercase tracking-wider">CATATAN PETUGAS (OPSIONAL)</label>
                <textarea id="catatan" name="catatan" rows="4" placeholder="Masukkan Catatan..." 
                          class="w-full bg-[#f8fafc] border border-gray-200 rounded-2xl p-4 text-xs text-gray-800 placeholder-gray-400 focus:outline-none focus:border-[#0A261D] transition resize-none"></textarea>
            </div>

            <!-- Tombol Aksi Bawah -->
            <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                <a href="{{ route('admin.pengembalian.index') }}" class="px-6 py-2.5 bg-white border border-gray-300 rounded-xl text-xs font-semibold text-gray-700 hover:bg-gray-50 transition">
                    Batal
                </a>
                
                <button type="submit" class="px-6 py-2.5 bg-[#0A261D] rounded-xl text-xs font-semibold text-white hover:bg-opacity-90 flex items-center gap-2 transition shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                    </svg>
                    Simpan & Selesai
                </button>
            </div>

        </form>

    </div>
</div>
@endsection