@extends('layouts.peminjam')
@section('title', 'Peminjaman | SkanSarpras')

@section('content')
@php
    $ph = 'bg-gradient-to-br from-brand-mint to-brand-soft/30 text-transparent ring-1 ring-black/5';
    $dipilih = old('sarana_id', request('sarana'));
    // Peminjaman hanya untuk hari ini, dan waktu selesai maksimal pukul 15.00 (WIB)
    $sekarang = now('Asia/Jakarta');
    $hariIni = $sekarang->toDateString();
    $batasJam = '15:00';
    $sudahTutup = $sekarang->format('H:i') >= $batasJam;

    // Jika controller sudah mengirim $saranas, itu yang dipakai. Jika tidak, ambil langsung (hanya baca).
    $saranas = $saranas ?? \App\Models\Sarana::orderBy('nama_sarana')->get();
    $aksi = Route::has('peminjam.pengajuan.store') ? route('peminjam.pengajuan.store') : '#';
@endphp

<section class="min-h-[calc(100vh-3.5rem)] rounded-b-[2rem] bg-gradient-to-b from-slate-50 to-white px-6 pb-20 pt-10 lg:px-12">
    <div class="mx-auto max-w-6xl">

        {{-- Judul --}}
        <div>
            <span class="inline-block rounded-full bg-brand-mint px-3 py-1 text-[11px] font-semibold tracking-wide">FORM PEMINJAMAN</span>
            <h1 class="mt-3 font-head text-3xl font-extrabold tracking-tight">Ajukan Peminjaman Sarana</h1>
            <p class="mt-2 max-w-xl text-sm leading-relaxed text-gray-500">
                Pilih sarana yang tersedia, tentukan jadwal dan jumlah unit, lalu isi keperluan penggunaan.
            </p>
        </div>

        {{-- Pesan sukses / error --}}
        @if (session('success'))
            <div class="mt-6 flex items-start gap-3 rounded-xl bg-brand-mint px-4 py-3 text-sm">
                <i data-lucide="check-circle-2" class="mt-0.5 h-4 w-4 shrink-0"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif
        @if ($sudahTutup)
            <div class="mt-6 flex items-start gap-3 rounded-xl bg-amber-50 px-4 py-3 text-sm text-amber-800">
                <i data-lucide="clock" class="mt-0.5 h-4 w-4 shrink-0"></i>
                <span>Peminjaman hari ini sudah ditutup (batas pukul 15.00). Silakan ajukan kembali pada jam operasional berikutnya.</span>
            </div>
        @endif
        @if ($errors->any())
            <div class="mt-6 flex items-start gap-3 rounded-xl bg-red-50 px-4 py-3 text-sm text-red-700">
                <i data-lucide="alert-circle" class="mt-0.5 h-4 w-4 shrink-0"></i>
                <span>Pengajuan belum bisa dikirim. Periksa kembali isian yang ditandai merah.</span>
            </div>
        @endif

        <form method="POST" action="{{ $aksi }}" class="mt-8 grid items-start gap-8 lg:grid-cols-3">
            @csrf

            <div class="space-y-8 lg:col-span-2">

                {{-- 1. PILIH SARANA --}}
                <div class="rounded-2xl bg-white p-6 shadow-xl shadow-brand/10 ring-1 ring-black/5">
                    <div class="flex items-center gap-3">
                        <span class="flex h-7 w-7 items-center justify-center rounded-full bg-brand text-xs font-bold text-white">1</span>
                        <h2 class="font-head text-lg font-bold">Pilih Sarana</h2>
                    </div>

                    <div class="mt-5 grid gap-4 sm:grid-cols-2">
                        @forelse ($saranas as $s)
                            @php
                                $ada = $s->status === 'tersedia' && $s->jumlah_tersedia > 0;
                                $foto = \App\Support\SaranaFoto::url($s);
                            @endphp
                            <label class="relative block {{ $ada ? 'cursor-pointer' : 'cursor-not-allowed' }}">
                                <input type="radio" name="sarana_id" value="{{ $s->id }}"
                                       data-nama="{{ $s->nama_sarana }}" data-max="{{ $s->jumlah_tersedia }}"
                                       class="peer sr-only" required
                                       {{ (string) $dipilih === (string) $s->id && $ada ? 'checked' : '' }}
                                       {{ $ada ? '' : 'disabled' }}>

                                <div class="rounded-2xl border border-gray-200 bg-white p-4 transition
                                            hover:border-brand-soft
                                            peer-checked:border-brand peer-checked:ring-2 peer-checked:ring-brand
                                            peer-focus-visible:ring-2 peer-focus-visible:ring-brand-soft
                                            peer-disabled:opacity-50">
                                    <img @if ($foto) src="{{ $foto }}" @endif alt="{{ $s->nama_sarana }}" onerror="this.removeAttribute('src')"
                                         class="h-28 w-full rounded-lg object-contain {{ $ph }}">
                                    <p class="mt-3 font-head text-[15px] font-bold leading-snug">{{ $s->nama_sarana }}</p>
                                    @if ($s->deskripsi)
                                        <p class="mt-1 text-xs leading-relaxed text-gray-500">{{ \Illuminate\Support\Str::limit($s->deskripsi, 70) }}</p>
                                    @endif
                                    @if ($s->lokasi)
                                        <p class="mt-2 flex items-center gap-1.5 text-xs text-gray-500">
                                            <i data-lucide="map-pin" class="h-3.5 w-3.5"></i> {{ $s->lokasi }}
                                        </p>
                                    @endif
                                    <p class="mt-3 flex items-center gap-2 text-xs">
                                        <span class="h-2 w-2 rounded-full {{ $ada ? 'bg-green-500' : 'bg-red-400' }}"></span>
                                        {{ $ada ? 'Tersedia · ' . $s->jumlah_tersedia . ' unit' : 'Tidak tersedia' }}
                                    </p>
                                </div>

                                {{-- Centang saat dipilih --}}
                                <span class="absolute right-3 top-3 hidden h-6 w-6 items-center justify-center rounded-full bg-brand text-white peer-checked:flex">
                                    <i data-lucide="check" class="h-3.5 w-3.5"></i>
                                </span>
                            </label>
                        @empty
                            <p class="col-span-full py-8 text-center text-sm text-gray-400">Belum ada sarana yang terdaftar.</p>
                        @endforelse
                    </div>
                    @error('sarana_id') <p class="mt-3 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                {{-- 2. DETAIL PEMINJAMAN --}}
                <div class="rounded-2xl bg-white p-6 shadow-xl shadow-brand/10 ring-1 ring-black/5">
                    <div class="flex items-center gap-3">
                        <span class="flex h-7 w-7 items-center justify-center rounded-full bg-brand text-xs font-bold text-white">2</span>
                        <h2 class="font-head text-lg font-bold">Detail Peminjaman</h2>
                    </div>

                    <div class="mt-5 grid gap-5 sm:grid-cols-3">
                        <div class="sm:col-span-3">
                            <label for="jumlah" class="text-sm font-semibold">Jumlah Unit</label>
                            <input type="number" id="jumlah" name="jumlah" min="1" value="{{ old('jumlah', 1) }}" required
                                   class="mt-1.5 w-full rounded-lg border border-gray-200 bg-white px-3.5 py-2.5 text-sm outline-none transition focus:border-brand focus:ring-2 focus:ring-brand-mint sm:w-40">
                            <p id="jumlah-info" class="mt-1.5 text-xs text-gray-400">Pilih sarana terlebih dahulu.</p>
                            @error('jumlah') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="tanggal_peminjaman" class="text-sm font-semibold">Tanggal Peminjaman</label>
                            <input type="date" id="tanggal_peminjaman" name="tanggal_peminjaman"
                                   min="{{ $hariIni }}" max="{{ $hariIni }}" value="{{ $hariIni }}" readonly required
                                   class="mt-1.5 w-full cursor-not-allowed rounded-lg border border-gray-200 bg-slate-50 px-3.5 py-2.5 text-sm text-gray-600 outline-none">
                            <p class="mt-1.5 text-xs text-gray-400">Hanya untuk hari ini.</p>
                            @error('tanggal_peminjaman') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="waktu_mulai" class="text-sm font-semibold">Waktu Mulai</label>
                            <input type="time" id="waktu_mulai" name="waktu_mulai" max="14:59" value="{{ old('waktu_mulai') }}" required
                                   class="mt-1.5 w-full rounded-lg border border-gray-200 bg-white px-3.5 py-2.5 text-sm outline-none transition focus:border-brand focus:ring-2 focus:ring-brand-mint">
                            @error('waktu_mulai') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="waktu_selesai" class="text-sm font-semibold">Waktu Selesai</label>
                            <input type="time" id="waktu_selesai" name="waktu_selesai" max="{{ $batasJam }}" value="{{ old('waktu_selesai') }}" required
                                   class="mt-1.5 w-full rounded-lg border border-gray-200 bg-white px-3.5 py-2.5 text-sm outline-none transition focus:border-brand focus:ring-2 focus:ring-brand-mint">
                            <p class="mt-1.5 text-xs text-gray-400">Maksimal pukul 15.00.</p>
                            @error('waktu_selesai') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div class="sm:col-span-3">
                            <label for="keperluan" class="text-sm font-semibold">Keperluan Penggunaan</label>
                            <textarea id="keperluan" name="keperluan" rows="4" required
                                      placeholder="Contoh: Praktikum desain grafis kelas XI RPL 2"
                                      class="mt-1.5 w-full resize-none rounded-lg border border-gray-200 bg-white px-3.5 py-2.5 text-sm leading-relaxed outline-none transition placeholder:text-gray-400 focus:border-brand focus:ring-2 focus:ring-brand-mint">{{ old('keperluan') }}</textarea>
                            @error('keperluan') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- RINGKASAN --}}
            <aside class="rounded-2xl bg-brand p-6 text-white shadow-xl shadow-brand/20 lg:sticky lg:top-24">
                <div class="inline-flex h-10 w-10 items-center justify-center rounded-lg bg-white/10">
                    <i data-lucide="clipboard-check" class="h-4 w-4"></i>
                </div>
                <h2 class="mt-4 font-head text-xl font-medium">Ringkasan Pengajuan</h2>

                <dl class="mt-5 space-y-4 text-sm">
                    <div>
                        <dt class="text-white/60">Sarana</dt>
                        <dd id="ringkas-sarana" class="mt-0.5 font-semibold">Belum dipilih</dd>
                    </div>
                    <div>
                        <dt class="text-white/60">Jumlah</dt>
                        <dd id="ringkas-jumlah" class="mt-0.5 font-semibold">-</dd>
                    </div>
                    <div>
                        <dt class="text-white/60">Jadwal</dt>
                        <dd id="ringkas-jadwal" class="mt-0.5 font-semibold">-</dd>
                    </div>
                </dl>

                <p class="mt-5 text-xs leading-relaxed text-white/60">
                    Pengajuan akan diperiksa oleh admin. Status dan hasilnya dapat dilihat di notifikasi dan menu Riwayat Pengajuan.
                </p>

                <button type="submit" {{ $sudahTutup ? 'disabled' : '' }}
                        class="mt-6 inline-flex w-full items-center justify-center gap-2 rounded-lg bg-gray-100 px-6 py-3 text-sm font-medium text-brand transition hover:bg-white disabled:cursor-not-allowed disabled:opacity-50 disabled:hover:bg-gray-100">
                    <i data-lucide="send" class="h-4 w-4"></i> Kirim Pengajuan
                </button>
            </aside>
        </form>
    </div>
