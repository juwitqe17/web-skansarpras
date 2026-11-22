<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login - SkanSarpras</title>

    {{-- Font: Bricolage Grotesque (judul) + Figtree (isi) --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .font-display { font-family: 'Work Sans', 'Figtree', ui-sans-serif, system-ui, sans-serif; }
        .font-body    { font-family: 'Work Sans', ui-sans-serif, system-ui, sans-serif; }

        /* Satu momen animasi: kartu peminjaman naik satu per satu saat halaman dibuka */
        @keyframes card-rise {
            from { opacity: 0; transform: translateY(22px) scale(.97); }
            to   { opacity: 1; transform: translateY(0) scale(1); }
        }
        .card-rise {
            opacity: 0;
            animation: card-rise .7s cubic-bezier(.2, .8, .2, 1) forwards;
        }

        @media (prefers-reduced-motion: reduce) {
            .card-rise { animation: none; opacity: 1; }
        }
    </style>
</head>

<body class="font-body relative min-h-screen overflow-x-hidden bg-[#f8f3ed] flex items-center justify-center px-5 py-10">

    {{-- Dekorasi latar halaman --}}
    <div class="pointer-events-none absolute -left-40 top-0 h-[420px] w-[420px] rounded-full bg-[#4eb18f]/15 blur-3xl"></div>
    <div class="pointer-events-none absolute -bottom-40 -right-32 h-[460px] w-[460px] rounded-full bg-[#32846b]/15 blur-3xl"></div>

    <div class="relative w-full max-w-[1000px] overflow-hidden rounded-[22px] bg-white shadow-[0_40px_80px_-30px_rgba(23,63,52,0.45)] ring-1 ring-[#173f34]/5">

        <div class="grid min-h-[600px] md:grid-cols-[1.38fr_1fr]">

            {{-- =========================
                BAGIAN KIRI
            ========================== --}}
            <div
                class="relative flex flex-col justify-between gap-10 overflow-hidden bg-gradient-to-br from-[#4eb18f] via-[#32846b] to-[#173f34] px-8 py-10 sm:px-12 md:px-14 md:py-12"
            >

                {{-- Efek dekorasi --}}
                <div
                    class="absolute -left-32 -top-32 h-80 w-80 rounded-full bg-white/10 blur-3xl"
                ></div>

                <div
                    class="absolute -bottom-40 -right-32 h-96 w-96 rounded-full bg-black/10 blur-3xl"
                ></div>

                {{-- Pola titik halus --}}
                <div
                    class="pointer-events-none absolute inset-0"
                    style="
                        background-image: radial-gradient(rgba(255,255,255,.16) 1px, transparent 1px);
                        background-size: 22px 22px;
                        -webkit-mask-image: linear-gradient(135deg, #000 0%, transparent 65%);
                        mask-image: linear-gradient(135deg, #000 0%, transparent 65%);
                    "
                ></div>

                {{-- Brand --}}
                <div class="relative z-10 flex items-center gap-3 text-white">
                    <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-white p-1.5 shadow-md ring-1 ring-white/25">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo SMK" class="h-full w-full object-contain">
                    </span>
                    <span class="font-display text-lg font-bold tracking-tight">SkanSarpras</span>
                </div>

                {{-- Text --}}
                <div class="relative z-10 max-w-[410px] text-white">

                    <h1 class="font-display text-4xl font-extrabold leading-[1.1] tracking-tight md:text-[52px]">
                        Halo, Selamat<br>
                        Datang!
                    </h1>

                    <p class="mt-5 max-w-[350px] text-[15px] font-medium leading-relaxed text-white/90">
                        Gunakan akun akademik Anda untuk mengakses dan
                        mengelola peminjaman sarana prasarana sekolah.
                    </p>

                </div>

                {{-- Contoh kartu peminjaman (hanya hiasan) --}}
                <div class="relative z-10 hidden space-y-3 md:block" aria-hidden="true">

                    {{-- Kartu 1 --}}
                    <div
                        class="card-rise flex max-w-[330px] items-center gap-3 rounded-2xl bg-white/15 p-3.5 text-white shadow-[0_18px_40px_-18px_rgba(0,0,0,0.5)] ring-1 ring-white/25 backdrop-blur-md"
                        style="animation-delay: .15s"
                    >
                        <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-white text-[#173f34]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </span>
                        <div class="min-w-0 flex-1">
                            <p class="truncate text-sm font-semibold">Laboratorium Komputer</p>
                            <p class="text-xs text-white/75">Rabu, 08.00 – 10.00</p>
                        </div>
                        <span class="shrink-0 rounded-full bg-white px-2.5 py-1 text-[11px] font-bold text-[#173f34]">
                            Disetujui
                        </span>
                    </div>

                    {{-- Kartu 2 --}}
                    <div
                        class="card-rise ml-10 flex max-w-[330px] items-center gap-3 rounded-2xl bg-white/15 p-3.5 text-white shadow-[0_18px_40px_-18px_rgba(0,0,0,0.5)] ring-1 ring-white/25 backdrop-blur-md"
                        style="animation-delay: .35s"
                    >
                        <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-white/90 text-[#32846b]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 10l4.55-2.28A1 1 0 0121 8.62v6.76a1 1 0 01-1.45.9L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                            </svg>
                        </span>
                        <div class="min-w-0 flex-1">
                            <p class="truncate text-sm font-semibold">Proyektor LCD</p>
                            <p class="text-xs text-white/75">Jumat, 13.00 – 15.00</p>
                        </div>
                        <span class="shrink-0 rounded-full bg-white/20 px-2.5 py-1 text-[11px] font-bold text-white ring-1 ring-white/40">
                            Menunggu
                        </span>
                    </div>
                </div>
            </div>


            {{-- =========================
                BAGIAN KANAN / FORM
            ========================== --}}
            <div class="flex items-center bg-white px-8 py-12 sm:px-12 md:px-12 lg:px-12">

                <div class="w-full max-w-[425px] mx-auto">
                    <a
                        href="{{ url('/') }}"
                        class="mb-8 inline-flex items-center gap-2 text-sm font-semibold text-[#64748b] transition hover:text-[#064e3b] focus:outline-none focus-visible:text-[#064e3b]"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                        </svg>
                        Kembali ke Beranda
                    </a>
                    {{-- Heading --}}
                    <div class="mb-9">

                        <span class="mb-5 flex h-12 w-12 items-center justify-center rounded-2xl bg-[#f8f3ed] text-[#064e3b] ring-1 ring-[#064e3b]/10">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 20.118a7.5 7.5 0 0115 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.5-1.632z" />
                            </svg>
                        </span>

                        <h2 class="font-display text-3xl font-bold tracking-tight text-[#111827]">
                            Log In
                        </h2>

                        <p class="mt-2 text-sm text-[#64748b]">
                            Silakan masuk menggunakan akun Anda!
                        </p>

                    </div>


                    {{-- Error --}}
                    @if ($errors->any())
                        <div class="mb-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-600">
                            <ul class="list-disc space-y-1 pl-4">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif


                    {{-- Session Error --}}
                    @if (session('error'))
                        <div class="mb-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-600">
                            {{ session('error') }}
                        </div>
                    @endif


                    {{-- FORM LOGIN --}}
                    <form action="{{ route('login.process') }}" method="POST" class="space-y-5">

                        @csrf


                        {{-- Email --}}
                        <div>

                            <label
                                for="email"
                                class="mb-2 block text-sm font-semibold text-[#111827]"
                            >
                                Email Akademik
                            </label>

                            <div class="group relative">

                                {{-- Mail Icon --}}
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-[#64748b] transition-colors group-focus-within:text-[#064e3b]">
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="h-5 w-5"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                        stroke-width="1.8"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M3 8l9 6 9-6M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"
                                        />
                                    </svg>
                                </div>

                                <input
                                    id="email"
                                    type="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    placeholder="contoh: student@school.sch.id"
                                    autocomplete="email"
                                    required
                                    class="h-[52px] w-full rounded-xl border border-[#cbd5e1] bg-[#f8f3ed]/40 pl-11 pr-4 text-sm text-[#111827] outline-none transition placeholder:text-[#94a3b8] hover:border-[#94a3b8] focus:border-[#064e3b] focus:bg-white focus:ring-4 focus:ring-[#064e3b]/10"
                                >

                            </div>

                        </div>


                        {{-- Password --}}
                        <div>

                            <label
                                for="password"
                                class="mb-2 block text-sm font-semibold text-[#111827]"
                            >
                                Password
                            </label>

                            <div class="group relative">

                                {{-- Lock Icon --}}
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-[#64748b] transition-colors group-focus-within:text-[#064e3b]">
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="h-5 w-5"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                        stroke-width="1.8"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M16 10V7a4 4 0 00-8 0v3m-2 0h12a2 2 0 012 2v7a2 2 0 01-2 2H6a2 2 0 01-2-2v-7a2 2 0 012-2z"
                                        />
                                    </svg>
                                </div>

                                <input
                                    id="password"
                                    type="password"
                                    name="password"
                                    placeholder="Masukkan kata sandi Anda"
                                    autocomplete="current-password"
                                    required
                                    class="h-[52px] w-full rounded-xl border border-[#cbd5e1] bg-[#f8f3ed]/40 pl-11 pr-12 text-sm text-[#111827] outline-none transition placeholder:text-[#94a3b8] hover:border-[#94a3b8] focus:border-[#064e3b] focus:bg-white focus:ring-4 focus:ring-[#064e3b]/10"
                                >

                                {{-- Show Password --}}
                                <button
                                    type="button"
                                    onclick="togglePassword()"
                                    class="absolute inset-y-0 right-0 flex items-center rounded-r-xl pr-4 text-[#64748b] transition hover:text-[#064e3b] focus:outline-none focus-visible:text-[#064e3b]"
                                    aria-label="Tampilkan password"
                                >
                                    <svg
                                        id="eyeIcon"
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="h-5 w-5"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                        stroke-width="1.8"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"
                                        />

                                        <circle
                                            cx="12"
                                            cy="12"
                                            r="3"
                                        />
                                    </svg>
                                </button>

                            </div>

                        </div>

                        {{-- Button --}}
                        <button
                            type="submit"
                            class="mt-2 h-[52px] w-full rounded-xl bg-[#003d2c] text-sm font-bold text-white shadow-[0_12px_24px_-10px_rgba(0,61,44,0.7)] transition duration-200 hover:-translate-y-0.5 hover:bg-[#00543d] hover:shadow-[0_16px_28px_-10px_rgba(0,61,44,0.75)] focus:outline-none focus:ring-4 focus:ring-[#003d2c]/20 active:translate-y-0 active:scale-[0.99]"
                        >
                            Log In
                        </button>

                    </form>


                    {{-- Register --}}
                    <div class="mt-7 flex items-center gap-3 rounded-xl bg-[#f8f3ed] px-4 py-3 text-sm text-[#64748b]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0 text-[#064e3b]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p>
                            Belum memiliki akun? Segera hubungi
                            <span class="font-semibold text-[#064e3b]">Admin IT</span>.
                        </p>
                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- Toggle Password --}}
    <script>
        function togglePassword() {
            const password = document.getElementById('password');
            const icon = document.getElementById('eyeIcon');

            if (password.type === 'password') {
                password.type = 'text';

                icon.innerHTML = `
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M3 3l18 18"
                    />
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M10.584 10.587a2 2 0 002.829 2.828"
                    />
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M9.88 4.24A9.956 9.956 0 0112 4c4.477 0 8.268 2.943 9.542 7a10.02 10.02 0 01-4.043 5.06M6.228 6.228A10.02 10.02 0 002.458 12C3.732 16.057 7.523 19 12 19c1.61 0 3.14-.38 4.48-1.05"
                    />
                `;
            } else {
                password.type = 'password';

                icon.innerHTML = `
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"
                    />
                    <circle
                        cx="12"
                        cy="12"
                        r="3"
                    />
                `;
            }
        }
    </script>

</body>
</html>
