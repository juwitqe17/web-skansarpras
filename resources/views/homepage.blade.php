<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SkanSarpras | Peminjaman Sarana & Prasarana SMK Negeri 1 Purwosari</title>
    <meta name="description" content="Pinjam sarana praktikum semua jurusan SMK Negeri 1 Purwosari lewat SkanSarpras.">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --ink: #0b3d2e;
            --ink-soft: #14503c;
            --lime: #c6f24e;
            --cream: #f7f5ef;
        }
        .font-display, .font-body { font-family: 'Plus Jakarta Sans', ui-sans-serif, system-ui, sans-serif; }

        @keyframes floatUp { from { opacity:0; transform: translateY(16px);} to {opacity:1; transform:none;} }
        .float-up { opacity:0; animation: floatUp .65s cubic-bezier(.2,.8,.2,1) forwards; }

        @media (prefers-reduced-motion: reduce) {
            html { scroll-behavior:auto !important; }
            .float-up { animation:none; opacity:1; }
        }
    </style>
</head>

@php
    $loginUrl = Route::has('login') ? route('login') : url('/login');

    // Data sarana lintas jurusan (contoh — nanti bisa dari database)
    $sarana = [
        ['nama'=>'Axioo Hype 5','jurusan'=>'TKJ','img'=>'images/hype5.png','specs'=>['Core i5','SSD 512 GB'],'desc'=>'Praktikum jaringan & pemrograman.','tersedia'=>true],
        ['nama'=>'Proyektor Epson','jurusan'=>'Umum','img'=>'images/proyektor.png','specs'=>['HDMI','3000 lumen'],'desc'=>'Presentasi kelas & seminar.','tersedia'=>false],
        ['nama'=>'Kamera DSLR Canon','jurusan'=>'DKV','img'=>'images/kamera.png','specs'=>['18-55mm','Full HD'],'desc'=>'Dokumentasi & produksi konten.','tersedia'=>true],
        ['nama'=>'Multimeter Digital','jurusan'=>'TKR','img'=>'images/multimeter.png','specs'=>['Auto-range'],'desc'=>'Praktikum kelistrikan otomotif.','tersedia'=>true],
        ['nama'=>'Kalkulator Ilmiah','jurusan'=>'Akuntansi','img'=>'images/kalkulator.png','specs'=>['Scientific'],'desc'=>'Ujian & praktikum hitung.','tersedia'=>true],
        ['nama'=>'Router Mikrotik','jurusan'=>'TKJ','img'=>'images/router.png','specs'=>['RB750'],'desc'=>'Konfigurasi jaringan lab.','tersedia'=>false],
        ['nama'=>'Set Mikrofon','jurusan'=>'Umum','img'=>'images/mic.png','specs'=>['Wireless'],'desc'=>'Kegiatan panggung & rapat.','tersedia'=>true],
    ];

    // Rekap jumlah per jurusan untuk section "Jelajahi per Jurusan"
    $perJurusan = collect($sarana)->groupBy('jurusan')->map->count();

    $kategori = ['Semua', ...$perJurusan->keys()->all()];
@endphp

<body class="font-body min-h-screen bg-[var(--cream)] text-[#0f172a] antialiased">

    {{-- HEADER --}}
    <header class="sticky top-0 z-40 border-b border-black/5 bg-[var(--cream)]/90 backdrop-blur">
        <div class="mx-auto flex h-[72px] max-w-6xl items-center justify-between px-5 lg:px-8">
            <a href="{{ url('/') }}" class="flex items-center gap-2.5">
                <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-white p-1.5 ring-1 ring-black/5">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo SMKN 1 Purwosari" class="h-full w-full object-contain">
                </span>
                <span class="font-display text-xl font-extrabold tracking-tight text-[var(--ink)]">SkanSarpras</span>
            </a>

            <nav class="hidden items-center gap-1 text-sm font-semibold text-slate-600 md:flex" aria-label="Navigasi utama">
                <a href="#sarana" class="rounded-full px-4 py-2 hover:bg-black/5 hover:text-[var(--ink)]">Sarana</a>
                <a href="#cara-meminjam" class="rounded-full px-4 py-2 hover:bg-black/5 hover:text-[var(--ink)]">Cara Meminjam</a>
                <a href="#bantuan" class="rounded-full px-4 py-2 hover:bg-black/5 hover:text-[var(--ink)]">Bantuan</a>
            </nav>

            <div class="flex items-center gap-2">
                <a href="{{ $loginUrl }}"
                   class="inline-flex h-10 items-center rounded-full bg-[var(--ink)] px-5 text-sm font-bold text-white transition hover:bg-[var(--ink-soft)] focus:outline-none focus:ring-4 focus:ring-[var(--ink)]/20">
                    Masuk
                </a>
            </div>
        </div>
    </header>

    <main>

        {{-- HERO --}}
        <section class="px-5 pt-8 lg:px-8 lg:pt-12">
            <div class="mx-auto grid max-w-6xl items-center gap-10 lg:grid-cols-[1.05fr_1fr]">

                <div class="float-up">
                    <span class="inline-flex items-center gap-2 rounded-full bg-[var(--ink)]/5 px-3 py-1 text-xs font-bold uppercase tracking-wider text-[var(--ink)]">
                        <span class="h-1.5 w-1.5 rounded-full bg-green-500"></span> Untuk Semua Jurusan
                    </span>

                    <h1 class="font-display mt-5 text-4xl font-extrabold leading-[1.05] tracking-tight text-[var(--ink)] sm:text-5xl lg:text-[58px]">
                        Sarana praktikum<br><span class="text-[#32846b]">semua jurusan,</span> satu tempat.
                    </h1>

                    <p class="mt-5 max-w-lg text-[15px] leading-relaxed text-slate-600">
                        Dari laptop TKJ sampai kamera DKV — cek ketersediaan, ajukan peminjaman, dan pantau statusnya dengan akun akademik Anda.
                    </p>

                    <div class="mt-8 flex flex-wrap items-center gap-3">
                        <a href="{{ $loginUrl }}"
                           class="inline-flex h-12 items-center rounded-full bg-[var(--ink)] px-7 text-sm font-bold text-white shadow-lg shadow-[var(--ink)]/25 transition hover:-translate-y-0.5 hover:bg-[var(--ink-soft)] focus:outline-none focus:ring-4 focus:ring-[var(--ink)]/20">
                            Mulai Pinjam
                        </a>
                        <a href="#sarana"
                           class="inline-flex h-12 items-center rounded-full border border-black/10 bg-white px-6 text-sm font-bold text-[var(--ink)] transition hover:bg-black/5">
                            Lihat Katalog →
                        </a>
                    </div>

                    <dl class="mt-10 grid max-w-md grid-cols-3 gap-4 border-t border-black/10 pt-6">
                        <div><dt class="text-xs text-slate-500">Jurusan</dt><dd class="font-display text-2xl font-extrabold text-[var(--ink)]">{{ $perJurusan->count() }}</dd></div>
                        <div><dt class="text-xs text-slate-500">Jenis sarana</dt><dd class="font-display text-2xl font-extrabold text-[var(--ink)]">{{ count($sarana) }}+</dd></div>
                        <div><dt class="text-xs text-slate-500">Jam layanan</dt><dd class="font-display text-2xl font-extrabold text-[var(--ink)]">07–15</dd></div>
                    </dl>
                </div>

                {{-- Mockup dashboard --}}
                <div class="float-up relative" style="animation-delay:.15s">
                    <div class="relative rounded-[26px] bg-[var(--ink)] p-3 shadow-2xl shadow-[var(--ink)]/30">
                        <div class="rounded-2xl bg-white p-5">
                            <div class="flex items-center justify-between">
                                <p class="font-display text-sm font-extrabold text-[var(--ink)]">Katalog Sarana</p>
                                <span class="rounded-full bg-green-100 px-2 py-0.5 text-[10px] font-bold text-green-700">LIVE</span>
                            </div>

                            <div class="mt-4 space-y-3">
                                @foreach (array_slice($sarana, 0, 3) as $i => $s)
                                <div class="flex items-center gap-3 rounded-xl border border-black/5 bg-[var(--cream)] p-2.5 {{ $i==1 ? 'ring-2 ring-[var(--lime)]' : '' }}">
                                    <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-lg bg-white ring-1 ring-black/5">
                                        <img src="{{ asset($s['img']) }}" alt="" onerror="this.removeAttribute('src')" class="h-full w-full object-contain p-1.5">
                                    </span>
                                    <div class="min-w-0 flex-1">
                                        <p class="truncate text-xs font-bold">{{ $s['nama'] }}</p>
                                        <p class="text-[10px] text-slate-500">{{ $s['jurusan'] }} · {{ $s['specs'][0] }}</p>
                                    </div>
                                    <span class="shrink-0 text-[10px] font-bold {{ $s['tersedia'] ? 'text-green-600' : 'text-red-500' }}">
                                        {{ $s['tersedia'] ? 'Tersedia' : 'Dipinjam' }}
                                    </span>
                                </div>
                                @endforeach
                            </div>

                            <a href="{{ $loginUrl }}" class="mt-4 block rounded-xl bg-[var(--lime)] py-2.5 text-center text-xs font-extrabold text-[var(--ink)] transition hover:brightness-95">
                                Pinjam Sekarang
                            </a>
                        </div>
                    </div>

                    <div class="absolute -left-4 bottom-8 hidden rounded-2xl bg-white px-4 py-3 shadow-xl ring-1 ring-black/5 sm:block">
                        <p class="text-[10px] font-semibold text-slate-500">Status pengajuan</p>
                        <p class="mt-0.5 flex items-center gap-1.5 text-xs font-extrabold text-[var(--ink)]">
                            <span class="h-2 w-2 rounded-full bg-green-500"></span> Disetujui
                        </p>
                    </div>
                </div>
            </div>
        </section>

        {{-- KATALOG + FILTER --}}
        <section id="sarana" class="scroll-mt-20 px-5 py-14 lg:px-8 lg:py-20">
            <div class="mx-auto max-w-6xl">

                <div class="flex flex-col justify-between gap-6 sm:flex-row sm:items-end">
                    <div class="max-w-lg">
                        <h2 class="font-display text-3xl font-extrabold tracking-tight text-[var(--ink)] lg:text-4xl">Sarana lintas jurusan</h2>
                        <p class="mt-2 text-[15px] leading-relaxed text-slate-600">Beberapa barang yang sering dipinjam. Filter berdasarkan jurusan.</p>
                    </div>

                    <div class="flex flex-wrap gap-2" id="filter">
                        @foreach ($kategori as $i => $k)
                            <button type="button" data-kategori="{{ $k }}"
                                class="filter-btn rounded-full border px-4 py-2 text-xs font-bold transition {{ $i===0 ? 'border-[var(--ink)] bg-[var(--ink)] text-white' : 'border-black/10 bg-white text-slate-600 hover:border-[var(--ink)] hover:text-[var(--ink)]' }}">
                                {{ $k }}
                            </button>
                        @endforeach
                    </div>
                </div>

                <div class="mt-10 grid gap-5 sm:grid-cols-2 lg:grid-cols-4" id="grid-sarana">
                    @foreach ($sarana as $s)
                        <article data-kategori="{{ $s['jurusan'] }}"
                            class="group flex flex-col overflow-hidden rounded-2xl border border-black/5 bg-white p-3 transition hover:-translate-y-1 hover:shadow-xl hover:shadow-black/5">
                            <div class="relative overflow-hidden rounded-xl bg-[var(--cream)] p-4">
                                <img src="{{ asset($s['img']) }}" alt="{{ $s['nama'] }}" onerror="this.removeAttribute('src')"
                                     class="h-36 w-full object-contain transition duration-300 group-hover:scale-105">
                                <span class="absolute right-2 top-2 rounded-full px-2 py-0.5 text-[10px] font-extrabold {{ $s['tersedia'] ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-600' }}">
                                    {{ $s['tersedia'] ? 'Tersedia' : 'Dipinjam' }}
                                </span>
                            </div>

                            <div class="flex flex-1 flex-col px-2 pb-1 pt-4">
                                <p class="text-[10px] font-bold uppercase tracking-wider text-[#32846b]">{{ $s['jurusan'] }}</p>
                                <h3 class="font-display mt-1 text-base font-extrabold leading-tight">{{ $s['nama'] }}</h3>
                                <p class="mt-1.5 text-xs leading-relaxed text-slate-500">{{ $s['desc'] }}</p>

                                <div class="mt-3 flex flex-wrap gap-1.5">
                                    @foreach ($s['specs'] as $sp)
                                        <span class="rounded-md bg-[var(--cream)] px-2 py-0.5 text-[10px] font-semibold text-slate-600">{{ $sp }}</span>
                                    @endforeach
                                </div>

                                <a href="{{ $loginUrl }}"
                                   class="mt-4 inline-flex h-10 w-full items-center justify-center rounded-xl border border-[var(--ink)]/15 text-xs font-bold text-[var(--ink)] transition hover:bg-[var(--ink)] hover:text-white">
                                    Pinjam
                                </a>
                            </div>
                        </article>
                    @endforeach
                </div>

                <p id="empty-state" class="mt-8 hidden rounded-xl border border-dashed border-black/10 py-10 text-center text-sm text-slate-500">
                    Belum ada sarana di jurusan ini.
                </p>

                <div class="mt-10 text-center">
                    <a href="{{ $loginUrl }}" class="inline-flex h-11 items-center rounded-full border border-[var(--ink)]/20 px-6 text-sm font-bold text-[var(--ink)] transition hover:bg-[var(--ink)] hover:text-white">
                        Lihat katalog lengkap
                    </a>
                </div>
            </div>
        </section>

        {{-- CARA MEMINJAM --}}
        <section id="cara-meminjam" class="scroll-mt-20 px-5 pb-20 lg:px-8">
            <div class="mx-auto max-w-6xl">
                <div class="max-w-lg">
                    <h2 class="font-display text-3xl font-extrabold tracking-tight text-[var(--ink)] lg:text-4xl">Tiga langkah, selesai.</h2>
                    <p class="mt-2 text-[15px] leading-relaxed text-slate-600">Dari memilih barang sampai mengembalikannya.</p>
                </div>

                <div class="mt-10 grid gap-4 md:grid-cols-3">
                    @foreach ([
                        ['01','Cari & pilih','Pilih sarana dari katalog, periksa status ketersediaannya.','M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0z'],
                        ['02','Ajukan pinjam','Isi durasi, tujuan, dan guru penanggung jawab.','M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.6a1 1 0 01.7.3l4.4 4.4a1 1 0 01.3.7V19a2 2 0 01-2 2z'],
                        ['03','Pakai & kembalikan','Gunakan dengan bertanggung jawab, kembalikan tepat waktu.','M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'],
                    ] as [$num,$judul,$isi,$path])
                        <div class="relative rounded-2xl border border-black/5 bg-white p-6">
                            <span class="font-display text-5xl font-extrabold text-[var(--cream)]">{{ $num }}</span>
                            <span class="absolute right-5 top-5 flex h-11 w-11 items-center justify-center rounded-xl bg-[var(--ink)] text-[var(--lime)]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $path }}"/></svg>
                            </span>
                            <h3 class="font-display mt-3 text-lg font-extrabold">{{ $judul }}</h3>
                            <p class="mt-1.5 text-sm leading-relaxed text-slate-600">{{ $isi }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- CTA BANTUAN --}}
        <section id="bantuan" class="scroll-mt-20 px-5 pb-20 lg:px-8">
            <div class="mx-auto flex max-w-6xl flex-col items-start justify-between gap-6 rounded-[26px] bg-[var(--ink)] px-7 py-10 text-white sm:px-12 md:flex-row md:items-center">
                <div>
                    <h2 class="font-display text-2xl font-extrabold tracking-tight sm:text-3xl">Belum punya akun?</h2>
                    <p class="mt-2 max-w-md text-sm leading-relaxed text-white/75">Akun dibuat oleh sekolah. Hubungi Admin IT untuk mendapatkan akun akademik Anda.</p>
                </div>
                <a href="{{ $loginUrl }}"
                   class="inline-flex h-12 shrink-0 items-center rounded-full bg-[var(--lime)] px-7 text-sm font-extrabold text-[var(--ink)] transition hover:brightness-95 focus:outline-none focus:ring-4 focus:ring-white/30">
                    Hubungi Admin
                </a>
            </div>
        </section>

    </main>

    {{-- FOOTER --}}
    <footer class="border-t border-black/5 bg-white">
        <div class="mx-auto grid max-w-6xl gap-8 px-5 py-12 sm:grid-cols-3 lg:px-8">
            <div>
                <div class="flex items-center gap-2.5">
                    <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-[var(--cream)] p-1 ring-1 ring-black/5">
                        <img src="{{ asset('images/logo.png') }}" alt="" class="h-full w-full object-contain">
                    </span>
                    <span class="font-display font-extrabold text-[var(--ink)]">SkanSarpras</span>
                </div>
                <p class="mt-3 max-w-xs text-sm leading-relaxed text-slate-500">Sistem peminjaman sarana & prasarana SMK Negeri 1 Purwosari untuk semua jurusan.</p>
            </div>

            <div class="text-sm">
                <p class="font-bold text-[var(--ink)]">Navigasi</p>
                <ul class="mt-3 space-y-2 text-slate-500">
                    <li><a href="#sarana" class="hover:text-[var(--ink)]">Sarana</a></li>
                    <li><a href="#jurusan" class="hover:text-[var(--ink)]">Jurusan</a></li>
                    <li><a href="#cara-meminjam" class="hover:text-[var(--ink)]">Cara Meminjam</a></li>
                </ul>
            </div>

            <div class="text-sm">
                <p class="font-bold text-[var(--ink)]">Kontak</p>
                <ul class="mt-3 space-y-2 text-slate-500">
                    <li>Admin IT · Ruang TU</li>
                    <li>Senin–Jumat, 07.00–15.00</li>
                    <li>sarpras@smkn1purwosari.sch.id</li>
                </ul>
            </div>
        </div>
        <div class="border-t border-black/5 py-5 text-center text-xs text-slate-400">
            &copy; {{ date('Y') }} SMK Negeri 1 Purwosari. Seluruh hak dilindungi.
        </div>
    </footer>

    <script>
        (function () {
            const filterBtns  = document.querySelectorAll('.filter-btn');
            const jurusanBtns = document.querySelectorAll('.jurusan-card');
            const cards       = document.querySelectorAll('#grid-sarana [data-kategori]');
            const empty       = document.getElementById('empty-state');

            function setAktif(kat) {
                // Reset semua filter-btn
                filterBtns.forEach(b => {
                    const aktif = b.dataset.kategori === kat;
                    b.classList.toggle('border-[var(--ink)]', aktif);
                    b.classList.toggle('bg-[var(--ink)]', aktif);
                    b.classList.toggle('text-white', aktif);
                    b.classList.toggle('border-black/10', !aktif);
                    b.classList.toggle('bg-white', !aktif);
                    b.classList.toggle('text-slate-600', !aktif);
                });

                // Tampilkan kartu yang cocok
                let tampil = 0;
                cards.forEach(c => {
                    const cocok = kat === 'Semua' || c.dataset.kategori === kat;
                    c.classList.toggle('hidden', !cocok);
                    if (cocok) tampil++;
                });
                empty.classList.toggle('hidden', tampil > 0);
            }

            filterBtns.forEach(btn => {
                btn.addEventListener('click', () => setAktif(btn.dataset.kategori));
            });

            // Klik kartu jurusan → set filter + scroll ke katalog
            jurusanBtns.forEach(btn => {
                btn.addEventListener('click', () => {
                    setAktif(btn.dataset.jurusan);
                    document.getElementById('sarana').scrollIntoView({ behavior: 'smooth', block: 'start' });
                });
            });
        })();
    </script>

</body>
</html>