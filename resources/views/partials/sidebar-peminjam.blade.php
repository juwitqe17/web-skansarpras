<aside class="hidden lg:flex fixed inset-y-0 left-0 w-[264px] flex-col bg-brand text-white px-4 py-6">
        <div class="flex items-center gap-3 px-2 pb-4 border-b border-white/20">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-12 h-12 rounded bg-white/90 p-1">
            <div>
                <p class="font-head font-bold text-2xl leading-tight">SkanSarpras</p>
                <p class="text-xs text-white/60 leading-tight">Manajemen Sarana Prasarana<br>SMK Negeri 1 Purwosari</p>
            </div>
        </div>

        @php
            $menu = [
                ['Beranda', 'peminjam.dashboard', 'layout-dashboard'],
                ['Sarana Prasarana', 'peminjam.sarana.index', 'archive'],
                ['Peminjaman', 'peminjam.peminjaman.index', 'clipboard-list'],
                ['Riwayat Pengajuan', 'peminjam.riwayat.index', 'history'],
            ];
        @endphp
        <nav class="mt-6 space-y-2 text-base">
            @foreach ($menu as [$label, $route, $icon])
                <a href="{{ Route::has($route) ? route($route) : '#' }}"
                   class="flex items-center gap-3 rounded-md px-4 py-3 transition
                          {{ request()->routeIs($route) ? 'bg-brand-soft' : 'hover:bg-white/10' }}">
                    <i data-lucide="{{ $icon }}" class="w-5 h-5"></i> {{ $label }}
                </a>
            @endforeach
        </nav>

        <form method="POST" action="{{ Route::has('logout') ? route('logout') : '#' }}" class="mt-auto">
            @csrf
            <button class="w-full flex items-center gap-3 rounded-md bg-brand-soft px-4 py-3 text-base text-red-400 hover:bg-red-500/20">
                <i data-lucide="log-out" class="w-5 h-5"></i> Keluar Akun
            </button>
        </form>
    </aside>