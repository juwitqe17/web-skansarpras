<header
    class="relative z-40 flex h-[94px] items-center justify-between border-b border-[#b8c0bd] bg-white px-14"
>

    {{-- TITLE --}}
    <h1 class="text-[27px] font-bold tracking-tight text-[#073b2b]">
        SkanSarpras Admin
    </h1>


    {{-- RIGHT --}}
    <div class="flex items-center gap-5">

        {{-- NOTIFICATION --}}
        <div class="relative">

            <button
                type="button"
                id="adminNotificationButton"
                class="flex h-10 w-10 items-center justify-center rounded-full text-[#9ca5a1] transition hover:bg-[#f1f5f3] hover:text-[#073b2b]"
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

            {{-- POPUP NOTIFICATION --}}
            <div
                id="adminNotificationPopup"
                class="absolute right-[-45px] top-[55px] hidden w-[585px] max-w-[calc(100vw-40px)]"
            >

                <div
                    class="absolute right-[64px] -top-3 h-0 w-0 border-x-[14px] border-b-[14px] border-x-transparent border-b-[#aeb7b3]"
                ></div>

                <div
                    class="absolute right-[65px] -top-[10px] h-0 w-0 border-x-[13px] border-b-[13px] border-x-transparent border-b-white"
                ></div>

                <div class="rounded-2xl border border-[#aeb7b3] bg-white p-5 shadow-lg">

                    <div class="mb-4 flex items-center justify-between">

                        <button
                            type="button"
                            class="rounded-xl bg-[#245a48] px-5 py-2 text-xs font-medium text-white"
                        >
                            Sort By ↓
                        </button>

                        <button
                            type="button"
                            onclick="closeAdminNotification()"
                            class="flex h-8 w-8 items-center justify-center rounded-full border border-[#9da7a3] text-[#9da7a3]"
                        >
                            ×
                        </button>

                    </div>

                    <div class="rounded-xl border border-[#b8bfbc] p-4 shadow-sm">

                        <div class="flex gap-4">

                            <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-[#c8ffc5] font-bold text-[#21b52a]">
                                ✓
                            </div>

                            <div>

                                <h4 class="text-sm font-semibold text-[#111827]">
                                    Pengajuan Baru
                                </h4>

                                <p class="mt-1 text-xs text-gray-500">
                                    Terdapat pengajuan peminjaman baru yang perlu diperiksa.
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
                id="adminProfileButton"
                class="flex h-10 w-10 items-center justify-center rounded-full text-[#9ca5a1] transition hover:bg-[#f1f5f3] hover:text-[#073b2b]"
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
                id="adminProfilePopup"
                class="absolute right-0 top-[55px] hidden w-[273px]"
            >

                <div
                    class="absolute right-[24px] -top-[14px] h-0 w-0 border-x-[14px] border-b-[14px] border-x-transparent border-b-[#aeb7b3]"
                ></div>

                <div
                    class="absolute right-[25px] -top-[12px] h-0 w-0 border-x-[13px] border-b-[13px] border-x-transparent border-b-white"
                ></div>

                <div class="rounded-2xl border border-[#aeb7b3] bg-white px-6 pb-5 pt-7 shadow-lg">

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


                    {{-- Data Admin --}}
                    <div class="mt-7 text-center">

                        <h3 class="text-sm font-semibold uppercase tracking-wide text-[#073b2b]">
                            {{ auth()->user()->name ?? 'ADMIN SARPRAS' }}
                        </h3>

                        <span class="mt-3 inline-flex rounded-md bg-[#a5efcf] px-4 py-1 text-xs font-semibold text-[#073b2b]">
                            Admin
                        </span>

                        <p class="mt-3 text-xs text-gray-400">
                            {{ auth()->user()->email ?? 'admin@sarpras.test' }}
                        </p>

                    </div>


                    {{-- Logout --}}
                    <form
                        action="{{ route('logout') }}"
                        method="POST"
                        class="mt-7"
                    >
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
    const adminNotificationButton =
        document.getElementById('adminNotificationButton');

    const adminNotificationPopup =
        document.getElementById('adminNotificationPopup');

    const adminProfileButton =
        document.getElementById('adminProfileButton');

    const adminProfilePopup =
        document.getElementById('adminProfilePopup');


    adminNotificationButton?.addEventListener('click', function (event) {

        event.stopPropagation();

        adminNotificationPopup?.classList.toggle('hidden');

        adminProfilePopup?.classList.add('hidden');

    });


    adminProfileButton?.addEventListener('click', function (event) {

        event.stopPropagation();

        adminProfilePopup?.classList.toggle('hidden');

        adminNotificationPopup?.classList.add('hidden');

    });


    document.addEventListener('click', function (event) {

        if (
            !adminNotificationPopup?.contains(event.target) &&
            !adminNotificationButton?.contains(event.target)
        ) {
            adminNotificationPopup?.classList.add('hidden');
        }

        if (
            !adminProfilePopup?.contains(event.target) &&
            !adminProfileButton?.contains(event.target)
        ) {
            adminProfilePopup?.classList.add('hidden');
        }

    });


    function closeAdminNotification() {
        adminNotificationPopup?.classList.add('hidden');
    }
</script>
