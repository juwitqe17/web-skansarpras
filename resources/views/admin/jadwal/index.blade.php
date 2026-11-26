@extends('layouts.admin')

@section('page-content')

<div class="space-y-6">

    {{-- HEADER --}}
    <div>
        <h1 class="text-2xl font-bold text-gray-900">
            Manajemen Jadwal Penggunaan
        </h1>

        <p class="mt-1 text-sm text-gray-500">
            Monitor pemakaian sarana berdasarkan jadwal penggunaan.
        </p>
    </div>


    {{-- FILTER & CONTROL --}}
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">

        {{-- BARIS 1 : PERIODE --}}
        <div class="flex flex-col gap-5">

            <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">

                {{-- PERIODE --}}
                <div>
                    <p class="mb-2 text-xs font-medium text-gray-500">
                        Periode
                    </p>

                    <div class="flex items-center gap-2">

                        <a
                            href="{{ route('admin.jadwal.index', [
                                'bulan' => $bulan->copy()->subMonth()->format('Y-m')
                            ]) }}"
                            class="flex h-10 w-10 items-center justify-center rounded-xl border border-gray-200 bg-gray-50 text-lg text-gray-500 transition hover:bg-gray-100"
                        >
                            ‹
                        </a>

                        <div
                            class="flex h-10 min-w-[160px] items-center justify-center rounded-xl border border-gray-200 bg-gray-50 px-4"
                        >
                            <p class="text-sm font-semibold text-gray-900">
                                {{ $bulan->translatedFormat('F Y') }}
                            </p>
                        </div>

                        <a
                            href="{{ route('admin.jadwal.index', [
                                'bulan' => $bulan->copy()->addMonth()->format('Y-m')
                            ]) }}"
                            class="flex h-10 w-10 items-center justify-center rounded-xl border border-gray-200 bg-gray-50 text-lg text-gray-500 transition hover:bg-gray-100"
                        >
                            ›
                        </a>

                        {{-- HARI INI --}}
                        <a
                            href="{{ route('admin.jadwal.index') }}"
                            class="ml-1 flex h-10 items-center rounded-xl border border-gray-200 bg-gray-50 px-4 text-sm font-medium text-gray-700 transition hover:bg-gray-100"
                        >
                            Hari ini
                        </a>

                        {{-- EXPORT PDF --}}
                        <a
                            href="{{ route('admin.jadwal.index', [
                                'bulan' => $bulan->format('Y-m'),
                                'jurusan_id' => $selectedJurusan,
                                'status' => $selectedStatus,
                                'search' => $search,
                            ]) }}"
                            class="ml-1 flex h-10 items-center gap-2 rounded-xl bg-[#0f2e24] px-4 text-sm font-semibold text-white transition hover:bg-[#163f32]"
                        >
                            <svg
                                class="h-4 w-4"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M12 3v12m0 0 4-4m-4 4-4-4M5 21h14"
                                />
                            </svg>

                            Export PDF
                        </a>

                    </div>
                </div>

            </div>


            {{-- BARIS 2 : FILTER & SEARCH --}}
            <div class="grid grid-cols-1 gap-4 md:grid-cols-3">

                {{-- JURUSAN --}}
                <div>
                    <p class="mb-2 text-xs font-medium text-gray-500">
                        Jurusan
                    </p>

                    <form
                        method="GET"
                        action="{{ route('admin.jadwal.index') }}"
                    >
                        <input
                            type="hidden"
                            name="bulan"
                            value="{{ $bulan->format('Y-m') }}"
                        >

                        <select
                            name="jurusan_id"
                            onchange="this.form.submit()"
                            class="h-10 w-full rounded-xl border border-gray-200 bg-gray-50 px-4 text-sm text-gray-700 focus:border-emerald-800 focus:ring-2 focus:ring-emerald-800"
                        >
                            <option value="">
                                Semua Jurusan
                            </option>

                            @foreach($jurusans as $jurusan)
                                <option
                                    value="{{ $jurusan->id }}"
                                    {{ $selectedJurusan == $jurusan->id ? 'selected' : '' }}
                                >
                                    {{ $jurusan->nama_jurusan }}
                                </option>
                            @endforeach
                        </select>
                    </form>
                </div>


                {{-- STATUS --}}
                <div>
                    <p class="mb-2 text-xs font-medium text-gray-500">
                        Status
                    </p>

                    <form
                        method="GET"
                        action="{{ route('admin.jadwal.index') }}"
                    >
                        <input
                            type="hidden"
                            name="bulan"
                            value="{{ $bulan->format('Y-m') }}"
                        >

                        @if($selectedJurusan)
                            <input
                                type="hidden"
                                name="jurusan_id"
                                value="{{ $selectedJurusan }}"
                            >
                        @endif

                        <select
                            name="status"
                            onchange="this.form.submit()"
                            class="h-10 w-full rounded-xl border border-gray-200 bg-gray-50 px-4 text-sm text-gray-700 focus:border-emerald-800 focus:ring-2 focus:ring-emerald-800"
                        >
                            <option value="">
                                Semua Status
                            </option>

                            <option
                                value="berlangsung"
                                {{ $selectedStatus === 'berlangsung' ? 'selected' : '' }}
                            >
                                Berlangsung
                            </option>

                            <option
                                value="selesai"
                                {{ $selectedStatus === 'selesai' ? 'selected' : '' }}
                            >
                                Selesai
                            </option>
                        </select>
                    </form>
                </div>


                {{-- SEARCH --}}
                <div>
                    <p class="mb-2 text-xs font-medium text-gray-500">
                        Pencarian
                    </p>

                    <form
                        method="GET"
                        action="{{ route('admin.jadwal.index') }}"
                        class="relative"
                    >
                        <input
                            type="hidden"
                            name="bulan"
                            value="{{ $bulan->format('Y-m') }}"
                        >

                        @if($selectedJurusan)
                            <input
                                type="hidden"
                                name="jurusan_id"
                                value="{{ $selectedJurusan }}"
                            >
                        @endif

                        @if($selectedStatus)
                            <input
                                type="hidden"
                                name="status"
                                value="{{ $selectedStatus }}"
                            >
                        @endif

                        <svg
                            class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="m21 21-6-6m2-5a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z"
                            />
                        </svg>

                        <input
                            type="text"
                            name="search"
                            value="{{ $search }}"
                            placeholder="Cari sarana / peminjam..."
                            class="h-10 w-full rounded-xl border border-gray-200 bg-gray-50 py-2.5 pl-9 pr-4 text-sm text-gray-700 focus:border-emerald-800 focus:ring-2 focus:ring-emerald-800"
                        >
                    </form>
                </div>

            </div>

        </div>

    </div>


    {{-- KETERANGAN STATUS --}}
    <div class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100">

        <div class="flex flex-wrap items-center gap-5 text-xs text-gray-600">

            <span class="font-semibold text-gray-700">
                Keterangan:
            </span>

            <span class="flex items-center gap-2">
                <span class="h-3 w-3 rounded-full bg-emerald-400"></span>
                Sedang Berlangsung
            </span>

            {{-- <span class="flex items-center gap-2">
                <span class="h-3 w-3 rounded-full bg-blue-500"></span>
                Terjadwal
            </span> --}}

            <span class="flex items-center gap-2">
                <span class="h-3 w-3 rounded-full bg-gray-400"></span>
                Selesai
            </span>

        </div>

    </div>

    @php
        $awalKalender = $bulan->copy()
            ->startOfMonth()
            ->startOfWeek(\Carbon\Carbon::MONDAY);

        $akhirKalender = $bulan->copy()
            ->endOfMonth()
            ->endOfWeek(\Carbon\Carbon::SUNDAY);

        $tanggalKalender = [];
        $tanggal = $awalKalender->copy();

        while ($tanggal->lte($akhirKalender)) {
            $tanggalKalender[] = $tanggal->copy();
            $tanggal->addDay();
        }

        $jadwalPerTanggal = $jadwals->groupBy(function ($jadwal) {
            return \Carbon\Carbon::parse($jadwal->tanggal)->format('Y-m-d');
        });
    @endphp


    {{-- CALENDAR --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

        {{-- HEADER HARI --}}
        <div class="grid grid-cols-7 border-b border-gray-200 bg-gray-50">

            @foreach([
                'Senin',
                'Selasa',
                'Rabu',
                'Kamis',
                'Jumat',
                'Sabtu',
                'Minggu'
            ] as $hari)

                <div class="px-4 py-3 text-center text-xs font-semibold text-gray-600">
                    {{ $hari }}
                </div>

            @endforeach

        </div>


        {{-- GRID TANGGAL --}}
        <div class="grid grid-cols-7">

            @foreach($tanggalKalender as $tanggal)

                @php
                    $tanggalKey = $tanggal->format('Y-m-d');

                    $jadwalHariIni = $jadwalPerTanggal->get(
                        $tanggalKey,
                        collect()
                    );

                    $diluarBulan = $tanggal->month !== $bulan->month;
                @endphp

                {{-- Diubah: min-h diperkecil dari 130px ke 100px agar lebih proporsional, dan warna luar bulan lebih kontras (bg-gray-100/80) --}}
                <div
                    class="relative min-h-[100px] border-b border-r border-gray-200 p-2.5
                    {{ $diluarBulan ? 'bg-gray-200/80' : 'bg-white' }}"
                >

                    {{-- NOMOR TANGGAL --}}
                    <div
                        class="mb-2 text-right text-xs font-medium
                        {{ $diluarBulan ? 'text-gray-400 font-normal' : ($tanggal->isToday() ? 'text-emerald-800 font-bold' : 'text-gray-700') }}"
                    >
                        {{ $tanggal->day }}
                    </div>


                    {{-- JADWAL --}}
                    <div class="space-y-1.5">

                        @foreach($jadwalHariIni as $jadwal)

                            @php

                                $statusClass = match($jadwal->status) {

                                    'berlangsung'
                                        => 'border-emerald-400 bg-emerald-50 text-emerald-800',

                                    'selesai'
                                        => 'border-gray-400 bg-gray-50 text-gray-600',

                                    default
                                        => 'border-blue-400 bg-blue-50 text-blue-700',

                                };

                            @endphp


                            <button
                                type="button"
                                onclick="openJadwal({{ $jadwal->id }}, event)"
                                class="jadwal-item w-full rounded-lg border-l-4 px-2 py-1.5 text-left text-xs transition hover:brightness-95 {{ $statusClass }}"
                            >

                                <div class="font-semibold truncate">
                                    {{ \Carbon\Carbon::parse($jadwal->waktu_mulai)->format('H:i') }}
                                    -
                                    {{ \Carbon\Carbon::parse($jadwal->waktu_selesai)->format('H:i') }}
                                </div>

                                <div class="mt-0.5 truncate font-medium">
                                    {{ $jadwal->sarana->nama_sarana ?? '-' }}
                                </div>

                            </button>

                        @endforeach

                    </div>

                </div>

            @endforeach

        </div>

    </div>

</div>


{{-- ========================================================= --}}
{{-- POPOVER DETAIL --}}
{{-- ========================================================= --}}

<div
    id="jadwalPopover"
    class="fixed z-[100] hidden w-[320px]"
>

    <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-xl">

        {{-- HEADER --}}
        <div class="flex items-center justify-between">

            <span
                id="popoverStatus"
                class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-800"
            >
                Berlangsung
            </span>

            <button
                type="button"
                onclick="closeJadwal()"
                class="flex h-8 w-8 items-center justify-center rounded-full text-gray-400 hover:bg-gray-100"
            >
                ×
            </button>

        </div>


        {{-- TITLE --}}
        <div class="mt-4">

            <h3
                id="popoverTitle"
                class="text-base font-bold text-gray-900"
            >
                -
            </h3>

            <p
                id="popoverSubtitle"
                class="mt-1 text-xs text-gray-400"
            >
                -
            </p>

        </div>


        {{-- DETAIL --}}
        <div class="mt-5 space-y-4">

            <div>
                <p class="text-xs font-medium text-gray-400">
                    Peminjam
                </p>

                <p
                    id="popoverPeminjam"
                    class="mt-1 text-sm text-gray-700"
                >
                    -
                </p>
            </div>


            <div>
                <p class="text-xs font-medium text-gray-400">
                    Waktu
                </p>

                <p
                    id="popoverWaktu"
                    class="mt-1 text-sm text-gray-700"
                >
                    -
                </p>
            </div>


            <div>
                <p class="text-xs font-medium text-gray-400">
                    Keperluan
                </p>

                <p
                    id="popoverKeperluan"
                    class="mt-1 text-sm leading-relaxed text-gray-700"
                >
                    -
                </p>
            </div>

        </div>


        {{-- BUTTON --}}
        <div class="mt-5 flex justify-end">
            <a
                id="popoverDetail"
                href="#"
                class="inline-flex items-center rounded-xl bg-[#0f2e24] px-3.5 py-2 text-xs font-semibold text-white transition hover:bg-[#163f32]"
            >
                Lihat Detail Peminjaman
            </a>
        </div>

    </div>

</div>

@php
    $jadwalData = $jadwals->map(function ($jadwal) {
        $pengembalianId = optional(optional($jadwal->peminjaman)->pengembalian)->id;

        $pengembalianUrl = $pengembalianId
            ? route('admin.pengembalian.show', $pengembalianId)
            : route('admin.pengembalian.index');

        return [
            'id' => $jadwal->id,
            'pengembalian_id' => $pengembalianId,
            'detail_url' => $pengembalianUrl,
            'status' => $jadwal->status,
            'nama_sarana' => $jadwal->sarana->nama_sarana ?? '-',
            'kode_sarana' => $jadwal->sarana->kode_sarana ?? '-',
            'jurusan' => $jadwal->sarana->jurusan->nama_jurusan ?? '-',
            'peminjam' => $jadwal->peminjaman->user->name ?? '-',
            'tanggal' => \Carbon\Carbon::parse($jadwal->tanggal)->translatedFormat('d F Y'),
            'waktu_mulai' => \Carbon\Carbon::parse($jadwal->waktu_mulai)->format('H:i'),
            'waktu_selesai' => \Carbon\Carbon::parse($jadwal->waktu_selesai)->format('H:i'),
            'keperluan' => $jadwal->peminjaman->keperluan ?? '-',
        ];
    });
@endphp

{{-- DATA UNTUK POPOVER --}}
<script>
    const jadwalData = @json($jadwalData);

    function openJadwal(id, event) {
        event.stopPropagation(); // Mencegah event klik langsung menutup popover

        const jadwal = jadwalData.find(item => item.id === id);
        if (!jadwal) return;

        document.getElementById('popoverTitle').textContent = jadwal.nama_sarana;
        document.getElementById('popoverSubtitle').textContent = `${jadwal.kode_sarana} • ${jadwal.jurusan}`;
        document.getElementById('popoverPeminjam').textContent = jadwal.peminjam;
        document.getElementById('popoverWaktu').textContent = `${jadwal.tanggal} • ${jadwal.waktu_mulai} - ${jadwal.waktu_selesai}`;
        document.getElementById('popoverKeperluan').textContent = jadwal.keperluan;
        document.getElementById('popoverDetail').href = `/admin/jadwal/${jadwal.id}`;

        const status = document.getElementById('popoverStatus');
        if (jadwal.status === 'berlangsung') {
            status.textContent = 'Berlangsung';
            status.className = 'rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-800';
        } else {
            status.textContent = 'Selesai';
            status.className = 'rounded-full bg-gray-100 px-3 py-1 text-xs font-semibold text-gray-600';
        }
        
        const detailLink = document.getElementById('popoverDetail');
        if (detailLink) {
            detailLink.href = jadwal.detail_url || '{{ route('admin.pengembalian.index') }}';
        }

        const popover = document.getElementById('jadwalPopover');
        popover.classList.remove('hidden');

        const button = event.currentTarget;
        const rect = button.getBoundingClientRect();

        let left = rect.left;
        let top = rect.bottom + 8;

        if (left + popover.offsetWidth > window.innerWidth - 15) {
            left = window.innerWidth - popover.offsetWidth - 15;
        }

        if (top + popover.offsetHeight > window.innerHeight - 15) {
            top = rect.top - popover.offsetHeight - 8;
        }

        popover.style.left = `${left}px`;
        popover.style.top = `${top}px`;
    }

    function closeJadwal() {
        document.getElementById('jadwalPopover').classList.add('hidden');
    }

    // Menutup popover saat halaman digulir (scroll) agar tidak stuck
    window.addEventListener('scroll', function() {
        closeJadwal();
    }, { passive: true });

    // Menutup popover ketika area luar diklik
    document.addEventListener('click', function(event) {
        const popover = document.getElementById('jadwalPopover');
        if (!popover.contains(event.target) && !event.target.closest('.jadwal-item')) {
            closeJadwal();
        }
    });
</script>
@endsection
