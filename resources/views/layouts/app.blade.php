<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SkanSarpras')</title>

    {{-- Google Fonts (Sama dengan layout peminjam) --}}
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@500;700;800&family=Work+Sans:wght@400;500;600&display=swap" rel="stylesheet">

    {{-- Jika memakai Vite, pastikan `npm run dev` atau `npm run build` dijalankan --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Lucide Icons (Wajib ada jika memakai <i data-lucide="...">) --}}
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="antialiased">
    @yield('content')

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        });
    </script>
    @stack('scripts')
</body>
</html>