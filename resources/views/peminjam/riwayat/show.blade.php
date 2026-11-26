@extends('layouts.peminjam')
@section('title', 'Detail Peminjaman | SkanSarpras')

@section('content')
@php
    // Dari controller: $peminjaman. Nama sarana diambil dari detailPeminjamans.sarana.
    $p = $peminjaman;
    $tgl = fn ($v) => $v ? \Carbon\Carbon::parse($v)->locale('id')->translatedFormat('l, d F Y') : null;
    $tglPendek = fn ($v) => $v ? \Carbon\Carbon::parse($v)->locale('id')->translatedFormat('d F Y, H:i') : null;

    // Nilai status di database -> kunci tampilan
    $statusMap = [
        'menunggu' => 'diproses', 'pending' => 'diproses', 'diajukan' => 'diproses',
        'sedang_dipinjam' => 'dipinjam', 'selesai' => 'dikembalikan',
    ];
    $s = strtolower((string) data_get($p, 'status', 'diproses'));
    $s = $statusMap[$s] ?? $s;
    $st = [
        'diproses'     => ['Diproses',     'bg-amber-50 text-amber-700 ring-amber-200'],
        'disetujui'    => ['Disetujui',    'bg-emerald-50 text-emerald-700 ring-emerald-200'],
        'dipinjam'     => ['Dipinjam',     'bg-sky-50 text-sky-700 ring-sky-200'],
        'terlambat'    => ['Terlambat',    'bg-orange-50 text-orange-700 ring-orange-200'],
        'dikembalikan' => ['Dikembalikan', 'bg-slate-100 text-slate-600 ring-slate-200'],
        'dibatalkan'   => ['Dibatalkan',   'bg-slate-100 text-slate-500 ring-slate-200'],
        'ditolak'      => ['Ditolak',      'bg-red-50 text-red-700 ring-red-200'],
    ];
    [$label, $badge] = $st[$s] ?? [ucfirst($s), $st['diproses'][1]];

    // Satu pengajuan bisa memuat beberapa sarana (tabel detail_peminjamans)
    $details = collect(data_get($p, 'detailPeminjamans', []));
    $sar = data_get($p, 'sarana') ?? data_get($details->first(), 'sarana');
    $nama = $details->map(fn ($d) => data_get($d, 'sarana.nama_sarana'))->filter()->join(', ')
        ?: (data_get($sar, 'nama_sarana') ?? data_get($sar, 'nama') ?? 'Sarana');
    $jumlah = $details->isNotEmpty()
        ? $details->sum(fn ($d) => (int) data_get($d, 'jumlah', 1))
        : data_get($p, 'jumlah', 1);

    $kode   = data_get($sar, 'kode_inventaris') ?? data_get($sar, 'kode_sarana') ?? data_get($sar, 'kode') ?? '-';
    $kat    = data_get($sar, 'kategori.nama_kategori') ?? data_get($sar, 'jurusan.nama_jurusan') ?? '-';
    $lokasi = data_get($p, 'lokasi_pengambilan') ?? data_get($sar, 'lokasi') ?? '-';
    $foto   = \App\Support\SaranaFoto::url($sar);
    $mulai  = data_get($p, 'waktu_mulai') ?? data_get($p, 'jam_mulai');
    $selesai = data_get($p, 'waktu_selesai') ?? data_get($p, 'jam_selesai');
    // Catatan / alasan dari petugas: dicari di data pengajuan, lalu di catatan persetujuan terakhir
    $persetujuan = collect(data_get($p, 'persetujuans', []))->sortByDesc('id')->first();
    $catatan = collect([
        data_get($p, 'alasan_penolakan'),
        data_get($p, 'catatan'),
        data_get($persetujuan, 'alasan'),
        data_get($persetujuan, 'catatan'),
        data_get($persetujuan, 'keterangan'),
    ])->first(fn ($v) => filled($v));
    $alasanTolak = $s === 'ditolak' ? ($catatan ?: 'Petugas belum mencantumkan alasan penolakan.') : null;

    // Linimasa
    $langkah = ['Pengajuan', 'Disetujui / Dipinjam', 'Dikembalikan'];
    // Tahap 2 = disetujui sekaligus dipinjam. Setelah dikembalikan, semua tahap bercentang.
    $aktif = ['diproses' => 0, 'disetujui' => 1, 'dipinjam' => 1, 'terlambat' => 1, 'dikembalikan' => 3][$s] ?? 0;
    $gagal = in_array($s, ['ditolak', 'dibatalkan']);
    $bisaBatal = $s === 'diproses' && \Illuminate\Support\Facades\Route::has('peminjam.pengajuan.cancel');
    $bisaHapus = in_array($s, ['ditolak', 'dibatalkan', 'dikembalikan']) && \Illuminate\Support\Facades\Route::has('peminjam.riwayat.destroy');
