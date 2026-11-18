<aside
    class="hidden lg:flex fixed inset-y-0 left-0 z-50 w-[264px] flex-col border-r border-[#b8c0bd] bg-white px-4 py-6 text-[#625b56]"
>
    @php
        $activeClass = 'bg-[#1b5541] text-white';
        $inactiveClass = 'text-[#625b56] hover:bg-[#f1f5f3] hover:text-[#073b2b]';
    @endphp

    {{-- BRAND / BAGIAN ATAS --}}
    <div class="flex items-center gap-3 px-2 pb-4 border-b border-[#b8c0bd]">
        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-[#f8f3e8] overflow-hidden">
            <img
                src="{{ asset('images/logo.png') }}"
                alt="Logo SMK"
                class="h-8 w-8 object-contain"
            >
        </div>
        <div>
            <h1 class="font-bold text-2xl leading-tight text-[#073b2b]">
                SkanSarpras
            </h1>
            <p class="text-[11px] text-[#8b8b8b] leading-tight whitespace-nowrap">
                Manajemen Sarana Prasarana
            </p>
            <p class="text-[11px] text-[#8b8b8b] leading-tight whitespace-nowrap">
                SMK Negeri 1 Purwosari
            </p>
        </div>
    </div>

    {{-- MENU ADMIN --}}
    <nav class="mt-6 space-y-2 text-sm">

        {{-- Dashboard --}}
        <a
            href="{{ route('admin.dashboard') }}"
            class="flex items-center gap-3 rounded-md px-4 py-3 transition
            {{ request()->routeIs('admin.dashboard') ? $activeClass : $inactiveClass }}"
        >
            <x-heroicon-s-squares-2x2 class="h-5 w-5 shrink-0" />
            <span>Dashboard</span>
        </a>

        {{-- Data Departemen --}}
        <a
            href="{{ route('admin.jurusan.index') }}"
            class="flex items-center gap-3 rounded-md px-4 py-3 transition
            {{ request()->routeIs('admin.jurusan.index') ? $activeClass : $inactiveClass }}"
        >
            <x-heroicon-o-academic-cap class="h-5 w-5 shrink-0" />
            <span>Departemen (Jurusan)</span>
        </a>

        {{-- Data Sarana Prasarana --}}
        <a
            href="{{ route('admin.sarana.index') }}"
            class="flex items-center gap-3 rounded-md px-4 py-3 transition
            {{ request()->routeIs('admin.sarana.index') ? $activeClass : $inactiveClass }}"
        >
            <x-heroicon-o-cube class="h-5 w-5 shrink-0" />
            <span>Sarana Prasarana</span>
        </a>

        {{-- Pengajuan --}}
        <a
            href="{{ route('admin.pengajuan.index') }}"
            class="flex items-center gap-3 rounded-md px-4 py-3 transition
            {{ request()->routeIs('admin.pengajuan.index') ? $activeClass : $inactiveClass }}"
        >
            <x-heroicon-o-document-text class="h-5 w-5 shrink-0" />
            <span>Pengajuan</span>
        </a>

        {{-- Pengembalian --}}
        <a
            href="{{ route('admin.pengembalian.index') }}"
            class="flex items-center gap-3 rounded-md px-4 py-3 transition
            {{ request()->routeIs('admin.pengembalian.index') ? $activeClass : $inactiveClass }}"
        >
            <x-heroicon-o-arrow-path-rounded-square class="h-5 w-5 shrink-0" />
            <span>Pengembalian</span>
        </a>

        {{-- Jadwal --}}
        <a
            href="{{ route('admin.jadwal.index') }}"
            class="flex items-center gap-3 rounded-md px-4 py-3 transition
            {{ request()->routeIs('admin.jadwal.index') ? $activeClass : $inactiveClass }}"
        >
            <x-heroicon-o-calendar-days class="h-5 w-5 shrink-0" />
            <span>Jadwal Penggunaan</span>
        </a>

    </nav>

    {{-- LOGOUT --}}
    <div class="mt-auto">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button
                type="submit"
                class="flex w-full items-center gap-3 rounded-md px-4 py-3 text-left text-sm text-red-600 transition hover:bg-red-50"
            >
                <x-heroicon-o-arrow-left-on-rectangle class="h-5 w-5 shrink-0" />
                <span>Keluar Akun</span>
            </button>
        </form>
    </div>

</aside>
