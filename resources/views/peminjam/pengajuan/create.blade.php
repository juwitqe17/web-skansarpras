@extends('layouts.peminjam')
@section('title', 'Peminjaman | SkanSarpras')

@section('content')
@php
    $ph = 'bg-gradient-to-br from-brand-mint to-brand-soft/30 text-transparent ring-1 ring-black/5';
    $dipilih = old('sarana_id', request('sarana'));
    // Peminjaman hanya untuk hari ini (WIB), dipilih per jam pelajaran
    $sekarang = now('Asia/Jakarta');
    $hariIni = $sekarang->toDateString();

    // ==== JAM PELAJARAN (sesuai jadwal sekolah): ubah daftar ini jika jadwal berubah ====
    // [nama, mulai, selesai, apakah istirahat]. Baris istirahat hanya ditampilkan, tidak bisa dipilih sendiri.
    $jamPelajaran = [
        ['Jam ke-1',  '06:45', '07:25', false],
        ['Jam ke-2',  '07:25', '08:05', false],
        ['Jam ke-3',  '08:05', '08:45', false],
        ['Jam ke-4',  '08:45', '09:25', false],
        ['Istirahat', '09:25', '09:40', true],
        ['Jam ke-5',  '09:40', '10:20', false],
        ['Jam ke-6',  '10:20', '11:00', false],
        ['Jam ke-7',  '11:00', '11:40', false],
        ['Jam ke-8',  '11:40', '12:20', false],
        ['Istirahat', '12:20', '12:50', true],
        ['Jam ke-9',  '12:50', '13:30', false],
        ['Jam ke-10', '13:30', '14:10', false],
        ['Jam ke-11', '14:10', '14:50', false],
    ];

    $jam = collect($jamPelajaran)->map(fn ($j) => [
        'nama' => $j[0], 'mulai' => $j[1], 'selesai' => $j[2], 'istirahat' => $j[3],
        'lewat' => $j[2] <= $sekarang->format('H:i'), // jam yang sudah berakhir tidak bisa dipilih
    ]);
    $pelajaran = $jam->where('istirahat', false)->values(); // hanya jam pelajaran yang bisa dipilih
    $jamTerakhir = $pelajaran->last()['selesai'];
    $sudahTutup = $pelajaran->every(fn ($j) => $j['lewat']);

    // Pulihkan pilihan jam jika validasi gagal
    $awalIdx = $pelajaran->search(fn ($j) => $j['mulai'] === substr((string) old('waktu_mulai'), 0, 5));
    $akhirIdx = $pelajaran->search(fn ($j) => $j['selesai'] === substr((string) old('waktu_selesai'), 0, 5));
    $pilihanLama = ($awalIdx !== false && $akhirIdx !== false && $awalIdx <= $akhirIdx)
        ? ['awal' => $awalIdx, 'akhir' => $akhirIdx] : null;

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
                <span>Peminjaman hari ini sudah ditutup (jam pelajaran terakhir berakhir pukul {{ $jamTerakhir }}). Silakan ajukan kembali pada jam operasional berikutnya.</span>
            </div>
        @endif
        @if ($errors->any())
            <div class="mt-6 flex items-start gap-3 rounded-xl bg-red-50 px-4 py-3 text-sm text-red-700">
                <i data-lucide="alert-circle" class="mt-0.5 h-4 w-4 shrink-0"></i>
                <span>Pengajuan belum bisa dikirim. Periksa kembali isian yang ditandai merah.</span>
            </div>
        @endif

        <form method="POST" action="{{ $aksi }}" class="mt-8 grid items-start gap-8 lg:grid-cols-3"
              data-konfirmasi data-konfirmasi-gaya="tanya" data-konfirmasi-judul="Kirim pengajuan?"
              data-konfirmasi-tombol="Ya" data-konfirmasi-batal="Tidak">
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
                        <div class="sm:col-span-3">
                            <div class="flex flex-wrap items-baseline justify-between gap-2">
                                <span class="text-sm font-semibold">Jam Pelajaran</span>
                                <span class="text-xs text-gray-400">Klik satu jam, lalu klik jam lain untuk memperpanjang. Jam pelajaran terakhir berakhir pukul {{ $jamTerakhir }}.</span>
                            </div>

                            <input type="hidden" id="waktu_mulai" name="waktu_mulai" value="{{ old('waktu_mulai') }}">
                            <input type="hidden" id="waktu_selesai" name="waktu_selesai" value="{{ old('waktu_selesai') }}">

                            <div id="jam-grid" class="mt-2 grid grid-cols-2 gap-2 sm:grid-cols-3 lg:grid-cols-4">
                                @foreach ($jam as $j)
                                    @if ($j['istirahat'])
                                        <div class="flex flex-col justify-center rounded-xl border border-dashed border-amber-200 bg-amber-50/60 px-3 py-2.5">
                                            <span class="block text-sm font-semibold text-amber-700">{{ $j['nama'] }}</span>
                                            <span class="mt-0.5 block text-xs text-amber-600/80">{{ $j['mulai'] }} – {{ $j['selesai'] }}</span>
                                        </div>
                                    @else
                                        <button type="button" data-mulai="{{ $j['mulai'] }}" data-selesai="{{ $j['selesai'] }}" data-nama="{{ $j['nama'] }}"
                                                {{ $j['lewat'] ? 'disabled' : '' }}
                                                class="jam rounded-xl border border-gray-200 bg-white px-3 py-2.5 text-left transition hover:border-brand-soft
                                                       disabled:cursor-not-allowed disabled:opacity-40 disabled:hover:border-gray-200">
                                            <span class="block text-sm font-semibold">{{ $j['nama'] }}</span>
                                            <span class="mt-0.5 block text-xs text-gray-500">{{ $j['mulai'] }} – {{ $j['selesai'] }}</span>
                                        </button>
                                    @endif
                                @endforeach
                            </div>

                            <p id="jam-info" class="mt-2 text-xs text-gray-500">Belum ada jam yang dipilih.</p>
                            <p id="jam-error" class="mt-1 hidden text-xs text-red-600">Pilih minimal satu jam pelajaran.</p>
                            @error('waktu_mulai') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                            @error('waktu_selesai') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
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
    [jumlah, tanggal].forEach((el) => el.addEventListener('input', perbarui));

    // ---- Pilihan jam pelajaran ----
    const jam = Array.from(document.querySelectorAll('#jam-grid .jam'));
    const jamInfo = $('jam-info');
    const pilihanLama = @json($pilihanLama);
    let awal = null, akhir = null, tahap = 0; // tahap: 0 kosong, 1 satu jam dipilih, 2 rentang jam

    function gambarJam() {
        jam.forEach((b, i) => {
            const dalam = awal !== null && i >= awal && i <= akhir;
            ['ring-2', 'ring-brand', '!border-brand', '!bg-brand-mint'].forEach((c) => b.classList.toggle(c, dalam));
        });

        if (awal === null) {
            mulai.value = '';
            selesai.value = '';
            jamInfo.textContent = 'Belum ada jam yang dipilih.';
        } else {
            mulai.value = jam[awal].dataset.mulai;
            selesai.value = jam[akhir].dataset.selesai;
            const nama = awal === akhir
                ? jam[awal].dataset.nama
                : jam[awal].dataset.nama + ' sampai ' + jam[akhir].dataset.nama;
            jamInfo.textContent = nama + ' (' + mulai.value + ' – ' + selesai.value + ')';
            $('jam-error').classList.add('hidden');
        }
        perbarui();
    }

    jam.forEach((b, i) => b.addEventListener('click', () => {
        if (tahap === 1) {
            const lo = Math.min(awal, i), hi = Math.max(awal, i);
            if (jam.slice(lo, hi + 1).some((x) => x.disabled)) { awal = akhir = i; tahap = 1; }
            else { awal = lo; akhir = hi; tahap = 2; }
        } else {
            awal = akhir = i; tahap = 1; // klik pertama, atau mulai ulang setelah rentang dipilih
        }
        gambarJam();
    }));

    if (pilihanLama) { awal = pilihanLama.awal; akhir = pilihanLama.akhir; tahap = 2; }
    gambarJam();

    mulai.form.addEventListener('submit', (e) => {
        if (!mulai.value || !selesai.value) {
            e.preventDefault();
            $('jam-error').classList.remove('hidden');
            $('jam-grid').scrollIntoView({ behavior: 'smooth', block: 'center' });
            return;
        }

        // Isi pesan dialog konfirmasi dengan ringkasan pengajuan
        const r = document.querySelector('input[name="sarana_id"]:checked');
        mulai.form.dataset.konfirmasiPesan =
            (r ? r.dataset.nama : 'Sarana') + ' · ' + (jumlah.value || 1) + ' unit · ' + $('ringkas-jadwal').textContent +
            '. Pengajuan akan dikirim ke admin untuk diperiksa.';
    });
})();
</script>
@endsection