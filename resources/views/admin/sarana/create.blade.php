@extends('layouts.admin')

@section('page-content')
<div class="p-6 max-w-6xl mx-auto">
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Manajemen Sarana & Prasarana</h1>
        <p class="text-sm text-gray-500">
            Inventaris peralatan dan perangkat kejuruan. Pastikan untuk memilih kategori jurusan terlebih dahulu sebelum menambahkan data sarana.
        </p>
        <a href="{{ route('admin.sarana.index', ['jurusan_id' => $selectedJurusan->id]) }}" 
           class="inline-flex items-center gap-1 mt-3 px-3 py-1.5 text-xs font-medium text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-lg transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali
        </a>
    </div>

    <!-- Banner Jurusan saat ini -->
    <div class="bg-emerald-950 text-white rounded-2xl p-5 mb-6 flex items-center justify-between shadow-sm">
        <div class="flex items-center gap-4">
            <div class="p-3 bg-white/10 rounded-xl">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
            </div>
            <div>
                <p class="text-xs text-emerald-200">Jurusan Saat Ini <span class="text-gray-300">({{ $selectedJurusan->nama_jurusan }})</span></p>
                <h2 class="text-lg font-semibold">Data baru akan ditambahkan ke Departemen ini.</h2>
            </div>
        </div>
        <span class="text-2xl font-bold uppercase tracking-wider text-emerald-300 px-4 py-1 bg-white/10 rounded-xl">
            {{ $selectedJurusan->kode_jurusan }}
        </span>
    </div>

    <!-- Form Container -->
    <form action="{{ route('admin.sarana.store') }}" method="POST" enctype="multipart/form-data" class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
        @csrf
        <input type="hidden" name="jurusan_id" value="{{ $selectedJurusan->id }}">

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Kolom Kiri & Tengah (Input Teks) -->
            <div class="lg:col-span-2 space-y-4">
                <!-- Nama Sarana -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Sarana / Prasarana</label>
                    <input type="text" name="nama_sarana" value="{{ old('nama_sarana') }}" placeholder="Cth: Laptop Axioo Hype 1" 
                           class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-emerald-800 focus:outline-none transition @error('nama_sarana') border-red-500 @enderror" required>
                    @error('nama_sarana') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- Kode Sarana -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Kode Sarana / Prasarana</label>
                    <input type="text" name="kode_sarana" value="{{ old('kode_sarana') }}" placeholder="Cth: RPL-NET-001" 
                           class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-emerald-800 focus:outline-none transition @error('kode_sarana') border-red-500 @enderror" required>
                    @error('kode_sarana') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- Jumlah Unit & Lokasi -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="sm:col-span-1">
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Jumlah Unit</label>
                        <input type="number" name="jumlah" value="{{ old('jumlah', 1) }}" min="1" 
                               class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-emerald-800 focus:outline-none transition @error('jumlah') border-red-500 @enderror" required>
                        @error('jumlah') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Lokasi</label>
                        <input type="text" name="lokasi" value="{{ old('lokasi') }}" placeholder="Cth: Ruang Toolman RPL Gedung E-204" 
                               class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-emerald-800 focus:outline-none transition @error('lokasi') border-red-500 @enderror" required>
                        @error('lokasi') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Deskripsi -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Deskripsi Mengenai Sarana / Prasarana</label>
                    <textarea name="deskripsi" rows="4" placeholder="Deskripsi..." 
                              class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-emerald-800 focus:outline-none transition">{{ old('deskripsi') }}</textarea>
                </div>
            </div>

            <!-- Kolom Kanan (Gambar, Kondisi, Status) -->
            <div class="bg-gray-50 p-4 border border-gray-200 rounded-2xl space-y-4">
                <!-- Upload Gambar -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Gambar Sarana</label>
                    <div class="relative border-2 border-dashed border-gray-300 bg-white rounded-xl p-4 text-center hover:border-emerald-800 transition cursor-pointer">
                        <input type="file" name="gambar" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" onchange="previewImage(event)">
                        <div id="upload-placeholder" class="flex flex-col items-center justify-center py-4 text-gray-400">
                            <svg class="w-8 h-8 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                            <span class="text-xs">Klik untuk mengunggah gambar</span>
                        </div>
                        <img id="image-preview" class="hidden w-full h-32 object-cover rounded-lg mx-auto">
                    </div>
                </div>

                <!-- Kondisi Sarana -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Kondisi Sarana</label>
                    <select name="kondisi" class="w-full px-4 py-2.5 bg-white border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-emerald-800 focus:outline-none transition">
                        <option value="baik" {{ old('kondisi') == 'baik' ? 'selected' : '' }}>Baik</option>
                        <option value="rusak_ringan" {{ old('kondisi') == 'rusak_ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                        <option value="rusak_berat" {{ old('kondisi') == 'rusak_berat' ? 'selected' : '' }}>Rusak Berat</option>
                    </select>
                </div>

                <!-- Status Sarana -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Status Sarana</label>
                    <select name="status" class="w-full px-4 py-2.5 bg-white border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-emerald-800 focus:outline-none transition">
                        <option value="tersedia" {{ old('status') == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                        <option value="tidak_tersedia" {{ old('status') == 'tidak_tersedia' ? 'selected' : '' }}>Tidak Tersedia / Maintenance</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="mt-6 flex justify-end items-center gap-3 border-t border-gray-100 pt-4">
            <a href="{{ route('admin.sarana.index', ['jurusan_id' => $selectedJurusan->id]) }}" class="px-5 py-2.5 text-sm font-medium text-red-500 bg-white border border-red-200 rounded-xl hover:bg-red-50 transition">
                Batal
            </a>
            <button type="submit" class="px-5 py-2.5 text-sm font-medium text-white bg-emerald-900 hover:bg-emerald-950 rounded-xl flex items-center gap-2 transition shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Buat Data
            </button>
        </div>
    </form>
</div>

<script>
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function(){
            const output = document.getElementById('image-preview');
            const placeholder = document.getElementById('upload-placeholder');
            output.src = reader.result;
            output.classList.remove('hidden');
            placeholder.classList.add('hidden');
        };
        if(event.target.files[0]) {
            reader.readAsDataURL(event.target.files[0]);
        }
    }
</script>
@endsection