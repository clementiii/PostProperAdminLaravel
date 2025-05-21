<div>
    <!-- Stats Cards -->
    <div class="mb-12 grid grid-cols-1 md:grid-cols-3 gap-12 justify-items-center">
        <div
            class="h-[150px] w-[500px] bg-gradient-to-r from-blue-500 to-blue-600 text-white p-6 rounded-lg shadow-lg shadow-blue-700 flex items-center">
            <div class="mr-4">
                <h3 class="text-xl pb-3">Total Reports</h3>
                <p id="totalReports" class="text-4xl font-bold">{{ $totalReports }}</p>
            </div>
            <i
                class="material-icons-outlined bg-white bg-opacity-20 rounded-full !text-[64px] ml-auto p-5">description</i>
        </div>
        <div
            class="h-[150px] w-[500px] bg-gradient-to-r from-amber-500 to-amber-600 text-white p-6 rounded-lg shadow-lg shadow-amber-700 flex items-center">
            <div class="mr-4">
                <h3 class="text-xl pb-3">Pending Reports</h3>
                <p id="pendingReports" class="text-4xl font-bold">{{ $pendingReports }}</p>
            </div>
            <i
                class="material-symbols-outlined bg-white bg-opacity-20 rounded-full !text-[64px] ml-auto p-5">pending</i>
        </div>
        <div
            class="h-[150px] w-[500px] bg-gradient-to-r from-emerald-500 to-emerald-600 text-white p-6 rounded-lg shadow-lg shadow-emerald-700 flex items-center">
            <div class="mr-4">
                <h3 class="text-xl pb-3">Resolved Reports</h3>
                <p id="resolvedReports" class="text-4xl font-bold">{{ $resolvedReports }}</p>
            </div>
            <i class="material-icons-outlined bg-white bg-opacity-20 rounded-full !text-[64px] ml-auto p-5">task_alt</i>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-lg overflow-hidden mt-9">
        <!-- Purple Top Border -->
        <div class="h-1 bg-purple-800"></div>

        <!-- Header Section -->
        <div class="p-6 flex justify-between items-center">
            <div>
                <h2 class="text-3xl font-semibold font-poppins text-purple-800">Incident Reports</h2>
                <p class="text-gray-500 mt-1">Manage and view all incident reports from residents</p>
            </div>

            <!-- Search and Filter Section -->
            <div class="flex items-center space-x-4">
                <!-- Search Input -->
                <div class="relative">
                    <input type="text" wire:model.live="search" placeholder="Search reports..."
                        class="pl-10 pr-4 py-2 w-72 rounded-lg border focus:outline-none focus:ring-2 focus:ring-purple-600">
                    <span
                        class="material-icons-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-500">search</span>
                </div>

                <!-- Filter Dropdown -->
                <div class="relative">
                    <select wire:model.live="filterField"
                        class="border rounded-lg px-4 py-2 pr-10 appearance-none bg-white">
                        <option value="">Filter by</option>
                        <option value="title">Report Title</option>
                        <option value="date_submitted">Date Submitted</option>
                        <option value="status">Status</option>
                    </select>
                    <span class="material-icons-outlined absolute right-2 top-1/2 -translate-y-1/2 text-gray-500 pointer-events-none">
                        arrow_drop_down
                    </span>
                </div>
            </div>
        </div>

        <!-- Table Section -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-100 text-center">
                    <tr>
                        <th class="px-6 py-4 text-lg font-semibold text-purple-800">
                            <button wire:click="sortBy('name')" class="flex items-center justify-center w-full">
                                Name
                                <span class="material-icons-outlined align-middle cursor-pointer">
                                    {{ $sortField === 'name' ? ($sortDirection === 'asc' ? 'arrow_upward' : 'arrow_downward') : 'swap_vert' }}
                                </span>
                            </button>
                        </th>
                        <th class="px-6 py-4 text-lg font-semibold text-purple-800">
                            <button wire:click="sortBy('title')" class="flex items-center justify-center w-full">
                                Report Title
                                <span class="material-icons-outlined align-middle cursor-pointer">
                                    {{ $sortField === 'title' ? ($sortDirection === 'asc' ? 'arrow_upward' : 'arrow_downward') : 'swap_vert' }}
                                </span>
                            </button>
                        </th>
                        <th class="px-6 py-4 text-lg font-semibold text-purple-800">Description</th>
                        <th class="px-6 py-4 text-lg font-semibold text-purple-800">
                            <button wire:click="sortBy('date_submitted')"
                                class="flex items-center justify-center w-full">
                                Date Submitted
                                <span class="material-icons-outlined align-middle cursor-pointer">
                                    {{ $sortField === 'date_submitted' ? ($sortDirection === 'asc' ? 'arrow_upward' : 'arrow_downward') : 'swap_vert' }}
                                </span>
                            </button>
                        </th>
                        <th class="px-6 py-4 text-lg font-semibold text-purple-800">Status</th>
                        <th class="px-6 py-4 text-lg font-semibold text-purple-800">Action</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    @foreach($reports as $report)
                        <tr class="border-t text-center hover:bg-gray-200">
                            <td class="p-2">{{ $report->name }}</td>
                            <td class="p-2">{{ $report->title }}</td>
                            <td class="p-2">{{ $report->description }}</td>
                            <td class="p-2">{{ \Carbon\Carbon::parse($report->date_submitted)->format('F d, Y h:i A') }}</td>
                            <td class="p-2">
                                <span
                                    class="px-3 py-1 rounded-full {{ $report->status === 'pending' ? 'bg-[#FEF9C3] text-gray-700' : 'bg-[#DCFCE7] text-[#1A6838]' }}">
                                    {{ ucfirst($report->status) }}
                                </span>
                            </td>
                            <td class="p-2">
                                <a href="{{ route('incident-reports.show', $report->id) }}"
                                    class="bg-purple-900 hover:bg-purple-800 text-white py-1 px-3 rounded text-sm font-medium"
                                    title="View Details">
                                    View
                                </a>
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
                    Showing {{ $reports->firstItem() ?? 0 }} to {{ $reports->lastItem() ?? 0 }} of
                    {{ $reports->total() }} results
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
                        <button wire:click="gotoPage(1)" @if($reports->onFirstPage()) disabled @endif
                            class="p-1 text-gray-600 hover:text-purple-800 disabled:text-gray-300 disabled:cursor-not-allowed text-2xl font-bold">
                            «
                        </button>

                        <!-- Previous Page -->
                        <button wire:click="previousPage" @if($reports->onFirstPage()) disabled @endif
                            class="p-1 text-gray-600 hover:text-purple-800 disabled:text-gray-300 disabled:cursor-not-allowed text-3xl font-bold">
                            ‹
                        </button>

                        <!-- Page Numbers -->
                        @for ($i = 1; $i <= $reports->lastPage(); $i++)
                            @if($i == $reports->currentPage())
                                <button wire:click="gotoPage({{ $i }})"
                                    class="px-3 py-1 rounded-full bg-purple-900 text-white text-lg">
                                    {{ $i }}
                                </button>
                            @elseif($i == 1 || $i == $reports->lastPage() || abs($reports->currentPage() - $i) <= 2)
                                <button wire:click="gotoPage({{ $i }})"
                                    class="px-3 py-1 text-lg text-gray-600 hover:text-purple-800">
                                    {{ $i }}
                                </button>
                            @elseif(abs($reports->currentPage() - $i) == 3)
                                <span class="text-gray-600">...</span>
                            @endif
                        @endfor

                        <!-- Next Page -->
                        <button wire:click="nextPage" @if(!$reports->hasMorePages()) disabled @endif
                            class="p-1 text-gray-600 hover:text-purple-800 disabled:text-gray-300 disabled:cursor-not-allowed text-3xl font-bold">
                            ›
                        </button>

                        <!-- Last Page -->
                        <button wire:click="gotoPage({{ $reports->lastPage() }})" @if(!$reports->hasMorePages()) disabled
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