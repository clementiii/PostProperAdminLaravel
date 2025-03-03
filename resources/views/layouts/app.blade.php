<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body class="flex bg-gray-100">

    <!-- Sidebar -->
    @include('layouts.sidebar')

    <!-- Main Content -->
    <div class="flex-1 ml-72">
        <!-- Topbar -->
        @include('layouts.topbar')

        <div class="p-6 mt-16">
            @yield('content') 
        </div>
    </div>
    
    <script src="{{ asset('js/dashboard.js') }}"></script>
</body>
</html>
