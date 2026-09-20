<aside
    class="fixed left-0 top-0 z-50 flex h-screen w-[295px] flex-col bg-[#003b2b] px-[18px] py-8 pt-10 text-white"
>

    @php
        $activeClass = 'bg-[#ffffff]/15 text-white';
        $inactiveClass = 'text-white/80 hover:bg-white/10 hover:text-white';
    @endphp

    {{-- BRAND --}}
    <div class="border-b border-white/50 px-2 pb-5">

        <div class="flex items-center gap-4">

            {{-- Logo --}}
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

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M8.5 11h7M9.5 8.5h5M9 14.5h6"
                    />
                </svg>

            </div>


            {{-- Brand Text --}}
            <div>

                <h1 class="text-[25px] font-bold leading-none">
                    SkanSarpras
                </h1>

                <p class="mt-2 text-[12px] leading-4 text-white/65">
                    Manajemen Sarana Prasarana<br>
                    SMK Negeri 1 Purwosari
                </p>

            </div>

        </div>

    </div>


    {{-- MENU --}}
    <nav class="mt-5 space-y-2">

        {{-- Beranda --}}
       <a
            href="{{ route('peminjam.dashboard') }}"
            class="flex h-[34px] items-center gap-4 rounded-lg px-4 text-[13px] transition
            {{ request()->routeIs('peminjam.dashboard') ? $activeClass : $inactiveClass }}"
        >

            <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-5 w-5"
                fill="currentColor"
                viewBox="0 0 24 24"
            >
                <path d="M4 4h6v6H4zM14 4h6v6h-6zM4 14h6v6H4zM14 14h6v6h-6z"/>
            </svg>

            <span>Beranda</span>

        </a>


        {{-- Sarana Prasarana --}}
        <a
            href="{{ route('peminjam.sarana') }}"
            class="flex h-[34px] items-center gap-4 rounded-lg px-4 text-[13px] transition
            {{ request()->routeIs('peminjam.sarana') ? $activeClass : $inactiveClass }}"
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
                    d="M4 7h16M6 7v12h12V7M8 4h8v3H8V4zM9 11h6M9 15h6"
                />
            </svg>

            <span>Sarana Prasarana</span>

        </a>


        {{-- Peminjaman --}}
        <a
            href="{{ route('peminjam.peminjaman') }}"
            class="flex h-[34px] items-center gap-4 rounded-lg px-4 text-[13px] transition
            {{ request()->routeIs('peminjam.peminjaman') ? $activeClass : $inactiveClass }}"
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
                <circle cx="17" cy="17" r="3" fill="#003b2b"/>
            </svg>

            <span>Peminjaman</span>

        </a>


        {{-- Riwayat --}}
        <a
            href="{{ route('peminjam.riwayat') }}"
            class="flex h-[34px] items-center gap-4 rounded-lg px-4 text-[13px] transition
            {{ request()->routeIs('peminjam.riwayat') ? $activeClass : $inactiveClass }}"
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
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M12 8v4l3 2"
                />
            </svg>

            <span>Riwayat Pengajuan</span>

        </a>

    </nav>


    {{-- LOGOUT DI BAWAH --}}
    <div class="mt-auto px-2">

        <form action="{{ route('logout') }}" method="POST">
            @csrf

            <button
                type="submit"
                class="flex w-full items-center gap-4 rounded-lg px-4 py-3 text-left text-sm text-white/90 transition hover:bg-red-500/15 hover:text-red-200"
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