@endphp

<section class="bg-gradient-to-b from-slate-50 to-white px-6 pb-20 pt-10 lg:px-12">
    <div class="mx-auto max-w-5xl">
        <a href="{{ route('peminjam.riwayat.index') }}" class="inline-flex items-center gap-1 text-sm text-gray-500 transition hover:text-brand">
            <i data-lucide="chevron-left" class="h-4 w-4"></i> Kembali ke Riwayat
        </a>

        <div class="mt-3 flex flex-wrap items-center justify-between gap-4">
            <div>
                <h1 class="font-head text-3xl font-bold tracking-tight lg:text-4xl">Detail Peminjaman</h1>
                <p class="mt-2 text-sm text-gray-500">Diajukan pada {{ $tglPendek(data_get($p, 'created_at')) ?? '-' }}</p>
            </div>
            <span class="rounded-full px-4 py-1.5 text-sm font-semibold ring-1 {{ $badge }}">{{ $label }}</span>
        </div>

        {{-- Linimasa status --}}
        <div class="mt-8 rounded-2xl bg-white p-6 shadow-lg shadow-brand/10 ring-1 ring-black/5 sm:p-8">
            @if ($gagal)
                @if ($s === 'ditolak')
                    <div class="rounded-xl bg-red-50 px-5 py-4 text-red-700 ring-1 ring-red-100">
                        <div class="flex items-center gap-2 text-sm font-semibold">
                            <i data-lucide="circle-x" class="h-4 w-4 shrink-0"></i> Pengajuan ditolak oleh petugas
                        </div>
                        <p class="mt-3 text-[11px] font-semibold uppercase tracking-wide text-red-500">Alasan penolakan</p>
                        <p class="mt-1 text-sm leading-relaxed">{{ $alasanTolak }}</p>
                    </div>
                @else
                    <div class="flex items-start gap-3 rounded-xl bg-slate-100 px-4 py-3 text-sm text-slate-600">
                        <i data-lucide="ban" class="mt-0.5 h-4 w-4 shrink-0"></i>
                        <p>Pengajuan ini telah Anda batalkan.</p>
                    </div>
                @endif
            @else
                <ol class="grid grid-cols-3 gap-2">
                    @foreach ($langkah as $i => $l)
                        <li class="relative text-center">
                            @if ($i > 0)<span class="absolute right-1/2 top-4 -z-0 h-0.5 w-full {{ $i <= $aktif ? 'bg-brand' : 'bg-gray-200' }}"></span>@endif
                            <span class="relative z-10 mx-auto flex h-8 w-8 items-center justify-center rounded-full text-xs font-semibold ring-4 ring-white
                                {{ $i < $aktif ? 'bg-brand text-white' : ($i === $aktif ? 'bg-brand-mint text-brand ring-brand-soft/30' : 'bg-gray-100 text-gray-400') }}">
                                @if ($i < $aktif)<i data-lucide="check" class="h-4 w-4"></i>@else{{ $i + 1 }}@endif
                            </span>
                            <p class="mt-2 text-xs {{ $i <= $aktif ? 'font-semibold text-brand' : 'text-gray-400' }}">{{ $l }}</p>
                        </li>
                    @endforeach
                </ol>
            @endif
        </div>

        <div class="mt-6 grid gap-6 lg:grid-cols-[320px_1fr]">
            {{-- Sarana --}}
            <aside class="self-start overflow-hidden rounded-2xl bg-white shadow-lg shadow-brand/10 ring-1 ring-black/5">
                <div class="relative flex h-48 items-center justify-center bg-gradient-to-br from-brand-mint to-slate-100">
                    <i data-lucide="package" class="h-12 w-12 text-brand-soft/30" stroke-width="1.2"></i>
                    @if ($foto)<img src="{{ $foto }}" alt="{{ $nama }}" onerror="this.remove()" class="absolute inset-0 h-full w-full object-cover">@endif
                </div>
                <div class="p-5">
                    <p class="text-xs text-gray-400">{{ $kat }}</p>
                    <h2 class="mt-1 font-head text-xl font-bold tracking-tight">{{ $nama }}</h2>
                    <p class="mt-1 text-xs text-gray-500">Kode Inventaris: <span class="font-medium text-brand">{{ $kode }}</span></p>
                </div>
            </aside>

            {{-- Rincian --}}
            <div class="rounded-2xl bg-white p-6 shadow-lg shadow-brand/10 ring-1 ring-black/5 sm:p-8">
                <h2 class="font-head text-lg font-bold">Rincian Peminjaman</h2>
                <dl class="mt-4 grid gap-x-8 gap-y-5 text-sm sm:grid-cols-2">
                    @foreach ([
                        ['Jumlah Unit', $jumlah.' unit', 'boxes'],
                        ['Tanggal Peminjaman', $tgl(data_get($p, 'tanggal_peminjaman') ?? data_get($p, 'tanggal_pinjam')) ?? 'Belum ditentukan', 'calendar'],
                        ['Waktu Peminjaman', $mulai ? substr($mulai, 0, 5).' – '.substr((string) $selesai, 0, 5) : '-', 'clock-3'],
                        ['Lokasi Pengambilan', $lokasi, 'map-pin'],
                    ] as [$l, $v, $ic])
                        <div class="flex gap-3">
                            <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-brand-mint/70"><i data-lucide="{{ $ic }}" class="h-4 w-4"></i></span>
                            <div><dt class="text-xs text-gray-500">{{ $l }}</dt><dd class="mt-0.5 font-semibold">{{ $v }}</dd></div>
                        </div>
                    @endforeach
                </dl>

                <div class="mt-6 border-t border-gray-100 pt-5">
                    <p class="text-xs text-gray-500">Tujuan Peminjaman</p>
                    <p class="mt-1 text-sm leading-relaxed">{{ data_get($p, 'keperluan') ?? data_get($p, 'tujuan', '-') }}</p>
                </div>

                @if ($catatan && $s !== 'ditolak')
                    <div class="mt-5 flex items-start gap-3 rounded-xl bg-slate-50 px-4 py-3.5 ring-1 ring-gray-100">
                        <i data-lucide="message-square-text" class="mt-0.5 h-4 w-4 shrink-0 text-gray-400"></i>
                        <div><p class="text-xs text-gray-500">Catatan dari petugas</p><p class="mt-0.5 text-sm">{{ $catatan }}</p></div>
                    </div>
                @endif

                <div class="mt-7 flex flex-wrap justify-end gap-3">
                    @if ($bisaBatal)
                        <form method="POST" action="{{ route('peminjam.pengajuan.cancel', data_get($p, 'id')) }}" onsubmit="return confirm('Batalkan pengajuan ini?')">
                            @csrf @method('PATCH')
                            <button class="rounded-xl border border-red-200 px-5 py-2.5 text-sm font-medium text-red-600 transition hover:bg-red-50">Batalkan Pengajuan</button>
                        </form>
                    @endif
                    @if ($bisaHapus)
                        <form method="POST" action="{{ route('peminjam.riwayat.destroy', data_get($p, 'id')) }}" onsubmit="return confirm('Hapus pengajuan ini dari riwayat?')">
                            @csrf @method('DELETE')
                            <button class="inline-flex items-center gap-2 rounded-xl border border-red-200 px-5 py-2.5 text-sm font-medium text-red-600 transition hover:bg-red-50">
                                <i data-lucide="trash-2" class="h-4 w-4"></i> Hapus dari Riwayat
                            </button>
                        </form>
                    @endif
                    @if (in_array($s, ['ditolak', 'dibatalkan', 'dikembalikan']))
                        <a href="{{ route('peminjam.pengajuan.create', ['sarana' => data_get($details->first(), 'sarana_id')]) }}"
                           class="inline-flex items-center gap-2 rounded-xl bg-brand px-5 py-2.5 text-sm font-medium text-white shadow-lg shadow-brand/25 transition hover:bg-brand-soft">
                            <i data-lucide="rotate-ccw" class="h-4 w-4"></i> Ajukan Lagi
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection