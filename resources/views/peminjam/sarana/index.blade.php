@extends('layouts.peminjam')

@section('content')
<div class="min-h-screen bg-[#f7f9f8]">

    {{-- ================= HEADER ================= --}}
    <section class="border-b border-slate-200/70 bg-white">
        <div class="mx-auto max-w-7xl px-6 py-14 lg:px-8">

            <div class="max-w-3xl">
                <span class="mb-3 inline-block text-sm font-medium tracking-wide text-emerald-700">
                    KATALOG SARANA
                </span>

                <h1 class="text-4xl font-semibold tracking-tight text-slate-900 md:text-5xl">
                    Temukan sarana yang
                    <span class="text-emerald-900">kamu butuhkan.</span>
                </h1>

                <p class="mt-5 max-w-2xl text-base leading-7 text-slate-500">
                    Lihat berbagai sarana yang tersedia dan gunakan fasilitas sekolah
                    dengan lebih mudah, teratur, dan efisien.
                </p>
            </div>

            {{-- ================= FILTER ================= --}}
            <div class="mt-10 flex flex-wrap items-center gap-3">

                <button
                    class="rounded-full bg-emerald-950 px-6 py-2.5 text-sm font-medium text-white
                           shadow-sm transition duration-200 hover:bg-emerald-900">
                    Semua Sarana
                </button>

                <button
                    class="rounded-full border border-slate-200 bg-white px-6 py-2.5
                           text-sm font-medium text-slate-600 transition duration-200
                           hover:border-emerald-700 hover:text-emerald-800">
                    Elektronik & Laptop
                </button>

                <button
                    class="rounded-full border border-slate-200 bg-white px-6 py-2.5
                           text-sm font-medium text-slate-600 transition duration-200
                           hover:border-emerald-700 hover:text-emerald-800">
                    Peralatan Lab
                </button>

                <button
                    class="rounded-full border border-slate-200 bg-white px-6 py-2.5
                           text-sm font-medium text-slate-600 transition duration-200
                           hover:border-emerald-700 hover:text-emerald-800">
                    Ruang & Fasilitas
                </button>

            </div>
        </div>
    </section>


    {{-- ================= CONTENT ================= --}}
    <main class="mx-auto max-w-7xl px-6 py-12 lg:px-8">

        {{-- Jumlah data --}}
        <div class="mb-7 flex items-center justify-between">
            <div>
                <h2 class="text-lg font-semibold text-slate-900">
                    Semua Sarana
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Menampilkan 3 sarana
                </p>
            </div>

            <div class="hidden text-sm text-slate-400 sm:block">
                Terakhir diperbarui hari ini
            </div>
        </div>


        {{-- ================= CARD GRID ================= --}}
        <div class="grid gap-7 sm:grid-cols-2 lg:grid-cols-3">


            {{-- ================= CARD 1 ================= --}}
            <article
                class="group overflow-hidden rounded-2xl border border-slate-200
                       bg-white shadow-[0_4px_20px_rgba(15,23,42,0.05)]
                       transition duration-300 hover:-translate-y-1
                       hover:shadow-[0_12px_35px_rgba(15,23,42,0.10)]">

                {{-- Image --}}
                <div class="relative aspect-[4/3] overflow-hidden bg-slate-100">

                    <img
                        src="{{ asset('images/laptop-axioo.jpg') }}"
                        alt="Laptop Axioo"
                        class="h-full w-full object-cover transition duration-500
                               group-hover:scale-105">

                    {{-- Status --}}
                    <div class="absolute left-4 top-4">
                        <span
                            class="inline-flex items-center gap-2 rounded-full
                                   bg-white/95 px-3 py-1.5 text-xs font-medium
                                   text-slate-700 shadow-sm backdrop-blur">
                            <span class="h-2 w-2 rounded-full bg-red-500"></span>
                            Tidak tersedia
                        </span>
                    </div>

                </div>


                {{-- Content --}}
                <div class="p-5">

                    <p class="text-xs font-medium uppercase tracking-wide text-emerald-700">
                        Elektronik & Laptop
                    </p>

                    <h3 class="mt-2 text-xl font-semibold tracking-tight text-slate-900">
                        Laptop Axioo
                    </h3>

                    <p class="mt-2 line-clamp-2 text-sm leading-6 text-slate-500">
                        Laptop untuk menunjang kegiatan belajar, praktik,
                        dan kebutuhan pekerjaan sekolah.
                    </p>


                    {{-- Action --}}
                    <div class="mt-6 flex items-center gap-3">

                        <a href="#"
                           class="flex-1 rounded-xl border border-emerald-900
                                  px-4 py-2.5 text-center text-sm font-medium
                                  text-emerald-950 transition
                                  hover:bg-emerald-950 hover:text-white">
                            Lihat Detail
                        </a>

                        <button
                            disabled
                            class="flex-1 cursor-not-allowed rounded-xl
                                   bg-slate-200 px-4 py-2.5 text-sm
                                   font-medium text-slate-400">
                            Tidak tersedia
                        </button>

                    </div>

                </div>
            </article>



            {{-- ================= CARD 2 ================= --}}
            <article
                class="group overflow-hidden rounded-2xl border border-slate-200
                       bg-white shadow-[0_4px_20px_rgba(15,23,42,0.05)]
                       transition duration-300 hover:-translate-y-1
                       hover:shadow-[0_12px_35px_rgba(15,23,42,0.10)]">

                <div class="relative aspect-[4/3] overflow-hidden bg-slate-100">

                    <img
                        src="{{ asset('images/proyektor-epson.jpg') }}"
                        alt="Proyektor Epson"
                        class="h-full w-full object-cover transition duration-500
                               group-hover:scale-105">

                    <div class="absolute left-4 top-4">
                        <span
                            class="inline-flex items-center gap-2 rounded-full
                                   bg-white/95 px-3 py-1.5 text-xs font-medium
                                   text-slate-700 shadow-sm backdrop-blur">

                            <span class="h-2 w-2 rounded-full bg-emerald-500"></span>

                            Tersedia
                        </span>
                    </div>

                </div>


                <div class="p-5">

                    <p class="text-xs font-medium uppercase tracking-wide text-emerald-700">
                        Elektronik & Laptop
                    </p>

                    <h3 class="mt-2 text-xl font-semibold tracking-tight text-slate-900">
                        Proyektor Epson
                    </h3>

                    <p class="mt-2 line-clamp-2 text-sm leading-6 text-slate-500">
                        Proyektor untuk kebutuhan presentasi,
                        pembelajaran, dan kegiatan sekolah.
                    </p>


                    <div class="mt-6 flex items-center gap-3">

                        <a href="#"
                           class="flex-1 rounded-xl border border-emerald-900
                                  px-4 py-2.5 text-center text-sm font-medium
                                  text-emerald-950 transition
                                  hover:bg-emerald-950 hover:text-white">
                            Lihat Detail
                        </a>

                        <a href="#"
                           class="flex-1 rounded-xl bg-emerald-950
                                  px-4 py-2.5 text-center text-sm font-medium
                                  text-white transition
                                  hover:bg-emerald-900">
                            Pinjam
                        </a>

                    </div>

                </div>
            </article>



            {{-- ================= CARD 3 ================= --}}
            <article
                class="group overflow-hidden rounded-2xl border border-slate-200
                       bg-white shadow-[0_4px_20px_rgba(15,23,42,0.05)]
                       transition duration-300 hover:-translate-y-1
                       hover:shadow-[0_12px_35px_rgba(15,23,42,0.10)]">

                <div class="relative aspect-[4/3] overflow-hidden bg-slate-100">

                    <img
                        src="{{ asset('images/macbook-m1.jpg') }}"
                        alt="MacBook M1 Air"
                        class="h-full w-full object-cover transition duration-500
                               group-hover:scale-105">

                    <div class="absolute left-4 top-4">
                        <span
                            class="inline-flex items-center gap-2 rounded-full
                                   bg-white/95 px-3 py-1.5 text-xs font-medium
                                   text-slate-700 shadow-sm backdrop-blur">

                            <span class="h-2 w-2 rounded-full bg-emerald-500"></span>

                            Tersedia
                        </span>
                    </div>

                </div>


                <div class="p-5">

                    <p class="text-xs font-medium uppercase tracking-wide text-emerald-700">
                        Elektronik & Laptop
                    </p>

                    <h3 class="mt-2 text-xl font-semibold tracking-tight text-slate-900">
                        MacBook M1 Air
                    </h3>

                    <p class="mt-2 line-clamp-2 text-sm leading-6 text-slate-500">
                        Perangkat komputer untuk mendukung kebutuhan
                        pengembangan aplikasi dan kegiatan pembelajaran.
                    </p>


                    <div class="mt-6 flex items-center gap-3">

                        <a href="#"
                           class="flex-1 rounded-xl border border-emerald-900
                                  px-4 py-2.5 text-center text-sm font-medium
                                  text-emerald-950 transition
                                  hover:bg-emerald-950 hover:text-white">
                            Lihat Detail
                        </a>

                        <a href="#"
                           class="flex-1 rounded-xl bg-emerald-950
                                  px-4 py-2.5 text-center text-sm font-medium
                                  text-white transition
                                  hover:bg-emerald-900">
                            Pinjam
                        </a>

                    </div>

                </div>
            </article>

        </div>
    </main>

</div>
@endsection