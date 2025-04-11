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
        <form method="POST" action="{{ route('logout') }}" id="logout-form">
            @csrf
            <button type="button" onclick="showLogoutModal()"
                class="w-full flex items-center space-x-3 px-4 py-2 rounded-md font-medium text-2xl bg-purple-600 hover:bg-purple-500 transition text-white">
                <span class="material-icons">logout</span>
                <span>Logout</span>
            </button>
        </form>
    </div>
</div>

<!-- Logout Confirmation Modal -->
<div id="logout-modal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg shadow-xl w-96 p-6 transform transition-all scale-95 opacity-0" id="modal-content">
        <div class="text-center">
            <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-purple-100 mb-6">
                <span class="material-icons text-purple-600 text-3xl">logout</span>
            </div>
            <h3 class="text-xl font-medium text-gray-900 mb-2">Confirm Logout</h3>
            <p class="text-gray-600 mb-8">Are you sure you want to log out of your account?</p>
            <div class="flex justify-center space-x-4">
                <button type="button" onclick="hideLogoutModal()" 
                    class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 transition">
                    Cancel
                </button>
                <button type="button" onclick="submitLogout()" 
                    class="px-4 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700 transition">
                    Yes, Logout
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Google Icons -->
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<!-- Google Fonts -->
<link
    href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Roboto:wght@300;400;500;700&display=swap"
    rel="stylesheet">

<!-- Logout Modal Script -->
<script>
    function showLogoutModal() {
        const modal = document.getElementById('logout-modal');
        const modalContent = document.getElementById('modal-content');
        
        modal.classList.remove('hidden');
        setTimeout(() => {
            modalContent.classList.remove('scale-95', 'opacity-0');
            modalContent.classList.add('scale-100', 'opacity-100');
        }, 10);
    }
    
    function hideLogoutModal() {
        const modal = document.getElementById('logout-modal');
        const modalContent = document.getElementById('modal-content');
        
        modalContent.classList.remove('scale-100', 'opacity-100');
        modalContent.classList.add('scale-95', 'opacity-0');
        
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 200);
    }
    
    function submitLogout() {
        document.getElementById('logout-form').submit();
    }
</script>