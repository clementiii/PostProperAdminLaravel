<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />


</head>

<body class="flex bg-gray-100">

    <!-- Sidebar -->
    @include('layouts.sidebar')

    <!-- Main Content -->
    <div class="h-full flex-1 ml-72 p-6">
        <!-- Header Section -->
        <div class="relative w-full h-[21.25rem] rounded-3xl overflow-hidden shadow-lg">
            <!-- Background Image -->
            <img src="{{ asset('assets/mckinley.jpg') }}" class="absolute inset-0 w-full h-full object-cover"
                alt="Background">

            <!-- Dark Overlay -->
            <div class="absolute inset-0 bg-black bg-opacity-50"></div>

            <!-- Welcome Text -->
            <div class="absolute bottom-10 left-10 text-white">
                <h1 class="text-3xl font-bold">Welcome, Admin {{ Auth::user()->name }}</h1>
            </div>

            <!-- Profile Image -->
            <div class="absolute top-6 right-6">
                <a href="{{ route('admin.profile') }}">
                    @if(Auth::user()->profile_picture)
                        <img src="{{ Auth::user()->profile_picture }}" 
                            class="w-14 h-14 rounded-full border-2 border-white hover:scale-110 transition" 
                            alt="Profile">
                    @else
                        <div class="w-14 h-14 rounded-full border-2 border-white bg-gray-200 flex items-center justify-center hover:scale-110 transition">
                            <i class="fas fa-user text-gray-400 text-xl"></i>
                        </div>
                    @endif
                </a>
            </div>
        </div>

        <!-- Dynamic Content -->
        <div class="p-6">
            @yield('content')
        </div>
    </div>

    <script src="{{ asset('js/dashboard.js') }}"></script>
</body>

</html>