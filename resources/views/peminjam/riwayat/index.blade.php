@extends('layouts.peminjam')
@section('title', 'Riwayat Pengajuan | SkanSarpras')

@section('content')
@php
    // Dari controller: $riwayats (pengajuan milik user, with('sarana')). Kolom dibaca fleksibel.
    $st = [ // [label, kelas badge, warna teks status]
        'diproses'     => ['Diproses',     'bg-amber-50 text-amber-700 ring-amber-200',       'text-amber-700'],
        'disetujui'    => ['Disetujui',    'bg-emerald-50 text-emerald-700 ring-emerald-200', 'text-emerald-700'],
        'dipinjam'     => ['Dipinjam',     'bg-sky-50 text-sky-700 ring-sky-200',             'text-sky-700'],
        'dikembalikan' => ['Dikembalikan', 'bg-slate-100 text-slate-600 ring-slate-200',      'text-slate-600'],
        'dibatalkan'   => ['Dibatalkan',   'bg-slate-100 text-slate-500 ring-slate-200',      'text-slate-500'],
        'ditolak'      => ['Ditolak',      'bg-red-50 text-red-700 ring-red-200',             'text-red-700'],
    ];
    $tgl = fn ($v) => $v ? \Carbon\Carbon::parse($v)->locale('id')->translatedFormat('d F Y') : null;
    $jurusan = data_get(auth()->user(), 'jurusan.nama_jurusan') ?? '-';

    $items = ($riwayats ?? $riwayat ?? $peminjamans ?? $pengajuans ?? $pengajuan ?? $daftarRiwayat ?? $data ?? collect())->map(function ($r) use ($st, $tgl, $jurusan) {
        $s = strtolower((string) data_get($r, 'status', 'diproses'));
        $s = in_array($s, ['menunggu', 'pending', 'diajukan']) ? 'diproses' : $s;
        $f = data_get($r, 'sarana.foto') ?? data_get($r, 'sarana.gambar');
        if ($f && ! preg_match('#^(https?:)?//|^/#', $f)) $f = asset('storage/'.$f);
        $mulai = data_get($r, 'jam_mulai'); $selesai = data_get($r, 'jam_selesai');
        return [
            'id' => data_get($r, 'id'),
            'nama' => data_get($r, 'sarana.nama') ?? data_get($r, 'sarana.nama_sarana') ?? 'Sarana',
            'foto' => $f,
            'kode' => data_get($r, 'sarana.kode_inventaris') ?? data_get($r, 'sarana.kode') ?? '-',
            'jumlah' => data_get($r, 'jumlah', 1),
            'tujuan' => data_get($r, 'tujuan', '-'),
            'dibuat' => $tgl(data_get($r, 'created_at')) ?? '-',
            'tanggal' => in_array($s, ['diproses', 'ditolak']) ? null : $tgl(data_get($r, 'tanggal_pinjam')),
            'waktu' => $mulai ? substr($mulai, 0, 5).' – '.substr((string) $selesai, 0, 5) : null,
            'lokasi' => data_get($r, 'lokasi_pengambilan') ?? data_get($r, 'sarana.lokasi') ?? '-',
            'jurusan' => $jurusan,
            'status' => $s,
            'label' => $st[$s][0] ?? ucfirst($s),
            'badge' => $st[$s][1] ?? $st['diproses'][1],
            'warna' => $st[$s][2] ?? $st['diproses'][2],
            'detail' => url('/peminjam/riwayat/'.data_get($r, 'id')),
            'batal' => $s === 'diproses' && \Illuminate\Support\Facades\Route::has('peminjam.pengajuan.cancel') ? route('peminjam.pengajuan.cancel', data_get($r, 'id')) : null,
        ];
    })->values();

    if ($items->isEmpty()) {
        $items = collect([
            ['Laptop Macbook M1 Air', 2, 'Lupa Bawa Laptop', 'diproses', 'SMKN1-RPL-LPT-042'],
            ['Laptop Axioo Hype', 2, 'Lupa Bawa Laptop', 'ditolak', 'SMKN1-RPL-LPT-017'],
            ['Microphone', 1, 'TOEIC', 'diproses', 'SMKN1-MM-MIC-005'],
        ])->map(fn ($r, $i) => [
            'id' => $i + 1, 'nama' => $r[0], 'foto' => null, 'kode' => $r[4], 'jumlah' => $r[1], 'tujuan' => $r[2], 'dibuat' => '19 Agustus 2026',
            'tanggal' => null, 'waktu' => null, 'lokasi' => 'Ruang Toolsman RPL, Gedung E-204', 'jurusan' => $jurusan, 'status' => $r[3],
            'detail' => null, 'label' => $st[$r[3]][0], 'badge' => $st[$r[3]][1], 'warna' => $st[$r[3]][2], 'batal' => null,
        ]);
    }
