@extends('layouts.peminjam')
@section('title', 'Katalog Sarana | SkanSarpras')

@section('content')
@php
    // Dari controller: $saranas (koleksi). Tiap item: id, nama, kategori (teks), deskripsi, foto, tersedia, stok (opsional).
    $lorem = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas posuere, elit vitae lacinia pretium, nisl neque tempus est.';
    $daftar = ($saranas ?? collect())->count() ? $saranas : collect([
        ['Laptop Axioo', 'Elektronik & Laptop', false, 0],
        ['Proyektor Epson', 'Elektronik & Laptop', true, 3],
        ['Laptop Macbook M1 Air', 'Elektronik & Laptop', true, 5],
        ['Multimeter Digital', 'Peralatan Lab', true, 12],
        ['Oscilloscope', 'Peralatan Lab', false, 0],
        ['Kamera DSLR', 'Elektronik & Laptop', true, 2],
    ])->map(fn ($r, $i) => (object) ['id' => $i + 1, 'nama' => $r[0], 'kategori' => $r[1], 'deskripsi' => $lorem,
        'foto' => asset('images/sarana-'.($i + 1).'.png'), 'tersedia' => $r[2], 'stok' => $r[3]]);

    // Normalisasi: menerima berbagai nama kolom dari tabel sarana Anda.
    $ambil = function ($o, array $keys, $default = null) {
        foreach ($keys as $k) {
            $v = data_get($o, $k);
            if (is_scalar($v) && $v !== '') return $v;
        }
        return $default;
    };
    $daftar = $daftar->map(function ($s) use ($ambil) {
        $foto = $ambil($s, ['foto', 'gambar', 'image', 'photo', 'foto_sarana', 'gambar_sarana']);
        if ($foto && ! preg_match('#^(https?:)?//|^/#', $foto)) $foto = asset('storage/'.$foto);
        $stok = $ambil($s, ['stok', 'jumlah', 'jumlah_tersedia', 'stok_tersedia', 'qty']);
        $status = strtolower((string) $ambil($s, ['status', 'kondisi', 'ketersediaan'], ''));
        if (isset($s->tersedia)) {
            $tersedia = (bool) $s->tersedia;
        } elseif ($stok !== null) {
            $tersedia = (int) $stok > 0 && ! in_array($status, ['nonaktif', 'rusak', 'dipinjam', 'tidak tersedia']);
        } else {
            $tersedia = in_array($status, ['tersedia', 'aktif', 'baik', 'ready']);
        }
        return (object) [
            'id' => $s->id ?? null,
            'nama' => $ambil($s, ['nama', 'nama_sarana', 'nama_barang', 'nama_alat', 'nama_prasarana', 'judul', 'name'], 'Tanpa nama'),
            'kategori' => $ambil($s, ['kategori.nama_kategori', 'kategori.nama', 'nama_kategori', 'kategori', 'jenis'], 'Lainnya'),
            'deskripsi' => $ambil($s, ['deskripsi', 'keterangan', 'description'], ''),
            'foto' => $foto,
            'tersedia' => $tersedia,
            'stok' => $stok !== null ? (int) $stok : null,
        ];
    });

    $kategoris = $daftar->groupBy('kategori')->map->count();
    $total = $daftar->count();
    $ada = $daftar->where('tersedia', true)->count();

    $ikon = function ($k) {
        $k = strtolower($k);
        return str_contains($k, 'lab') ? 'flask-conical' : (str_contains($k, 'laptop') || str_contains($k, 'elektronik') ? 'laptop' : 'package');
    };
@endphp

