<div>
    <!-- Stats Cards -->
    <div class="mb-12 grid grid-cols-1 md:grid-cols-3 gap-12 justify-items-center">
        <div
            class="h-[150px] w-[500px] bg-gradient-to-r from-blue-500 to-blue-600 text-white p-6 rounded-lg shadow-lg shadow-blue-700 flex items-center">
            <div class="mr-4">
                <h3 class="text-xl pb-3">Registered Residents</h3>
                <p id="residentsCount" class="text-4xl font-bold">{{ $registeredResidentsCount }}</p>
            </div>
            <i class="material-icons-outlined bg-white bg-opacity-20 rounded-full !text-[64px] ml-auto p-5">group</i>
        </div>
        <div
            class="h-[150px] w-[500px] bg-gradient-to-r from-emerald-500 to-emerald-600 text-white p-6 rounded-lg shadow-lg shadow-emerald-700 flex items-center">
            <div class="mr-4">
                <h3 class="text-xl pb-3">Active Users</h3>
                <p id="pendingDocsCount" class="text-4xl font-bold">{{ $activeUsersCount }}</p>
            </div>
            <i
                class="material-symbols-outlined bg-white bg-opacity-20 rounded-full !text-[64px] ml-auto p-5">person_check</i>
        </div>
        <div
            class="h-[150px] w-[500px] bg-gradient-to-r from-slate-500 to-slate-600 text-white p-6 rounded-lg shadow-lg shadow-slate-700 flex items-center">
            <div class="mr-4">
                <h3 class="text-xl pb-3">Inactive Users</h3>
                <p id="incidentCount" class="text-4xl font-bold">{{ $inactiveUsersCount }}</p>
            </div>
            <i
                class="material-icons-outlined bg-white bg-opacity-20 rounded-full !text-[64px] ml-auto p-5">person_off</i>
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

                <!-- Filter Dropdown -->
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open"
                        class="flex items-center bg-gray-100 px-4 py-2 rounded-lg shadow-sm hover:bg-gray-200">
                        <span>Filter by</span>
                        <span class="material-icons-outlined ml-2">arrow_drop_down</span>
                    </button>
                    <!-- Dropdown Menu -->
                    <div x-show="open" @click.away="open = false"
                        class="absolute right-0 mt-2 bg-white border rounded-lg shadow-lg w-40 z-50">
                        <ul class="text-gray-700">
                            <li><button wire:click="$set('filterField', 'lastName')"
                                    class="px-4 py-2 hover:bg-gray-100 w-full text-left">Last Name</button></li>
                            <li><button wire:click="$set('filterField', 'firstName')"
                                    class="px-4 py-2 hover:bg-gray-100 w-full text-left">First Name</button></li>
                            <li><button wire:click="$set('filterField', 'adrStreet')"
                                    class="px-4 py-2 hover:bg-gray-100 w-full text-left">Address</button></li>
                            <li><button wire:click="$set('filterField', 'status')"
                                    class="px-4 py-2 hover:bg-gray-100 w-full text-left">Status</button></li>
                        </ul>
                    </div>
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
                                                <form action="{{ route('users.delete', $user->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        onclick="return confirm('Are you sure you want to delete this user? This action cannot be undone.')"
                                                        class="bg-red-500 hover:bg-red-600 text-white py-1 px-3 rounded text-sm font-medium">
                                                        Delete
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
</div>