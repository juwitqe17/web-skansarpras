@extends('layouts.peminjam')
@section('title', 'Beranda | SkanSarpras')

@section('content')
@php
    $ph = 'bg-gradient-to-br from-brand-mint to-brand-soft/30 text-transparent ring-1 ring-black/5';

    // Ubah true/false sesuai status sarana (atau ambil dari database)
    $macbookTersedia = true;
    $axiooTersedia = true;
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
            <img src="{{ asset('images/m1.png') }}" alt="Laboratorium komputer" onerror="this.removeAttribute('src')"
                 class="absolute left-0 top-0 h-[58%] w-[66%] rounded-2xl object-cover shadow-xl shadow-brand/15 {{ $ph }}">
            <img src="{{ asset('images/hype5.png') }}" alt="Studio multimedia" onerror="this.removeAttribute('src')"
                 class="absolute right-0 top-[26%] h-[40%] w-[50%] rounded-2xl object-cover shadow-xl shadow-brand/15 {{ $ph }}">
            <img src="{{ asset('images/m1air.webp') }}" alt="Bengkel praktik" onerror="this.removeAttribute('src')"
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

        {{-- 1. Laptop MacBook M1 Air (gambar kiri) --}}
        <article class="grid items-center gap-10 md:grid-cols-2">
            <div class="relative flex justify-center py-6">
                <div class="absolute left-2 top-0 h-56 w-64 rounded-bl-[2.5rem] rounded-tr-[4rem] rounded-tl-xl rounded-br-xl bg-gradient-to-br from-brand-soft/70 to-brand"></div>
                <span class="absolute right-6 top-2 h-3 w-3 rounded-full bg-brand"></span>
                <div class="relative z-10 rounded-2xl bg-white p-4 shadow-xl shadow-brand/15 ring-1 ring-black/5">
                    <img src="{{ asset('images/m1airmac.png') }}" alt="Laptop MacBook M1 Air" onerror="this.removeAttribute('src')"
                         class="h-44 w-64 rounded-lg object-contain {{ $ph }}">
                </div>
            </div>

            <div>
                <h3 class="font-head text-2xl font-bold tracking-tight">Laptop MacBook M1 Air</h3>
                <p class="mt-4 text-sm font-semibold">Deskripsi :</p>
                <p class="mt-1.5 max-w-md text-sm leading-relaxed text-gray-500">
                    Laptop Apple dengan chip M1 (CPU 8-core, GPU 7-core), RAM 8 GB, dan penyimpanan SSD 256 GB. Layar Retina 13,3 inci beresolusi 2560 × 1600, baterai tahan hingga sekitar 18 jam, dan bobot ringan ±1,29 kg. Berjalan di macOS, cocok untuk desain grafis, editing video, dan pemrograman.
                </p>
                <p class="mt-4 flex items-center gap-2 text-sm">
                    <span class="h-2 w-2 rounded-full {{ $macbookTersedia ? 'bg-green-500' : 'bg-red-400' }}"></span>
                    {{ $macbookTersedia ? 'Tersedia' : 'Sedang dipinjam' }}
                </p>
                <a href="{{ route('peminjam.pengajuan.create', ['sarana' => 1]) }}"
                   class="mt-4 inline-flex items-center gap-2 rounded-lg bg-brand px-5 py-2.5 text-sm font-medium text-white shadow-md shadow-brand/20 transition hover:bg-brand-soft {{ $macbookTersedia ? '' : 'pointer-events-none opacity-50' }}">
                    <i data-lucide="log-in" class="h-4 w-4"></i> Pinjam
                </a>
            </div>
        </article>

        {{-- 2. Laptop Axioo Hype 5 (gambar kanan) --}}
        <article class="grid items-center gap-10 md:grid-cols-2">
            <div class="relative flex justify-center py-6 md:order-2">
                <div class="absolute bottom-0 right-2 h-56 w-64 rounded-br-[2.5rem] rounded-tl-[4rem] rounded-tr-xl rounded-bl-xl bg-gradient-to-br from-brand-soft/70 to-brand"></div>
                <span class="absolute bottom-2 left-6 h-3 w-3 rounded-full bg-brand"></span>
                <div class="relative z-10 rounded-2xl bg-white p-4 shadow-xl shadow-brand/15 ring-1 ring-black/5">
                    <img src="{{ asset('images/hype5.png') }}" alt="Laptop Axioo Hype 5" onerror="this.removeAttribute('src')"
                         class="h-44 w-64 rounded-lg object-contain {{ $ph }} ">
                </div>
            </div>

            <div class="md:order-1">
                <h3 class="font-head text-2xl font-bold tracking-tight">Laptop Axioo Hype 5</h3>
                <p class="mt-4 text-sm font-semibold">Deskripsi :</p>
                <p class="mt-1.5 max-w-md text-sm leading-relaxed text-gray-500">
                    Laptop Windows dengan prosesor Intel Core i5, RAM 8 GB, dan penyimpanan SSD 512 GB. Layar 14 inci Full HD (1920 × 1080) IPS dengan bodi tipis dan ringan. Andal untuk praktikum ketik, desain, pemrograman, dan kegiatan belajar mengajar sehari-hari.
                </p>
                <p class="mt-4 flex items-center gap-2 text-sm">
                    <span class="h-2 w-2 rounded-full {{ $axiooTersedia ? 'bg-green-500' : 'bg-red-400' }}"></span>
                    {{ $axiooTersedia ? 'Tersedia' : 'Sedang dipinjam' }}
                </p>
                <a href="{{ route('peminjam.pengajuan.create', ['sarana' => 2]) }}"
                   class="mt-4 inline-flex items-center gap-2 rounded-lg bg-brand px-5 py-2.5 text-sm font-medium text-white shadow-md shadow-brand/20 transition hover:bg-brand-soft {{ $axiooTersedia ? '' : 'pointer-events-none opacity-50' }}">
                    <i data-lucide="log-in" class="h-4 w-4"></i> Pinjam
                </a>
            </div>
        </article>

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