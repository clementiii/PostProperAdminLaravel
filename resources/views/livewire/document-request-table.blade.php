<div>
    <!-- Stats Cards -->
    <div class="mb-12 grid grid-cols-1 md:grid-cols-3 gap-12 justify-items-center">
        <div
            class="h-[150px] w-[500px] bg-gradient-to-r from-blue-500 to-blue-600 text-white p-6 rounded-lg shadow-lg shadow-blue-700 flex items-center">
            <div class="mr-4">
                <h3 class="text-xl pb-3">Registered Residents</h3>
                <p id="residentsCount" class="text-4xl font-bold">{{ $registeredResidents }}</p>
            </div>
            <i class="material-icons-outlined bg-white bg-opacity-20 rounded-full !text-[64px] ml-auto p-5">group</i>
        </div>
        <div
            class="h-[150px] w-[500px] bg-gradient-to-r from-yellow-500 to-yellow-600 text-white p-6 rounded-lg shadow-lg shadow-yellow-700 flex items-center">
            <div class="mr-4">
                <h3 class="text-xl pb-3">Pending Documents</h3>
                <p id="pendingDocsCount" class="text-4xl font-bold">{{ $pendingDocuments }}</p>
            </div>
            <i
                class="material-icons-outlined bg-white bg-opacity-20 rounded-full !text-[64px] ml-auto p-5">description</i>
        </div>
        <div
            class="h-[150px] w-[500px] bg-gradient-to-r from-red-500 to-red-600 text-white p-6 rounded-lg shadow-lg shadow-red-700 flex items-center">
            <div class="mr-4">
                <h3 class="text-xl pb-3">Incident Reports</h3>
                <p id="incidentCount" class="text-4xl font-bold">{{ $incidentReports }}</p>
            </div>
            <i class="material-icons-outlined bg-white bg-opacity-20 rounded-full !text-[64px] ml-auto p-5">report</i>
        </div>
    </div>

    <!-- Recent Document Requests -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <!-- Purple Top Border -->
        <div class="h-1 bg-purple-800"></div>

        <!-- Header Section -->
        <div class="p-6 flex justify-between items-center">
            <div>
                <h2 class="text-3xl font-semibold font-poppins text-purple-800">Recent Document Request</h2>
                <p class="text-gray-500 mt-1">Manage and view all recent document requests from residents</p>
            </div>

            <!-- Search and Filter Section -->
            <div class="flex items-center space-x-4">
                <!-- Search Input -->
                <div class="relative">
                    <input type="text" wire:model.live="search" placeholder="Search requests..."
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
                            <li><button wire:click="$set('filterField', 'id')"
                                    class="px-4 py-2 hover:bg-gray-100 w-full text-left">Transaction ID</button></li>
                            <li><button wire:click="$set('filterField', 'Name')"
                                    class="px-4 py-2 hover:bg-gray-100 w-full text-left">Name</button></li>
                            <li><button wire:click="$set('filterField', 'DocumentType')"
                                    class="px-4 py-2 hover:bg-gray-100 w-full text-left">Document Type</button></li>
                            <li><button wire:click="$set('filterField', 'Quantity')"
                                    class="px-4 py-2 hover:bg-gray-100 w-full text-left">Quantity</button></li>
                            <li><button wire:click="$set('filterField', 'DateRequested')"
                                    class="px-4 py-2 hover:bg-gray-100 w-full text-left">Date Requested</button></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Table Section -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-4 text-lg font-semibold text-purple-800">
                            <button wire:click="sortBy('id')" class="flex items-center">
                                Transaction ID
                                <span class="material-icons-outlined align-middle cursor-pointer">
                                    {{ $sortField === 'id' ? ($sortDirection === 'asc' ? 'arrow_upward' : 'arrow_downward') : 'swap_vert' }}
                                </span>
                            </button>
                        </th>
                        <th class="px-6 py-4 text-lg font-semibold text-purple-800">
                            <button wire:click="sortBy('Name')" class="flex items-center">
                                Name
                                <span class="material-icons-outlined align-middle cursor-pointer">
                                    {{ $sortField === 'Name' ? ($sortDirection === 'asc' ? 'arrow_upward' : 'arrow_downward') : 'swap_vert' }}
                                </span>
                            </button>
                        </th>
                        <th class="px-6 py-4 text-lg font-semibold text-purple-800">
                            <button wire:click="sortBy('DocumentType')" class="flex items-center">
                                Document Type
                                <span class="material-icons-outlined align-middle cursor-pointer">
                                    {{ $sortField === 'DocumentType' ? ($sortDirection === 'asc' ? 'arrow_upward' : 'arrow_downward') : 'swap_vert' }}
                                </span>
                            </button>
                        </th>
                        <th class="px-6 py-4 text-lg font-semibold text-purple-800">
                            <button wire:click="sortBy('Quantity')" class="flex items-center">
                                Quantity
                                <span class="material-icons-outlined align-middle cursor-pointer">
                                    {{ $sortField === 'Quantity' ? ($sortDirection === 'asc' ? 'arrow_upward' : 'arrow_downward') : 'swap_vert' }}
                                </span>
                            </button>
                        </th>
                        <th class="px-6 py-4 text-lg font-semibold text-purple-800">
                            <button wire:click="sortBy('DateRequested')" class="flex items-center">
                                Date Requested
                                <span class="material-icons-outlined align-middle cursor-pointer">
                                    {{ $sortField === 'DateRequested' ? ($sortDirection === 'asc' ? 'arrow_upward' : 'arrow_downward') : 'swap_vert' }}
                                </span>
                            </button>
                        </th>
                        <th class="px-6 py-4 text-lg font-semibold text-purple-800">Action</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    @foreach($requests as $request)
                        <tr class="border-t">
                            <td class="px-6 py-4">
                                <span
                                    class="font-medium">TXN-{{ str_pad((string) $request->id, 2, '0', STR_PAD_LEFT) }}</span>
                            </td>
                            <td class="px-6 py-4">{{ $request->Name }}</td>
                            <td class="px-6 py-4">{{ $request->DocumentType }}</td>
                            <td class="px-6 py-4">{{ $request->Quantity }}</td>
                            <td class="px-6 py-4">{{ $request->DateRequested }}</td>
                            <td class="px-6 py-4">
                                <button class="view-btn text-blue-600 hover:underline" data-id="{{ $request->id }}"
                                    onclick="showModal({{ $request->id }})">
                                    <i class="material-icons-outlined text-[24px]">visibility</i>
                                </button>
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
                    Showing {{ $requests->firstItem() ?? 0 }} to {{ $requests->lastItem() ?? 0 }} of
                    {{ $requests->total() }} results
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
                    <div class="flex items-center space-x-4">
                        <!-- First Page -->
                        <button wire:click="gotoPage(1)" @if($requests->onFirstPage()) disabled @endif
                            class="p-1 text-gray-600 hover:text-purple-800 disabled:text-gray-300 disabled:cursor-not-allowed text-2xl font-bold">
                            «
                        </button>

                        <!-- Previous Page -->
                        <button wire:click="previousPage" @if($requests->onFirstPage()) disabled @endif
                            class="p-1 text-gray-600 hover:text-purple-800 disabled:text-gray-300 disabled:cursor-not-allowed text-3xl font-bold">
                            ‹
                        </button>

                        <!-- Page Numbers -->
                        @for ($i = 1; $i <= $requests->lastPage(); $i++)
                            @if($i == $requests->currentPage())
                                <button wire:click="gotoPage({{ $i }})"
                                    class="px-3 py-1 rounded-full bg-purple-900 text-white text-lg">
                                    {{ $i }}
                                </button>
                            @elseif($i == 1 || $i == $requests->lastPage() || abs($requests->currentPage() - $i) <= 2)
                                <button wire:click="gotoPage({{ $i }})"
                                    class="px-3 py-1 text-lg text-gray-600 hover:text-purple-800">
                                    {{ $i }}
                                </button>
                            @elseif(abs($requests->currentPage() - $i) == 3)
                                <span class="text-gray-600">...</span>
                            @endif
                        @endfor

                        <!-- Next Page -->
                        <button wire:click="nextPage" @if(!$requests->hasMorePages()) disabled @endif
                            class="p-1 text-purple-600 hover:text-purple-800 disabled:text-gray-300 disabled:cursor-not-allowed text-3xl font-bold">
                            ›
                        </button>

                        <!-- Last Page -->
                        <button wire:click="gotoPage({{ $requests->lastPage() }})" @if(!$requests->hasMorePages())
                        disabled @endif
                            class="p-1 text-purple-600 hover:text-purple-800 disabled:text-gray-300 disabled:cursor-not-allowed text-2xl font-bold">
                            »
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>