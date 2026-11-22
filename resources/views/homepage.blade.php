<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>SkanSarpras | Peminjaman Sarana & Prasarana SMK Negeri 1 Purwosari</title>
    <meta name="description" content="Pinjam laptop dan fasilitas praktikum SMK Negeri 1 Purwosari lewat SkanSarpras.">

    {{-- Font: Bricolage Grotesque (judul) + Figtree (isi) --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .font-display { font-family: 'Work Sans', 'Figtree', ui-sans-serif, system-ui, sans-serif; }
        .font-body    { font-family: 'Work Sans', ui-sans-serif, system-ui, sans-serif; }

        /* Satu momen animasi: kartu di hero naik saat halaman dibuka */
        @keyframes card-rise {
            from { opacity: 0; transform: translateY(24px) scale(.97); }
            to   { opacity: 1; transform: translateY(0) scale(1); }
        }
        .card-rise {
            opacity: 0;
            animation: card-rise .75s cubic-bezier(.2, .8, .2, 1) forwards;
        }

        @media (prefers-reduced-motion: reduce) {
            html { scroll-behavior: auto !important; }
            .card-rise { animation: none; opacity: 1; }
        }
    </style>
</head>

@php
    // Link ke halaman login (sesuaikan nama route jika berbeda)
    $loginUrl = Route::has('login') ? route('login') : url('/login');

    // Ubah true/false sesuai status sarana (atau ambil dari database)
    $macbookTersedia = true;
    $axiooTersedia = true;

    // Placeholder jika gambar belum ada
    $ph = 'bg-[#f8f3ed] ring-1 ring-black/5';
@endphp

<body class="font-body min-h-screen bg-[#f8f3ed] text-[#111827] antialiased">

    {{-- =========================
        HEADER
    ========================== --}}
<header class="sticky top-0 z-30 flex h-[74px] items-center justify-between border-b border-gray-200 bg-white px-6 lg:px-10">

    <a href="{{ url('/') }}" class="flex items-center gap-3 rounded-lg focus:outline-none focus-visible:ring-4 focus-visible:ring-[#003d2c]/20">
        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-white p-1.5 shadow-sm ring-1 ring-[#173f34]/10">
            <img src="{{ asset('images/logo.png') }}" alt="Logo SMK Negeri 1 Purwosari" class="h-full w-full object-contain">
        </span>
        <span class="font-display text-2xl font-extrabold tracking-tight text-[#073b2b]">SkanSarpras</span>
    </a>

    <nav class="hidden items-center gap-1 text-sm font-semibold text-gray-600 md:flex" aria-label="Navigasi utama">
        <a href="#sarana" class="rounded-full px-4 py-2 transition hover:bg-gray-100 hover:text-[#073b2b]">Sarana</a>
        <a href="#cara-meminjam" class="rounded-full px-4 py-2 transition hover:bg-gray-100 hover:text-[#073b2b]">Cara Meminjam</a>
        <a href="#bantuan" class="rounded-full px-4 py-2 transition hover:bg-gray-100 hover:text-[#073b2b]">Bantuan</a>
    </nav>

    <a
        href="{{ $loginUrl }}"
        class="inline-flex h-11 items-center gap-2 rounded-xl bg-[#003d2c] px-5 text-sm font-bold text-white shadow-[0_10px_20px_-10px_rgba(0,61,44,0.7)] transition duration-200 hover:-translate-y-0.5 hover:bg-[#00543d] focus:outline-none focus:ring-4 focus:ring-[#003d2c]/20 active:translate-y-0"
    >
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
        </svg>
        Log In
    </a>

</header>


    <main>

        {{-- =========================
            HERO
        ========================== --}}
        <section class="px-5 pt-6 lg:px-8 lg:pt-8">
            <div class="relative mx-auto max-w-6xl overflow-hidden rounded-[28px] bg-gradient-to-br from-[#4eb18f] via-[#32846b] to-[#173f34] shadow-[0_40px_80px_-35px_rgba(23,63,52,0.6)]">

                {{-- Efek dekorasi --}}
                <div class="absolute -left-32 -top-32 h-80 w-80 rounded-full bg-white/10 blur-3xl"></div>
                <div class="absolute -bottom-40 -right-32 h-96 w-96 rounded-full bg-black/10 blur-3xl"></div>
                <div
                    class="pointer-events-none absolute inset-0"
                    style="
                        background-image: radial-gradient(rgba(255,255,255,.16) 1px, transparent 1px);
                        background-size: 22px 22px;
                        -webkit-mask-image: linear-gradient(135deg, #000 0%, transparent 60%);
                        mask-image: linear-gradient(135deg, #000 0%, transparent 60%);
                    "
                ></div>

                <div class="relative grid items-center gap-12 px-7 py-14 sm:px-12 lg:grid-cols-[1.1fr_1fr] lg:px-16 lg:py-20">

                    {{-- Teks --}}
                    <div class="text-white">

                        <h1 class="font-display text-4xl font-extrabold leading-[1.08] tracking-tight sm:text-5xl lg:text-[56px]">
                            Butuh sarana untuk praktikum? Pinjam lewat SkanSarpras.
                        </h1>

                        <p class="mt-6 max-w-[460px] text-[15px] font-medium leading-relaxed text-white/90">
                            Sistem peminjaman sarana dan prasarana SMK Negeri 1 Purwosari. Cek ketersediaan, ajukan peminjaman, dan pantau statusnya dengan akun akademik Anda.
                        </p>

                        <div class="mt-8 flex flex-wrap items-center gap-3">
                            <a
                                href="{{ $loginUrl }}"
                                class="inline-flex h-[52px] items-center rounded-xl bg-white px-7 text-sm font-bold text-[#173f34] shadow-[0_14px_28px_-12px_rgba(0,0,0,0.5)] transition duration-200 hover:-translate-y-0.5 hover:bg-[#f8f3ed] focus:outline-none focus:ring-4 focus:ring-white/30 active:translate-y-0"
                            >
                                Log In untuk Meminjam
                            </a>

                            <a
                                href="#sarana"
                                class="inline-flex h-[52px] items-center rounded-xl px-6 text-sm font-bold text-white ring-1 ring-white/40 transition hover:bg-white/10 focus:outline-none focus:ring-4 focus:ring-white/30"
                            >
                                Lihat Sarana
                            </a>
                        </div>

                    </div>

                    {{-- Kartu sarana --}}
                    <div class="relative mx-auto h-[380px] w-full max-w-[440px] sm:h-[420px]" aria-hidden="true">

                        {{-- Kartu 1 --}}
                        <div class="absolute left-0 top-0 w-[70%] -rotate-3">
                            <div class="card-rise rounded-3xl bg-white p-3 shadow-[0_28px_50px_-20px_rgba(0,0,0,0.55)]" style="animation-delay: .15s">
                                <img
                                    src="{{ asset('images/m1airmac.png') }}"
                                    alt=""
                                    onerror="this.removeAttribute('src')"
                                    class="h-40 w-full rounded-2xl object-contain p-3 {{ $ph }} sm:h-44"
                                >
                                <div class="flex items-center justify-between gap-2 px-1.5 pb-1 pt-3">
                                    <p class="truncate text-sm font-bold text-[#111827]">MacBook M1 Air</p>
                                    <span class="flex shrink-0 items-center gap-1.5 text-xs font-semibold text-[#32846b]">
                                        <span class="h-2 w-2 rounded-full {{ $macbookTersedia ? 'bg-green-500' : 'bg-red-400' }}"></span>
                                        {{ $macbookTersedia ? 'Tersedia' : 'Dipinjam' }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        {{-- Kartu 2 --}}
                        <div class="absolute bottom-0 right-0 w-[70%] rotate-3">
                            <div class="card-rise rounded-3xl bg-white p-3 shadow-[0_28px_50px_-20px_rgba(0,0,0,0.55)]" style="animation-delay: .4s">
                                <img
                                    src="{{ asset('images/hype5.png') }}"
                                    alt=""
                                    onerror="this.removeAttribute('src')"
                                    class="h-40 w-full rounded-2xl object-contain p-3 {{ $ph }} sm:h-44"
                                >
                                <div class="flex items-center justify-between gap-2 px-1.5 pb-1 pt-3">
                                    <p class="truncate text-sm font-bold text-[#111827]">Axioo Hype 5</p>
                                    <span class="flex shrink-0 items-center gap-1.5 text-xs font-semibold text-[#32846b]">
                                        <span class="h-2 w-2 rounded-full {{ $axiooTersedia ? 'bg-green-500' : 'bg-red-400' }}"></span>
                                        {{ $axiooTersedia ? 'Tersedia' : 'Dipinjam' }}
                                    </span>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </section>


        {{-- =========================
            SARANA
        ========================== --}}
        <section id="sarana" class="scroll-mt-24 px-5 py-20 lg:px-8">
            <div class="mx-auto max-w-6xl">

                <div class="max-w-xl">
                    <h2 class="font-display text-3xl font-bold tracking-tight text-[#173f34] lg:text-4xl">
                        Sarana yang bisa dipinjam
                    </h2>
                    <p class="mt-3 text-[15px] leading-relaxed text-[#64748b]">
                        Beberapa sarana yang sering dipakai untuk praktikum. Log in untuk melihat katalog lengkap dan mengajukan peminjaman.
                    </p>
                </div>

                <div class="mt-10 grid gap-6 md:grid-cols-3">

                    {{-- MacBook --}}
                    <article class="flex flex-col overflow-hidden rounded-3xl bg-white shadow-[0_24px_50px_-30px_rgba(23,63,52,0.45)] ring-1 ring-[#173f34]/5">
                        <div class="bg-[#f8f3ed] p-6">
                            <img
                                src="{{ asset('images/m1airmac.png') }}"
                                alt="Laptop MacBook M1 Air"
                                onerror="this.removeAttribute('src')"
                                class="h-44 w-full object-contain {{ $ph }} rounded-xl"
                            >
                        </div>
                        <div class="flex flex-1 flex-col p-6">
                            <h3 class="font-display text-xl font-bold tracking-tight">Laptop MacBook M1 Air</h3>

                            <div class="mt-3 flex flex-wrap gap-2 text-xs font-semibold text-[#173f34]">
                                <span class="rounded-full bg-[#f8f3ed] px-3 py-1">Chip M1</span>
                                <span class="rounded-full bg-[#f8f3ed] px-3 py-1">RAM 8 GB</span>
                                <span class="rounded-full bg-[#f8f3ed] px-3 py-1">SSD 256 GB</span>
                            </div>

                            <p class="mt-4 text-sm leading-relaxed text-[#64748b]">
                                Cocok untuk desain grafis, editing video, dan pemrograman.
                            </p>

                            <div class="mt-auto pt-6">
                                <p class="flex items-center gap-2 text-sm font-semibold">
                                    <span class="h-2 w-2 rounded-full {{ $macbookTersedia ? 'bg-green-500' : 'bg-red-400' }}"></span>
                                    {{ $macbookTersedia ? 'Tersedia' : 'Sedang dipinjam' }}
                                </p>
                                <a
                                    href="{{ $loginUrl }}"
                                    class="mt-3 inline-flex h-11 w-full items-center justify-center rounded-xl bg-[#003d2c] text-sm font-bold text-white transition hover:bg-[#00543d] focus:outline-none focus:ring-4 focus:ring-[#003d2c]/20"
                                >
                                    Log In untuk Pinjam
                                </a>
                            </div>
                        </div>
                    </article>

                    {{-- Axioo --}}
                    <article class="flex flex-col overflow-hidden rounded-3xl bg-white shadow-[0_24px_50px_-30px_rgba(23,63,52,0.45)] ring-1 ring-[#173f34]/5">
                        <div class="bg-[#f8f3ed] p-6">
                            <img
                                src="{{ asset('images/hype5.png') }}"
                                alt="Laptop Axioo Hype 5"
                                onerror="this.removeAttribute('src')"
                                class="h-44 w-full object-contain {{ $ph }} rounded-xl"
                            >
                        </div>
                        <div class="flex flex-1 flex-col p-6">
                            <h3 class="font-display text-xl font-bold tracking-tight">Laptop Axioo Hype 5</h3>

                            <div class="mt-3 flex flex-wrap gap-2 text-xs font-semibold text-[#173f34]">
                                <span class="rounded-full bg-[#f8f3ed] px-3 py-1">Core i5</span>
                                <span class="rounded-full bg-[#f8f3ed] px-3 py-1">RAM 8 GB</span>
                                <span class="rounded-full bg-[#f8f3ed] px-3 py-1">SSD 512 GB</span>
                            </div>

                            <p class="mt-4 text-sm leading-relaxed text-[#64748b]">
                                Andal untuk praktikum ketik, desain, pemrograman, dan kegiatan belajar sehari-hari.
                            </p>

                            <div class="mt-auto pt-6">
                                <p class="flex items-center gap-2 text-sm font-semibold">
                                    <span class="h-2 w-2 rounded-full {{ $axiooTersedia ? 'bg-green-500' : 'bg-red-400' }}"></span>
                                    {{ $axiooTersedia ? 'Tersedia' : 'Sedang dipinjam' }}
                                </p>
                                <a
                                    href="{{ $loginUrl }}"
                                    class="mt-3 inline-flex h-11 w-full items-center justify-center rounded-xl bg-[#003d2c] text-sm font-bold text-white transition hover:bg-[#00543d] focus:outline-none focus:ring-4 focus:ring-[#003d2c]/20"
                                >
                                    Log In untuk Pinjam
                                </a>
                            </div>
                        </div>
                    </article>

                    {{-- Ajakan lihat katalog --}}
                    <a
                        href="{{ $loginUrl }}"
                        class="group flex flex-col items-center justify-center rounded-3xl border-2 border-dashed border-[#32846b]/40 p-8 text-center transition hover:border-[#064e3b] hover:bg-white focus:outline-none focus-visible:ring-4 focus-visible:ring-[#003d2c]/20"
                    >
                        <span class="flex h-14 w-14 items-center justify-center rounded-2xl bg-white text-[#064e3b] shadow-sm ring-1 ring-[#173f34]/10 transition group-hover:bg-[#f8f3ed]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                            </svg>
                        </span>
                        <h3 class="font-display mt-5 text-xl font-bold tracking-tight text-[#173f34]">Masih ada sarana lainnya</h3>
                        <p class="mt-2 max-w-[220px] text-sm leading-relaxed text-[#64748b]">
                            Log in untuk melihat daftar lengkap sarana dan prasarana sekolah.
                        </p>
                        <span class="mt-5 text-sm font-bold text-[#064e3b] underline-offset-4 group-hover:underline">Log In</span>
                    </a>

                </div>
            </div>
        </section>


        {{-- =========================
            CARA MEMINJAM
        ========================== --}}
        <section id="cara-meminjam" class="scroll-mt-24 px-5 pb-20 lg:px-8">
            <div class="mx-auto max-w-6xl rounded-[28px] bg-white px-7 py-14 shadow-[0_24px_50px_-30px_rgba(23,63,52,0.45)] ring-1 ring-[#173f34]/5 sm:px-12 lg:px-16">

                <div class="max-w-xl">
                    <h2 class="font-display text-3xl font-bold tracking-tight text-[#173f34] lg:text-4xl">
                        Cara meminjam sarana
                    </h2>
                    <p class="mt-3 text-[15px] leading-relaxed text-[#64748b]">
                        Tiga langkah singkat dari memilih barang sampai mengembalikannya.
                    </p>
                </div>

                <ol class="relative mt-12 grid gap-10 md:grid-cols-3 md:gap-8">

                    {{-- Garis penghubung antar langkah --}}
                    <div class="pointer-events-none absolute left-6 right-6 top-6 hidden border-t-2 border-dashed border-[#32846b]/30 md:block"></div>

                    @foreach ([
                        ['Cari & pilih barang', 'Pilih sarana dari katalog, lalu periksa status ketersediaannya.'],
                        ['Ajukan peminjaman', 'Isi durasi pinjam, tujuan penggunaan, dan guru penanggung jawab kelas.'],
                        ['Gunakan & kembalikan', 'Gunakan untuk praktikum dengan bertanggung jawab, lalu kembalikan tepat waktu.'],
                    ] as $n => [$judul, $isi])
                        <li class="relative flex gap-5 md:block">
                            <span class="font-display relative z-10 flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-[#003d2c] text-lg font-bold text-white shadow-[0_12px_22px_-10px_rgba(0,61,44,0.7)]">
                                {{ $n + 1 }}
                            </span>
                            <div class="md:mt-6">
                                <h3 class="font-display text-lg font-bold tracking-tight text-[#111827]">{{ $judul }}</h3>
                                <p class="mt-1.5 max-w-[300px] text-sm leading-relaxed text-[#64748b]">{{ $isi }}</p>
                            </div>
                        </li>
                    @endforeach

                </ol>
            </div>
        </section>


        {{-- =========================
            BANTUAN / CTA
        ========================== --}}
        <section id="bantuan" class="scroll-mt-24 px-5 pb-20 lg:px-8">
            <div class="mx-auto flex max-w-6xl flex-col items-start justify-between gap-6 rounded-[28px] bg-[#173f34] px-7 py-10 text-white sm:px-12 md:flex-row md:items-center lg:px-16">

                <div>
                    <h2 class="font-display text-2xl font-bold tracking-tight sm:text-3xl">Belum memiliki akun?</h2>
                    <p class="mt-2 max-w-md text-sm leading-relaxed text-white/80">
                        Akun dibuat oleh sekolah. Segera hubungi Admin IT untuk mendapatkan akun akademik Anda.
                    </p>
                </div>

                <a
                    href="{{ $loginUrl }}"
                    class="inline-flex h-[52px] shrink-0 items-center rounded-xl bg-white px-7 text-sm font-bold text-[#173f34] transition duration-200 hover:-translate-y-0.5 hover:bg-[#f8f3ed] focus:outline-none focus:ring-4 focus:ring-white/30 active:translate-y-0"
                >
                    Sudah punya akun? Log In
                </a>

            </div>
        </section>

    </main>


    {{-- =========================
        FOOTER
    ========================== --}}
    <footer class="border-t border-[#173f34]/10">
        <div class="mx-auto flex max-w-6xl flex-col items-start justify-between gap-4 px-5 py-8 text-sm text-[#64748b] sm:flex-row sm:items-center lg:px-8">

            <div class="flex items-center gap-3">
                <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-white p-1 shadow-sm ring-1 ring-[#173f34]/10">
                    <img src="{{ asset('images/logo.png') }}" alt="" class="h-full w-full object-contain">
                </span>
                <span class="font-semibold text-[#173f34]">SkanSarpras</span>
            </div>

            <p>&copy; {{ date('Y') }} SMK Negeri 1 Purwosari. Seluruh hak dilindungi.</p>

        </div>
    </footer>

</body>
</html>
