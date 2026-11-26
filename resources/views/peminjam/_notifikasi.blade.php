{{--
    Simpan sebagai: resources/views/peminjam/_notifikasi.blade.php
    Dipakai oleh layout (saat halaman dimuat) dan oleh route peminjam.notifikasi.index
    (pembaruan otomatis tiap beberapa detik). Butuh variabel $notifikasi.
--}}
@php
    // [ikon, warna] menurut jenis notifikasi
    $gayaNotif = [
        'disetujui' => ['circle-check', 'bg-emerald-50 text-emerald-600'],
        'ditolak'   => ['circle-x', 'bg-red-50 text-red-600'],
        'pengingat' => ['alarm-clock', 'bg-amber-50 text-amber-600'],
        'tenggat'   => ['alarm-clock', 'bg-amber-50 text-amber-600'],
        'terlambat' => ['triangle-alert', 'bg-red-50 text-red-600'],
        'selesai'   => ['check-check', 'bg-sky-50 text-sky-600'],
    ];
@endphp
@forelse ($notifikasi as $n)
    @php [$ikonNotif, $warnaNotif] = $gayaNotif[$n->data['jenis'] ?? ''] ?? ['bell-ring', 'bg-brand-mint text-brand']; @endphp
    <li>
        <a href="{{ $n->data['url'] ?? '#' }}"
           class="flex gap-3 px-4 py-3 transition hover:bg-slate-50 {{ $n->read_at ? '' : 'bg-brand-mint/40' }}">
            <span class="mt-0.5 flex h-8 w-8 shrink-0 items-center justify-center rounded-full {{ $warnaNotif }}">
                <i data-lucide="{{ $ikonNotif }}" class="h-4 w-4"></i>
            </span>
            <div class="min-w-0 flex-1">
                <p class="text-sm font-semibold leading-snug">{{ $n->data['judul'] ?? 'Notifikasi' }}</p>
                <p class="mt-0.5 text-xs leading-relaxed text-gray-500">{{ $n->data['pesan'] ?? '' }}</p>
                <p class="mt-1 text-[11px] text-gray-400">{{ $n->created_at->locale('id')->diffForHumans() }}</p>
            </div>
            @unless ($n->read_at)
                <span class="mt-1.5 h-2 w-2 shrink-0 rounded-full bg-red-500"></span>
            @endunless
        </a>
    </li>
@empty
    <li class="px-4 py-10 text-center text-sm text-gray-400">
        <i data-lucide="bell-off" class="mx-auto mb-2 h-6 w-6"></i>
        Belum ada notifikasi
    </li>
@endforelse