


<div class="w-full-lg bg-purple-700 text-gray-100 flex items-center justify-between p-6 m-4">
    <h1 class="text-4xl font-bold">@yield('title', 'Dashboard')</h1>

    <!-- Account Section -->
    <div class="flex items-center space-x-4">
        <span class="text-xl">{{ Auth::user()->name }}</span>
        <a href="{{ route('profile') }}">
            <img src="{{ Auth::user()->profile_picture }}" 
                 class="w-12 h-12 rounded-full border-2 border-white hover:scale-110 transition" 
                 alt="Profile">
        </a>
    </div>
</div>
