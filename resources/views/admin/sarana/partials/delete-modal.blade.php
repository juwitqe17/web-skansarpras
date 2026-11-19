{{-- DELETE MODAL --}}
<div
    id="deleteModal"
    class="fixed inset-0 z-[100] hidden items-center justify-center bg-black/40 px-4"
>
    <div
        class="w-full max-w-lg overflow-hidden rounded-2xl bg-white shadow-2xl"
        onclick="event.stopPropagation()"
    >

        {{-- HEADER --}}
        <div class="flex items-center justify-between border-b border-gray-100 px-6 py-5">
            <div>
                <h2 class="text-lg font-semibold text-gray-900">
                    Hapus Data Sarana
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Periksa data sebelum menghapus.
                </p>
            </div>

            <button
                type="button"
                onclick="closeDeleteModal()"
                class="rounded-lg p-2 text-gray-400 transition hover:bg-gray-100 hover:text-gray-700"
            >
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M6 18L18 6M6 6l12 12"
                    />
                </svg>
            </button>
        </div>


        {{-- CONTENT --}}
        <div class="p-6">

            {{-- IDENTITAS SARANA --}}
            <div class="flex gap-4">

                {{-- GAMBAR --}}
                <div class="h-24 w-24 shrink-0 overflow-hidden rounded-xl bg-gray-100">

                    <img
                        id="deleteImage"
                        src=""
                        alt=""
                        class="hidden h-full w-full object-cover"
                    >

                    <div
                        id="deleteImagePlaceholder"
                        class="flex h-full w-full items-center justify-center text-xs text-gray-400"
                    >
                        Tidak ada gambar
                    </div>

                </div>


                {{-- NAMA + KODE --}}
                <div class="min-w-0 py-1">

                    <h3
                        id="deleteName"
                        class="text-base font-semibold text-gray-900"
                    ></h3>

                    <p
                        id="deleteCode"
                        class="mt-1 text-sm text-gray-500"
                    ></p>

                </div>

            </div>


            {{-- DETAIL --}}
            <div class="mt-6 grid grid-cols-2 gap-3">

                {{-- JUMLAH --}}
                <div class="rounded-xl bg-gray-50 p-4">
                    <p class="text-xs text-gray-500">
                        Jumlah Unit
                    </p>

                    <p
                        id="deleteJumlah"
                        class="mt-1 text-sm font-semibold text-gray-900"
                    ></p>
                </div>


                {{-- TERSEDIA --}}
                <div class="rounded-xl bg-gray-50 p-4">
                    <p class="text-xs text-gray-500">
                        Tersedia
                    </p>

                    <p
                        id="deleteTersedia"
                        class="mt-1 text-sm font-semibold text-gray-900"
                    ></p>
                </div>


                {{-- KONDISI --}}
                <div class="col-span-2 rounded-xl bg-gray-50 p-4">
                    <p class="text-xs text-gray-500">
                        Kondisi
                    </p>

                    <p
                        id="deleteKondisi"
                        class="mt-1 text-sm font-semibold capitalize text-gray-900"
                    ></p>
                </div>

            </div>


            {{-- WARNING --}}
            <div class="mt-5 rounded-xl border border-red-100 bg-red-50 p-4">
                <p class="text-sm leading-5 text-red-700">
                    Data sarana ini akan dihapus secara permanen dan tidak dapat
                    dikembalikan.
                </p>
            </div>

        </div>


        {{-- FOOTER --}}
        <div class="flex justify-end gap-3 border-t border-gray-100 bg-gray-50 px-6 py-4">

            {{-- BATAL --}}
            <button
                type="button"
                onclick="closeDeleteModal()"
                class="rounded-xl border border-gray-200 bg-white px-5 py-2.5 text-sm font-medium text-gray-700 transition hover:bg-gray-100"
            >
                Batal
            </button>


            {{-- FORM DELETE --}}
            <form
                id="deleteForm"
                action=""
                method="POST"
            >
                @csrf
                @method('DELETE')

                <button
                    type="submit"
                    class="rounded-xl bg-red-600 px-5 py-2.5 text-sm font-medium text-white transition hover:bg-red-700"
                >
                    Hapus Data
                </button>
            </form>

        </div>

    </div>
</div>


{{-- JAVASCRIPT --}}
<script>
    function openDeleteModal(
        id,
        nama,
        kode,
        jumlah,
        tersedia,
        kondisi,
        gambar
    ) {
        const modal = document.getElementById('deleteModal');

        // Isi data sarana
        document.getElementById('deleteName').textContent = nama;
        document.getElementById('deleteCode').textContent = kode;
        document.getElementById('deleteJumlah').textContent = jumlah + ' unit';
        document.getElementById('deleteTersedia').textContent = tersedia + ' unit';

        // Format kondisi
        document.getElementById('deleteKondisi').textContent =
            kondisi.replaceAll('_', ' ');


        // Gambar
        const image = document.getElementById('deleteImage');
        const placeholder = document.getElementById('deleteImagePlaceholder');

        if (gambar) {
            image.src = gambar;
            image.classList.remove('hidden');
            placeholder.classList.add('hidden');
        } else {
            image.src = '';
            image.classList.add('hidden');
            placeholder.classList.remove('hidden');
        }


        // Tentukan URL delete
        document.getElementById('deleteForm').action =
            `/admin/sarana/${id}`;


        // Tampilkan modal
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }


    function closeDeleteModal() {
        const modal = document.getElementById('deleteModal');

        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }


    // Klik area luar modal untuk menutup
    document.getElementById('deleteModal').addEventListener('click', function (event) {
        if (event.target === this) {
            closeDeleteModal();
        }
    });


    // Tekan Escape untuk menutup
    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            closeDeleteModal();
        }
    });
</script>
