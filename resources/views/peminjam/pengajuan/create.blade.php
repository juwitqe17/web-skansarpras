@extends('layouts.peminjam')
@section('title', 'Ajukan Peminjaman | SkanSarpras')

@section('content')
@php
    $u = auth()->user();
    $nama  = data_get($u, 'name', '-');
    $kelas = data_get($u, 'kelas.nama_kelas') ?? data_get($u, 'kelas.nama') ?? (is_scalar(data_get($u, 'kelas')) ? data_get($u, 'kelas') : null) ?? data_get($u, 'siswa.kelas') ?? '-';
    $nis   = data_get($u, 'nis') ?? data_get($u, 'siswa.nis') ?? '-';

    // Dari controller: $saranas (yang tersedia) dan opsional $sarana (terpilih). Kolom dibaca fleksibel.
    $pilihan = ($saranas ?? $daftarSarana ?? $saranaList ?? $sarana_list ?? collect())->map(fn ($s) => (object) [
        'id'   => $s->id,
        'nama' => data_get($s, 'nama') ?? data_get($s, 'nama_sarana') ?? data_get($s, 'nama_barang') ?? 'Tanpa nama',
        'kat'  => data_get($s, 'kategori.nama_kategori') ?? data_get($s, 'kategori.nama') ?? (is_scalar(data_get($s, 'kategori')) ? data_get($s, 'kategori') : '-'),
        'stok' => (int) (data_get($s, 'stok') ?? data_get($s, 'jumlah') ?? data_get($s, 'jumlah_tersedia') ?? 1),
    ]);
    if ($pilihan->isEmpty()) {
        $pilihan = collect([[1, 'Laptop Macbook M1 Air', 'Elektronik & Laptop', 5], [2, 'Proyektor Epson', 'Elektronik & Laptop', 3], [3, 'Multimeter Digital', 'Peralatan Lab', 12]])
            ->map(fn ($r) => (object) ['id' => $r[0], 'nama' => $r[1], 'kat' => $r[2], 'stok' => $r[3]]);
    }
    $terpilih = ($sarana ?? $saranaTerpilih ?? null) instanceof \Illuminate\Database\Eloquent\Model ? ($sarana ?? $saranaTerpilih)->id : null;
    $dipilih = old('sarana_id', request('sarana', $terpilih));
    $in = 'w-full rounded-xl border border-gray-200 bg-white px-4 py-3 text-sm outline-none transition placeholder:text-gray-400 focus:border-brand-soft focus:ring-4 focus:ring-brand-mint/70';
@endphp

