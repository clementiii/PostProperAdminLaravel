<div class="px-4 sm:px-6 lg:px-8 py-6">
    <!-- Stats Cards -->
    <div class="mb-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div
            class="h-[150px] bg-gradient-to-r from-blue-500 to-blue-600 text-white p-6 rounded-lg shadow-lg hover:shadow-blue-200 transition-all duration-300 flex items-center transform hover:scale-105">
            <div class="mr-4">
                <h3 class="text-xl font-medium">Registered Residents</h3>
                <p id="residentsCount" class="text-3xl sm:text-4xl font-bold mt-2">{{ $registeredResidents }}</p>
            </div>
            <div class="bg-white bg-opacity-20 rounded-full p-4 ml-auto">
                <i class="material-icons-outlined !text-[48px] sm:!text-[56px]">group</i>
            </div>
        </div>

        <div
            class="bg-gradient-to-r from-yellow-500 to-yellow-600 text-white p-6 rounded-lg shadow-lg hover:shadow-yellow-200 transition-all duration-300 flex items-center transform hover:scale-105">
            <div class="mr-4">
                <h3 class="text-xl font-medium">Pending Documents</h3>
                <p id="pendingDocsCount" class="text-3xl sm:text-4xl font-bold mt-2">{{ $pendingDocuments }}</p>
            </div>
            <div class="bg-white bg-opacity-20 rounded-full p-4 ml-auto">
                <i class="material-icons-outlined !text-[48px] sm:!text-[56px]">description</i>
            </div>
        </div>

        <div
            class="bg-gradient-to-r from-red-500 to-red-600 text-white p-6 rounded-lg shadow-lg hover:shadow-red-200 transition-all duration-300 flex items-center transform hover:scale-105">
            <div class="mr-4">
                <h3 class="text-xl font-medium">Incident Reports</h3>
                <p id="incidentCount" class="text-3xl sm:text-4xl font-bold mt-2">{{ $incidentReports }}</p>
            </div>
            <div class="bg-white bg-opacity-20 rounded-full p-4 ml-auto">
                <i class="material-icons-outlined !text-[48px] sm:!text-[56px]">report</i>
            </div>
        </div>
    </div>

    <!-- Recent Document Requests -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <!-- Purple Top Border -->
        <div class="h-1 bg-purple-800"></div>

        <!-- Header Section -->
        <div class="p-6 flex flex-col lg:flex-row lg:justify-between lg:items-center space-y-4 lg:space-y-0">
            <div>
                <h2 class="text-2xl sm:text-3xl font-semibold font-poppins text-purple-800">Recent Document Requests
                </h2>
                <p class="text-gray-500 mt-1">Manage and view all recent document requests from residents</p>
            </div>

            <!-- Search and Filter Section -->
            <div class="flex flex-col sm:flex-row items-start sm:items-center space-y-3 sm:space-y-0 sm:space-x-4">
                <!-- Search Input -->
                <div class="relative w-full sm:w-auto">
                    <input type="text" wire:model.live="search" placeholder="Search requests..."
                        class="pl-10 pr-4 py-2 w-full sm:w-72 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent">
                    <span
                        class="material-icons-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-500">search</span>
                </div>

                <!-- Filter Dropdown -->
                <div class="relative w-full sm:w-auto" x-data="{ open: false }">
                    <button @click="open = !open"
                        class="flex items-center justify-center bg-gray-100 px-4 py-2 rounded-lg shadow-sm hover:bg-gray-200 w-full sm:w-auto">
                        <span>Filter by</span>
                        <span class="material-icons-outlined ml-2">arrow_drop_down</span>
                    </button>
                    <!-- Dropdown Menu -->
                    <div x-show="open" @click.away="open = false"
                        class="absolute right-0 mt-2 bg-white border rounded-lg shadow-lg w-full sm:w-40 z-50"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 transform scale-95"
                        x-transition:enter-end="opacity-100 transform scale-100"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 transform scale-100"
                        x-transition:leave-end="opacity-0 transform scale-95">
                        <ul class="text-gray-700">
                            <li><button wire:click="$set('filterField', 'id')"
                                    class="px-4 py-2 hover:bg-purple-50 hover:text-purple-700 w-full text-left">Transaction
                                    ID</button></li>
                            <li><button wire:click="$set('filterField', 'Name')"
                                    class="px-4 py-2 hover:bg-purple-50 hover:text-purple-700 w-full text-left">Name</button>
                            </li>
                            <li><button wire:click="$set('filterField', 'DocumentType')"
                                    class="px-4 py-2 hover:bg-purple-50 hover:text-purple-700 w-full text-left">Document
                                    Type</button></li>
                            <li><button wire:click="$set('filterField', 'Quantity')"
                                    class="px-4 py-2 hover:bg-purple-50 hover:text-purple-700 w-full text-left">Quantity</button>
                            </li>
                            <li><button wire:click="$set('filterField', 'DateRequested')"
                                    class="px-4 py-2 hover:bg-purple-50 hover:text-purple-700 w-full text-left">Date
                                    Requested</button></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Table Section -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 sm:px-6 py-3.5 text-sm sm:text-base font-semibold text-purple-800">
                            <button wire:click="sortBy('id')" class="flex items-center hover:text-purple-600">
                                Transaction ID
                                <span class="material-icons-outlined align-middle text-sm ml-1">
                                    {{ $sortField === 'id' ? ($sortDirection === 'asc' ? 'arrow_upward' : 'arrow_downward') : 'swap_vert' }}
                                </span>
                            </button>
                        </th>
                        <th class="px-4 sm:px-6 py-3.5 text-sm sm:text-base font-semibold text-purple-800">
                            <button wire:click="sortBy('Name')" class="flex items-center hover:text-purple-600">
                                Name
                                <span class="material-icons-outlined align-middle text-sm ml-1">
                                    {{ $sortField === 'Name' ? ($sortDirection === 'asc' ? 'arrow_upward' : 'arrow_downward') : 'swap_vert' }}
                                </span>
                            </button>
                        </th>
                        <th class="px-4 sm:px-6 py-3.5 text-sm sm:text-base font-semibold text-purple-800">
                            <button wire:click="sortBy('DocumentType')" class="flex items-center hover:text-purple-600">
                                Document Type
                                <span class="material-icons-outlined align-middle text-sm ml-1">
                                    {{ $sortField === 'DocumentType' ? ($sortDirection === 'asc' ? 'arrow_upward' : 'arrow_downward') : 'swap_vert' }}
                                </span>
                            </button>
                        </th>
                        <th class="px-4 sm:px-6 py-3.5 text-sm sm:text-base font-semibold text-purple-800">
                            <button wire:click="sortBy('Quantity')" class="flex items-center hover:text-purple-600">
                                Quantity
                                <span class="material-icons-outlined align-middle text-sm ml-1">
                                    {{ $sortField === 'Quantity' ? ($sortDirection === 'asc' ? 'arrow_upward' : 'arrow_downward') : 'swap_vert' }}
                                </span>
                            </button>
                        </th>
                        <th class="px-4 sm:px-6 py-3.5 text-sm sm:text-base font-semibold text-purple-800">
                            <button wire:click="sortBy('DateRequested')"
                                class="flex items-center hover:text-purple-600">
                                Date Requested
                                <span class="material-icons-outlined align-middle text-sm ml-1">
                                    {{ $sortField === 'DateRequested' ? ($sortDirection === 'asc' ? 'arrow_upward' : 'arrow_downward') : 'swap_vert' }}
                                </span>
                            </button>
                        </th>
                        <th class="px-4 sm:px-6 py-3.5 text-sm sm:text-base font-semibold text-purple-800">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($requests as $request)
                        <tr class="hover:bg-gray-200 transition-colors duration-150 ease-in-out">
                            <td class="px-4 sm:px-6 py-4 text-sm sm:text-base">
                                <span
                                    class="font-medium text-gray-900">TXN-{{ str_pad((string) $request->id, 2, '0', STR_PAD_LEFT) }}</span>
                            </td>
                            <td class="px-4 sm:px-6 py-4 text-sm sm:text-base text-gray-700">{{ $request->Name }}</td>
                            <td class="px-4 sm:px-6 py-4 text-sm sm:text-base text-gray-700">{{ $request->DocumentType }}
                            </td>
                            <td class="px-4 sm:px-6 py-4 text-sm sm:text-base text-gray-700">{{ $request->Quantity }}</td>
                            <td class="px-4 sm:px-6 py-4 text-sm sm:text-base text-gray-700">{{ $request->DateRequested }}
                            </td>
                            <td class="px-4 sm:px-6 py-4 text-sm sm:text-base">
                                <button
                                    class="view-btn bg-[#61009F] text-white px-6 py-1.5 rounded-md hover:bg-purple-700 focus:ring-2 focus:ring-purple-500 focus:ring-opacity-50 transition-all duration-150"
                                    data-id="{{ $request->Id }}">
                                    View
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Empty State -->
        @if(count($requests) === 0)
            <div class="text-center py-12">
                <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                    </path>
                </svg>
                <h3 class="mt-2 text-lg font-medium text-gray-900">No requests found</h3>
                <p class="mt-1 text-gray-500">No document requests match your current filter criteria.</p>
            </div>
        @endif

        <!-- Pagination Section -->
        <div class="px-4 sm:px-6 py-4 bg-gray-50 border-t border-gray-200">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <!-- Showing Results Text -->
                <div class="text-sm text-gray-700">
                    Showing {{ $requests->firstItem() ?? 0 }} to {{ $requests->lastItem() ?? 0 }} of
                    {{ $requests->total() }} results
                </div>

                <div class="flex flex-col sm:flex-row sm:items-center gap-4">
                    <!-- Items Per Page Dropdown -->
                    <div class="flex items-center gap-2">
                        <span class="text-sm text-gray-700">Rows per page</span>
                        <select wire:model.live="perPage"
                            class="border rounded px-2 py-1 text-sm text-gray-600 focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent">
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                        </select>
                    </div>

                    <!-- Navigation Buttons -->
                    <div class="flex items-center space-x-2">
                        <!-- First Page -->
                        <button wire:click="gotoPage(1)" @if($requests->onFirstPage()) disabled @endif
                            class="p-1 text-gray-600 hover:text-purple-800 disabled:text-gray-300 disabled:cursor-not-allowed">
                            <span class="material-icons-outlined text-xl">first_page</span>
                        </button>

                        <!-- Previous Page -->
                        <button wire:click="previousPage" @if($requests->onFirstPage()) disabled @endif
                            class="p-1 text-gray-600 hover:text-purple-800 disabled:text-gray-300 disabled:cursor-not-allowed">
                            <span class="material-icons-outlined text-xl">chevron_left</span>
                        </button>

                        <!-- Page Numbers -->
                        <div class="flex items-center space-x-1">
                            @for ($i = 1; $i <= $requests->lastPage(); $i++)
                                @if($i == $requests->currentPage())
                                    <button wire:click="gotoPage({{ $i }})"
                                        class="px-3 py-1 rounded-full bg-purple-900 text-white text-sm">
                                        {{ $i }}
                                    </button>
                                @elseif($i == 1 || $i == $requests->lastPage() || abs($requests->currentPage() - $i) <= 1)
                                    <button wire:click="gotoPage({{ $i }})"
                                        class="px-3 py-1 text-sm text-gray-600 hover:text-purple-800 hover:bg-purple-100 rounded-full">
                                        {{ $i }}
                                    </button>
                                @elseif(abs($requests->currentPage() - $i) == 2)
                                    <span class="text-gray-600">...</span>
                                @endif
                            @endfor
                        </div>

                        <!-- Next Page -->
                        <button wire:click="nextPage" @if(!$requests->hasMorePages()) disabled @endif
                            class="p-1 text-gray-600 hover:text-purple-800 disabled:text-gray-300 disabled:cursor-not-allowed">
                            <span class="material-icons-outlined text-xl">chevron_right</span>
                        </button>

                        <!-- Last Page -->
                        <button wire:click="gotoPage({{ $requests->lastPage() }})" @if(!$requests->hasMorePages())
                        disabled @endif
                            class="p-1 text-gray-600 hover:text-purple-800 disabled:text-gray-300 disabled:cursor-not-allowed">
                            <span class="material-icons-outlined text-xl">last_page</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>