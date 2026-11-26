@php
    $user = auth()->user();

    // Notifikasi belum dibaca (memakai fitur notifikasi bawaan Laravel).
    // Dibungkus try/catch supaya header tidak error jika tabel notifications belum ada.
    $unreadCount = 0;
    $notifications = collect();

    try {
        if ($user && method_exists($user, 'unreadNotifications')) {
            $unreadCount   = $user->unreadNotifications()->count();
            $notifications = $user->unreadNotifications()->latest()->take(5)->get();
        }
    } catch (\Throwable $e) {
        // abaikan, tampilkan sebagai "belum ada notifikasi"
    }
@endphp

<header class="sticky top-0 z-30 flex h-[74px] items-center justify-between border-b border-gray-200 bg-white px-6 lg:px-10">
    {{-- JUDUL --}}
    <h1 class="text-2xl font-extrabold tracking-tight text-[#073b2b]">
        SkanSarpras Admin
    </h1>

    {{-- KANAN --}}
    <div class="flex items-center gap-3">

        {{-- TOMBOL NOTIFIKASI --}}
        <div class="relative" data-admin-popup>
            <button type="button"
                    onclick="toggleAdminPopup('adminNotifMenu')"
                    aria-label="Notifikasi{{ $unreadCount > 0 ? ' (' . $unreadCount . ' belum dibaca)' : '' }}"
                    aria-haspopup="true"
                    aria-expanded="false"
                    aria-controls="adminNotifMenu"
                    class="group relative flex h-10 w-10 items-center justify-center rounded-full text-gray-600 transition-all duration-200 hover:bg-gray-100 hover:text-[#073b2b] active:scale-95 focus:outline-none focus-visible:ring-2 focus-visible:ring-[#073b2b]/40">
                {{-- Icon Bell (Heroicons Outline) --}}
                <svg class="h-6 w-6 transition-transform duration-200 group-hover:rotate-12" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                </svg>

                {{-- Badge jumlah notifikasi --}}
                @if ($unreadCount > 0)
                    <span class="absolute right-1 top-1 flex h-[17px] min-w-[17px] items-center justify-center rounded-full bg-red-500 px-1 text-[10px] font-bold leading-none text-white ring-2 ring-white animate-pulse">
                        {{ $unreadCount > 9 ? '9+' : $unreadCount }}
                    </span>
                @endif
            </button>

            {{-- POPUP NOTIFIKASI (Dengan Animasi Smooth) --}}
            <div id="adminNotifMenu"
                 class="pointer-events-none invisible opacity-0 scale-95 -translate-y-2 origin-top-right transition-all duration-200 ease-out absolute right-0 z-50 mt-3 w-[min(20rem,calc(100vw-2rem))] rounded-2xl border border-gray-200 bg-white shadow-xl">

                {{-- Header popup --}}
                <div class="flex items-center justify-between border-b border-gray-100 px-4 py-3">
                    <p class="text-sm font-bold text-gray-900">
                        Notifikasi
                        @if ($unreadCount > 0)
                            <span class="ml-1 rounded-full bg-red-50 px-2 py-0.5 text-[11px] font-semibold text-red-600">{{ $unreadCount }} baru</span>
                        @endif
                    </p>

                    <button type="button"
                            onclick="closeAdminPopup('adminNotifMenu')"
                            aria-label="Tutup notifikasi"
                            class="flex h-7 w-7 items-center justify-center rounded-full text-gray-400 transition-colors duration-150 hover:bg-gray-100 hover:text-gray-700 focus:outline-none focus-visible:ring-2 focus-visible:ring-[#073b2b]/40">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                {{-- Daftar notifikasi --}}
                @if ($notifications->isEmpty())
                    <div class="flex flex-col items-center px-4 py-8 text-center">
                        <span class="flex h-11 w-11 items-center justify-center rounded-full bg-gray-100 text-gray-400">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                            </svg>
                        </span>
                        <p class="mt-3 text-xs text-gray-400">Belum ada notifikasi saat ini.</p>
                    </div>
                @else
                    <ul class="max-h-80 divide-y divide-gray-100 overflow-y-auto">
                        @foreach ($notifications as $notif)
                            <li class="flex gap-3 px-4 py-3 transition-colors duration-150 hover:bg-gray-50">
                                <span class="mt-1.5 h-2 w-2 shrink-0 rounded-full bg-[#073b2b]"></span>
                                <div class="min-w-0">
                                    <p class="truncate text-sm font-semibold text-gray-900">
                                        {{ $notif->data['title'] ?? 'Notifikasi baru' }}
                                    </p>
                                    @if (!empty($notif->data['message']))
                                        <p class="mt-0.5 line-clamp-2 text-xs leading-relaxed text-gray-500">
                                            {{ $notif->data['message'] }}
                                        </p>
                                    @endif
                                    <p class="mt-1 text-[11px] text-gray-400">{{ $notif->created_at->diffForHumans() }}</p>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>

        {{-- TOMBOL PROFIL --}}
        <div class="relative" data-admin-popup>
            <button type="button"
                    onclick="toggleAdminPopup('adminProfileMenu')"
                    aria-label="Menu profil"
                    aria-haspopup="true"
                    aria-expanded="false"
                    aria-controls="adminProfileMenu"
                    class="flex h-10 w-10 items-center justify-center rounded-full text-gray-600 transition-all duration-200 hover:bg-gray-100 hover:text-[#073b2b] active:scale-95 focus:outline-none focus-visible:ring-2 focus-visible:ring-[#073b2b]/40">
                {{-- Icon User Circle (Heroicons Outline - Sesuai Desain UI) --}}
                <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
            </button>

            {{-- POPUP PROFIL (Dengan Animasi Smooth) --}}
            <div id="adminProfileMenu"
                 class="pointer-events-none invisible opacity-0 scale-95 -translate-y-2 origin-top-right transition-all duration-200 ease-out absolute right-0 z-50 mt-3 w-[min(18rem,calc(100vw-2rem))] rounded-2xl border border-gray-200 bg-white shadow-xl">

                {{-- Header popup --}}
                <div class="flex items-center justify-between border-b border-gray-100 px-4 py-3">
                    <p class="text-sm font-bold text-gray-900">Profil</p>

                    <button type="button"
                            onclick="closeAdminPopup('adminProfileMenu')"
                            aria-label="Tutup profil"
                            class="flex h-7 w-7 items-center justify-center rounded-full text-gray-400 transition-colors duration-150 hover:bg-gray-100 hover:text-gray-700 focus:outline-none focus-visible:ring-2 focus-visible:ring-[#073b2b]/40">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                {{-- Info akun --}}
                <div class="flex items-center gap-3 px-4 py-4">
                    <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-[#073b2b] text-base font-bold text-white shadow-xs">
                        {{ strtoupper(substr($user->name ?? 'A', 0, 1)) }}
                    </span>
                    <div class="min-w-0">
                        <p class="truncate text-sm font-bold text-gray-900">{{ $user->name ?? 'Admin Sarpras' }}</p>
                        <p class="truncate text-xs text-gray-500">{{ $user->email ?? '-' }}</p>
                    </div>
                </div>

                {{-- Keluar --}}
                <form method="POST" action="{{ route('logout') }}" class="border-t border-gray-100 p-3">
                    @csrf
                    <button type="submit" class="w-full rounded-xl bg-red-50 py-2.5 text-xs font-semibold text-red-600 transition-all duration-150 hover:bg-red-100 active:scale-[0.98] focus:outline-none focus-visible:ring-2 focus-visible:ring-red-300">
                        Keluar Akun
                    </button>
                </form>
            </div>
        </div>

    </div>
</header>

<script>
    const adminPopups = ['adminNotifMenu', 'adminProfileMenu'];

    function setAdminPopupState(id, open) {
        const el = document.getElementById(id);
        if (!el) return;

        if (open) {
            el.classList.remove('invisible', 'opacity-0', 'scale-95', '-translate-y-2', 'pointer-events-none');
            el.classList.add('visible', 'opacity-100', 'scale-100', 'translate-y-0', 'pointer-events-auto');
        } else {
            el.classList.remove('visible', 'opacity-100', 'scale-100', 'translate-y-0', 'pointer-events-auto');
            el.classList.add('invisible', 'opacity-0', 'scale-95', '-translate-y-2', 'pointer-events-none');
        }

        const trigger = document.querySelector('[aria-controls="' + id + '"]');
        if (trigger) trigger.setAttribute('aria-expanded', open ? 'true' : 'false');
    }

    function toggleAdminPopup(id) {
        const el = document.getElementById(id);
        const willOpen = el ? el.classList.contains('invisible') : false;

        adminPopups.forEach(menuId => setAdminPopupState(menuId, menuId === id && willOpen));
    }

    function closeAdminPopup(id) {
        setAdminPopupState(id, false);
    }

    // Tutup saat klik di luar popup
    document.addEventListener('click', function (e) {
        if (!e.target.closest('[data-admin-popup]')) {
            adminPopups.forEach(id => setAdminPopupState(id, false));
        }
    });

    // Tutup dengan tombol Esc
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            adminPopups.forEach(id => setAdminPopupState(id, false));
        }
    });
</script>