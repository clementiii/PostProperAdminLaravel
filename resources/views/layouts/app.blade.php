<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="icon" href="{{ asset('/assets/Southside.png') }}" type="image/png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard')</title>
    {{-- Tailwind CSS --}}
    <script src="https://cdn.tailwindcss.com"></script>
    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    {{-- CSRF Token --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>

    {{-- Include other head elements or @stack('styles') if needed --}}
    @stack('styles') {{-- Added stack for styles --}}

</head>

<body class="flex bg-gray-100">

    @include('layouts.sidebar')

    <div class="flex-1 ml-72"> {{-- Adjust margin if sidebar width changes --}}
        @include('layouts.topbar')

        {{-- Page Content --}}
        <div class="p-6 mt-16"> {{-- Adjust top margin if topbar height changes --}}
            @yield('content')
        </div>
    </div>

    {{-- ** FIX: Include jQuery Library (via CDN) BEFORE dashboard.js ** --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
            integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
            crossorigin="anonymous"></script>

    {{-- Your dashboard script that uses jQuery --}}
    {{-- Ensure this file exists in public/js/ --}}
    <script src="{{ asset('js/dashboard.js') }}"></script>

    {{-- Alpine JS (Defer ensures it runs after DOM is parsed) --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    {{-- Stack for page-specific scripts --}}
    {{-- Make sure this is present if any child views use @push('scripts') --}}
    @stack('scripts')

</body>

</html>
