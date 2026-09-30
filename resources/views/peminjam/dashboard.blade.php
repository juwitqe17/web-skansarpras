@extends('layouts.peminjam')

@section('page-content')

{{-- ===================== HERO ===================== --}}
<section class="mb-14">
    <div class="mb-5">
        <p class="text-[13px] text-gray-500">
            Hello, <span class="font-semibold text-gray-800">{{ auth()->user()->name ?? 'Juwita Serina Putri' }}</span> 👋
        </p>
        <div class="mt-1.5 inline-flex items-center gap-1.5 rounded-full bg-[#e6f7ef] px-3 py-1 text-[11px] font-semibold tracking-wide text-[#0B3D2E]">
            <span class="h-1.5 w-1.5 rounded-full bg-[#22c55e]"></span>
            SELAMAT DATANG DI SKANSARPRAS
        </div>
    </div>

    <div class="grid grid-cols-1 items-center gap-10 lg:grid-cols-2">
        <div>
            <h1 class="mb-4 text-[2.1rem] font-bold leading-[1.2] text-gray-900 lg:text-[2.35rem]">
                Sistem Manajemen<br>
                Sarana & Prasarana SMK<br>
                <span class="text-[#0B3D2E]">Negeri 1 Purwosari</span>
            </h1>
            <p class="mb-7 max-w-[390px] text-[14px] leading-relaxed text-gray-500">
                Temukan, ajukan, dan kelola peminjaman fasilitas sekolah dan peralatan praktikum dengan cepat, transparan, dan mudah. Kami mendukung kegiatan belajar mengajar terbaik Anda.
            </p>
            <a href="{{ route('peminjam.sarana') }}"
               class="inline-flex items-center gap-2 rounded-lg bg-[#0B3D2E] px-6 py-3 text-sm font-medium text-white transition hover:bg-[#083226]">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 11.5V14m0-2.5v-6a1.5 1.5 0 113 0m-3 6a1.5 1.5 0 00-3 0v2a7.5 7.5 0 0015 0v-5a1.5 1.5 0 00-3 0m-6-3V11m0-5.5v-1a1.5 1.5 0 013 0v1m0 0V11m0-5.5a1.5 1.5 0 013 0v3m0 0V11"/>
                </svg>
                Mulai Pinjam
            </a>
        </div>

        {{-- Image Collage --}}
        <div class="relative h-[270px] w-full">
            <img src="https://images.unsplash.com/photo-1497366216548-37526070297c?w=600&h=400&fit=crop"
                 class="absolute left-0 top-0 z-10 h-[135px] w-[47%] rounded-2xl object-cover shadow-md" alt="">
            <img src="https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?w=700&h=450&fit=crop"
                 class="absolute right-0 top-2 z-20 h-[150px] w-[56%] rounded-2xl object-cover shadow-md" alt="">
            <img src="https://images.unsplash.com/photo-1581092918056-0c4c3acd3789?w=600&h=400&fit=crop"
                 class="absolute bottom-1 left-[6%] z-30 h-[110px] w-[50%] rounded-2xl object-cover shadow-md" alt="">
            <img src="https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=600&h=400&fit=crop"
                 class="absolute bottom-0 right-1 z-10 h-[105px] w-[43%] rounded-2xl object-cover shadow-md" alt="">
        </div>
    </div>
</section>

