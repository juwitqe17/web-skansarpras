{{--
    Simpan sebagai: resources/views/admin/pengajuan/_tolak.blade.php

    Pemakaian (ganti tombol/formulir "Tolak" yang lama):
        @include('admin.pengajuan._tolak', ['peminjaman' => $peminjaman])

    Hanya tampil untuk pengajuan yang masih menunggu.
--}}
@if ($peminjaman->status === 'menunggu')
    @php $dialogId = 'tolak-' . $peminjaman->id; @endphp

    <button type="button" onclick="document.getElementById('{{ $dialogId }}').showModal()"
            class="inline-flex items-center gap-2 rounded-lg border border-red-200 px-4 py-2 text-sm font-medium text-red-600 transition hover:bg-red-50">
        Tolak
    </button>

    <dialog id="{{ $dialogId }}" class="w-full max-w-md rounded-2xl p-0 shadow-xl backdrop:bg-black/40">
        <form method="POST" action="{{ route('admin.pengajuan.reject', $peminjaman) }}" class="p-6">
            @csrf
            @method('PATCH')
            <input type="hidden" name="_dialog" value="{{ $dialogId }}">

            <h3 class="text-lg font-bold">Tolak Pengajuan</h3>
            <p class="mt-1 text-sm text-gray-500">
                Tuliskan alasan penolakan. Alasan ini akan dilihat oleh peminjam.
            </p>

            <label for="alasan-{{ $peminjaman->id }}" class="mt-4 block text-sm font-semibold">Alasan penolakan</label>
            <textarea id="alasan-{{ $peminjaman->id }}" name="alasan" rows="4" minlength="5" maxlength="500" required
                      oninput="this.form.querySelector('[data-hitung]').textContent = this.value.length"
                      placeholder="Ketik alasan penolakan di sini..."
                      class="mt-1.5 w-full resize-none rounded-lg border border-gray-300 px-3 py-2 text-sm leading-relaxed focus:border-red-400 focus:outline-none focus:ring-2 focus:ring-red-100">{{ old('_dialog') === $dialogId ? old('alasan') : '' }}</textarea>
            <p class="mt-1 text-right text-xs text-gray-400"><span data-hitung>{{ old('_dialog') === $dialogId ? mb_strlen((string) old('alasan')) : 0 }}</span>/500</p>

            @if ($errors->has('alasan') && old('_dialog') === $dialogId)
                <p class="mt-1 text-xs text-red-600">{{ $errors->first('alasan') }}</p>
            @endif

            <div class="mt-5 flex justify-end gap-2">
                <button type="button" onclick="this.closest('dialog').close()"
                        class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-50">
                    Batal
                </button>
                <button type="submit"
                        class="rounded-lg bg-red-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-red-700">
                    Tolak Pengajuan
                </button>
            </div>
        </form>
    </dialog>

    {{-- Buka kembali dialog jika validasi gagal --}}
    @if ($errors->has('alasan') && old('_dialog') === $dialogId)
        <script>document.getElementById('{{ $dialogId }}').showModal();</script>
    @endif
@endif