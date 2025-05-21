<div>
    <!-- Stats Cards -->
    <div class="mb-12 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 justify-items-center">
        <div
            class="h-[150px] w-full bg-gradient-to-r from-blue-500 to-blue-600 text-white p-6 rounded-lg shadow-lg hover:shadow-blue-200 transition-all duration-300 flex items-center transform hover:scale-105">
            <div class="mr-4">
                <h3 class="text-xl pb-3">Registered Residents</h3>
                <p id="user_residents_count" class="text-4xl font-bold">{{ $registeredResidentsCount }}</p>
            </div>
            <div class="bg-white bg-opacity-20 rounded-full p-4 ml-auto flex items-center justify-center">
                <i class="material-icons-outlined !text-[64px]">group</i>
            </div>
        </div>
        <div
            class="h-[150px] w-full bg-gradient-to-r from-emerald-500 to-emerald-600 text-white p-6 rounded-lg shadow-lg hover:shadow-emerald-200 transition-all duration-300 flex items-center transform hover:scale-105">
            <div class="mr-4">
                <h3 class="text-xl pb-3">Active Users</h3>
                <p id="user_active_count" class="text-4xl font-bold">{{ $activeUsersCount }}</p>
            </div>
            <div class="bg-white bg-opacity-20 rounded-full p-4 ml-auto flex items-center justify-center">
                <i class="material-symbols-outlined !text-[64px]">person_check</i>
            </div>
        </div>
        <div
            class="h-[150px] w-full bg-gradient-to-r from-slate-500 to-slate-600 text-white p-6 rounded-lg shadow-lg hover:shadow-slate-200 transition-all duration-300 flex items-center transform hover:scale-105">
            <div class="mr-4">
                <h3 class="text-xl pb-3">Inactive Users</h3>
                <p id="user_inactive_count" class="text-4xl font-bold">{{ $inactiveUsersCount }}</p>
            </div>
            <div class="bg-white bg-opacity-20 rounded-full p-4 ml-auto flex items-center justify-center">
                <i class="material-icons-outlined !text-[64px]">person_off</i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-lg overflow-hidden mt-9">
        <!-- Purple Top Border -->
        <div class="h-1 bg-purple-800"></div>

        <!-- Header Section -->
        <div class="p-6 flex justify-between items-center">
            <div>
                <h2 class="text-3xl font-semibold font-poppins text-purple-800">Resident Users</h2>
                <p class="text-gray-500 mt-1">Manage and view all registered in the barangay</p>
            </div>

            <!-- Search and Filter Section -->
            <div class="flex items-center space-x-4">
                <!-- Search Input -->
                <div class="relative">
                    <input type="text" wire:model.live="search" placeholder="Search residents..."
                        class="pl-10 pr-4 py-2 w-72 rounded-lg border focus:outline-none focus:ring-2 focus:ring-purple-600">
                    <span
                        class="material-icons-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-500">search</span>
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
                                <span class="material-icons-outlined align-middle cursor-pointer">
                                    {{ $sortField === 'lastName' ? ($sortDirection === 'asc' ? 'arrow_upward' : 'arrow_downward') : 'swap_vert' }}
                                </span>
                            </button>
                        </th>
                        <th class="px-6 py-4 text-lg font-semibold text-purple-800">
                            <button wire:click="sortBy('firstName')" class="flex items-center justify-center w-full">
                                First Name
                                <span class="material-icons-outlined align-middle cursor-pointer">
                                    {{ $sortField === 'firstName' ? ($sortDirection === 'asc' ? 'arrow_upward' : 'arrow_downward') : 'swap_vert' }}
                                </span>
                            </button>
                        </th>
                        <th class="px-6 py-4 text-lg font-semibold text-purple-800">
                            Address
                            <span class="material-icons-outlined align-middle cursor-pointer">swap_vert</span>
                        </th>
                        <th class="px-6 py-4 text-lg font-semibold text-purple-800">
                            <button wire:click="sortBy('status')" class="flex items-center justify-center w-full">
                                Status
                                <span class="material-icons-outlined align-middle cursor-pointer">
                                    {{ $sortField === 'status' ? ($sortDirection === 'asc' ? 'arrow_upward' : 'arrow_downward') : 'swap_vert' }}
                                </span>
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
                                                @php
                                                    $statusClass = match (strtolower($user->status)) {
                                                        'pending' => 'bg-[#FEF9C3] text-gray-700',
                                                        'verified' => 'bg-[#DCFCE7] text-[#1A6838]',
                                                        'rejected' => 'bg-red-500 text-white',
                                                        default => ''
                                                    };
                                                @endphp
                                                <span class="px-3 py-1 rounded-full {{ $statusClass }}">
                                                    {{ ucfirst($user->status ?? 'Pending') }}
                                                </span>
                                            </td>
                                            <td class="p-2 flex justify-center items-center space-x-2">
                                                <a href="{{ route('users.verify', $user->id) }}"
                                                    class="bg-purple-900 hover:bg-purple-800 text-white py-1 px-3 rounded text-sm font-medium">
                                                    View
                                                </a>
                                                <form id="archive-form-{{ $user->id }}" action="{{ route('users.archive', ['id' => $user->id]) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="button"
                                                        onclick="openArchiveModal({{ $user->id }})"
                                                        class="bg-amber-500 hover:bg-amber-600 text-white py-1 px-3 rounded text-sm font-medium flex items-center">
                                                        <span class="material-icons-outlined text-sm mr-1">archive</span>
                                                        Archive
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                    @endforeach
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

    <!-- Archive Confirmation Modal -->
    <div id="archiveModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg shadow-xl w-96 p-6 transform transition-all scale-95 opacity-0" id="archive-modal-content">
            <div class="text-center">
                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-amber-100 mb-6">
                    <span class="material-icons-outlined text-amber-600 text-3xl">archive</span>
                </div>
                <h3 class="text-xl font-medium text-gray-900 mb-2">Confirm User Archive</h3>
                <p class="text-gray-600 mb-8">Are you sure you want to archive this user? They will be moved to the archived users section.</p>
                <div class="flex justify-center space-x-4">
                    <button type="button" onclick="hideArchiveModal()" 
                        class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 transition">
                        Cancel
                    </button>
                    <button type="button" id="confirmArchiveBtn"
                        class="px-4 py-2 bg-amber-500 text-white rounded-md hover:bg-amber-600 transition">
                        Yes, Archive User
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg shadow-xl w-96 p-6 transform transition-all scale-95 opacity-0" id="modal-content">
            <div class="text-center">
                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-red-100 mb-6">
                    <span class="material-icons text-red-600 text-3xl">delete</span>
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

    <!-- Delete Modal Script -->
    <script>
        let currentDeleteId = null;
        let currentArchiveId = null;

        function openArchiveModal(userId) {
            currentArchiveId = userId;
            const modal = document.getElementById('archiveModal');
            const modalContent = document.getElementById('archive-modal-content');
            
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden'; // Prevent scrolling
            
            // Force a reflow before adding the transition classes
            void modalContent.offsetWidth;
            
            setTimeout(() => {
                modalContent.classList.remove('scale-95', 'opacity-0');
                modalContent.classList.add('scale-100', 'opacity-100');
            }, 10);
        }
        
        function hideArchiveModal() {
            const modal = document.getElementById('archiveModal');
            const modalContent = document.getElementById('archive-modal-content');
            
            modalContent.classList.remove('scale-100', 'opacity-100');
            modalContent.classList.add('scale-95', 'opacity-0');
            
            setTimeout(() => {
                modal.classList.add('hidden');
                document.body.style.overflow = ''; // Re-enable scrolling
                currentArchiveId = null;
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
            const confirmArchiveBtn = document.getElementById('confirmArchiveBtn');
            if (confirmArchiveBtn) {
                confirmArchiveBtn.addEventListener('click', function() {
                    if (currentArchiveId) {
                        document.getElementById('archive-form-' + currentArchiveId).submit();
                    }
                });
            }
            
            const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
            if (confirmDeleteBtn) {
                confirmDeleteBtn.addEventListener('click', function() {
                    if (currentDeleteId) {
                        document.getElementById('delete-form-' + currentDeleteId).submit();
                    }
                });
            }
            
            // Close modals when clicking outside
            const archiveModal = document.getElementById('archiveModal');
            if (archiveModal) {
                archiveModal.addEventListener('click', function(e) {
                    if (e.target === this) {
                        hideArchiveModal();
                    }
                });
            }
            
            const deleteModal = document.getElementById('deleteModal');
            if (deleteModal) {
                deleteModal.addEventListener('click', function(e) {
                    if (e.target === this) {
                        hideDeleteModal();
                    }
                });
            }
        });
    </script>

    <style>
        /* Additional modal styles */
        #modal-content {
            display: block;
            position: relative;
            z-index: 60;
            transition: transform 0.3s ease, opacity 0.3s ease;
        }
        
        /* Ensure modal is visible */
        #deleteModal.flex #modal-content {
            opacity: 1;
        }
        
        /* Force hardware acceleration for smoother animations */
        .transform {
            will-change: transform, opacity;
            backface-visibility: hidden;
        }
    </style>
</div>