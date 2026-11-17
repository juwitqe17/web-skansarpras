@extends('layouts.peminjam')
@section('title', 'Pengajuan Saya | SkanSarpras')

@section('content')
@php
    $badge = [
        'menunggu'        => ['Menunggu',        'bg-amber-100 text-amber-700'],
        'disetujui'       => ['Disetujui',       'bg-green-100 text-green-700'],
        'ditolak'         => ['Ditolak',         'bg-red-100 text-red-700'],
        'sedang_dipinjam' => ['Sedang Dipinjam', 'bg-blue-100 text-blue-700'],
        'selesai'         => ['Selesai',         'bg-gray-100 text-gray-700'],
        'terlambat'       => ['Terlambat',       'bg-orange-100 text-orange-700'],
        'dibatalkan'      => ['Dibatalkan',      'bg-gray-100 text-gray-500'],
    ];
@endphp

<section class="min-h-[calc(100vh-3.5rem)] rounded-b-[2rem] bg-gradient-to-b from-slate-50 to-white px-6 pb-20 pt-10 lg:px-12">
    <div class="mx-auto max-w-6xl">

        {{-- Judul --}}
        <div class="flex flex-wrap items-end justify-between gap-4">
            <div>
                <span class="inline-block rounded-full bg-brand-mint px-3 py-1 text-[11px] font-semibold tracking-wide">PENGAJUAN SAYA</span>
                <h1 class="mt-3 font-head text-3xl font-extrabold tracking-tight">Daftar Pengajuan Peminjaman</h1>
                <p class="mt-2 max-w-xl text-sm leading-relaxed text-gray-500">
                    Pantau status pengajuan Anda. Pengajuan yang masih menunggu masih bisa dibatalkan.
                </p>
            </div>
            <a href="{{ route('peminjam.pengajuan.create') }}"
               class="inline-flex items-center gap-2 rounded-lg bg-brand px-5 py-2.5 text-sm font-medium text-white shadow-md shadow-brand/20 transition hover:bg-brand-soft">
                <i data-lucide="plus" class="h-4 w-4"></i> Ajukan Peminjaman
            </a>
        </div>

        {{-- Pesan --}}
        @if (session('success'))
            <div class="mt-6 flex items-start gap-3 rounded-xl bg-brand-mint px-4 py-3 text-sm">
                <i data-lucide="check-circle-2" class="mt-0.5 h-4 w-4 shrink-0"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif
        @if (session('error'))
            <div class="mt-6 flex items-start gap-3 rounded-xl bg-red-50 px-4 py-3 text-sm text-red-700">
                <i data-lucide="alert-circle" class="mt-0.5 h-4 w-4 shrink-0"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        {{-- Tabel --}}
        <div class="mt-8 overflow-hidden rounded-2xl bg-white shadow-xl shadow-brand/10 ring-1 ring-black/5">
            <div class="overflow-x-auto">
                <table class="min-w-full text-left text-sm">
                    <thead class="bg-slate-50 text-xs uppercase tracking-wide text-gray-500">
                        <tr>
                            <th class="px-5 py-3.5 font-semibold">Diajukan</th>
                            <th class="px-5 py-3.5 font-semibold">Sarana</th>
                            <th class="px-5 py-3.5 font-semibold">Jadwal</th>
                            <th class="px-5 py-3.5 font-semibold">Keperluan</th>
                            <th class="px-5 py-3.5 font-semibold">Status</th>
                            <th class="px-5 py-3.5 text-right font-semibold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($pengajuans as $p)
                            @php
                                $namaSarana = $p->detailPeminjamans->map(function ($d) {
                                    $nama = $d->sarana->nama_sarana ?? null;
                                    return $nama ? $nama . ' (' . ($d->jumlah ?? 1) . ' unit)' : null;
                                })->filter()->join(', ');

                                [$labelStatus, $kelasStatus] = $badge[$p->status] ?? [ucfirst(str_replace('_', ' ', $p->status)), 'bg-gray-100 text-gray-700'];
                            @endphp
                            <tr class="align-top transition hover:bg-slate-50/70">
                                <td class="whitespace-nowrap px-5 py-4 text-gray-600">
                                    {{ \Carbon\Carbon::parse($p->tanggal_pengajuan)->format('d/m/Y') }}
                                </td>
                                <td class="px-5 py-4 font-semibold">{{ $namaSarana ?: '-' }}</td>
                                <td class="whitespace-nowrap px-5 py-4 text-gray-600">
                                    {{ \Carbon\Carbon::parse($p->tanggal_peminjaman)->format('d/m/Y') }}
                                    <span class="block text-xs text-gray-400">
                                        {{ substr($p->waktu_mulai, 0, 5) }} – {{ substr($p->waktu_selesai, 0, 5) }}
                                    </span>
                                </td>
                                <td class="max-w-xs px-5 py-4 text-gray-600">
                                    {{ \Illuminate\Support\Str::limit($p->keperluan, 60) }}
                                </td>
                                <td class="px-5 py-4">
                                    <span class="inline-block rounded-full px-2.5 py-1 text-[11px] font-semibold {{ $kelasStatus }}">{{ $labelStatus }}</span>
                                </td>
                                <td class="px-5 py-4">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('peminjam.pengajuan.show', $p) }}"
                                           class="inline-flex items-center gap-1.5 rounded-lg px-3 py-1.5 text-xs font-medium ring-1 ring-gray-200 transition hover:bg-brand-mint">
                                            <i data-lucide="eye" class="h-3.5 w-3.5"></i> Detail
                                        </a>

                                        @if ($p->status === 'menunggu')
                                            <form method="POST" action="{{ route('peminjam.pengajuan.cancel', $p) }}"
                                                  onsubmit="return confirm('Batalkan pengajuan ini?')">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit"
                                                        class="inline-flex items-center gap-1.5 rounded-lg px-3 py-1.5 text-xs font-medium text-red-600 ring-1 ring-red-200 transition hover:bg-red-50">
                                                    <i data-lucide="x-circle" class="h-3.5 w-3.5"></i> Batalkan
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-5 py-16 text-center text-gray-400">
                                    <i data-lucide="inbox" class="mx-auto mb-3 h-8 w-8"></i>
                                    <p class="text-sm">Belum ada pengajuan.</p>
                                    <a href="{{ route('peminjam.pengajuan.create') }}" class="mt-2 inline-block text-sm font-medium text-brand hover:underline">Ajukan peminjaman pertama Anda</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if ($pengajuans->hasPages())
            <div class="mt-6">{{ $pengajuans->links() }}</div>
        @endif
    </div>
</section>
@endsection