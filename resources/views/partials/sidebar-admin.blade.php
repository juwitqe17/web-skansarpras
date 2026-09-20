<aside
    class="fixed left-0 top-0 z-50 flex h-screen w-[295px] flex-col border-r border-[#b8c0bd] bg-white px-[18px] py-8 pt-10 text-[#625b56]"
>

    @php
        $activeClass = 'bg-[#1b5541] text-white';
        $inactiveClass = 'text-[#625b56] hover:bg-[#f1f5f3] hover:text-[#073b2b]';
    @endphp

    {{-- BRAND --}}
   <div class="border-b border-[#b8c0bd] px-2 pb-5">

        <div class="flex items-center gap-4">

            <div class="flex h-[52px] w-[52px] shrink-0 items-center justify-center rounded-xl bg-[#f8f3e8]">

                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-8 w-8 text-[#386553]"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="1.4"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M12 3l7 4v5c0 4.5-3 7.5-7 9-4-1.5-7-4.5-7-9V7l7-4z"
                    />
                </svg>

            </div>

            <div>

                <h1 class="text-[25px] font-bold leading-none text-[#073b2b]">
                    SkanSarpras
                </h1>

                <p class="mt-2 text-[12px] leading-4 text-[#8b8b8b]">
                    Manajemen Sarana Prasarana<br>
                    SMK Negeri 1 Purwosari
                </p>

            </div>

        </div>

    </div>


    {{-- MENU ADMIN --}}
    <nav class="mt-5 space-y-2">

        {{-- Dashboard --}}
        <a
            href="{{ route('admin.dashboard') }}"
            class="flex h-[34px] items-center gap-4 rounded-lg px-4 text-[13px] transition
            {{ request()->routeIs('admin.dashboard') ? $activeClass : $inactiveClass }}"
        >

            <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-5 w-5"
                fill="currentColor"
                viewBox="0 0 24 24"
            >
                <path d="M4 4h6v6H4zM14 4h6v6h-6zM4 14h6v6H4zM14 14h6v6h-6z"/>
            </svg>

            <span>Dashboard</span>

        </a>


        {{-- Data Departemen --}}
        <a
            href="{{ route('admin.jurusan') }}"
            class="flex h-[34px] items-center gap-4 rounded-lg px-4 text-[13px] transition
            {{ request()->routeIs('admin.jurusan') ? $activeClass : $inactiveClass }}"
        >

            <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-5 w-5"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="1.8"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M4 7h16M6 7v12h12V7M8 4h8v3H8V4z"
                />
            </svg>

            <span>Departemen (Jurusan)</span>

        </a>

        {{-- Data Sarana Prasarana --}}
        <a
            href="{{ route('admin.sarana') }}"
            class="flex h-[34px] items-center gap-4 rounded-lg px-4 text-[13px] transition
            {{ request()->routeIs('admin.sarana') ? $activeClass : $inactiveClass }}"
        >

            <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-5 w-5"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="1.8"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M4 7h16M6 7v12h12V7M8 4h8v3H8V4z"
                />
            </svg>

            <span>Sarana Prasarana</span>

        </a>


        {{-- Pengajuan --}}
         <a
            href="{{ route('admin.pengajuan') }}"
            class="flex h-[34px] items-center gap-4 rounded-lg px-4 text-[13px] transition
            {{ request()->routeIs('admin.pengajuan') ? $activeClass : $inactiveClass }}"
        >

            <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-5 w-5"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="1.8"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M8 6h10M8 12h10M8 18h6"
                />

                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M4 5h.01M4 11h.01M4 17h.01"
                />
            </svg>

            <span>Pengajuan</span>

        </a>

        {{-- Pengembalian --}}
         <a
            href="{{ route('admin.pengembalian') }}"
            class="flex h-[34px] items-center gap-4 rounded-lg px-4 text-[13px] transition
            {{ request()->routeIs('admin.pengembalian') ? $activeClass : $inactiveClass }}"
        >

            <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-5 w-5"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="1.8"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M4 12a8 8 0 108-8"
                />
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M4 6v6h6"
                />
            </svg>

            <span>Pengembalian</span>

        </a>

        {{-- Jadwal --}}
         <a
            href="{{ route('admin.jadwal') }}"
            class="flex h-[34px] items-center gap-4 rounded-lg px-4 text-[13px] transition
            {{ request()->routeIs('admin.jadwal') ? $activeClass : $inactiveClass }}"
        >

            <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-5 w-5"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="1.8"
            >
                <rect x="4" y="5" width="16" height="15" rx="2"/>
                <path stroke-linecap="round" d="M8 3v4M16 3v4M4 10h16"/>
            </svg>

            <span>Jadwal Penggunaan</span>

        </a>


      

    </nav>

    {{-- LOGOUT --}}
    <div class="mt-auto px-2">

        <form action="{{ route('logout') }}" method="POST">
            @csrf

            <button
                type="submit"
                class="flex w-full items-center gap-4 rounded-lg px-4 py-3 text-left text-sm text-[#625b56] transition hover:bg-red-50 hover:text-red-600"
            >

                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="1.8"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M10 17l5-5-5-5M15 12H3"
                    />

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M21 19V5a2 2 0 00-2-2h-6"
                    />
                </svg>

                <span>Keluar Akun</span>

            </button>

        </form>

    </div>

</aside>
