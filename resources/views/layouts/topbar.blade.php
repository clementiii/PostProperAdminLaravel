<div class="bg-purple-900 text-white fixed top-0 right-0 w-[calc(100%-18rem)] h-16 flex items-center justify-between px-6 shadow-md">
    <h1 class="text-xl font-semibold">@yield('title', 'Dashboard')</h1>

    <!-- Account Section -->
    <div class="flex items-center space-x-4">
        <span class="text-sm">{{ Auth::user()->name }}</span>
        <a href="{{ route('profile') }}">
            <img src="{{ Auth::user()->profile_picture }}" 
                 class="w-12 h-12 rounded-full border-2 border-white hover:scale-110 transition" 
                 alt="Profile">
        </a>
    </div>
</div>
