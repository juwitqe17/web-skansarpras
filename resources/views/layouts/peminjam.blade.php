<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SkanSarpras')</title>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@500;700;800&family=Work+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        tailwind.config = { theme: { extend: {
            colors: { brand: { DEFAULT: '#10291D', soft: '#2E4A3B', mint: '#D5EBDD' } },
            fontFamily: { sans: ['Work Sans', 'sans-serif'], head: ['Manrope', 'sans-serif'] }
        } } }
    </script>
</head>
<body class="bg-brand font-sans text-brand antialiased">

{{-- SIDEBAR --}}
<aside class="hidden lg:flex fixed inset-y-0 left-0 z-30 w-60 flex-col bg-brand px-4 py-6 text-white">
    <div class="flex items-center gap-3 border-b border-white/15 px-1 pb-5">
       <div class="relative flex h-12 w-12 shrink-0 items-center justify-center">
    <img src="{{ asset('images/logosmk.png') }}" alt="Logo SkanSarpras"
         onerror="this.classList.add('hidden'); this.nextElementSibling.classList.remove('hidden')"
         class="h-full w-full object-contain drop-shadow-[0_0_10px_rgba(213,235,221,0.25)]">
    <i data-lucide="school" class="hidden h-6 w-6 text-white"></i>
</div>
        <div>
            <p class="font-head text-lg font-bold leading-tight">SkanSarpras</p>
            <p class="text-[11px] leading-snug text-white/60">Manajemen Sarana Prasarana<br>SMK Negeri 1 Purwosari</p>
        </div>
    </div>

    @php
      $menu = [
    ['Beranda', 'peminjam.dashboard', 'layout-dashboard'],
    ['Sarana Prasarana', 'peminjam.sarana.index', 'archive'],
    ['Peminjaman', 'peminjam.pengajuan.create', 'clipboard-list'],   // <- ini yang diganti
    ['Riwayat Pengajuan', 'peminjam.riwayat.index', 'history'],
];
    @endphp
    <nav class="mt-6 space-y-1.5 text-sm">
        @foreach ($menu as [$label, $route, $icon])
            <a href="{{ Route::has($route) ? route($route) : '#' }}"
               class="flex items-center gap-3 rounded-lg px-3.5 py-2.5 transition-colors
                      {{ request()->routeIs($route) ? 'bg-brand-soft font-medium' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
                <i data-lucide="{{ $icon }}" class="h-4 w-4"></i> {{ $label }}
            </a>
        @endforeach
    </nav>

    <form method="POST" action="{{ Route::has('logout') ? route('logout') : '#' }}" class="mt-auto">
        @csrf
        <button class="flex w-full items-center gap-3 rounded-lg bg-brand-soft/70 px-3.5 py-2.5 text-sm text-red-300 transition hover:bg-red-500/20">
            <i data-lucide="log-out" class="h-4 w-4"></i> Keluar Akun
        </button>
    </form>
</aside>

<div class="min-w-0 lg:ml-60">
    {{-- NAVBAR --}}
    @php
        $user = auth()->user();
        $notifikasi = $user ? $user->notifications()->latest()->take(8)->get() : collect();
        $belumDibaca = $user ? $user->unreadNotifications()->count() : 0;
        $urlBaca = Route::has('peminjam.notifikasi.baca') ? route('peminjam.notifikasi.baca') : null;
        $namaJurusan = $user->jurusan->nama_jurusan ?? '-';
    @endphp
    <header class="sticky top-0 z-20 flex h-14 items-center justify-between border-b border-gray-200 bg-white/95 px-6 backdrop-blur lg:px-10">
        <span class="font-head text-lg font-extrabold">SkanSarpras</span>
        <div class="flex items-center gap-5 text-sm">
            <span class="hidden items-center gap-2 text-gray-700 sm:flex">
                <i data-lucide="graduation-cap" class="h-4 w-4"></i>
                Jurusan: {{ $namaJurusan }}
            </span>

            {{-- NOTIFIKASI --}}
            <div class="relative" data-dropdown>
                <button type="button" data-dropdown-btn data-notif-btn aria-label="Notifikasi"
                        class="relative flex items-center text-gray-600 hover:text-brand">
                    <i data-lucide="bell" class="h-[18px] w-[18px]"></i>
                    @if ($belumDibaca > 0)
                        <span data-notif-badge
                              class="absolute -right-2 -top-2 flex h-4 min-w-[16px] items-center justify-center rounded-full bg-red-500 px-1 text-[10px] font-bold leading-none text-white ring-2 ring-white">
                            {{ $belumDibaca > 9 ? '9+' : $belumDibaca }}
                        </span>
                    @endif
                </button>

                <div data-dropdown-panel
                     class="invisible absolute right-0 z-50 mt-4 w-80 max-w-[calc(100vw-2rem)] origin-top-right scale-95 rounded-2xl bg-white opacity-0 shadow-xl shadow-brand/15 ring-1 ring-black/5 transition duration-150">
                    <div class="flex items-center justify-between border-b border-gray-100 px-4 py-3">
                        <p class="font-head text-sm font-bold">Notifikasi</p>
                        @if ($belumDibaca > 0)
                            <span class="rounded-full bg-brand-mint px-2 py-0.5 text-[11px] font-semibold">{{ $belumDibaca }} baru</span>
                        @endif
                    </div>

                    <ul class="max-h-80 divide-y divide-gray-50 overflow-y-auto">
                        @forelse ($notifikasi as $n)
                            <li class="flex gap-3 px-4 py-3 {{ $n->read_at ? '' : 'bg-brand-mint/40' }}">
                                <span class="mt-0.5 flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-brand-mint text-brand">
                                    <i data-lucide="bell-ring" class="h-4 w-4"></i>
                                </span>
                                <div class="min-w-0 flex-1">
                                    <p class="text-sm font-semibold leading-snug">{{ $n->data['judul'] ?? 'Notifikasi' }}</p>
                                    <p class="mt-0.5 text-xs leading-relaxed text-gray-500">{{ $n->data['pesan'] ?? '' }}</p>
                                    <p class="mt-1 text-[11px] text-gray-400">{{ $n->created_at->diffForHumans() }}</p>
                                </div>
                                @unless ($n->read_at)
                                    <span class="mt-1.5 h-2 w-2 shrink-0 rounded-full bg-red-500"></span>
                                @endunless
                            </li>
                        @empty
                            <li class="px-4 py-10 text-center text-sm text-gray-400">
                                <i data-lucide="bell-off" class="mx-auto mb-2 h-6 w-6"></i>
                                Belum ada notifikasi
                            </li>
                        @endforelse
                    </ul>
                </div>
            </div>

            {{-- PROFIL --}}
            <div class="relative" data-dropdown>
                <button type="button" data-dropdown-btn aria-label="Profil"
                        class="flex items-center text-gray-600 hover:text-brand">
                    <i data-lucide="circle-user-round" class="h-6 w-6"></i>
                </button>

                <div data-dropdown-panel
                     class="invisible absolute right-0 z-50 mt-4 w-64 max-w-[calc(100vw-2rem)] origin-top-right scale-95 rounded-2xl bg-white p-2 opacity-0 shadow-xl shadow-brand/15 ring-1 ring-black/5 transition duration-150">
                    <div class="flex items-center gap-3 border-b border-gray-100 px-3 pb-3 pt-2">
                        <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-brand text-sm font-bold text-white">
                            {{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}
                        </span>
                        <div class="min-w-0">
                            <p class="truncate text-sm font-semibold">{{ $user->name ?? 'Pengguna' }}</p>
                            <p class="truncate text-xs text-gray-500">{{ $user->email ?? '' }}</p>
                            <p class="truncate text-[11px] text-gray-400 sm:hidden">Jurusan: {{ $namaJurusan }}</p>
                        </div>
                    </div>

                    <div class="py-1.5">
                        <a href="{{ Route::has('peminjam.profil') ? route('peminjam.profil') : '#' }}"
                           class="flex items-center gap-2.5 rounded-lg px-3 py-2 transition hover:bg-brand-mint">
                            <i data-lucide="user" class="h-4 w-4 text-gray-500"></i> Profil Saya
                        </a>
                        <a href="{{ Route::has('peminjam.riwayat.index') ? route('peminjam.riwayat.index') : '#' }}"
                           class="flex items-center gap-2.5 rounded-lg px-3 py-2 transition hover:bg-brand-mint">
                            <i data-lucide="history" class="h-4 w-4 text-gray-500"></i> Riwayat Pengajuan
                        </a>
                    </div>

                    <form method="POST" action="{{ Route::has('logout') ? route('logout') : '#' }}" class="border-t border-gray-100 pt-1.5">
                        @csrf
                        <button type="submit"
                                class="flex w-full items-center gap-2.5 rounded-lg px-3 py-2 text-red-600 transition hover:bg-red-50">
                            <i data-lucide="log-out" class="h-4 w-4"></i> Keluar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    <main>@yield('content')</main>
</div>

<script>
    lucide.createIcons();

    (function () {
        const dropdowns = document.querySelectorAll('[data-dropdown]');

        const panel = (d) => d.querySelector('[data-dropdown-panel]');
        const tutup = (d) => {
            panel(d).classList.add('invisible', 'opacity-0', 'scale-95');
            panel(d).classList.remove('visible', 'opacity-100', 'scale-100');
        };
        const buka = (d) => {
            panel(d).classList.remove('invisible', 'opacity-0', 'scale-95');
            panel(d).classList.add('visible', 'opacity-100', 'scale-100');
        };

        // Badge hilang saat notifikasi dibuka, lalu tandai dibaca di server
        function tandaiDibaca() {
            const badge = document.querySelector('[data-notif-badge]');
            if (!badge) return;
            badge.remove();
            const url = @json($urlBaca);
            if (!url) return;
            fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            }).catch(() => {});
        }

        dropdowns.forEach((d) => {
            d.querySelector('[data-dropdown-btn]').addEventListener('click', (e) => {
                e.stopPropagation();
                const sedangBuka = panel(d).classList.contains('visible');
                dropdowns.forEach(tutup);
                if (!sedangBuka) {
                    buka(d);
                    if (d.querySelector('[data-notif-btn]')) tandaiDibaca();
                }
            });
        });

        document.addEventListener('click', (e) => {
            dropdowns.forEach((d) => { if (!d.contains(e.target)) tutup(d); });
        });
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') dropdowns.forEach(tutup);
        });
    })();
</script>
</body>
</html>