</section>

<script>
(function () {
    const $ = (id) => document.getElementById(id);
    const jumlah = $('jumlah'), tanggal = $('tanggal_peminjaman');
    const mulai = $('waktu_mulai'), selesai = $('waktu_selesai');

    function tanggalIndo(v) {
        const d = new Date(v + 'T00:00:00');
        return d.toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
    }

    function perbarui() {
        const r = document.querySelector('input[name="sarana_id"]:checked');

        // Waktu selesai: tidak sebelum waktu mulai, maksimal 15:00
        if (mulai.value) selesai.min = mulai.value;
        if (selesai.value && selesai.value > '15:00') selesai.value = '15:00';

        if (r) {
            const max = parseInt(r.dataset.max, 10) || 1;
            jumlah.max = max;
            if (parseInt(jumlah.value, 10) > max) jumlah.value = max;
            $('jumlah-info').textContent = 'Maksimal ' + max + ' unit tersedia.';
            $('ringkas-sarana').textContent = r.dataset.nama;
            $('ringkas-jumlah').textContent = (jumlah.value || 1) + ' unit';
        } else {
            $('ringkas-sarana').textContent = 'Belum dipilih';
            $('ringkas-jumlah').textContent = '-';
        }

        if (tanggal.value && mulai.value && selesai.value) {
            $('ringkas-jadwal').textContent = tanggalIndo(tanggal.value) + ', ' + mulai.value + ' – ' + selesai.value;
        } else if (tanggal.value) {
            $('ringkas-jadwal').textContent = tanggalIndo(tanggal.value);
        } else {
            $('ringkas-jadwal').textContent = '-';
        }
    }

    document.querySelectorAll('input[name="sarana_id"]').forEach((el) => el.addEventListener('change', perbarui));
    [jumlah, tanggal, mulai, selesai].forEach((el) => el.addEventListener('input', perbarui));
    perbarui();
})();
</script>
@endsection