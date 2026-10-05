<header
    class="relative z-40 flex h-[82px] items-center justify-between border-b border-[#b8c0bd] bg-white px-8"
>

    {{-- LOGO / BRAND --}}
    <div class="text-[27px] font-bold tracking-tight text-[#073b2b]">
        SkanSarpras
    </div>


    {{-- BAGIAN KANAN --}}
    <div class="flex items-center gap-7">

      {{-- JURUSAN --}}
@if(auth()->check() && auth()->user()->jurusan)
    <div class="hidden items-center gap-2 text-sm text-[#173d32] md:flex">
        {{-- Icon Toga --}}
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0112 20.055a11.952 11.952 0 01-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 14v7" />
        </svg>
        <span>
            Jurusan:
            <span class="font-medium">
                {{ auth()->user()->jurusan->nama_jurusan }}
            </span>
        </span>
    </div>
@endif


        {{-- NOTIFICATION --}}
        <div class="relative">

            <button
                type="button"
                id="notificationButton"
                class="flex h-10 w-10 items-center justify-center rounded-full text-[#9ca5a1] transition hover:bg-[#f1f5f3] hover:text-[#073b2b]"
                aria-label="Notifikasi"
            >

                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-6 w-6"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="1.6"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M15 17H9m8-1V10a5 5 0 00-10 0v6l-2 2h14l-2-2z"
                    />
                </svg>

            </button>


            {{-- NOTIFICATION POPUP --}}
            <div
                id="notificationPopup"
                class="absolute right-[-40px] top-[57px] hidden w-[585px] max-w-[calc(100vw-40px)]"
            >

                {{-- Segitiga --}}
                <div
                    class="absolute right-[65px] -top-[12px] h-0 w-0 border-x-[14px] border-b-[14px] border-x-transparent border-b-[#aeb7b3]"
                ></div>

                <div
                    class="absolute right-[66px] -top-[10px] h-0 w-0 border-x-[13px] border-b-[13px] border-x-transparent border-b-white"
                ></div>


                {{-- BOX --}}
                <div
                    class="rounded-2xl border border-[#aeb7b3] bg-white p-5 shadow-lg"
                >

                    {{-- Header --}}
                    <div class="mb-4 flex items-center justify-between">

                        <button
                            type="button"
                            class="rounded-xl bg-[#245a48] px-5 py-2 text-xs font-medium text-white"
                        >
                            Sort By ↓
                        </button>

                        <button
                            type="button"
                            onclick="closeNotification()"
                            class="flex h-8 w-8 items-center justify-center rounded-full border border-[#9da7a3] text-[#9da7a3] hover:bg-gray-50"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="1.7"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M6 6l12 12M18 6L6 18"
                                />
                            </svg>
                        </button>

                    </div>


                    {{-- Notification 1 --}}
                    <div class="mb-5 rounded-xl border border-[#b8bfbc] bg-white p-4 shadow-sm">

                        <div class="flex gap-4">

                            <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-[#c8ffc5] text-[#21b52a]">
                                ✓
                            </div>

                            <div class="min-w-0 flex-1">

                                <div class="flex justify-between gap-3">

                                    <h4 class="text-sm font-semibold text-[#111827]">
                                        Pengajuanmu Disetujui
                                    </h4>

                                    <span class="shrink-0 text-[11px] text-gray-500">
                                        5 menit lalu
                                    </span>

                                </div>

                                <p class="mt-1 text-xs leading-4 text-gray-500">
                                    Pengajuan peminjaman
                                    <strong class="text-gray-700">Microphone</strong>
                                    telah disetujui admin, silakan ambil
                                    di Ruang Toolman RPL.
                                </p>

                            </div>

                        </div>

                    </div>


                    {{-- Notification 2 --}}
                    <div class="mb-5 rounded-xl border border-[#b8bfbc] bg-white p-4 shadow-sm">

                        <div class="flex gap-4">

                            <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-[#c8ffc5] text-[#21b52a]">
                                ✓
                            </div>

                            <div class="min-w-0 flex-1">

                                <div class="flex justify-between gap-3">

                                    <h4 class="text-sm font-semibold text-[#111827]">
                                        Pengajuanmu Disetujui
                                    </h4>

                                    <span class="shrink-0 text-[11px] text-gray-500">
                                        5 menit lalu
                                    </span>

                                </div>

                                <p class="mt-1 text-xs leading-4 text-gray-500">
                                    Pengajuan peminjaman
                                    <strong class="text-gray-700">Microphone</strong>
                                    telah disetujui admin, silakan ambil
                                    di Ruang Toolman RPL.
                                </p>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- PROFILE --}}
        <div class="relative">

            <button
                type="button"
                id="profileButton"
                class="flex h-10 w-10 items-center justify-center rounded-full text-[#9ca5a1] transition hover:bg-[#f1f5f3] hover:text-[#073b2b]"
                aria-label="Profil"
            >

                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-8 w-8"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="1.3"
                >
                    <circle cx="12" cy="12" r="9"/>
                    <circle cx="12" cy="9" r="3"/>
                    <path
                        stroke-linecap="round"
                        d="M6.8 18c.9-2.1 2.7-3.2 5.2-3.2s4.3 1.1 5.2 3.2"
                    />
                </svg>

            </button>


            {{-- PROFILE POPUP --}}
            <div
                id="profilePopup"
                class="absolute right-0 top-[57px] hidden w-[273px]"
            >

                {{-- Segitiga --}}
                <div
                    class="absolute right-[24px] -top-[14px] h-0 w-0 border-x-[14px] border-b-[14px] border-x-transparent border-b-[#aeb7b3]"
                ></div>

                <div
                    class="absolute right-[25px] -top-[12px] h-0 w-0 border-x-[13px] border-b-[13px] border-x-transparent border-b-white"
                ></div>


                {{-- Profile Card --}}
                <div
                    class="rounded-2xl border border-[#aeb7b3] bg-white px-6 pb-5 pt-7 shadow-lg"
                >

                    {{-- Avatar --}}
                    <div class="mx-auto flex h-28 w-28 items-center justify-center rounded-full bg-[#d9d9d9]">

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-12 w-12 text-white"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="1.3"
                        >
                            <circle cx="12" cy="8" r="3"/>
                            <path
                                stroke-linecap="round"
                                d="M5.5 19c1.1-3.2 3.3-4.8 6.5-4.8s5.4 1.6 6.5 4.8"
                            />
                        </svg>

                    </div>


                    {{-- Name --}}
                    <div class="mt-7 text-center">

                        <h3 class="text-sm font-semibold uppercase tracking-wide text-[#073b2b]">
                            {{ auth()->user()->name ?? 'JUWITA SERINA PUTRI' }}
                        </h3>

                        <span class="mt-3 inline-flex rounded-md bg-[#a5efcf] px-4 py-1 text-xs font-semibold text-[#073b2b]">
                            {{ auth()->user()->role === 'admin' ? 'Admin' : 'Siswa Aktif' }}
                        </span>

                        <p class="mt-3 text-xs text-gray-400">
                            {{ auth()->user()->email ?? 'juwita.serina6@smk.belajar.id' }}
                        </p>

                        @if(auth()->user()->kelas ?? false)
                            <p class="mt-2 text-sm font-semibold text-[#073b2b]">
                                {{ auth()->user()->kelas }}
                            </p>
                        @endif

                    </div>


                    {{-- Logout --}}
                    <form action="{{ route('logout') }}" method="POST" class="mt-7">
                        @csrf

                        <button
                            type="submit"
                            class="w-full rounded-lg border border-red-400 py-2 text-xs font-medium text-red-600 transition hover:bg-red-50"
                        >
                            Keluar Akun
                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

</header>


<script>
    const notificationButton = document.getElementById('notificationButton');
    const notificationPopup = document.getElementById('notificationPopup');

    const profileButton = document.getElementById('profileButton');
    const profilePopup = document.getElementById('profilePopup');


    notificationButton?.addEventListener('click', function (event) {
        event.stopPropagation();

        notificationPopup?.classList.toggle('hidden');
        profilePopup?.classList.add('hidden');
    });


    profileButton?.addEventListener('click', function (event) {
        event.stopPropagation();

        profilePopup?.classList.toggle('hidden');
        notificationPopup?.classList.add('hidden');
    });


    document.addEventListener('click', function (event) {

        if (
            !notificationPopup?.contains(event.target) &&
            !notificationButton?.contains(event.target)
        ) {
            notificationPopup?.classList.add('hidden');
        }

        if (
            !profilePopup?.contains(event.target) &&
            !profileButton?.contains(event.target)
        ) {
            profilePopup?.classList.add('hidden');
        }

    });


    function closeNotification() {
        notificationPopup?.classList.add('hidden');
    }
</script>