@endphp

<section class="bg-gradient-to-b from-slate-50 to-white px-6 pb-20 pt-10 lg:px-12">
    <div class="mx-auto max-w-6xl">
        <a href="{{ Route::has('peminjam.dashboard') ? route('peminjam.dashboard') : '#' }}" class="inline-flex items-center gap-1 text-sm text-gray-500 transition hover:text-brand">
            <i data-lucide="chevron-left" class="h-4 w-4"></i> Kembali ke Beranda
        </a>

        <div class="mt-3 flex flex-wrap items-end justify-between gap-4">
            <div>
                <h1 class="font-head text-3xl font-bold tracking-tight lg:text-4xl">Riwayat Pengajuan Saya</h1>
                <p class="mt-2 text-[15px] text-gray-500">Pantau status peminjaman dan cek riwayat peminjaman sebelumnya.</p>
            </div>
            <a href="{{ route('peminjam.pengajuan.create') }}"
               class="inline-flex items-center gap-2 rounded-xl bg-brand px-5 py-2.5 text-sm font-medium text-white shadow-lg shadow-brand/25 transition hover:-translate-y-0.5 hover:bg-brand-soft">
                <i data-lucide="plus" class="h-4 w-4"></i> Tambah Pengajuan
            </a>
        </div>

        <div class="mt-9 grid items-start gap-8 lg:grid-cols-[1fr_370px]">
            {{-- DAFTAR --}}
            <div>
                <h2 class="font-head text-lg font-bold">Daftar Pengajuan</h2>
                <div id="list" class="mt-4 space-y-4">
                    @foreach ($items as $i => $r)
                        <div role="button" tabindex="0" data-i="{{ $i }}"
                                class="item group flex w-full items-center gap-4 rounded-2xl bg-white p-4 text-left shadow-md shadow-brand/10 ring-1 ring-black/5 transition hover:-translate-y-0.5 hover:shadow-lg hover:shadow-brand/15">
                            <span class="relative flex h-[68px] w-[68px] shrink-0 items-center justify-center overflow-hidden rounded-xl bg-gradient-to-br from-brand-mint to-slate-100">
                                <i data-lucide="package" class="h-6 w-6 text-brand-soft/40"></i>
                                @if ($r['foto'])<img src="{{ $r['foto'] }}" alt="" onerror="this.remove()" class="absolute inset-0 h-full w-full object-cover">@endif
                            </span>
                            <span class="min-w-0 flex-1">
                                <span class="block truncate font-head text-lg font-bold tracking-tight">{{ $r['nama'] }}</span>
                                <span class="mt-1 block text-xs text-gray-500">Jumlah Unit: <b class="text-brand">{{ $r['jumlah'] }}</b> <span class="mx-1.5 text-gray-300">|</span> Tujuan: <b class="text-brand">{{ $r['tujuan'] }}</b></span>
                                <span class="mt-1 block text-xs text-gray-400">Diajukan pada: {{ $r['dibuat'] }}</span>
                            </span>
                            <span class="rounded-full px-3 py-1 text-xs font-semibold ring-1 {{ $r['badge'] }}">{{ $r['label'] }}</span>
                            <a href="{{ $r['detail'] ?? '#' }}" title="Lihat detail" aria-label="Lihat detail" onclick="event.stopPropagation()" class="flex h-9 w-9 items-center justify-center rounded-full bg-slate-100 text-brand transition hover:bg-brand hover:text-white"><i data-lucide="eye" class="h-4 w-4"></i></a>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- DETAIL AKTIF --}}
            <aside class="rounded-2xl bg-white p-6 shadow-xl shadow-brand/10 ring-1 ring-black/5 lg:sticky lg:top-24">
                <h2 class="font-head text-lg font-bold">Detail Pengajuan Aktif</h2>
                <p class="mt-0.5 text-xs text-gray-500">Status: <b id="d-status"></b></p>

                <div class="relative mt-4 flex h-44 items-center justify-center overflow-hidden rounded-xl bg-gradient-to-br from-brand-mint to-slate-100">
                    <i data-lucide="package" class="h-12 w-12 text-brand-soft/30" stroke-width="1.2"></i>
                    <img id="d-foto" alt="" class="absolute inset-0 hidden h-full w-full object-cover" onerror="this.classList.add('hidden')">
                </div>

                <h3 id="d-nama" class="mt-4 font-head text-xl font-bold tracking-tight"></h3>
                <p class="mt-0.5 text-xs text-gray-500">Kode Inventaris: <span id="d-kode" class="font-medium text-brand"></span></p>

                <dl class="mt-4 divide-y divide-gray-100 text-sm">
                    @foreach ([['Jurusan', 'd-jurusan'], ['Tgl Pengajuan', 'd-dibuat'], ['Tgl Peminjaman', 'd-tanggal'], ['Waktu Peminjaman', 'd-waktu']] as [$l, $id])
                        <div class="flex justify-between gap-4 py-2.5"><dt class="text-gray-500">{{ $l }}</dt><dd id="{{ $id }}" class="text-right font-semibold"></dd></div>
                    @endforeach
                    <div class="py-2.5"><dt class="text-xs text-gray-500">Lokasi Pengambilan</dt><dd id="d-lokasi" class="mt-0.5 font-semibold"></dd></div>
                    <div class="py-2.5"><dt class="text-xs text-gray-500">Tujuan Peminjaman</dt><dd id="d-tujuan" class="mt-0.5 font-semibold"></dd></div>
                </dl>

                <a id="d-detail" href="#" class="mt-5 hidden items-center justify-center gap-2 rounded-xl border border-brand py-2.5 text-sm font-medium transition hover:bg-brand hover:text-white">Lihat detail lengkap <i data-lucide="arrow-right" class="h-4 w-4"></i></a>

                <form id="d-batal" method="POST" class="mt-4 hidden" onsubmit="return confirm('Batalkan pengajuan ini?')">
                    @csrf @method('PATCH')
                    <button class="w-full rounded-xl bg-red-600 py-3 text-sm font-medium text-white shadow-md shadow-red-600/25 transition hover:bg-red-700">Batalkan Pengajuan</button>
                </form>
            </aside>
        </div>
    </div>