{{-- HEADER --}}
<section class="relative overflow-hidden bg-gradient-to-b from-slate-50 to-white px-6 pb-10 pt-12 lg:px-12">
    <div class="pointer-events-none absolute -right-24 -top-24 h-72 w-72 rounded-full bg-brand-mint/60 blur-3xl"></div>
    <div class="relative mx-auto flex max-w-6xl flex-col gap-8 lg:flex-row lg:items-end lg:justify-between">
        <div>
            <h1 class="font-head text-3xl font-bold tracking-tight lg:text-4xl">Katalog Sarana</h1>
            <p class="mt-3 max-w-xl text-[15px] leading-relaxed text-gray-500">
                Pilih sarana dan peralatan praktikum yang Anda butuhkan, periksa ketersediaannya, lalu ajukan peminjaman dalam beberapa langkah.
            </p>
        </div>
        <dl class="flex gap-3 text-sm">
            @foreach ([['Total sarana', $total, 'boxes'], ['Tersedia', $ada, 'circle-check'], ['Dipinjam', $total - $ada, 'clock']] as [$l, $v, $ic])
                <div class="min-w-[104px] rounded-2xl bg-white px-4 py-3 shadow-md shadow-brand/10 ring-1 ring-black/5">
                    <dt class="flex items-center gap-1.5 text-xs text-gray-500"><i data-lucide="{{ $ic }}" class="h-3.5 w-3.5"></i>{{ $l }}</dt>
                    <dd class="mt-1 font-head text-2xl font-bold">{{ $v }}</dd>
                </div>
            @endforeach
        </dl>
    </div>
</section>

{{-- TOOLBAR --}}
<div class="sticky top-14 z-10 border-y border-gray-100 bg-white/90 px-6 py-3.5 backdrop-blur lg:px-12">
    <div class="mx-auto flex max-w-6xl flex-wrap items-center gap-3">
        <div id="filter" class="-mx-1 flex max-w-full gap-2 overflow-x-auto px-1 py-1 text-sm [scrollbar-width:none]">
            <button data-kat="" class="chip is-active">
                <i data-lucide="layout-grid" class="h-4 w-4"></i> Semua Sarana <span>{{ $total }}</span>
            </button>
            @foreach ($kategoris as $k => $n)
                <button data-kat="{{ $k }}" class="chip">
                    <i data-lucide="{{ $ikon($k) }}" class="h-4 w-4"></i> {{ $k }} <span>{{ $n }}</span>
                </button>
            @endforeach
        </div>
        <div class="ml-auto flex flex-wrap items-center gap-3 text-sm">
            <label class="flex cursor-pointer items-center gap-2 text-gray-600">
                <input id="hanya" type="checkbox" class="h-4 w-4 rounded border-gray-300 accent-[#10291D]"> Hanya tersedia
            </label>
            <select id="urut" class="rounded-full border border-gray-200 bg-white py-2 pl-4 pr-8 text-sm outline-none focus:border-brand-soft">
                <option value="az">Nama A–Z</option>
                <option value="ada">Tersedia dulu</option>
            </select>
            <label class="relative">
                <i data-lucide="search" class="pointer-events-none absolute left-3.5 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400"></i>
                <input id="cari" type="search" placeholder="Cari sarana..." class="w-48 rounded-full border border-gray-200 py-2 pl-10 pr-4 text-sm outline-none transition focus:border-brand-soft focus:ring-2 focus:ring-brand-mint">
            </label>
        </div>
    </div>
</div>

