@extends('layouts.admin')

@section('page-content')
<div class="space-y-6">
    <!-- Header Page -->
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Manajemen Pengguna</h1>
        <p class="mt-1 text-sm text-gray-500">
            Kelola akun siswa, guru, dan petugas pengelola. Pilih kategori jurusan terlebih dahulu sebelum mengelola data pengguna.
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

    <!-- Filter Departemen / Jurusan Card -->
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="p-3 bg-gray-100 rounded-xl text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-base font-semibold text-gray-900">Pilih Kategori Departemen / Jurusan</h2>
                    <p class="text-xs text-gray-500">Data akun pengguna akan disaring sesuai dengan departemen yang dipilih.</p>
                </div>
            </div>

            <!-- Dropdown Filter Jurusan -->
            <form method="GET" action="{{ route('admin.user.index') }}" class="w-full sm:w-72">
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
            <!-- Total user -->
            <div class="p-4 rounded-xl border border-gray-200 bg-white">
                <div class="flex items-center gap-2 text-xs font-medium text-gray-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    Total user
                </div>
                <div class="mt-2 flex items-baseline gap-2">
                    <span class="text-2xl font-bold text-gray-900">{{ $selectedJurusan ? $stats['total'] : 0 }}</span>
                    <span class="text-xs text-gray-500">akun</span>
                </div>
                <p class="mt-1 text-xs text-gray-400">
                    {{ $selectedJurusan ? 'Terdaftar di jurusan ' . $selectedJurusan->kode_jurusan . '.' : '-' }}
                </p>
            </div>

            <!-- Akun Peminjam -->
            <div class="p-4 rounded-xl border border-gray-200 bg-white">
                <div class="flex items-center gap-2 text-xs font-medium text-gray-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    Akun Peminjam
                </div>
                <div class="mt-2 flex items-baseline gap-2">
                    <span class="text-2xl font-bold text-gray-900">{{ $selectedJurusan ? $stats['peminjam'] : 0 }}</span>
                    <span class="text-xs text-gray-500">akun</span>
                </div>
                <p class="mt-1 text-xs text-gray-400">
                    {{ $selectedJurusan ? 'Siswa / Guru peminjam.' : '-' }}
                </p>
            </div>

            <!-- Akun Admin / Toolman -->
            <div class="p-4 rounded-xl border border-gray-200 bg-white">
                <div class="flex items-center gap-2 text-xs font-medium text-emerald-700">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    Petugas / Admin
                </div>
                <div class="mt-2 flex items-baseline gap-2">
                    <span class="text-2xl font-bold text-gray-900">{{ $selectedJurusan ? $stats['admin'] : 0 }}</span>
                    <span class="text-xs text-gray-500">akun</span>
                </div>
                <p class="mt-1 text-xs text-gray-400">
                    {{ $selectedJurusan ? 'Pengelola sarpras jurusan.' : '-' }}
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
        <!-- Control Bar (Search, Filter Role, Add Button) -->
        <div class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100 flex flex-wrap items-center justify-between gap-3">
            <form method="GET" action="{{ route('admin.user.index') }}" class="flex flex-wrap items-center gap-3 flex-1">
                <input type="hidden" name="jurusan_id" value="{{ request('jurusan_id') }}">
                
                <!-- Search Input -->
                <div class="relative flex-1 min-w-[200px]">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, email, atau kelas..." class="w-full pl-9 pr-4 py-2 bg-gray-50 border border-gray-200 text-sm rounded-xl focus:ring-2 focus:ring-emerald-800">
                </div>

                <!-- Filter Role -->
                <select name="role" onchange="this.form.submit()" class="bg-gray-50 border border-gray-200 text-sm rounded-xl px-3 py-2 text-gray-600 focus:ring-2 focus:ring-emerald-800">
                    <option value="">Semua Role</option>
                    <option value="peminjam" {{ request('role') == 'peminjam' ? 'selected' : '' }}>Peminjam</option>
                    <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
            </form>

            <div class="flex items-center gap-3">
                <!-- Dropdown Button Excel (Ekspor / Impor) -->
                <div class="relative" id="excelDropdownWrapper">
                    <button type="button" onclick="toggleExcelDropdown()" 
                            class="inline-flex items-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium px-4 py-2 rounded-xl border border-gray-200 transition">
                        <!-- Icon Spreadsheet / Excel -->
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
                        <a href="{{ route('admin.user.export', ['jurusan_id' => request('jurusan_id')]) }}" 
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

                <!-- Tombol Tambah Pengguna -->
                <a href="{{ route('admin.user.create', ['jurusan_id' => request('jurusan_id')]) }}" class="inline-flex items-center gap-2 bg-[#0f2e24] hover:bg-[#163f32] text-white text-sm font-medium px-4 py-2 rounded-xl transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Tambah Pengguna {{ $selectedJurusan->kode_jurusan }}
                </a>
            </div>

        </div>

        <!-- Data Table -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-600">
                    <thead class="bg-[#0f2e24] text-white text-xs uppercase font-semibold tracking-wider">
                        <tr>
                            <th class="px-6 py-4">Nama Pengguna</th>
                            <th class="px-6 py-4">Kelas</th>
                            <th class="px-6 py-4">No. HP</th>
                            <th class="px-6 py-4">Role</th>
                            <th class="px-6 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($users as $user)
                            <tr class="hover:bg-gray-50/50 transition">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-full bg-emerald-100 text-emerald-900 font-bold flex items-center justify-center text-xs uppercase">
                                            {{ substr($user->name, 0, 2) }}
                                        </div>
                                        <div>
                                            <div class="font-semibold text-gray-900">{{ $user->name }}</div>
                                            <div class="text-xs text-gray-400">{{ $user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 font-medium text-gray-700">
                                    {{ $user->kelas ?? '-' }}
                                </td>
                                <td class="px-6 py-4 text-gray-600">
                                    {{ $user->no_hp ?? '-' }}
                                </td>
                                <td class="px-6 py-4">
                                    @if($user->role === 'admin')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-800">
                                            Admin
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800">
                                            Peminjam
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('admin.user.edit', $user->id) }}" class="p-1.5 text-gray-500 hover:text-emerald-800 rounded-lg hover:bg-gray-100" title="Edit Pengguna">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        </a>
                                        <form action="{{ route('admin.user.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Hapus pengguna {{ $user->name }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-1.5 text-gray-500 hover:text-red-600 rounded-lg hover:bg-gray-100" title="Hapus Pengguna">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-gray-400">
                                    Belum ada data pengguna untuk jurusan {{ $selectedJurusan->nama_jurusan }}.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 bg-gray-50/50 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-gray-500">
                <div>
                    Menampilkan {{ $users->firstItem() ?? 0 }} - {{ $users->lastItem() ?? 0 }} dari {{ $users->total() }} user jurusan {{ $selectedJurusan->nama_jurusan }}
                </div>
                <div>
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    @endif
</div>

