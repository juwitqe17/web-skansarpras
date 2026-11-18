<header class="relative z-40 flex h-[94px] items-center justify-between border-b border-[#b8c0bd] bg-white px-6 lg:px-14">
    @php
        $user = auth()->user();
        $notifikasi = $user ? $user->notifications()->latest()->take(8)->get() : collect();
        $belumDibaca = $user ? $user->unreadNotifications()->count() : 0;
        $urlBaca = Route::has('admin.notifikasi.baca') ? route('admin.notifikasi.baca') : null; // Sesuaikan route jika ada
    @endphp

    {{-- TITLE --}}
    <h1 class="text-[27px] font-bold tracking-tight text-[#073b2b]">
        SkanSarpras Admin
    </h1>

    {{-- RIGHT --}}
    <div class="flex items-center gap-5">
        {{-- NOTIFICATION --}}
        <div class="relative" data-dropdown>
            <button type="button" data-dropdown-btn data-notif-btn aria-label="Notifikasi"
                    class="relative flex h-10 w-10 items-center justify-center rounded-full text-[#9ca5a1] transition hover:bg-[#f1f5f3] hover:text-[#073b2b]">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 17H9m8-1V10a5 5 0 00-10 0v6l-2 2h14l-2-2z" />
                </svg>
                @if ($belumDibaca > 0)
                    <span data-notif-badge
                          class="absolute right-1 top-1 flex h-4 min-w-[16px] items-center justify-center rounded-full bg-red-500 px-1 text-[10px] font-bold leading-none text-white ring-2 ring-white">
                        {{ $belumDibaca > 9 ? '9+' : $belumDibaca }}
                    </span>
                @endif
            </button>

            {{-- POPUP NOTIFICATION --}}
            <div data-dropdown-panel class="invisible absolute right-[-45px] top-[55px] hidden w-[585px] max-w-[calc(100vw-40px)] z-50 origin-top-right scale-95 opacity-0 transition duration-150">
                <div class="absolute right-[64px] -top-3 h-0 w-0 border-x-[14px] border-b-[14px] border-x-transparent border-b-[#aeb7b3]"></div>
                <div class="absolute right-[65px] -top-[10px] h-0 w-0 border-x-[13px] border-b-[13px] border-x-transparent border-b-white"></div>
                <div class="rounded-2xl border border-[#aeb7b3] bg-white p-5 shadow-lg">
                    <div class="mb-4 flex items-center justify-between">
                        <span class="rounded-xl bg-[#245a48] px-5 py-2 text-xs font-medium text-white">
                            Notifikasi Baru ({{ $belumDibaca }})
                        </span>
                        <button type="button" data-close-notif class="flex h-8 w-8 items-center justify-center rounded-full border border-[#9da7a3] text-[#9da7a3] hover:bg-gray-100">
                            ×
                        </button>
                    </div>

                    <div class="max-h-80 space-y-3 overflow-y-auto pr-1">
                        @forelse ($notifikasi as $n)
                            <div class="rounded-xl border border-[#b8bfbc] p-4 shadow-sm {{ $n->read_at ? 'bg-white' : 'bg-[#D5EBDD]/30' }}">
                                <div class="flex gap-4">
                                    <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-[#c8ffc5] font-bold text-[#21b52a]">
                                        ✓
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <h4 class="text-sm font-semibold text-[#111827]">
                                            {{ $n->data['judul'] ?? 'Notifikasi' }}
                                        </h4>
                                        <p class="mt-1 text-xs text-gray-500">
                                            {{ $n->data['pesan'] ?? '' }}
                                        </p>
                                        <p class="mt-1 text-[11px] text-gray-400">
                                            {{ $n->created_at->diffForHumans() }}
                                        </p>
                                    </div>
                                    @unless ($n->read_at)
                                        <span class="mt-1.5 h-2 w-2 shrink-0 rounded-full bg-red-500"></span>
                                    @endunless
                                </div>
                            </div>
                        @empty
                            <div class="rounded-xl border border-[#b8bfbc] p-6 text-center text-sm text-gray-400">
                                Belum ada notifikasi saat ini.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        {{-- PROFILE --}}
        <div class="relative" data-dropdown>
            <button type="button" data-dropdown-btn aria-label="Profil"
                    class="flex h-10 w-10 items-center justify-center rounded-full text-[#9ca5a1] transition hover:bg-[#f1f5f3] hover:text-[#073b2b]">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.3">
                    <circle cx="12" cy="12" r="9"/>
                    <circle cx="12" cy="9" r="3"/>
                    <path stroke-linecap="round" d="M6.8 18c.9-2.1 2.7-3.2 5.2-3.2s4.3 1.1 5.2 3.2"/>
                </svg>
            </button>

            {{-- PROFILE POPUP --}}
            <div data-dropdown-panel class="invisible absolute right-0 top-[55px] hidden w-[273px] z-50 origin-top-right scale-95 opacity-0 transition duration-150">
                <div class="absolute right-[24px] -top-[14px] h-0 w-0 border-x-[14px] border-b-[14px] border-x-transparent border-b-[#aeb7b3]"></div>
                <div class="absolute right-[25px] -top-[12px] h-0 w-0 border-x-[13px] border-b-[13px] border-x-transparent border-b-white"></div>
                <div class="rounded-2xl border border-[#aeb7b3] bg-white px-6 pb-5 pt-7 shadow-lg">
                    {{-- Avatar --}}
                    <div class="mx-auto flex h-28 w-28 items-center justify-center rounded-full bg-[#d9d9d9] overflow-hidden">
                        <span class="text-3xl font-bold text-white">
                            {{ strtoupper(substr($user->name ?? 'A', 0, 1)) }}
                        </span>
                    </div>

                    {{-- Data Admin --}}
                    <div class="mt-7 text-center">
                        <h3 class="text-sm font-semibold uppercase tracking-wide text-[#073b2b]">
                            {{ $user->name ?? 'ADMIN SARPRAS' }}
                        </h3>
                        <span class="mt-3 inline-flex rounded-md bg-[#a5efcf] px-4 py-1 text-xs font-semibold text-[#073b2b]">
                            Admin
                        </span>
                        <p class="mt-3 text-xs text-gray-400">
                            {{ $user->email ?? 'admin@sarpras.test' }}
                        </p>
                    </div>

                    {{-- Logout --}}
                    <form action="{{ Route::has('logout') ? route('logout') : '#' }}" method="POST" class="mt-7">
                        @csrf
                        <button type="submit" class="w-full rounded-lg border border-red-400 py-2 text-xs font-medium text-red-600 transition hover:bg-red-50">
                            Keluar Akun
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>

<script>
    (function () {
        const dropdowns = document.querySelectorAll('[data-dropdown]');

        const panel = (d) => d.querySelector('[data-dropdown-panel]');
        const tutup = (d) => {
            const p = panel(d);
            if (!p) return;
            p.classList.add('invisible', 'opacity-0', 'scale-95', 'hidden');
            p.classList.remove('visible', 'opacity-100', 'scale-100');
        };
        const buka = (d) => {
            const p = panel(d);
            if (!p) return;
            p.classList.remove('invisible', 'opacity-0', 'scale-95', 'hidden');
            p.classList.add('visible', 'opacity-100', 'scale-100');
        };

        // Menandai notifikasi dibaca ke server
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
            const btn = d.querySelector('[data-dropdown-btn]');
            if (!btn) return;

            btn.addEventListener('click', (e) => {
                e.stopPropagation();
                const p = panel(d);
                const sedangBuka = p && p.classList.contains('visible');

                dropdowns.forEach(tutup);
                if (!sedangBuka && p) {
                    buka(d);
                    if (d.querySelector('[data-notif-btn]')) tandaiDibaca();
                }
            });
        });

        // Tombol close manual pada notifikasi
        document.querySelectorAll('[data-close-notif]').forEach((closeBtn) => {
            closeBtn.addEventListener('click', () => {
                dropdowns.forEach(tutup);
            });
        });

        document.addEventListener('click', (e) => {
            dropdowns.forEach((d) => {
                if (!d.contains(e.target)) tutup(d);
            });
        });

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') dropdowns.forEach(tutup);
        });
    })();
</script>