{{-- ===================== SARANA TERSEDIA ===================== --}}
<section class="mb-16">
    <div class="mb-8 text-center">
        <h2 class="text-2xl font-bold text-gray-900">Sarana Tersedia</h2>
        <p class="mt-2 text-sm text-gray-500">
            Jelajahi daftar sarana yang tersedia dan rasakan kemudahan proses<br>
            peminjamannya.
        </p>
    </div>

    <div class="mb-6 flex justify-end">
        <a href="{{ route('peminjam.sarana') }}" class="flex items-center gap-1 text-sm font-medium text-[#0B3D2E] hover:underline">
            Lihat Semua
            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
            </svg>
        </a>
    </div>

    <div class="space-y-14">
        {{-- Card 1 --}}
        <div class="flex flex-col items-center gap-10 md:flex-row">
            <div class="relative flex w-full justify-center md:w-[46%]">
                <div class="absolute -left-8 top-0 h-52 w-48 rounded-[40%_60%_55%_45%/55%_40%_60%_45%] bg-[#0B3D2E]"></div>
                <div class="relative z-10 rounded-2xl border border-gray-100 bg-white p-5 shadow-lg">
                    <img src="https://images.unsplash.com/photo-1517336714731-489689fd1ca8?w=500&h=350&fit=crop"
                         class="h-48 w-64 object-contain" alt="MacBook">
                </div>
            </div>
            <div class="w-full md:w-[50%]">
                <h3 class="mb-2 text-xl font-bold text-gray-900">Laptop Macbook M1 Air</h3>
                <p class="mb-1 text-sm font-medium text-gray-700">Deskripsi :</p>
                <p class="mb-5 max-w-md text-sm leading-relaxed text-gray-500">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                </p>
                <div class="flex items-center gap-3">
                    <span class="inline-flex items-center gap-1.5 text-xs font-medium text-emerald-600">
                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                        Tersedia
                    </span>
                    <a href="{{ route('peminjam.peminjaman') }}"
                       class="inline-flex items-center gap-1.5 rounded-md bg-[#0B3D2E] px-4 py-2 text-xs font-medium text-white transition hover:bg-[#083226]">
                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7 11.5V14m0-2.5v-6a1.5 1.5 0 113 0m-3 6a1.5 1.5 0 00-3 0v2a7.5 7.5 0 0015 0v-5a1.5 1.5 0 00-3 0m-6-3V11m0-5.5v-1a1.5 1.5 0 013 0v1m0 0V11m0-5.5a1.5 1.5 0 013 0v3m0 0V11"/>
                        </svg>
                        Pinjam
                    </a>
                </div>
            </div>
        </div>

        {{-- Card 2 --}}
        <div class="flex flex-col items-center gap-10 md:flex-row-reverse">
            <div class="relative flex w-full justify-center md:w-[46%]">
                <div class="absolute -right-8 top-0 h-52 w-48 rounded-[60%_40%_45%_55%/40%_55%_45%_60%] bg-[#0B3D2E]"></div>
                <div class="relative z-10 rounded-2xl border border-gray-100 bg-white p-5 shadow-lg">
                    <img src="https://images.unsplash.com/photo-1517336714731-489689fd1ca8?w=500&h=350&fit=crop"
                         class="h-48 w-64 object-contain" alt="MacBook">
                </div>
            </div>
            <div class="w-full md:w-[50%] md:text-right">
                <h3 class="mb-2 text-xl font-bold text-gray-900">Laptop Macbook M1 Air</h3>
                <p class="mb-1 text-sm font-medium text-gray-700">Deskripsi :</p>
                <p class="mb-5 max-w-md text-sm leading-relaxed text-gray-500 md:ml-auto">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                </p>
                <div class="flex items-center gap-3 md:justify-end">
                    <span class="inline-flex items-center gap-1.5 text-xs font-medium text-emerald-600">
                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                        Tersedia
                    </span>
                    <a href="{{ route('peminjam.peminjaman') }}"
                       class="inline-flex items-center gap-1.5 rounded-md bg-[#0B3D2E] px-4 py-2 text-xs font-medium text-white transition hover:bg-[#083226]">
                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7 11.5V14m0-2.5v-6a1.5 1.5 0 113 0m-3 6a1.5 1.5 0 00-3 0v2a7.5 7.5 0 0015 0v-5a1.5 1.5 0 00-3 0m-6-3V11m0-5.5v-1a1.5 1.5 0 013 0v1m0 0V11m0-5.5a1.5 1.5 0 013 0v3m0 0V11"/>
                        </svg>
                        Pinjam
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ===================== CARA MEMINJAM ===================== --}}
<section class="overflow-hidden rounded-2xl bg-[#0B3D2E] text-white">
    <div class="grid grid-cols-1 items-center gap-10 p-10 lg:grid-cols-2 lg:p-12">
        <div>
            <div class="mb-5 flex h-11 w-11 items-center justify-center rounded-xl bg-white/10">
                <svg class="h-5 w-5 opacity-80" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M14.017 21v-3c0-1.1-.9-2-2-2h-3c-1.1 0-2 .9-2 2v3H4V11c0-3.87 3.13-7 7-7s7 3.13 7 7v10h-3.983zM11 6c-2.76 0-5 2.24-5 5v3h10v-3c0-2.76-2.24-5-5-5z"/>
                </svg>
            </div>
            <h2 class="mb-3 text-2xl font-bold leading-snug">
                Cara Meminjam<br>Sarana Praktikum
            </h2>
            <p class="mb-7 max-w-sm text-sm leading-relaxed text-white/70">
                Kami merancang alur peminjaman yang ringkas agar Anda dapat fokus sepenuhnya pada pencapaian akademis dan praktik tanpa hambatan logistik.
            </p>
            <a href="{{ route('peminjam.sarana') }}"
               class="inline-flex items-center gap-2 rounded-lg bg-white px-6 py-3 text-sm font-medium text-[#0B3D2E] transition hover:bg-gray-100">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 11.5V14m0-2.5v-6a1.5 1.5 0 113 0m-3 6a1.5 1.5 0 00-3 0v2a7.5 7.5 0 0015 0v-5a1.5 1.5 0 00-3 0m-6-3V11m0-5.5v-1a1.5 1.5 0 013 0v1m0 0V11m0-5.5a1.5 1.5 0 013 0v3m0 0V11"/>
                </svg>
                Mulai Pinjam
            </a>
        </div>

        <div class="space-y-3.5">
            <div class="flex gap-4 rounded-xl bg-white/10 p-4.5">
                <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-white text-sm font-bold text-[#0B3D2E]">1</div>
                <div>
                    <h4 class="mb-0.5 text-sm font-semibold">Cari & Pilih Barang</h4>
                    <p class="text-xs leading-relaxed text-white/70">Pilih sarana atau prasarana dari katalog kami, lalu periksa status ketersediaannya secara real-time.</p>
                </div>
            </div>
            <div class="flex gap-4 rounded-xl bg-white/10 p-4.5">
                <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-white text-sm font-bold text-[#0B3D2E]">2</div>
                <div>
                    <h4 class="mb-0.5 text-sm font-semibold">Ajukan Peminjaman</h4>
                    <p class="text-xs leading-relaxed text-white/70">Isi detail peminjaman termasuk durasi waktu, tujuan penggunaan, dan guru penanggung jawab kelas.</p>
                </div>
            </div>
            <div class="flex gap-4 rounded-xl bg-white/10 p-4.5">
                <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-white text-sm font-bold text-[#0B3D2E]">3</div>
                <div>
                    <h4 class="mb-0.5 text-sm font-semibold">Gunakan & Kembalikan</h4>
                    <p class="text-xs leading-relaxed text-white/70">Gunakan barang secara bertanggung jawab untuk praktikum, lalu kembalikan tepat waktu sesuai ketentuan.</p>
                </div>
            </div>
        </div> 
    </div>
</section>

@endsection