{{-- DAFTAR --}}
<section class="rounded-b-[2rem] bg-white px-6 pb-20 pt-8 lg:px-12">
    <div class="mx-auto max-w-6xl">
        <p class="mb-5 text-sm text-gray-500">Menampilkan <b id="jumlah" class="text-brand">{{ $total }}</b> sarana</p>

        <div id="grid" class="grid gap-7 sm:grid-cols-2 xl:grid-cols-3">
            @foreach ($daftar as $s)
                <article data-kat="{{ $s->kategori }}" data-nama="{{ $s->nama }}" data-ok="{{ $s->tersedia ? 1 : 0 }}"
                         data-desk="{{ $s->deskripsi }}" data-foto="{{ $s->foto }}" data-stok="{{ $s->stok ?? '' }}"
                         data-pinjam="{{ route('peminjam.pengajuan.create', ['sarana' => $s->id]) }}"
                         class="group flex flex-col overflow-hidden rounded-2xl bg-white shadow-lg shadow-brand/10 ring-1 ring-black/5 transition duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-brand/20">
                    <div class="relative h-48 overflow-hidden bg-gradient-to-br from-brand-mint via-slate-50 to-white">
                        <i data-lucide="{{ $ikon($s->kategori) }}" class="absolute left-1/2 top-1/2 h-16 w-16 -translate-x-1/2 -translate-y-1/2 text-brand-soft/25" stroke-width="1.2"></i>
                        @if ($s->foto)
                            <img src="{{ $s->foto }}" alt="{{ $s->nama }}" onerror="this.remove()"
                                 class="absolute inset-0 h-full w-full object-cover transition duration-500 group-hover:scale-105 {{ $s->tersedia ? '' : 'opacity-60 grayscale' }}">
                        @endif
                        <span class="absolute left-3 top-3 inline-flex items-center gap-1.5 rounded-full bg-white/95 px-3 py-1 text-xs font-medium shadow-sm backdrop-blur">
                            <span class="h-1.5 w-1.5 rounded-full {{ $s->tersedia ? 'bg-green-500' : 'bg-red-500' }}"></span>
                            {{ $s->tersedia ? 'Tersedia' : 'Tidak tersedia' }}
                        </span>
                    </div>

                    <div class="flex flex-1 flex-col p-5">
                        <p class="text-xs text-gray-400">{{ $s->kategori }}</p>
                        <h3 class="mt-1 font-head text-xl font-bold tracking-tight">{{ $s->nama }}</h3>
                        <p class="mt-2 line-clamp-2 text-sm leading-relaxed text-gray-500">{{ $s->deskripsi }}</p>
                        @if ($s->tersedia && ($s->stok ?? 0) > 0)
                            <p class="mt-3 text-xs text-gray-500">Stok tersisa: <b class="text-brand">{{ $s->stok }}</b></p>
                        @endif

                        <div class="mt-auto flex items-center justify-end gap-2.5 border-t border-gray-100 pt-4 mt-5">
                            <button type="button" data-detail class="inline-flex items-center gap-1 rounded-lg border border-brand px-4 py-2 text-sm font-medium transition hover:bg-brand hover:text-white">
                                Lihat Detail <i data-lucide="chevron-right" class="h-3.5 w-3.5"></i>
                            </button>
                            @if ($s->tersedia)
                                <a href="{{ route('peminjam.pengajuan.create', ['sarana' => $s->id]) }}"
                                   class="rounded-lg bg-brand px-5 py-2 text-sm font-medium text-white shadow-md shadow-brand/20 transition hover:bg-brand-soft">Pinjam</a>
                            @else
                                <span class="cursor-not-allowed rounded-lg bg-gray-200 px-5 py-2 text-sm font-medium text-gray-400">Pinjam</span>
                            @endif
                        </div>
                    </div>
                </article>
            @endforeach
        </div>

        <div id="kosong" class="hidden flex-col items-center py-20 text-center">
            <span class="flex h-14 w-14 items-center justify-center rounded-full bg-brand-mint"><i data-lucide="search-x" class="h-6 w-6"></i></span>
            <p class="mt-4 font-head text-lg font-bold">Sarana tidak ditemukan</p>
            <p class="mt-1 text-sm text-gray-500">Coba ganti kategori atau kata kunci pencarian.</p>
        </div>
    </div>
</section>

{{-- MODAL DETAIL --}}
<dialog id="modal" class="w-[92%] max-w-2xl overflow-hidden rounded-2xl p-0 shadow-2xl backdrop:bg-brand/60 backdrop:backdrop-blur-sm">
    <div class="grid md:grid-cols-2">
        <div class="relative min-h-[220px] bg-gradient-to-br from-brand-mint to-slate-100">
            <img id="m-foto" src="" alt="" class="absolute inset-0 h-full w-full object-cover" onerror="this.style.display='none'">
        </div>
        <div class="flex flex-col p-6">
            <p id="m-kat" class="text-xs text-gray-400"></p>
            <h3 id="m-nama" class="mt-1 font-head text-2xl font-bold tracking-tight"></h3>
            <p id="m-status" class="mt-3 flex items-center gap-2 text-sm"></p>
            <p id="m-desk" class="mt-4 text-sm leading-relaxed text-gray-500"></p>
            <div class="mt-auto flex justify-end gap-2.5 pt-6">
                <form method="dialog"><button class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium hover:bg-gray-50">Tutup</button></form>
                <a id="m-pinjam" href="#" class="rounded-lg bg-brand px-5 py-2 text-sm font-medium text-white shadow-md shadow-brand/20 hover:bg-brand-soft">Pinjam</a>
            </div>
        </div>
    </div>