</section>

<script>
(() => {
    const data = @json($items);
    const $ = id => document.getElementById(id);
    const btns = document.querySelectorAll('#list .item');

    function pilih(i) {
        const r = data[i];
        btns.forEach((b, n) => { b.classList.toggle('ring-2', n === i); b.classList.toggle('ring-brand-soft', n === i); b.classList.toggle('ring-black/5', n !== i); });
        const s = $('d-status'); s.textContent = r.label + (r.status === 'diproses' ? ' oleh Admin' : ''); s.className = r.warna;
        const f = $('d-foto'); f.classList.toggle('hidden', !r.foto); if (r.foto) f.src = r.foto;
        $('d-nama').textContent = r.nama; $('d-kode').textContent = r.kode; $('d-jurusan').textContent = r.jurusan;
        $('d-dibuat').textContent = r.dibuat; $('d-lokasi').textContent = r.lokasi; $('d-tujuan').textContent = r.tujuan;
        const t = $('d-tanggal'); t.textContent = r.tanggal || (r.status === 'ditolak' ? 'Tidak disetujui' : 'Belum Disetujui');
        t.className = 'text-right font-semibold ' + (r.tanggal ? '' : 'text-amber-700');
        $('d-waktu').textContent = r.waktu || '-';
        const dl = $('d-detail'); dl.classList.toggle('hidden', !r.detail); dl.classList.toggle('flex', !!r.detail); if (r.detail) dl.href = r.detail;
        const b = $('d-batal'); b.classList.toggle('hidden', !r.batal); if (r.batal) b.action = r.batal;
    }
    btns.forEach((b, i) => { b.addEventListener('click', () => pilih(i)); b.addEventListener('keydown', e => { if (e.key === 'Enter') pilih(i); }); });
    if (data.length) pilih(0);
})();
</script>
@endsection