<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
        <div class="relative flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-white/90 text-brand">
            <i data-lucide="school" class="h-5 w-5"></i>
            <img src="{{ asset('images/logo.png') }}" alt="Logo SkanSarpras" onerror="this.remove()"
                 class="absolute inset-0 h-full w-full rounded-lg bg-white object-contain p-1">
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
            ['Peminjaman', 'peminjam.pengajuan.create', 'clipboard-list'],
            ['Riwayat Pengajuan', 'peminjam.riwayat.index', 'history'],
        ];
    @endphp
    <nav class="mt-6 space-y-1.5 text-sm">
        @foreach ($menu as [$label, $route, $icon])
            <a href="{{ Route::has($route) ? route($route) : '#' }}"
               class="flex items-center gap-3 rounded-lg px-3.5 py-2.5 transition-colors
                      {{ request()->routeIs(str_replace('.create', '.*', str_replace('.index', '.*', $route))) ? 'bg-brand-soft font-medium' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
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
    <header class="sticky top-0 z-20 flex h-14 items-center justify-between border-b border-gray-200 bg-white/95 px-6 backdrop-blur lg:px-10">
        <span class="font-head text-lg font-extrabold">SkanSarpras</span>
        <div class="flex items-center gap-5 text-sm">
            <span class="hidden items-center gap-2 text-gray-700 sm:flex">
                <i data-lucide="graduation-cap" class="h-4 w-4"></i>
                Jurusan: {{ auth()->user()->jurusan->nama_jurusan ?? '-' }}
            </span>
            <button aria-label="Notifikasi" class="text-gray-600 hover:text-brand"><i data-lucide="bell" class="h-[18px] w-[18px]"></i></button>
            <button aria-label="Profil" class="text-gray-600 hover:text-brand"><i data-lucide="circle-user-round" class="h-6 w-6"></i></button>
        </div>
    </header>

    <main>@yield('content')</main>
</div>

<script>lucide.createIcons();</script>
</body>
</html>