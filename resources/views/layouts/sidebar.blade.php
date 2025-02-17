<div class="w-72 min-h-screen bg-purple-900 text-white fixed top-0 left-0 shadow-lg flex flex-col justify-between">
    <!-- Sidebar Header -->
    <div class="p-6">
        <div class="flex items-center space-x-3 mb-4">
            <img src="{{ asset('assets/Southside.png') }}" class="w-16 h-16 rounded-full shadow-md" alt="Logo">
            <h2 class="text-lg font-bold">Admin Panel</h2>
        </div>

        <!-- Navigation Links -->
        <ul class="space-y-2">
            <li><a href="{{ route('dashboard') }}" class="flex items-center space-x-3 px-4 py-2 rounded-md hover:bg-purple-700 transition">
                <i class="fas fa-tachometer-alt"></i> <span>Dashboard</span>
            </a></li>
            <li><a href="{{ route('admin.staff') }}" class="flex items-center space-x-3 px-4 py-2 rounded-md hover:bg-purple-700 transition">
                <i class="fas fa-users"></i> <span>Admin Staff</span>
            </a></li>
            <li><a href="{{ route('users.view') }}" class="flex items-center space-x-3 px-4 py-2 rounded-md hover:bg-purple-700 transition">
                <i class="fa-solid fa-user"></i> <span>User Accounts</span>
            </a></li>
            <li><a href="{{ route('announcement.index') }}" class="flex items-center space-x-3 px-4 py-2 rounded-md hover:bg-purple-700 transition">
                <i class="fas fa-bullhorn"></i> <span>Announcement</span>
            </a></li>
            <li><a href="{{ route('documents.index') }}" class="flex items-center space-x-3 px-4 py-2 rounded-md hover:bg-purple-700 transition">
                <i class="fas fa-folder"></i> <span>Document Requests</span>
            </a></li>
            <li><a href="{{ route('reports.index') }}" class="flex items-center space-x-3 px-4 py-2 rounded-md hover:bg-purple-700 transition">
                <i class="fas fa-flag"></i> <span>Reports</span>
            </a></li>
            <li><a href="{{ route('desk_support.index') }}" class="flex items-center space-x-3 px-4 py-2 rounded-md hover:bg-purple-700 transition">
                <i class="fas fa-headset"></i> <span>Desk Support</span>
            </a></li>
        </ul>
    </div>

    <!-- Logout Button -->
    <div class="p-6">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full flex items-center space-x-3 px-4 py-2 rounded-md bg-purple-600 hover:bg-purple-500 transition text-white">
                <i class="fas fa-sign-out-alt"></i> <span>Logout</span>
            </button>
        </form>
    </div>
</div>
