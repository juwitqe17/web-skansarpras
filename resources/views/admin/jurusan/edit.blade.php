@extends('layouts.admin')

@section('page-content')
<!-- CSS Bawaan untuk Interaktif Status Radio Button -->
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
        <h1 class="text-3xl font-bold text-gray-900">Manajemen Departemen (Edit Data)</h1>
        <p class="mt-1 text-sm text-gray-400">Ubah informasi departemen atau jurusan di bawah ini.</p>
    </div>

    <!-- Tombol Kembali -->
    <div>
        <a href="{{ route('admin.jurusan.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-xs font-semibold text-gray-700 bg-white hover:bg-gray-50 transition shadow-sm">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" />
            </svg>
            Kembali
        </a>
    </div>

    <!-- Form Card Container -->
    <div class="bg-white border border-gray-200 rounded-2xl p-6 sm:p-8 shadow-sm">
        <!-- Menggunakan Method PUT untuk Update Data -->
        <form action="{{ route('admin.jurusan.update', $jurusan->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <!-- FLEXBOX LAYOUT (Deskripsi di kanan) -->
            <div class="flex flex-col lg:flex-row gap-6 lg:gap-8">
                
                <!-- Kolom Kiri: Nama dan Kode -->
                <div class="w-full lg:w-1/2 flex flex-col gap-6">
                    <div>
                        <label for="nama_jurusan" class="block text-sm font-bold text-[#0A261D] mb-2">Nama Departemen / Jurusan</label>
                        <input type="text" id="nama_jurusan" name="nama_jurusan" value="{{ old('nama_jurusan', $jurusan->nama_jurusan) }}" placeholder="Cth: Rekayasa Perangkat Lunak" required 
                               class="w-full bg-[#f8fafc] border border-gray-200 rounded-lg px-4 py-3 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:border-[#0A261D] transition">
                    </div>

                    <div>
                        <label for="kode_jurusan" class="block text-sm font-bold text-[#0A261D] mb-2">Kode Departemen / Jurusan</label>
                        <input type="text" id="kode_jurusan" name="kode_jurusan" value="{{ old('kode_jurusan', $jurusan->kode_jurusan) }}" placeholder="Cth: RPL" required 
                               class="w-full sm:w-2/3 bg-[#f8fafc] border border-gray-200 rounded-lg px-4 py-3 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:border-[#0A261D] transition">
                    </div>
                </div>

                <!-- Kolom Kanan: Deskripsi -->
                <div class="w-full lg:w-1/2 flex flex-col">
                    <label for="deskripsi" class="block text-sm font-bold text-[#0A261D] mb-2">Deskripsi Mengenai Departemen / Jurusan</label>
                    <textarea id="deskripsi" name="deskripsi" placeholder="Deskripsi..." 
                              class="w-full h-full min-h-[140px] bg-[#f8fafc] border border-gray-200 rounded-lg px-4 py-3 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:border-[#0A261D] transition resize-none">{{ old('deskripsi', $jurusan->deskripsi) }}</textarea>
                </div>
            </div>

            <!-- Status Custom Radio Button -->
            <div class="mt-8">
                <label class="block text-sm font-bold text-[#0A261D] mb-3">Status</label>
                <div class="flex flex-wrap items-center gap-4">
                    
                    <!-- Pilihan Aktif -->
                    <label class="cursor-pointer relative">
                        <input type="radio" name="status" value="aktif" class="radio-input absolute opacity-0 w-0 h-0" {{ old('status', $jurusan->status) == 'aktif' ? 'checked' : '' }}>
                        <div class="radio-box flex items-center gap-3 w-36 px-4 py-3 rounded-lg border-2 border-gray-200 bg-[#f8fafc] transition-all">
                            <div class="radio-circle w-4 h-4 rounded-full border-2 border-gray-300 flex items-center justify-center bg-white transition-all">
                                <div class="radio-dot w-2 h-2 rounded-full bg-[#0A261D] opacity-0 transition-all"></div>
                            </div>
                            <span class="radio-text text-sm font-bold text-gray-600 transition-all">Aktif</span>
                        </div>
                    </label>

                    <!-- Pilihan Tidak Aktif -->
                    <label class="cursor-pointer relative">
                        <input type="radio" name="status" value="tidak_aktif" class="radio-input absolute opacity-0 w-0 h-0" {{ old('status', $jurusan->status) == 'tidak_aktif' ? 'checked' : '' }}>
                        <div class="radio-box flex items-center gap-3 w-40 px-4 py-3 rounded-lg border-2 border-gray-200 bg-[#f8fafc] transition-all">
                            <div class="radio-circle w-4 h-4 rounded-full border-2 border-gray-300 flex items-center justify-center bg-white transition-all">
                                <div class="radio-dot w-2 h-2 rounded-full bg-[#0A261D] opacity-0 transition-all"></div>
                            </div>
                            <span class="radio-text text-sm font-bold text-gray-600 transition-all">Tidak Aktif</span>
                        </div>
                    </label>

                </div>
            </div>

            <!-- Action Buttons -->
            <div class="mt-10 flex items-center justify-end gap-3">
                <a href="{{ route('admin.jurusan.index') }}" class="px-6 py-2.5 bg-white border border-gray-300 rounded-lg text-sm font-semibold text-[#FF4D4D] hover:bg-gray-50 transition text-center">
                    Batal
                </a>
                
                <button type="submit" class="px-6 py-2.5 bg-[#0A261D] rounded-lg text-sm font-semibold text-white hover:bg-opacity-90 flex items-center gap-2 transition shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                    Simpan Perubahan
                </button>
            </div>

        </form>
    </div>
</div>
@endsection