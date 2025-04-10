<div class="w-full-lg flex items-center justify-between p-6 m-4">
    <h1 class="text-4xl text-purple-900 font-bold">@yield('title', 'Dashboard')</h1>

    <!-- Account Section -->
    <div class="flex items-center space-x-4">
        <span class="text-xl font-semibold">{{ Auth::user()->name }}</span>
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