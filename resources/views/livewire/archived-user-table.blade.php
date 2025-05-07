<div>
    <!-- Stats Card -->
    <div class="mb-12">
        <div class="h-[150px] w-full max-w-md bg-gradient-to-r from-purple-500 to-purple-600 text-white p-6 rounded-lg shadow-lg hover:shadow-purple-200 transition-all duration-300 flex items-center transform hover:scale-105">
            <div class="mr-4">
                <h3 class="text-xl pb-3">Archived Users</h3>
                <p id="archived_users_count" class="text-4xl font-bold">{{ $archivedCount }}</p>
            </div>
            <div class="bg-white bg-opacity-20 rounded-full p-4 ml-auto flex items-center justify-center">
                <i class="material-icons !text-[64px]">archive</i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-lg overflow-hidden mt-9">
        <!-- Purple Top Border -->
        <div class="h-1 bg-purple-800"></div>

        <!-- Header Section -->
        <div class="p-6 flex justify-between items-center">
            <div>
                <h2 class="text-3xl font-semibold font-poppins text-purple-800">Archived Users</h2>
                <p class="text-gray-500 mt-1">View and manage archived user accounts</p>
            </div>
            
            <div class="flex items-center">
                <!-- Back to Users Button -->
                <a href="{{ route('users.view') }}" class="bg-purple-700 hover:bg-purple-600 text-white py-2 px-4 rounded flex items-center mr-4">
                    <i class="material-icons mr-1">arrow_back</i>
                    Back to Users
                </a>
                
                <!-- Search Input -->
                <div class="relative">
                    <input type="text" wire:model.live="search" placeholder="Search archived users..."
                        class="pl-10 pr-4 py-2 w-72 rounded-lg border focus:outline-none focus:ring-2 focus:ring-purple-600">
                    <i class="material-icons absolute left-3 top-1/2 -translate-y-1/2 text-gray-500">search</i>
                </div>
            </div>
        </div>

        <!-- Table Section -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-100 text-center">
                    <tr>
                        <th class="px-6 py-4 text-lg font-semibold text-purple-800">
                            <button wire:click="sortBy('lastName')" class="flex items-center justify-center w-full">
                                Last Name
                                <i class="material-icons align-middle ml-1">
                                    {{ $sortField === 'lastName' ? ($sortDirection === 'asc' ? 'arrow_upward' : 'arrow_downward') : 'swap_vert' }}
                                </i>
                            </button>
                        </th>
                        <th class="px-6 py-4 text-lg font-semibold text-purple-800">
                            <button wire:click="sortBy('firstName')" class="flex items-center justify-center w-full">
                                First Name
                                <i class="material-icons align-middle ml-1">
                                    {{ $sortField === 'firstName' ? ($sortDirection === 'asc' ? 'arrow_upward' : 'arrow_downward') : 'swap_vert' }}
                                </i>
                            </button>
                        </th>
                        <th class="px-6 py-4 text-lg font-semibold text-purple-800">
                            Address
                            <i class="material-icons align-middle ml-1">
                                swap_vert
                            </i>
                        </th>
                        <th class="px-6 py-4 text-lg font-semibold text-purple-800">
                            <button wire:click="sortBy('archived_at')" class="flex items-center justify-center w-full">
                                Archived Date
                                <i class="material-icons align-middle ml-1">
                                    {{ $sortField === 'archived_at' ? ($sortDirection === 'asc' ? 'arrow_upward' : 'arrow_downward') : 'swap_vert' }}
                                </i>
                            </button>
                        </th>
                        <th class="px-6 py-4 text-lg font-semibold text-purple-800">Action</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    @foreach($users as $user)
                        <tr class="border-t text-center hover:bg-gray-200">
                            <td class="p-2">{{ $user->lastName }}</td>
                            <td class="p-2">{{ $user->firstName }}</td>
                            <td class="p-2">
                                {{ $user->adrHouseNo }} {{ $user->adrStreet }} {{ $user->adrZone }}
                            </td>
                            <td class="p-2">
                                {{ $user->formatted_archived_at }}
                            </td>
                            <td class="p-2 flex justify-center items-center space-x-2">
                                <a href="{{ route('archives.users.view', $user->id) }}"
                                   class="bg-purple-900 hover:bg-purple-800 text-white py-1 px-3 rounded text-sm font-medium">
                                    View
                                </a>
                                <form id="unarchive-form-{{ $user->id }}" action="{{ route('archives.users.unarchive', $user->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="button"
                                        onclick="openUnarchiveModal({{ $user->id }})"
                                        class="bg-green-500 hover:bg-green-600 text-white py-1 px-3 rounded text-sm font-medium flex items-center">
                                        <i class="material-icons text-sm mr-1">unarchive</i>
                                        Unarchive
                                    </button>
                                </form>
                                <form id="delete-form-{{ $user->id }}" action="{{ route('archives.users.delete', $user->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button"
                                        onclick="openDeleteModal({{ $user->id }})"
                                        class="bg-red-500 hover:bg-red-600 text-white py-1 px-3 rounded text-sm font-medium">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach

                    @if($users->count() == 0)
                        <tr class="border-t">
                            <td colspan="5" class="p-6 text-center text-gray-500">
                                <div class="flex flex-col items-center justify-center py-8">
                                    <i class="material-icons text-6xl mb-4">archive</i>
                                    <p class="text-xl">No archived users found</p>
                                </div>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <!-- Pagination Section -->
        <div class="mt-2 px-6 pb-4">
            <div class="flex items-center justify-between border-t pt-3">
                <!-- Showing Results Text -->
                <div class="text-lg text-gray-700">
                    Showing {{ $users->firstItem() ?? 0 }} to {{ $users->lastItem() ?? 0 }} of {{ $users->total() }}
                    results
                </div>

                <div class="flex items-center gap-4">
                    <!-- Items Per Page Dropdown -->
                    <div class="flex items-center gap-2">
                        <span class="text-lg text-gray-700">Rows per page</span>
                        <select wire:model.live="perPage" class="border rounded px-2 py-1 text-lg text-gray-600">
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                        </select>
                    </div>

                    <!-- Navigation Buttons -->
                    <div class="flex items-center space-x-2">
                        <!-- First Page -->
                        <button wire:click="gotoPage(1)" @if($users->onFirstPage()) disabled @endif
                            class="p-1 text-gray-600 hover:text-purple-800 disabled:text-gray-300 disabled:cursor-not-allowed text-2xl font-bold">
                            «
                        </button>

                        <!-- Previous Page -->
                        <button wire:click="previousPage" @if($users->onFirstPage()) disabled @endif
                            class="p-1 text-gray-600 hover:text-purple-800 disabled:text-gray-300 disabled:cursor-not-allowed text-3xl font-bold">
                            ‹
                        </button>

                        <!-- Page Numbers -->
                        @for ($i = 1; $i <= $users->lastPage(); $i++)
                            @if($i == $users->currentPage())
                                <button wire:click="gotoPage({{ $i }})"
                                    class="px-3 py-1 rounded-full bg-purple-900 text-white text-lg">
                                    {{ $i }}
                                </button>
                            @elseif($i == 1 || $i == $users->lastPage() || abs($users->currentPage() - $i) <= 2)
                                <button wire:click="gotoPage({{ $i }})"
                                    class="px-3 py-1 text-lg text-gray-600 hover:text-purple-800">
                                    {{ $i }}
                                </button>
                            @elseif(abs($users->currentPage() - $i) == 3)
                                <span class="text-gray-600">...</span>
                            @endif
                        @endfor

                        <!-- Next Page -->
                        <button wire:click="nextPage" @if(!$users->hasMorePages()) disabled @endif
                            class="p-1 text-gray-600 hover:text-purple-800 disabled:text-gray-300 disabled:cursor-not-allowed text-3xl font-bold">
                            ›
                        </button>

                        <!-- Last Page -->
                        <button wire:click="gotoPage({{ $users->lastPage() }})" @if(!$users->hasMorePages()) disabled
                        @endif
                            class="p-1 text-gray-600 hover:text-purple-800 disabled:text-gray-300 disabled:cursor-not-allowed text-2xl font-bold">
                            »
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg shadow-xl w-96 p-6 transform transition-all scale-95 opacity-0" id="modal-content">
            <div class="text-center">
                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-red-100 mb-6">
                    <i class="material-icons text-red-600 text-3xl">delete</i>
                </div>
                <h3 class="text-xl font-medium text-gray-900 mb-2">Confirm User Deletion</h3>
                <p class="text-gray-600 mb-8">Are you sure you want to delete this user? This action cannot be undone.</p>
                <div class="flex justify-center space-x-4">
                    <button type="button" onclick="hideDeleteModal()" 
                        class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 transition">
                        Cancel
                    </button>
                    <button type="button" id="confirmDeleteBtn"
                        class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition">
                        Yes, Delete User
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Unarchive Confirmation Modal -->
    <div id="unarchiveModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg shadow-xl w-96 p-6 transform transition-all scale-95 opacity-0" id="unarchive-modal-content">
            <div class="text-center">
                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-green-100 mb-6">
                    <i class="material-icons text-green-600 text-3xl">unarchive</i>
                </div>
                <h3 class="text-xl font-medium text-gray-900 mb-2">Confirm User Unarchive</h3>
                <p class="text-gray-600 mb-8">Are you sure you want to unarchive this user?</p>
                <div class="flex justify-center space-x-4">
                    <button type="button" onclick="hideUnarchiveModal()" 
                        class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 transition">
                        Cancel
                    </button>
                    <button type="button" id="confirmUnarchiveBtn"
                        class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition">
                        Yes, Unarchive User
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Confirmation Script -->
    <script>
        let currentDeleteId = null;
        let currentUnarchiveId = null;
        
        function openUnarchiveModal(userId) {
            currentUnarchiveId = userId;
            const modal = document.getElementById('unarchiveModal');
            const modalContent = document.getElementById('unarchive-modal-content');
            
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden'; // Prevent scrolling
            
            // Force a reflow before adding the transition classes
            void modalContent.offsetWidth;
            
            setTimeout(() => {
                modalContent.classList.remove('scale-95', 'opacity-0');
                modalContent.classList.add('scale-100', 'opacity-100');
            }, 10);
        }
        
        function hideUnarchiveModal() {
            const modal = document.getElementById('unarchiveModal');
            const modalContent = document.getElementById('unarchive-modal-content');
            
            modalContent.classList.remove('scale-100', 'opacity-100');
            modalContent.classList.add('scale-95', 'opacity-0');
            
            setTimeout(() => {
                modal.classList.add('hidden');
                document.body.style.overflow = ''; // Re-enable scrolling
                currentUnarchiveId = null;
            }, 200);
        }
        
        function openDeleteModal(userId) {
            currentDeleteId = userId;
            const modal = document.getElementById('deleteModal');
            const modalContent = document.getElementById('modal-content');
            
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden'; // Prevent scrolling
            
            // Force a reflow before adding the transition classes
            void modalContent.offsetWidth;
            
            setTimeout(() => {
                modalContent.classList.remove('scale-95', 'opacity-0');
                modalContent.classList.add('scale-100', 'opacity-100');
            }, 10);
        }
        
        function hideDeleteModal() {
            const modal = document.getElementById('deleteModal');
            const modalContent = document.getElementById('modal-content');
            
            modalContent.classList.remove('scale-100', 'opacity-100');
            modalContent.classList.add('scale-95', 'opacity-0');
            
            setTimeout(() => {
                modal.classList.add('hidden');
                document.body.style.overflow = ''; // Re-enable scrolling
                currentDeleteId = null;
            }, 200);
        }
        
        // Execute after the DOM is fully loaded
        document.addEventListener('DOMContentLoaded', function() {
            const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
            if (confirmDeleteBtn) {
                confirmDeleteBtn.addEventListener('click', function() {
                    if (currentDeleteId) {
                        document.getElementById('delete-form-' + currentDeleteId).submit();
                    }
                });
            }
            
            const confirmUnarchiveBtn = document.getElementById('confirmUnarchiveBtn');
            if (confirmUnarchiveBtn) {
                confirmUnarchiveBtn.addEventListener('click', function() {
                    if (currentUnarchiveId) {
                        document.getElementById('unarchive-form-' + currentUnarchiveId).submit();
                    }
                });
            }
            
            // Close modal when clicking outside
            const deleteModal = document.getElementById('deleteModal');
            if (deleteModal) {
                deleteModal.addEventListener('click', function(e) {
                    if (e.target === this) {
                        hideDeleteModal();
                    }
                });
            }
            
            const unarchiveModal = document.getElementById('unarchiveModal');
            if (unarchiveModal) {
                unarchiveModal.addEventListener('click', function(e) {
                    if (e.target === this) {
                        hideUnarchiveModal();
                    }
                });
            }
        });
    </script>

    <style>
        /* Additional modal styles */
        #modal-content, #unarchive-modal-content {
            display: block;
            position: relative;
            z-index: 60;
            transition: transform 0.3s ease, opacity 0.3s ease;
        }
        
        /* Ensure modal is visible */
        #deleteModal.flex #modal-content, #unarchiveModal.flex #unarchive-modal-content {
            opacity: 1;
        }
        
        /* Force hardware acceleration for smoother animations */
        .transform {
            will-change: transform, opacity;
            backface-visibility: hidden;
        }
    </style>
</div>
