@extends('layouts.peminjam')
@section('title', 'Beranda | SkanSarpras')

@section('content')
@php
    $daftar = ($saranas ?? collect())->count() ? $saranas : collect([0, 1])->map(fn () => (object) [
        'id' => 1,
        'nama' => 'Laptop Macbook M1 Air',
        'deskripsi' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
        'foto' => asset('images/macbook.png'),
        'tersedia' => true,
    ]);
    $ph = 'bg-gradient-to-br from-brand-mint to-brand-soft/30 text-transparent ring-1 ring-black/5';
@endphp

{{-- HERO --}}
<section class="bg-gradient-to-b from-slate-50 to-white px-6 py-14 lg:px-12 lg:py-16">
    <div class="mx-auto grid max-w-6xl items-center gap-12 lg:grid-cols-2">
        <div>
            <div class="flex items-center gap-2.5 text-sm">
                <span class="flex h-7 w-7 items-center justify-center rounded-full bg-brand text-xs font-bold text-white">{{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}</span>
                <span>Hello, <b class="font-head">{{ auth()->user()->name ?? 'Pengguna' }}!</b></span>
            </div>
            <span class="mt-3 inline-block rounded-full bg-brand-mint px-3 py-1 text-[11px] font-semibold tracking-wide">SELAMAT DATANG DI SKANSARPAS</span>
            <h1 class="mt-4 font-head text-4xl font-extrabold leading-[1.15] tracking-tight lg:text-[44px]">
                Sistem Manajemen Sarana &amp; Prasarana SMK Negeri 1 Purwosari
            </h1>
            <p class="mt-5 max-w-md text-[15px] leading-relaxed text-gray-500">
                Temukan, ajukan, dan kelola peminjaman fasilitas sekolah dan peralatan praktikum dengan cepat, transparan, dan mudah. Kami mendukung kegiatan belajar mengajar terbaik Anda.
            </p>
            <a href="{{ route('peminjam.pengajuan.create') }}"
               class="mt-7 inline-flex items-center gap-2.5 rounded-lg bg-brand px-6 py-3 text-sm font-medium text-white shadow-lg shadow-brand/25 transition hover:-translate-y-0.5 hover:bg-brand-soft">
                <i data-lucide="log-in" class="h-4 w-4"></i> Mulai Pinjam
            </a>
        </div>

        <div class="relative mx-auto h-[340px] w-full max-w-lg sm:h-[400px]">
            <div class="absolute inset-x-6 bottom-2 top-10 rounded-[3rem] bg-gradient-to-br from-brand-mint/70 to-transparent blur-2xl"></div>
            <img src="{{ asset('images/hero-1.jpg') }}" alt="Laboratorium komputer" onerror="this.removeAttribute('src')"
                 class="absolute left-0 top-0 h-[58%] w-[66%] rounded-2xl object-cover shadow-xl shadow-brand/15 {{ $ph }}">
            <img src="{{ asset('images/hero-2.jpg') }}" alt="Studio multimedia" onerror="this.removeAttribute('src')"
                 class="absolute right-0 top-[26%] h-[40%] w-[50%] rounded-2xl object-cover shadow-xl shadow-brand/15 {{ $ph }}">
            <img src="{{ asset('images/hero-3.jpg') }}" alt="Bengkel praktik" onerror="this.removeAttribute('src')"
                 class="absolute bottom-0 left-[16%] h-[34%] w-[48%] rounded-2xl object-cover shadow-xl shadow-brand/15 {{ $ph }}">
        </div>
    </div>
</section>

{{-- SARANA TERSEDIA --}}
<section class="rounded-b-[2rem] bg-white px-6 pb-20 pt-6 lg:px-12">
    <div class="mx-auto max-w-5xl text-center">
        <h2 class="font-head text-2xl font-bold tracking-tight">Sarana Tersedia</h2>
        <p class="mx-auto mt-2 max-w-sm text-sm leading-relaxed text-gray-500">Jelajahi daftar sarana yang tersedia dan rasakan kemudahan proses peminjamannya.</p>
    </div>

    <div class="mx-auto mt-8 max-w-5xl text-right">
        <a href="{{ Route::has('peminjam.sarana.index') ? route('peminjam.sarana.index') : '#' }}"
           class="inline-flex items-center gap-1 text-sm font-medium hover:underline">Lihat Semua <i data-lucide="chevron-right" class="h-4 w-4"></i></a>
    </div>

    <div class="mx-auto mt-6 max-w-5xl space-y-16">
        @foreach ($daftar as $s)
            <article class="grid items-center gap-10 md:grid-cols-2">
                <div class="relative flex justify-center py-6 {{ $loop->even ? 'md:order-2' : '' }}">
                    <div class="absolute h-56 w-64 bg-gradient-to-br from-brand-soft/70 to-brand
                        {{ $loop->even ? 'bottom-0 right-2 rounded-br-[2.5rem] rounded-tl-[4rem] rounded-tr-xl rounded-bl-xl' : 'left-2 top-0 rounded-bl-[2.5rem] rounded-tr-[4rem] rounded-tl-xl rounded-br-xl' }}"></div>
                    <span class="absolute h-3 w-3 rounded-full bg-brand {{ $loop->even ? 'bottom-2 left-6' : 'right-6 top-2' }}"></span>
                    <div class="relative z-10 rounded-2xl bg-white p-4 shadow-xl shadow-brand/15 ring-1 ring-black/5">
                        <img src="{{ $s->foto }}" alt="{{ $s->nama }}" onerror="this.removeAttribute('src')"
                             class="h-44 w-64 rounded-lg object-contain {{ $ph }}">
                    </div>
                </div>

                <div class="{{ $loop->even ? 'md:order-1' : '' }}">
                    <h3 class="font-head text-2xl font-bold tracking-tight">{{ $s->nama }}</h3>
                    <p class="mt-4 text-sm font-semibold">Deskripsi :</p>
                    <p class="mt-1.5 max-w-md text-sm leading-relaxed text-gray-500">{{ $s->deskripsi }}</p>
                    <p class="mt-4 flex items-center gap-2 text-sm">
                        <span class="h-2 w-2 rounded-full {{ $s->tersedia ? 'bg-green-500' : 'bg-red-400' }}"></span>
                        {{ $s->tersedia ? 'Tersedia' : 'Sedang dipinjam' }}
                    </p>
                    <a href="{{ route('peminjam.pengajuan.create', ['sarana' => $s->id]) }}"
                       class="mt-4 inline-flex items-center gap-2 rounded-lg bg-brand px-5 py-2.5 text-sm font-medium text-white shadow-md shadow-brand/20 transition hover:bg-brand-soft {{ $s->tersedia ? '' : 'pointer-events-none opacity-50' }}">
                        <i data-lucide="log-in" class="h-4 w-4"></i> Pinjam
                    </a>
                </div>
            </article>
        @endforeach
    </div>
</section>

{{-- CARA MEMINJAM --}}
<section class="bg-brand px-6 py-20 text-white lg:px-12">
    <div class="mx-auto grid max-w-5xl items-center gap-12 lg:grid-cols-2">
        <div>
            <div class="inline-flex h-10 w-10 items-center justify-center rounded-lg bg-white/10"><i data-lucide="quote" class="h-4 w-4"></i></div>
            <h2 class="mt-4 font-head text-3xl font-medium leading-snug lg:text-4xl">Cara Meminjam<br>Sarana Praktikum</h2>
            <p class="mt-4 max-w-sm text-sm leading-relaxed text-white/70">
                Kami merancang alur peminjaman yang ringkas agar Anda dapat fokus sepenuhnya pada pencapaian akademis dan praktik tanpa hambatan logistik.
            </p>
            <a href="{{ route('peminjam.pengajuan.create') }}"
               class="mt-6 inline-flex items-center gap-2 rounded-lg bg-gray-100 px-6 py-3 text-sm font-medium text-brand transition hover:bg-white">
                <i data-lucide="log-in" class="h-4 w-4"></i> Mulai Pinjam
            </a>
        </div>

        <ol class="space-y-3.5">
            @foreach ([
                ['Cari & Pilih Barang', 'Pilih sarana atau prasarana dari katalog kami, lalu periksa status ketersediaannya secara real-time.'],
                ['Ajukan Peminjaman', 'Isi detail peminjaman termasuk durasi waktu, tujuan penggunaan, dan guru penanggung jawab kelas.'],
                ['Gunakan & Kembalikan', 'Gunakan barang secara bertanggung jawab untuk praktikum, lalu kembalikan tepat waktu sesuai komitmen.'],
            ] as $n => [$judul, $isi])
                <li class="flex gap-4 rounded-2xl border border-white/10 bg-white/[.06] p-5">
                    <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full border border-white/60 text-xs">{{ $n + 1 }}</span>
                    <div>
                        <p class="text-[15px] font-semibold">{{ $judul }}</p>
                        <p class="mt-1 text-sm leading-relaxed text-white/65">{{ $isi }}</p>
                    </div>
                </li>
            @endforeach
        </ol>
    </div>
</section>
@endsection