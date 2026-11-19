@extends('layouts.admin')

@section('page-content')
<div class="space-y-6 max-w-5xl mx-auto">
    <!-- Header -->
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Tambah Pengguna Baru</h1>
        <p class="mt-1 text-sm text-gray-500">
            Daftarkan akun siswa, guru, atau petugas pengelola baru pada jurusan yang dipilih.
        </p>
        <a href="{{ route('admin.user.index', ['jurusan_id' => $selectedJurusan->id]) }}" 
           class="inline-flex items-center gap-1.5 mt-3 px-3 py-1.5 text-xs font-medium text-gray-600 bg-white border border-gray-200 hover:bg-gray-50 rounded-lg transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali
        </a>
    </div>

    <!-- Banner Jurusan Saat Ini -->
    <div class="bg-[#0f2e24] text-white rounded-2xl p-5 flex items-center justify-between shadow-sm">
        <div class="flex items-center gap-4">
            <div class="p-3 bg-white/10 rounded-xl text-emerald-300">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                </svg>
            </div>
            <div>
                <p class="text-xs text-emerald-200">Jurusan Saat Ini <span class="text-gray-300">({{ $selectedJurusan->nama_jurusan }})</span></p>
                <h2 class="text-lg font-semibold">Akun baru akan didaftarkan ke Departemen ini.</h2>
            </div>
        </div>
        <span class="hidden sm:inline-block text-xl font-bold uppercase tracking-wider text-emerald-300 px-4 py-1.5 bg-white/10 rounded-xl">
            {{ $selectedJurusan->kode_jurusan }}
        </span>
    </div>

    <!-- Form Create User -->
    <form action="{{ route('admin.user.store') }}" method="POST" class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
        @csrf
        <input type="hidden" name="jurusan_id" value="{{ $selectedJurusan->id }}">

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Kolom Kiri (Data Pribadi & Kredensial) -->
            <div class="lg:col-span-2 space-y-4">
                <!-- Nama Lengkap -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="Cth: Ahmad Fauzan"
                           class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-emerald-800 focus:outline-none transition @error('name') border-red-500 @enderror" required>
                    @error('name') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Alamat Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="Cth: ahmad.rpl@smkn1purwosari.sch.id"
                           class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-emerald-800 focus:outline-none transition @error('email') border-red-500 @enderror" required>
                    @error('email') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- Kelas & No HP -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Kelas <span class="text-xs font-normal text-gray-400">(Opsional untuk Admin/Guru)</span></label>
                        <input type="text" name="kelas" value="{{ old('kelas') }}" placeholder="Cth: XI {{ $selectedJurusan->kode_jurusan }} 1"
                               class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-emerald-800 focus:outline-none transition @error('kelas') border-red-500 @enderror">
                        @error('kelas') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Nomor HP / WhatsApp</label>
                        <input type="text" name="no_hp" value="{{ old('no_hp') }}" placeholder="Cth: 081234567890"
                               class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-emerald-800 focus:outline-none transition @error('no_hp') border-red-500 @enderror">
                        @error('no_hp') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Password -->
                <div class="pt-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Password Akun</label>
                    <input type="password" name="password" placeholder="Minimal 6 karakter"
                           class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-emerald-800 focus:outline-none transition @error('password') border-red-500 @enderror" required>
                    @error('password') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Kolom Kanan (Pengaturan Role & Info) -->
            <div class="bg-gray-50 p-5 border border-gray-200 rounded-2xl space-y-4 h-fit">
                <!-- Role Akses -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Role / Hak Akses</label>
                    <select name="role" class="w-full px-4 py-2.5 bg-white border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-emerald-800 focus:outline-none transition" required>
                        <option value="peminjam" {{ old('role') == 'peminjam' ? 'selected' : '' }}>Peminjam (Siswa / Guru)</option>
                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin / Petugas Sarpras</option>
                    </select>
                    @error('role') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- Catatan Kecil -->
                <div class="p-3.5 bg-white border border-gray-200 rounded-xl text-xs text-gray-500 space-y-1.5">
                    <p class="font-semibold text-gray-700">Keterangan Hak Akses:</p>
                    <ul class="list-disc pl-4 space-y-1">
                        <li><strong class="text-gray-700">Peminjam:</strong> Dapat melihat katalog sarana dan mengajukan peminjaman barang.</li>
                        <li><strong class="text-gray-700">Admin:</strong> Dapat mengelola inventaris barang, pengguna, dan menyetujui peminjaman.</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="mt-6 flex justify-end items-center gap-3 border-t border-gray-100 pt-4">
            <a href="{{ route('admin.user.index', ['jurusan_id' => $selectedJurusan->id]) }}" 
               class="px-5 py-2.5 text-sm font-medium text-red-500 bg-white border border-red-200 rounded-xl hover:bg-red-50 transition">
                Batal
            </a>
            <button type="submit" class="px-5 py-2.5 text-sm font-medium text-white bg-[#0f2e24] hover:bg-[#163f32] rounded-xl flex items-center gap-2 transition shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Buat Pengguna
            </button>
        </div>
    </form>
</div>
@endsection