<section class="bg-gradient-to-b from-slate-50 to-white px-6 pb-20 pt-12 lg:px-12">
    <div class="mx-auto max-w-4xl">
        <h1 class="font-head text-3xl font-bold tracking-tight lg:text-4xl">Ajukan Peminjaman</h1>
        <p class="mt-3 max-w-2xl text-[15px] leading-relaxed text-gray-500">
            Lengkapi data di bawah ini. Pengajuan Anda akan diteruskan ke guru penanggung jawab dan statusnya dapat dipantau di halaman Riwayat Pengajuan.
        </p>

        @if (session('success'))
            <div class="mt-6 flex items-start gap-3 rounded-xl bg-brand-mint px-4 py-3 text-sm"><i data-lucide="circle-check" class="mt-0.5 h-4 w-4 shrink-0"></i>{{ session('success') }}</div>
        @endif
        @if ($errors->any())
            <div class="mt-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                <p class="flex items-center gap-2 font-medium"><i data-lucide="circle-alert" class="h-4 w-4"></i>Periksa kembali isian Anda:</p>
                <ul class="mt-1.5 list-inside list-disc text-red-600">@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
        @endif

        <form id="form" method="POST" action="{{ route('peminjam.pengajuan.store') }}"
              class="mt-8 overflow-hidden rounded-3xl bg-white shadow-xl shadow-brand/10 ring-1 ring-black/5">
            @csrf

            {{-- Identitas peminjam --}}
            <div class="flex items-center gap-4 border-b border-gray-100 bg-gradient-to-r from-brand-mint/70 to-slate-50 px-6 py-5 sm:px-8">
                <span class="flex h-14 w-14 shrink-0 items-center justify-center rounded-full bg-brand font-head text-xl font-bold text-white shadow-md shadow-brand/30">{{ strtoupper(substr($nama, 0, 1)) }}</span>
                <div class="min-w-0">
                    <p class="truncate font-head text-xl font-bold tracking-tight">{{ $nama }}</p>
                    <p class="mt-1 flex flex-wrap items-center gap-x-3 gap-y-1 text-sm text-gray-600">
                        <span class="inline-flex items-center gap-1.5"><i data-lucide="graduation-cap" class="h-4 w-4"></i>{{ $kelas }}</span>
                        <span class="hidden h-1 w-1 rounded-full bg-gray-400 sm:inline-block"></span>
                        <span>NIS: {{ $nis }}</span>
                    </p>
                </div>
            </div>

            <div class="space-y-6 px-6 py-8 sm:px-8">
                <div class="grid gap-6 sm:grid-cols-[1fr_140px]">
                    <div>
                        <label for="sarana" class="mb-2 block text-sm font-medium">Pilih Sarana</label>
                        <select id="sarana" name="sarana_id" required class="{{ $in }}">
                            <option value="" disabled {{ $dipilih ? '' : 'selected' }}>Pilih sarana</option>
                            @foreach ($pilihan as $p)
                                <option value="{{ $p->id }}" data-stok="{{ $p->stok }}" data-kat="{{ $p->kat }}" {{ (string) $dipilih === (string) $p->id ? 'selected' : '' }}>{{ $p->nama }}</option>
                            @endforeach
                        </select>
                        <p id="info" class="mt-2 hidden items-center gap-1.5 text-xs text-gray-500"><i data-lucide="package-check" class="h-3.5 w-3.5"></i><span></span></p>
                    </div>
                    <div>
                        <label for="jumlah" class="mb-2 block text-sm font-medium">Jumlah</label>
                        <input id="jumlah" name="jumlah" type="number" min="1" value="{{ old('jumlah', 1) }}" required class="{{ $in }}">
                    </div>
                </div>

                <div class="grid gap-6 sm:grid-cols-3">
                    <div>
                        <label for="tanggal" class="mb-2 block text-sm font-medium">Tanggal Peminjaman</label>
                        <input id="tanggal" name="tanggal_pinjam" type="date" min="{{ now()->toDateString() }}" value="{{ old('tanggal_pinjam') }}" required class="{{ $in }}">
                    </div>
                    <div>
                        <label for="mulai" class="mb-2 block text-sm font-medium">Waktu Peminjaman</label>
                        <input id="mulai" name="jam_mulai" type="time" value="{{ old('jam_mulai') }}" required class="{{ $in }}">
                    </div>
                    <div>
                        <label for="selesai" class="mb-2 block text-sm font-medium">Waktu Selesai</label>
                        <input id="selesai" name="jam_selesai" type="time" value="{{ old('jam_selesai') }}" required class="{{ $in }}">
                    </div>
                </div>

                <div>
                    <div class="mb-2 flex items-end justify-between">
                        <label for="tujuan" class="text-sm font-medium">Tujuan Peminjaman</label>
                        <span id="hitung" class="text-xs text-gray-400">0 / 300</span>
                    </div>
                    <textarea id="tujuan" name="tujuan" rows="4" maxlength="300" required placeholder="Tulis tujuan peminjaman barang..." class="{{ $in }} resize-none">{{ old('tujuan') }}</textarea>
                </div>

                <div class="flex items-start gap-3 rounded-xl bg-slate-50 px-4 py-3.5 text-[13px] leading-relaxed text-gray-600 ring-1 ring-gray-100">
                    <i data-lucide="info" class="mt-0.5 h-4 w-4 shrink-0 text-brand-soft"></i>
                    Harap mengembalikan barang tepat waktu dan dalam kondisi seperti semula. Kerusakan atau kehilangan menjadi tanggung jawab peminjam.
                </div>

                <div class="flex flex-col-reverse items-stretch justify-end gap-3 pt-2 sm:flex-row sm:items-center">
                    <a href="{{ Route::has('peminjam.sarana.index') ? route('peminjam.sarana.index') : '#' }}" class="rounded-xl px-5 py-3 text-center text-sm font-medium text-gray-600 transition hover:bg-gray-100">Kembali ke katalog</a>
                    <button id="kirim" type="submit" class="inline-flex items-center justify-center gap-2.5 rounded-xl bg-brand px-7 py-3 text-sm font-medium text-white shadow-lg shadow-brand/25 transition hover:-translate-y-0.5 hover:bg-brand-soft disabled:opacity-60">
                        <i data-lucide="hand-helping" class="h-4 w-4"></i><span>Pinjam Sarana</span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</section>

<script>
(() => {
    const $ = s => document.querySelector(s);
    const sarana = $('#sarana'), jumlah = $('#jumlah'), info = $('#info');

    function sarSelected() {
        const o = sarana.selectedOptions[0];
        if (!o || !o.dataset.stok) return info.classList.add('hidden'), info.classList.remove('flex');
        const stok = +o.dataset.stok;
        jumlah.max = stok;
        if (+jumlah.value > stok) jumlah.value = stok;
        info.classList.remove('hidden'); info.classList.add('flex');
        info.lastElementChild.textContent = `${o.dataset.kat} · stok tersedia ${stok}`;
    }
    sarana.addEventListener('change', sarSelected); sarSelected();

    const mulai = $('#mulai'), selesai = $('#selesai');
    mulai.addEventListener('change', () => { selesai.min = mulai.value; if (selesai.value && selesai.value <= mulai.value) selesai.value = ''; });

    const t = $('#tujuan'), h = $('#hitung');
    const hitung = () => h.textContent = `${t.value.length} / 300`;
    t.addEventListener('input', hitung); hitung();

    $('#form').addEventListener('submit', () => {
        const b = $('#kirim'); b.disabled = true; b.lastElementChild.textContent = 'Mengirim...';
    });
})();
</script>
@endsection