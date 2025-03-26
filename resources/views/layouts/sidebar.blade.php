<!-- Sidebar -->
<div class="w-72 min-h-screen bg-purple-900 text-white fixed top-0 left-0 shadow-lg flex flex-col justify-between">
    <!-- Sidebar Header -->
    <div class="p-6">
        <div class="flex items-center space-x-3 mb-10">
            <img src="{{ asset('assets/Southside.png') }}" class="w-16 h-16 rounded-full shadow-md" alt="Logo">
            <h2 class="text-lg font-bold">Post Proper Southside</h2>
        </div>

        <!-- Navigation Links -->
        <ul class="space-y-7">
            <li>
                <a href="{{ route('dashboard') }}"
                    class="flex items-center space-x-3 px-4 py-2 rounded-md  text-2xl hover:bg-purple-700 transition">
                    <span class="material-icons">dashboard</span>
                    <span>Dashboard</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.staff') }}"
                    class="flex items-center space-x-3 px-4 py-2 rounded-md font-normal text-2xl hover:bg-purple-700 transition">
                    <span class="material-icons">shield</span>
                    <span>Admin Staff</span>
                </a>
            </li>
            <li>
                <a href="{{ route('users.view') }}"
                    class="flex items-center space-x-3 px-4 py-2 rounded-md font-normal text-2xl hover:bg-purple-700 transition">
                    <span class="material-icons">person</span>
                    <span>Users Account</span>
                </a>
            </li>
            <li>
                <a href="{{ route('announcements.index') }}"
                    class="flex items-center space-x-3 px-4 py-2 rounded-md font-normal text-2xl hover:bg-purple-700 transition">
                    <span class="material-icons">campaign</span>
                    <span>Announcements</span>
                </a>
            </li>
            <li>
                <a href="{{ route('documents.index') }}"
                    class="flex items-center space-x-3 px-4 py-2 rounded-md font-normal text-2xl hover:bg-purple-700 transition">
                    <span class="material-icons">description</span>
                    <span>Documents</span>
                </a>
            </li>
            <li>
                <a href="{{ route('incident-reports.index') }}"
                    class="flex items-center space-x-3 px-4 py-2 rounded-md font-normal text-2xl hover:bg-purple-700 transition">
                    <span class="material-icons">report</span>
                    <span>Reports</span>
                </a>
            </li>
            <li>
                <a href="{{ route('help_desk.index') }}"
                    class="flex items-center space-x-3 px-4 py-2 rounded-md font-normal text-2xl hover:bg-purple-700 transition">
                    <span class="material-icons">chat</span>
                    <span>Help Desk</span>
                </a>
            </li>
        </ul>
    </div>

    <!-- Logout Button -->
    <div class="p-6">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="w-full flex items-center space-x-3 px-4 py-2 rounded-md font-medium text-2xl bg-purple-600 hover:bg-purple-500 transition text-white">
                <span class="material-icons">logout</span>
                <span>Logout</span>
            </button>
        </form>
    </div>
</div>

<!-- Google Icons -->
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<!-- Google Fonts -->
<link
    href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Roboto:wght@300;400;500;700&display=swap"
    rel="stylesheet">