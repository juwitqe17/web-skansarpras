<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
    <style>
        /* Dialog konfirmasi: menggantikan kotak alert bawaan browser */
        #dialog-konfirmasi::backdrop { background: rgba(16, 41, 29, .45); backdrop-filter: blur(3px); }
        #dialog-konfirmasi[open] { animation: konfirmasi-muncul .18s ease-out; }
        #dialog-konfirmasi[open]::backdrop { animation: konfirmasi-pudar .18s ease-out; }
        @keyframes konfirmasi-muncul { from { opacity: 0; transform: translateY(10px) scale(.97); } to { opacity: 1; transform: none; } }
        @keyframes konfirmasi-pudar { from { opacity: 0; } to { opacity: 1; } }
    </style>
</head>
<body class="bg-brand font-sans text-brand antialiased">

{{-- SIDEBAR --}}
<aside class="hidden lg:flex fixed inset-y-0 left-0 z-30 w-64 flex-col bg-brand px-4 py-6 text-white">
    <div class="flex items-center gap-3 border-b border-white/15 px-1 pb-5">
        <div class="relative flex h-12 w-12 shrink-0 items-center justify-center">
            <img src="{{ asset('images/logosmk.png') }}" alt="Logo SkanSarpras"
                 onerror="this.classList.add('hidden'); this.nextElementSibling.classList.remove('hidden')"
                 class="h-full w-full object-contain drop-shadow-[0_0_10px_rgba(213,235,221,0.25)]">
            <i data-lucide="school" class="hidden h-6 w-6 text-white"></i>
        </div>
        <div class="min-w-0">
            <p class="font-head text-lg font-bold leading-tight">SkanSarpras</p>
            <p class="whitespace-nowrap text-[10px] leading-snug tracking-tight text-white/60">Peminjaman Sarana Prasarana<br>SMKN 1 Purwosari</p>
        </div>
    </div>

    @php
        // [label, route tujuan, ikon, daftar route yang membuat menu ini aktif]
        $menu = [
            ['Beranda', 'peminjam.dashboard', 'layout-dashboard', ['peminjam.dashboard']],
            ['Sarana Prasarana', 'peminjam.sarana.index', 'archive', ['peminjam.sarana.*']],
            ['Peminjaman', 'peminjam.pengajuan.create', 'clipboard-list', ['peminjam.pengajuan.create']],
            ['Riwayat Pengajuan', 'peminjam.riwayat.index', 'history', ['peminjam.riwayat.*', 'peminjam.pengajuan.index', 'peminjam.pengajuan.show']],
        ];
    @endphp
    <nav class="mt-6 space-y-1.5 text-sm">
        @foreach ($menu as [$label, $route, $icon, $aktifDi])
            <a href="{{ Route::has($route) ? route($route) : '#' }}"
               class="flex items-center gap-3 rounded-lg px-3.5 py-2.5 transition-colors
                      {{ request()->routeIs(...$aktifDi) ? 'bg-brand-soft font-medium' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
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

<div class="min-w-0 lg:ml-64">
    {{-- NAVBAR --}}
    @php
        $user = auth()->user();
        $notifikasi = $user ? $user->notifications()->latest()->take(8)->get() : collect();
        $belumDibaca = $user ? $user->unreadNotifications()->count() : 0;
        $urlBaca = Route::has('peminjam.notifikasi.baca') ? route('peminjam.notifikasi.baca') : null;
        $urlPoll = Route::has('peminjam.notifikasi.index') ? route('peminjam.notifikasi.index') : null;
        $namaJurusan = $user->jurusan->nama_jurusan ?? '-';
    @endphp
    <header class="sticky top-0 z-20 flex h-14 items-center justify-between border-b border-gray-200 bg-white/95 px-6 backdrop-blur lg:px-10">
        <span class="font-head text-lg font-extrabold">SkanSarpras</span>
        <div class="flex items-center gap-5 text-sm">
            <span class="hidden items-center gap-2 text-gray-700 sm:flex">
                <i data-lucide="graduation-cap" class="h-4 w-4"></i>
                Jurusan: {{ $namaJurusan }}
            </span>

            {{-- NOTIFIKASI --}}
            <div class="relative" data-dropdown>
                <button type="button" data-dropdown-btn data-notif-btn aria-label="Notifikasi"
                        class="relative flex items-center text-gray-600 hover:text-brand">
                    <i data-lucide="bell" class="h-[18px] w-[18px]"></i>
                    @if ($belumDibaca > 0)
                        <span data-notif-badge
                              class="absolute -right-2 -top-2 flex h-4 min-w-[16px] items-center justify-center rounded-full bg-red-500 px-1 text-[10px] font-bold leading-none text-white ring-2 ring-white">
                            {{ $belumDibaca > 9 ? '9+' : $belumDibaca }}
                        </span>
                    @endif
                </button>

                <div data-dropdown-panel
                     class="invisible absolute right-0 z-50 mt-4 w-80 max-w-[calc(100vw-2rem)] origin-top-right scale-95 rounded-2xl bg-white opacity-0 shadow-xl shadow-brand/15 ring-1 ring-black/5 transition duration-150">
                    <div class="flex items-center justify-between border-b border-gray-100 px-4 py-3">
                        <p class="font-head text-sm font-bold">Notifikasi</p>
                        <span id="notif-baru" class="{{ $belumDibaca > 0 ? '' : 'hidden' }} rounded-full bg-brand-mint px-2 py-0.5 text-[11px] font-semibold">{{ $belumDibaca }} baru</span>
                    </div>

                    <ul id="notif-list" class="max-h-80 divide-y divide-gray-50 overflow-y-auto">
                        @include('peminjam._notifikasi', ['notifikasi' => $notifikasi])
                    </ul>
                </div>
            </div>

            {{-- PROFIL --}}
            <div class="relative" data-dropdown>
                <button type="button" data-dropdown-btn aria-label="Profil"
                        class="flex items-center text-gray-600 hover:text-brand">
                    <i data-lucide="circle-user-round" class="h-6 w-6"></i>
                </button>

                <div data-dropdown-panel
                     class="invisible absolute right-0 z-50 mt-4 w-64 max-w-[calc(100vw-2rem)] origin-top-right scale-95 rounded-2xl bg-white p-2 opacity-0 shadow-xl shadow-brand/15 ring-1 ring-black/5 transition duration-150">
                    <div class="flex items-center gap-3 border-b border-gray-100 px-3 pb-3 pt-2">
                        <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-brand text-sm font-bold text-white">
                            {{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}
                        </span>
                        <div class="min-w-0">
                            <p class="truncate text-sm font-semibold">{{ $user->name ?? 'Pengguna' }}</p>
                            <p class="truncate text-xs text-gray-500">{{ $user->email ?? '' }}</p>
                            <p class="truncate text-[11px] text-gray-400 sm:hidden">Jurusan: {{ $namaJurusan }}</p>
                        </div>
                    </div>

                    <div class="py-1.5">
                        <a href="{{ Route::has('peminjam.profil') ? route('peminjam.profil') : '#' }}"
                           class="flex items-center gap-2.5 rounded-lg px-3 py-2 transition hover:bg-brand-mint">
                            <i data-lucide="user" class="h-4 w-4 text-gray-500"></i> Profil Saya
                        </a>
                        <a href="{{ Route::has('peminjam.riwayat.index') ? route('peminjam.riwayat.index') : '#' }}"
                           class="flex items-center gap-2.5 rounded-lg px-3 py-2 transition hover:bg-brand-mint">
                            <i data-lucide="history" class="h-4 w-4 text-gray-500"></i> Riwayat Pengajuan
                        </a>
                    </div>

                    <form method="POST" action="{{ Route::has('logout') ? route('logout') : '#' }}" class="border-t border-gray-100 pt-1.5">
                        @csrf
                        <button type="submit"
                                class="flex w-full items-center gap-2.5 rounded-lg px-3 py-2 text-red-600 transition hover:bg-red-50">
                            <i data-lucide="log-out" class="h-4 w-4"></i> Keluar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    <main>@yield('content')</main>
</div>

<script>
    lucide.createIcons();

    (function () {
        const dropdowns = document.querySelectorAll('[data-dropdown]');

        const panel = (d) => d.querySelector('[data-dropdown-panel]');
        const tutup = (d) => {
            panel(d).classList.add('invisible', 'opacity-0', 'scale-95');
            panel(d).classList.remove('visible', 'opacity-100', 'scale-100');
        };
        const buka = (d) => {
            panel(d).classList.remove('invisible', 'opacity-0', 'scale-95');
            panel(d).classList.add('visible', 'opacity-100', 'scale-100');
        };

        // Badge hilang saat notifikasi dibuka, lalu tandai dibaca di server
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

        // ---- Pembaruan lonceng otomatis (tanpa muat ulang halaman) ----
        const urlPoll = @json($urlPoll);
        const INTERVAL_DETIK = 15;
        const kelasBadge = 'absolute -right-2 -top-2 flex h-4 min-w-[16px] items-center justify-center rounded-full bg-red-500 px-1 text-[10px] font-bold leading-none text-white ring-2 ring-white';
        let htmlTerakhir = null;

        function perbaruiLonceng(data) {
            const tombol = document.querySelector('[data-notif-btn]');
            if (!tombol) return;

            let badge = document.querySelector('[data-notif-badge]');
            if (data.unread > 0) {
                if (!badge) {
                    badge = document.createElement('span');
                    badge.setAttribute('data-notif-badge', '');
                    badge.className = kelasBadge;
                    tombol.appendChild(badge);
                }
                badge.textContent = data.unread > 9 ? '9+' : data.unread;
            } else if (badge) {
                badge.remove();
            }

            const baru = document.getElementById('notif-baru');
            if (baru) {
                baru.textContent = data.unread + ' baru';
                baru.classList.toggle('hidden', data.unread === 0);
            }

            // Daftar tidak diganti saat dropdown sedang dibuka, agar tidak berubah di depan mata pengguna
            const terbuka = tombol.closest('[data-dropdown]').querySelector('[data-dropdown-panel]').classList.contains('visible');
            const daftar = document.getElementById('notif-list');
            if (daftar && !terbuka && data.html !== htmlTerakhir) {
                daftar.innerHTML = data.html;
                htmlTerakhir = data.html;
                lucide.createIcons();
            }
        }

        async function periksaNotifikasi() {
            if (!urlPoll || document.hidden) return;
            try {
                const r = await fetch(urlPoll, { headers: { 'Accept': 'application/json' }, credentials: 'same-origin' });
                if (r.ok) perbaruiLonceng(await r.json());
            } catch (e) { /* abaikan, coba lagi pada putaran berikutnya */ }
        }

        if (urlPoll) {
            setInterval(periksaNotifikasi, INTERVAL_DETIK * 1000);
            document.addEventListener('visibilitychange', () => { if (!document.hidden) periksaNotifikasi(); });
        }

        dropdowns.forEach((d) => {
            d.querySelector('[data-dropdown-btn]').addEventListener('click', (e) => {
                e.stopPropagation();
                const sedangBuka = panel(d).classList.contains('visible');
                dropdowns.forEach(tutup);
                if (!sedangBuka) {
                    buka(d);
                    if (d.querySelector('[data-notif-btn]')) tandaiDibaca();
                }
            });
        });

        document.addEventListener('click', (e) => {
            dropdowns.forEach((d) => { if (!d.contains(e.target)) tutup(d); });
        });
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') dropdowns.forEach(tutup);
        });
    })();
</script>
{{-- DIALOG KONFIRMASI --}}
{{-- Pakai pada form: data-konfirmasi data-konfirmasi-judul="..." data-konfirmasi-pesan="..."
     data-konfirmasi-tombol="..." data-konfirmasi-gaya="bahaya|peringatan" --}}
<dialog id="dialog-konfirmasi" class="m-auto w-[calc(100%-2rem)] max-w-sm overflow-hidden rounded-2xl p-0 shadow-2xl">
    <div class="px-6 pb-5 pt-7 text-center">
        <span id="konfirmasi-ikon" class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-red-50 text-red-600"></span>
        <h3 id="konfirmasi-judul" class="mt-4 font-head text-lg font-bold text-brand"></h3>
        <p id="konfirmasi-pesan" class="mt-1.5 text-sm leading-relaxed text-gray-500"></p>
    </div>
    <div class="flex gap-3 border-t border-gray-100 bg-slate-50 px-6 py-4">
        <button type="button" id="konfirmasi-batal"
                class="flex-1 rounded-xl border border-gray-200 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 transition hover:bg-gray-50">Batal</button>
        <button type="button" id="konfirmasi-ya"
                class="flex-1 rounded-xl bg-red-600 px-4 py-2.5 text-sm font-medium text-white transition hover:bg-red-700">Ya, Lanjutkan</button>
    </div>
</dialog>

<script>
(function () {
    const dlg = document.getElementById('dialog-konfirmasi');
    const $ = (id) => document.getElementById(id);
    const GAYA = {
        bahaya:     { ikon: 'trash-2',        wadah: 'bg-red-50 text-red-600',     tombol: 'bg-red-600 hover:bg-red-700' },
        peringatan: { ikon: 'triangle-alert', wadah: 'bg-amber-50 text-amber-600', tombol: 'bg-amber-500 hover:bg-amber-600' },
        tanya:      { ikon: 'send',           wadah: 'bg-brand-mint text-brand',   tombol: 'bg-brand hover:bg-brand-soft' },
    };
    let formTertunda = null;

    // Mencegat form yang bertanda data-konfirmasi, tampilkan dialog dulu
    document.addEventListener('submit', (e) => {
        const form = e.target;
        if (!(form instanceof HTMLFormElement) || !form.hasAttribute('data-konfirmasi')) return;
        if (e.defaultPrevented) return; // form tidak valid: tidak perlu tanya konfirmasi
        if (form.dataset.sudahKonfirmasi === '1') return;

        const judul = form.dataset.konfirmasiJudul || 'Apakah Anda yakin?';
        const pesan = form.dataset.konfirmasiPesan || '';

        // Browser yang terlalu lama: pakai konfirmasi bawaan sebagai cadangan
        if (!dlg || typeof dlg.showModal !== 'function') {
            if (!window.confirm(judul + (pesan ? '\n' + pesan : ''))) e.preventDefault();
            return;
        }

        e.preventDefault();
        formTertunda = form;
        const g = GAYA[form.dataset.konfirmasiGaya] || GAYA.bahaya;

        $('konfirmasi-judul').textContent = judul;
        $('konfirmasi-pesan').textContent = pesan;
        $('konfirmasi-ikon').className = 'mx-auto flex h-12 w-12 items-center justify-center rounded-full ' + g.wadah;
        $('konfirmasi-ikon').innerHTML = '<i data-lucide="' + g.ikon + '" class="h-6 w-6"></i>';

        const ya = $('konfirmasi-ya');
        ya.className = 'flex-1 rounded-xl px-4 py-2.5 text-sm font-medium text-white transition ' + g.tombol;
        ya.textContent = form.dataset.konfirmasiTombol || 'Ya, Lanjutkan';
        ya.disabled = false;
        $('konfirmasi-batal').textContent = form.dataset.konfirmasiBatal || 'Batal';

        lucide.createIcons();
        dlg.showModal();
    });

    if (dlg) {
        $('konfirmasi-ya').addEventListener('click', () => {
            if (!formTertunda) return;
            const ya = $('konfirmasi-ya');
            ya.disabled = true;
            ya.textContent = 'Memproses...';
            formTertunda.dataset.sudahKonfirmasi = '1';
            formTertunda.submit();
        });
        $('konfirmasi-batal').addEventListener('click', () => dlg.close());
        dlg.addEventListener('click', (e) => { if (e.target === dlg) dlg.close(); }); // klik di luar kotak = batal
        dlg.addEventListener('close', () => { formTertunda = null; });
    }
})();
</script>
</body>
</html>