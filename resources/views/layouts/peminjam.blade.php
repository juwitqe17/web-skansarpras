@extends('layouts.app')

@section('content')

<div class="min-h-screen">

    {{-- SIDEBAR PEMINJAM --}}
    @include('partials.sidebar-peminjam')

    {{-- AREA KANAN --}}
    <div class="ml-[295px] min-h-screen">

        {{-- NAVBAR --}}
        @include('partials.navbar')

        {{-- CONTENT --}}
        <main class="min-h-[calc(100vh-82px)] px-8 py-8">
            @yield('page-content')
        </main>

    </div>

</div>

@endsection