<!-- Modal Pop-up Impor Pengguna -->
<div id="importModal" class="fixed inset-0 z-50 hidden overflow-y-auto" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-gray-900/50 backdrop-blur-xs transition-opacity" onclick="closeImportModal()"></div>

    <div class="flex min-h-full items-center justify-center p-4">
        <div class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-xl transition-all sm:w-full sm:max-w-lg border border-gray-100">
            <form action="{{ route('admin.user.import') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-5">
                @csrf
                <input type="hidden" name="jurusan_id" value="{{ $selectedJurusan->id ?? '' }}">

                <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Impor Data Pengguna</h3>
                        <p class="text-xs text-gray-500">Jurusan tujuan: <strong class="text-emerald-800">{{ $selectedJurusan->nama_jurusan ?? '-' }}</strong></p>
                    </div>
                    <button type="button" onclick="closeImportModal()" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <!-- Panduan & Download Template -->
                <div class="p-4 bg-emerald-50/70 border border-emerald-100 rounded-xl text-xs text-emerald-900 space-y-2">
                    <p class="font-semibold">Petunjuk Impor:</p>
                    <ul class="list-disc pl-4 space-y-1 text-emerald-800">
                        <li>Gunakan file berformat <strong>.CSV</strong> (Comma Separated Values).</li>
                        <li>Urutan kolom: <code class="bg-white px-1 py-0.5 rounded">nama, email, password, role, kelas, no_hp</code></li>
                        <li>Jika kolom <em>password</em> dikosongkan, otomatis diisi <code class="bg-white px-1 py-0.5 rounded">password123</code>.</li>
                    </ul>
                    <div class="pt-1">
                        <a href="{{ route('admin.user.template') }}" class="inline-flex items-center gap-1.5 font-semibold text-emerald-900 underline hover:text-emerald-700">
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
@endsection

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

    // Tutup dropdown Excel saat klik di luar area tombol
    document.addEventListener('click', function(event) {
        const wrapper = document.getElementById('excelDropdownWrapper');
        const menu = document.getElementById('excelDropdownMenu');
        if (wrapper && !wrapper.contains(event.target)) {
            menu.classList.add('hidden');
        }
    });
</script>