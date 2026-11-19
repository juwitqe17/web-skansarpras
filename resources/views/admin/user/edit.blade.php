@extends('layouts.admin')

@section('page-content')
<div class="space-y-6 max-w-5xl mx-auto">
    <!-- Header -->
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Edit Data Pengguna</h1>
        <p class="mt-1 text-sm text-gray-500">
            Perbarui informasi akun, role akses, atau penempatan jurusan pengguna.
        </p>
        <a href="{{ route('admin.user.index', ['jurusan_id' => $user->jurusan_id]) }}" 
           class="inline-flex items-center gap-1.5 mt-3 px-3 py-1.5 text-xs font-medium text-gray-600 bg-white border border-gray-200 hover:bg-gray-50 rounded-lg transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali
        </a>
    </div>

    <!-- Banner Info Akun -->
    <div class="bg-[#0f2e24] text-white rounded-2xl p-5 flex items-center justify-between shadow-sm">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-white/10 flex items-center justify-center font-bold text-lg uppercase text-emerald-300">
                {{ substr($user->name, 0, 2) }}
            </div>
            <div>
                <p class="text-xs text-emerald-200">Mengedit Akun Pengguna</p>
                <h2 class="text-lg font-semibold">{{ $user->name }} <span class="text-sm font-normal text-gray-300">({{ $user->email }})</span></h2>
            </div>
        </div>
        <span class="hidden sm:inline-block text-sm font-bold uppercase tracking-wider text-emerald-300 px-4 py-1.5 bg-white/10 rounded-xl">
            {{ $selectedJurusan->kode_jurusan ?? '-' }}
        </span>
    </div>

    <!-- Form Edit -->
    <form action="{{ route('admin.user.update', $user->id) }}" method="POST" class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Kolom Kiri (Data Pribadi & Akademik) -->
            <div class="lg:col-span-2 space-y-4">
                <!-- Nama Lengkap -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" placeholder="Masukkan nama lengkap"
                           class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-emerald-800 focus:outline-none transition @error('name') border-red-500 @enderror" required>
                    @error('name') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Alamat Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" placeholder="contoh@sekolah.sch.id"
                           class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-emerald-800 focus:outline-none transition @error('email') border-red-500 @enderror" required>
                    @error('email') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- Kelas & No HP -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Kelas <span class="text-xs font-normal text-gray-400">(Opsional untuk Admin/Guru)</span></label>
                        <input type="text" name="kelas" value="{{ old('kelas', $user->kelas) }}" placeholder="Cth: XII RPL 1"
                               class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-emerald-800 focus:outline-none transition @error('kelas') border-red-500 @enderror">
                        @error('kelas') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Nomor HP / WhatsApp</label>
                        <input type="text" name="no_hp" value="{{ old('no_hp', $user->no_hp) }}" placeholder="Cth: 081234567890"
                               class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-emerald-800 focus:outline-none transition @error('no_hp') border-red-500 @enderror">
                        @error('no_hp') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Ubah Password -->
                <div class="pt-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Password Baru <span class="text-xs font-normal text-gray-400">(Kosongkan jika tidak ingin mengganti password)</span></label>
                    <input type="password" name="password" placeholder="Minimal 6 karakter"
                           class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-emerald-800 focus:outline-none transition @error('password') border-red-500 @enderror">
                    @error('password') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Kolom Kanan (Pengaturan Jurusan & Role) -->
            <div class="bg-gray-50 p-5 border border-gray-200 rounded-2xl space-y-4 h-fit">
                <!-- Jurusan -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Departemen / Jurusan</label>
                    <select name="jurusan_id" class="w-full px-4 py-2.5 bg-white border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-emerald-800 focus:outline-none transition" required>
                        @foreach($jurusans as $jrs)
                            <option value="{{ $jrs->id }}" {{ old('jurusan_id', $user->jurusan_id) == $jrs->id ? 'selected' : '' }}>
                                {{ $jrs->nama_jurusan }} ({{ $jrs->kode_jurusan }})
                            </option>
                        @endforeach
                    </select>
                    @error('jurusan_id') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- Role Akses -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Role / Hak Akses</label>
                    <select name="role" class="w-full px-4 py-2.5 bg-white border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-emerald-800 focus:outline-none transition" required>
                        <option value="peminjam" {{ old('role', $user->role) == 'peminjam' ? 'selected' : '' }}>Peminjam (Siswa / Guru)</option>
                        <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin / Petugas Sarpras</option>
                    </select>
                    @error('role') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="mt-6 flex justify-end items-center gap-3 border-t border-gray-100 pt-4">
            <a href="{{ route('admin.user.index', ['jurusan_id' => $user->jurusan_id]) }}" 
               class="px-5 py-2.5 text-sm font-medium text-gray-600 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 transition">
                Batal
            </a>
            <button type="submit" class="px-5 py-2.5 text-sm font-medium text-white bg-[#0f2e24] hover:bg-[#163f32] rounded-xl flex items-center gap-2 transition shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection