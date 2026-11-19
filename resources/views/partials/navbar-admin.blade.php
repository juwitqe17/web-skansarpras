@php
    $user = auth()->user();
@endphp

<header class="sticky top-0 z-30 flex h-[74px] items-center justify-between border-b border-gray-200 bg-white px-6 lg:px-10">
    {{-- JUDUL --}}
    <h1 class="text-2xl font-extrabold tracking-tight text-[#073b2b]">
        SkanSarpras Admin
    </h1>

    {{-- KANAN --}}
    <div class="flex items-center gap-4">
        {{-- TOMBOL NOTIFIKASI --}}
        <div class="relative">
            <button type="button" onclick="toggleAdminPopup('adminNotifMenu')"
                    class="relative flex h-10 w-10 items-center justify-center rounded-full text-gray-600 hover:bg-gray-100">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 17H9m8-1V10a5 5 0 00-10 0v6l-2 2h14l-2-2z" />
                </svg>
            </button>

            <div id="adminNotifMenu" class="hidden absolute right-0 mt-3 w-80 rounded-2xl border border-gray-200 bg-white p-4 shadow-xl z-50">
                <p class="text-sm font-bold text-gray-900 border-b pb-2 mb-2">Notifikasi</p>
                <p class="text-xs text-gray-400 text-center py-6">Belum ada notifikasi saat ini.</p>
            </div>
        </div>

        {{-- TOMBOL PROFIL --}}
        <div class="relative">
            <button type="button" onclick="toggleAdminPopup('adminProfileMenu')"
                    class="flex items-center gap-2 rounded-full p-1.5 text-gray-600 hover:bg-gray-100">
                <span class="flex h-9 w-9 items-center justify-center rounded-full bg-[#073b2b] text-sm font-bold text-white">
                    {{ strtoupper(substr($user->name ?? 'A', 0, 1)) }}
                </span>
            </button>

            <div id="adminProfileMenu" class="hidden absolute right-0 mt-3 w-64 rounded-2xl border border-gray-200 bg-white p-4 shadow-xl z-50">
                <div class="border-b border-gray-100 pb-3">
                    <p class="text-sm font-bold text-gray-900">{{ $user->name ?? 'Admin Sarpras' }}</p>
                    <p class="text-xs text-gray-500">{{ $user->email ?? '-' }}</p>
                </div>
                <form method="POST" action="{{ route('logout') }}" class="mt-3">
                    @csrf
                    <button type="submit" class="w-full rounded-xl bg-red-50 py-2 text-xs font-semibold text-red-600 hover:bg-red-100">
                        Keluar Akun
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>

<script>
    function toggleAdminPopup(id) {
        const menus = ['adminNotifMenu', 'adminProfileMenu'];
        menus.forEach(menuId => {
            const el = document.getElementById(menuId);
            if (el) {
                if (menuId === id) {
                    el.classList.toggle('hidden');
                } else {
                    el.classList.add('hidden');
                }
            }
        });
    }
</script>