</dialog>

<style>
    .chip { display:inline-flex; flex-shrink:0; align-items:center; gap:.5rem; white-space:nowrap; border:1px solid #e5e7eb; background:#fff; color:#374151; border-radius:9999px; padding:.55rem 1.1rem .55rem .95rem; font-size:.875rem; font-weight:500; transition:all .2s ease; }
    .chip span { min-width:1.35rem; border-radius:9999px; background:#f1f5f2; padding:.05rem .45rem; text-align:center; font-size:.7rem; font-weight:600; color:#2E4A3B; transition:all .2s ease; }
    .chip:hover { border-color:#2E4A3B; color:#10291D; }
    .chip.is-active { background:#10291D; border-color:#10291D; color:#fff; box-shadow:0 8px 16px -8px rgba(16,41,29,.55); }
    .chip.is-active span { background:rgba(255,255,255,.18); color:#fff; }
    .chip:focus-visible { outline:2px solid #2E4A3B; outline-offset:2px; }
    </style>

<script>
(() => {
    const $ = s => document.querySelector(s), grid = $('#grid');
    const cards = [...grid.children], chips = document.querySelectorAll('#filter .chip');
    let kat = '';

    function terapkan() {
        const q = $('#cari').value.trim().toLowerCase(), hanya = $('#hanya').checked;
        const urut = $('#urut').value;
        [...cards].sort((a, b) => urut === 'ada'
            ? (b.dataset.ok - a.dataset.ok) || a.dataset.nama.localeCompare(b.dataset.nama)
            : a.dataset.nama.localeCompare(b.dataset.nama)).forEach(c => grid.appendChild(c));
        let n = 0;
        cards.forEach(c => {
            const ok = (!kat || c.dataset.kat === kat) && c.dataset.nama.toLowerCase().includes(q) && (!hanya || c.dataset.ok === '1');
            c.classList.toggle('hidden', !ok); if (ok) n++;
        });
        $('#jumlah').textContent = n;
        $('#kosong').classList.toggle('hidden', n > 0); $('#kosong').classList.toggle('flex', n === 0);
    }
    chips.forEach(b => b.onclick = () => { chips.forEach(x => x.classList.remove('is-active')); b.classList.add('is-active'); kat = b.dataset.kat; terapkan(); });
    ['#cari'].forEach(s => $(s).addEventListener('input', terapkan));
    ['#hanya', '#urut'].forEach(s => $(s).addEventListener('change', terapkan));
    terapkan();

    // Modal detail
    const m = $('#modal');
    cards.forEach(c => c.querySelector('[data-detail]').onclick = () => {
        const ok = c.dataset.ok === '1', d = c.dataset;
        $('#m-foto').style.display = d.foto ? '' : 'none'; if (d.foto) $('#m-foto').src = d.foto;
        $('#m-kat').textContent = d.kat; $('#m-nama').textContent = d.nama; $('#m-desk').textContent = d.desk;
        $('#m-status').innerHTML = `<span class="h-2 w-2 rounded-full ${ok ? 'bg-green-500' : 'bg-red-500'}"></span>` + (ok ? 'Tersedia' + (d.stok ? ` · stok ${d.stok}` : '') : 'Tidak tersedia');
        const p = $('#m-pinjam'); p.href = d.pinjam;
        p.classList.toggle('pointer-events-none', !ok); p.classList.toggle('opacity-50', !ok);
        m.showModal();
    });
    m.addEventListener('click', e => { if (e.target === m) m.close(); });
})();
</script>
@endsection