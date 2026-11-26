@extends('layouts.peminjam')
@section('title', 'Profil Saya | SkanSarpras')

@section('content')
@php
    $user = auth()->user();
    $inisial = strtoupper(substr($user->name ?? 'U', 0, 1));
    $jurusan = $user->jurusan ?? null;

    // Jumlah pengajuan per status (satu query)
    $perStatus = $user->peminjamans()->selectRaw('status, count(*) as total')->groupBy('status')->pluck('total', 'status');
    $total = $perStatus->sum();
    $menunggu = $perStatus['menunggu'] ?? 0;
    $dipinjam = ($perStatus['sedang_dipinjam'] ?? 0) + ($perStatus['terlambat'] ?? 0);
    $selesai = $perStatus['selesai'] ?? 0;

    $data = [
        ['Nama',              $user->name,                                                                          'user'],
        ['Jurusan',           $jurusan->nama_jurusan ?? null,                                                       'building-2'],
        ['Email',             $user->email,                                                                         'mail'],
        ['No. WhatsApp',      $user->no_hp,                                                                         'message-circle'],
        ['Tanggal Terdaftar', $user->created_at ? $user->created_at->locale('id')->translatedFormat('d F Y') : null, 'calendar-days'],
    ];
@endphp

<section class="min-h-[calc(100vh-3.5rem)] rounded-b-[2rem] bg-gradient-to-b from-slate-50 to-white px-6 pb-20 pt-10 lg:px-12">
    <div class="mx-auto max-w-5xl">
        <a href="{{ Route::has('peminjam.dashboard') ? route('peminjam.dashboard') : '#' }}" class="inline-flex items-center gap-1 text-sm text-gray-500 transition hover:text-brand">
            <i data-lucide="chevron-left" class="h-4 w-4"></i> Kembali ke Beranda
        </a>

        <h1 class="mt-3 font-head text-3xl font-bold tracking-tight lg:text-4xl">Profil Saya</h1>
        <p class="mt-2 text-[15px] text-gray-500">Data identitas akun Anda di SkanSarpras.</p>

        <div class="mt-8 grid items-start gap-6 lg:grid-cols-[320px_1fr]">

            {{-- KARTU PROFIL --}}
            <aside class="overflow-hidden rounded-2xl bg-white shadow-xl shadow-brand/10 ring-1 ring-black/5">
                <div class="h-24 bg-gradient-to-br from-brand-soft to-brand"></div>
                <div class="-mt-12 px-6 pb-6 text-center">
                    <span class="mx-auto flex h-24 w-24 items-center justify-center rounded-full bg-brand font-head text-4xl font-extrabold text-white ring-4 ring-white">{{ $inisial }}</span>
                    <h2 class="mt-4 font-head text-xl font-bold tracking-tight">{{ $user->name }}</h2>
                    <p class="mt-1 text-sm text-gray-500">{{ $user->email }}</p>


                    @if ($jurusan)
                        <div class="mt-5 rounded-xl bg-slate-50 px-4 py-3 text-left ring-1 ring-gray-100">
                            <p class="text-xs text-gray-500">Jurusan</p>
                            <p class="mt-0.5 text-sm font-semibold">{{ $jurusan->nama_jurusan }}</p>
                            @if ($jurusan->kompetensi_keahlian)
                                <p class="mt-0.5 text-xs text-gray-500">{{ $jurusan->kompetensi_keahlian }}</p>
                            @endif
                        </div>
                    @endif
                </div>
            </aside>

            <div class="space-y-6">
                {{-- DATA IDENTITAS --}}
                <div class="rounded-2xl bg-white p-6 shadow-xl shadow-brand/10 ring-1 ring-black/5 sm:p-8">
                    <h2 class="font-head text-lg font-bold">Data Identitas</h2>
                    <dl class="mt-5 grid gap-x-8 gap-y-5 text-sm sm:grid-cols-2">
                        @foreach ($data as [$label, $nilai, $ikon])
                            <div class="flex gap-3">
                                <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-brand-mint/70">
                                    <i data-lucide="{{ $ikon }}" class="h-4 w-4"></i>
                                </span>
                                <div class="min-w-0">
                                    <dt class="text-xs text-gray-500">{{ $label }}</dt>
                                    <dd class="mt-0.5 break-words font-semibold">{{ $nilai ?: '-' }}</dd>
                                </div>
                            </div>
                        @endforeach
                    </dl>
                </div>

                {{-- RINGKASAN PEMINJAMAN --}}
                <div class="rounded-2xl bg-brand p-6 text-white shadow-xl shadow-brand/20 sm:p-8">
                    <div class="flex items-center justify-between gap-4">
                        <h2 class="font-head text-lg font-medium">Ringkasan Peminjaman</h2>
                        <a href="{{ Route::has('peminjam.riwayat.index') ? route('peminjam.riwayat.index') : '#' }}"
                           class="inline-flex items-center gap-1 text-xs text-white/70 transition hover:text-white">
                            Lihat riwayat <i data-lucide="chevron-right" class="h-3.5 w-3.5"></i>
                        </a>
                    </div>
                    <div class="mt-5 grid grid-cols-2 gap-3 sm:grid-cols-4">
                        @foreach ([['Total Pengajuan', $total], ['Menunggu', $menunggu], ['Sedang Dipinjam', $dipinjam], ['Selesai', $selesai]] as [$l, $n])
                            <div class="rounded-xl border border-white/10 bg-white/[.06] px-4 py-3.5">
                                <p class="font-head text-2xl font-bold">{{ $n }}</p>
                                <p class="mt-0.5 text-xs text-white/65">{{ $l }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection