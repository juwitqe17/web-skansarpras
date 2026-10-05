<header class="sticky top-0 z-20 flex items-center justify-between bg-white px-6 lg:px-8 h-16 border-b border-gray-200">
            <span class="font-head font-extrabold text-xl">SkanSarpras</span>
            <div class="flex items-center gap-6 text-sm">
                <span class="hidden sm:flex items-center gap-1.5"><i data-lucide="graduation-cap" class="w-5 h-5"></i>
                    Jurusan: {{ auth()->user()->jurusan->nama_jurusan ?? '-' }}</span>
                <button aria-label="Notifikasi"><i data-lucide="bell" class="w-5 h-5"></i></button>
                <button aria-label="Profil"><i data-lucide="circle-user-round" class="w-8 h-8"></i></button>
            </div>
        </header>