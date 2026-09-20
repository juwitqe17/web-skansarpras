@extends('layouts.app')

@section('content')

<div class="min-h-screen">

    {{-- SIDEBAR ADMIN --}}
    @include('partials.sidebar-admin')

    {{-- AREA KANAN --}}
    <div class="ml-[295px] min-h-screen">

        {{-- NAVBAR ADMIN --}}
        @include('partials.navbar-admin')

        {{-- CONTENT --}}
        <main class="min-h-[calc(100vh-94px)] bg-[#f5f7f8] px-8 py-8">
            @yield('page-content')
        </main>

    </div>

</div>

@endsection
