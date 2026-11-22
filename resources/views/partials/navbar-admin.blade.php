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
    <div class="flex items-center gap-4">

        {{-- TOMBOL NOTIFIKASI --}}
        <div class="relative" data-admin-popup>
            <button type="button"
                    onclick="toggleAdminPopup('adminNotifMenu')"
                    aria-label="Notifikasi{{ $unreadCount > 0 ? ' (' . $unreadCount . ' belum dibaca)' : '' }}"
                    aria-haspopup="true"
                    aria-expanded="false"
                    aria-controls="adminNotifMenu"
                    class="relative flex h-10 w-10 items-center justify-center rounded-full text-gray-600 transition hover:bg-gray-100 focus:outline-none focus-visible:ring-2 focus-visible:ring-[#073b2b]/40">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 17H9m8-1V10a5 5 0 00-10 0v6l-2 2h14l-2-2z" />
                </svg>

                {{-- Badge jumlah notifikasi --}}
                @if ($unreadCount > 0)
                    <span class="absolute -right-0.5 -top-0.5 flex h-[18px] min-w-[18px] items-center justify-center rounded-full bg-red-500 px-1 text-[10px] font-bold leading-none text-white ring-2 ring-white">
                        {{ $unreadCount > 9 ? '9+' : $unreadCount }}
                    </span>
                @endif
            </button>

            <div id="adminNotifMenu"
                 class="hidden absolute right-0 z-50 mt-3 w-[min(20rem,calc(100vw-2rem))] rounded-2xl border border-gray-200 bg-white shadow-xl">

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
                            class="flex h-7 w-7 items-center justify-center rounded-full text-gray-400 transition hover:bg-gray-100 hover:text-gray-700 focus:outline-none focus-visible:ring-2 focus-visible:ring-[#073b2b]/40">
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
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 17H9m8-1V10a5 5 0 00-10 0v6l-2 2h14l-2-2z" />
                            </svg>
                        </span>
                        <p class="mt-3 text-xs text-gray-400">Belum ada notifikasi saat ini.</p>
                    </div>
                @else
                    <ul class="max-h-80 divide-y divide-gray-100 overflow-y-auto">
                        @foreach ($notifications as $notif)
                            <li class="flex gap-3 px-4 py-3 transition hover:bg-gray-50">
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
                    class="flex items-center gap-2 rounded-full p-1.5 text-gray-600 transition hover:bg-gray-100 focus:outline-none focus-visible:ring-2 focus-visible:ring-[#073b2b]/40">
                <span class="flex h-9 w-9 items-center justify-center rounded-full bg-[#073b2b] text-sm font-bold text-white">
                    {{ strtoupper(substr($user->name ?? 'A', 0, 1)) }}
                </span>
            </button>

            <div id="adminProfileMenu"
                 class="hidden absolute right-0 z-50 mt-3 w-[min(18rem,calc(100vw-2rem))] rounded-2xl border border-gray-200 bg-white shadow-xl">

                {{-- Header popup --}}
                <div class="flex items-center justify-between border-b border-gray-100 px-4 py-3">
                    <p class="text-sm font-bold text-gray-900">Profil</p>

                    <button type="button"
                            onclick="closeAdminPopup('adminProfileMenu')"
                            aria-label="Tutup profil"
                            class="flex h-7 w-7 items-center justify-center rounded-full text-gray-400 transition hover:bg-gray-100 hover:text-gray-700 focus:outline-none focus-visible:ring-2 focus-visible:ring-[#073b2b]/40">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                {{-- Info akun --}}
                <div class="flex items-center gap-3 px-4 py-4">
                    <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-[#073b2b] text-lg font-bold text-white">
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
                    <button type="submit" class="w-full rounded-xl bg-red-50 py-2.5 text-xs font-semibold text-red-600 transition hover:bg-red-100 focus:outline-none focus-visible:ring-2 focus-visible:ring-red-300">
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

        el.classList.toggle('hidden', !open);

        const trigger = document.querySelector('[aria-controls="' + id + '"]');
        if (trigger) trigger.setAttribute('aria-expanded', open ? 'true' : 'false');
    }

    function toggleAdminPopup(id) {
        const el = document.getElementById(id);
        const willOpen = el ? el.classList.contains('hidden') : false;

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
