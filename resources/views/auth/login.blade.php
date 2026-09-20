<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login - SkanSarpras</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-[#f8f3ed] flex items-center justify-center px-5 py-10">

    <div class="w-full max-w-[1000px] overflow-hidden bg-white">

        <div class="grid min-h-[565px] md:grid-cols-[1.38fr_1fr]">

            {{-- =========================
                BAGIAN KIRI
            ========================== --}}
            <div
                class="relative flex min-h-[420px] items-center overflow-hidden rounded-t-[15px] bg-gradient-to-br from-[#4eb18f] via-[#32846b] to-[#173f34] px-12 py-16 md:min-h-0 md:rounded-l-[15px] md:rounded-tr-none md:px-[120px]"
            >

                {{-- Efek dekorasi --}}
                <div
                    class="absolute -left-32 -top-32 h-80 w-80 rounded-full bg-white/10 blur-3xl"
                ></div>

                <div
                    class="absolute -bottom-40 -right-32 h-96 w-96 rounded-full bg-black/10 blur-3xl"
                ></div>

                {{-- Text --}}
                <div class="relative z-10 max-w-[410px] text-white">

                    <h1 class="text-4xl font-bold leading-[1.15] tracking-tight md:text-5xl">
                        Halo, Selamat<br>
                        Datang!
                    </h1>

                    <p class="mt-5 max-w-[350px] text-sm font-medium leading-snug text-white/95">
                        Gunakan akun akademik Anda untuk mengakses dan
                        mengelola peminjaman sarana prasarana sekolah.
                    </p>

                </div>
            </div>


            {{-- =========================
                BAGIAN KANAN / FORM
            ========================== --}}
            <div class="flex items-center bg-white px-8 py-12 sm:px-12 md:px-12 lg:px-12">

                <div class="w-full max-w-[425px] mx-auto">

                    {{-- Heading --}}
                    <div class="mb-9">

                        <h2 class="text-3xl font-bold tracking-tight text-[#111827]">
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

                            <div class="relative">

                                {{-- Mail Icon --}}
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-[#64748b]">
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
                                    class="h-12 w-full rounded-xl border border-[#cbd5e1] bg-white pl-11 pr-4 text-sm text-[#111827] outline-none transition placeholder:text-[#94a3b8] focus:border-[#064e3b] focus:ring-2 focus:ring-[#064e3b]/10"
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

                            <div class="relative">

                                {{-- Lock Icon --}}
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-[#64748b]">
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
                                    class="h-12 w-full rounded-xl border border-[#cbd5e1] bg-white pl-11 pr-12 text-sm text-[#111827] outline-none transition placeholder:text-[#94a3b8] focus:border-[#064e3b] focus:ring-2 focus:ring-[#064e3b]/10"
                                >

                                {{-- Show Password --}}
                                <button
                                    type="button"
                                    onclick="togglePassword()"
                                    class="absolute inset-y-0 right-0 flex items-center pr-4 text-[#64748b] transition hover:text-[#064e3b]"
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
                            class="mt-2 h-[52px] w-full rounded-xl bg-[#003d2c] text-sm font-bold text-white transition duration-200 hover:bg-[#00543d] focus:outline-none focus:ring-4 focus:ring-[#003d2c]/20 active:scale-[0.99]"
                        >
                            Log In
                        </button>

                    </form>


                    {{-- Register --}}
                    <p class="mt-6 text-center text-sm text-[#64748b]">
                        Belum memiliki akun? Segera hubungi Admin IT.
                    </p>

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