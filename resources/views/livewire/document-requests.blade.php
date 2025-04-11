<div class="p-6 space-y-6">
    <div class="statistic-container grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 mb-10"
        style="grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));">
        <div
            class="relative h-[150px] w-full bg-blue-500 text-white p-6 rounded-lg shadow-lg flex items-center transition-transform hover:scale-105 hover:shadow-md">
            <div class="flex-1">
                <h2 class="text-lg font-semibold pb-1">Total Requests</h2>
                <div class="text-3xl font-bold">{{ $totalRequest }}</div>
            </div>
            <div class="bg-white bg-opacity-20 rounded-full p-4 ml-auto flex items-center justify-center">
                <i class="material-icons-outlined !text-[48px]">info</i>
            </div>
        </div>
        <div
            class="relative h-[150px] w-full bg-yellow-500 text-white p-6 rounded-lg shadow-lg flex items-center transition-transform hover:scale-105 hover:shadow-md">
            <div class="flex-1">
                <h2 class="text-lg font-semibold pb-1">Pending</h2>
                <div class="text-3xl font-bold">{{ $pendingCount }}</div>
            </div>
            <div class="bg-white bg-opacity-20 rounded-full p-4 ml-auto flex items-center justify-center">
                <i class="material-icons-outlined !text-[48px]">hourglass_empty</i>
            </div>
        </div>
        @if($approvedCount > 0)
            <div
                class="relative h-[150px] w-full bg-green-500 text-white p-6 rounded-lg shadow-lg flex items-center transition-transform hover:scale-105 hover:shadow-md">
                <div class="flex-1">
                    <h2 class="text-lg font-semibold pb-1">Approved</h2>
                    <div class="text-3xl font-bold">{{ $approvedCount }}</div>
                </div>
                <div class="bg-white bg-opacity-20 rounded-full p-4 ml-auto flex items-center justify-center">
                    <i class="material-icons-outlined !text-[48px]">check_circle</i>
                </div>
            </div>
        @endif
        @if($rejectedCount > 0)
            <div
                class="relative h-[150px] w-full bg-red-500 text-white p-6 rounded-lg shadow-lg flex items-center transition-transform hover:scale-105 hover:shadow-md">
                <div class="flex-1">
                    <h2 class="text-lg font-semibold pb-1">Rejected</h2>
                    <div class="text-3xl font-bold">{{ $rejectedCount }}</div>
                </div>
                <div class="bg-white bg-opacity-20 rounded-full p-4 ml-auto flex items-center justify-center">
                    <i class="material-icons-outlined !text-[48px]">cancel</i>
                </div>
            </div>
        @endif
        <div
            class="relative h-[150px] w-full bg-gray-500 text-white p-6 rounded-lg shadow-lg flex items-center transition-transform hover:scale-105 hover:shadow-md">
            <div class="flex-1">
                <h2 class="text-lg font-semibold pb-1">Overdue</h2>
                <div class="text-3xl font-bold">{{ $overdueCount }}</div>
            </div>
            <div class="bg-white bg-opacity-20 rounded-full p-4 ml-auto flex items-center justify-center">
                <i class="material-icons-outlined !text-[48px]">schedule</i>
            </div>
        </div>
    </div>

    <div>
        <div class="flex flex-col md:flex-row md:space-x-4 space-y-3 md:space-y-0 mb-6">
            <div class="flex-1 relative">
                <span class="absolute inset-y-0 left-4 flex items-center text-gray-400">
                    <i class="material-icons-outlined text-lg">search</i>
                </span>
                <input type="text" placeholder="Search by name or transaction ID"
                    class="w-full pl-12 pr-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                    wire:model.live.debounce.500ms="search">
            </div>
            <div class="w-full md:w-60 relative">
                <select
                    class="w-full py-3 px-4 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all appearance-none bg-white"
                    wire:model.live="statusFilter">
                    <option value="">All Statuses</option>
                    <option value="pending">Pending</option>
                    <option value="approved">Approved</option>
                    <option value="rejected">Rejected</option>
                    <option value="overdue">Overdue</option>
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                    <i class="material-icons-outlined text-gray-400">arrow_drop_down</i>
                </div>
            </div>
        </div>

        <div class="space-y-4">
            @foreach ($documentRequests as $row)
                <div class="bg-white rounded-lg shadow-md p-4 flex justify-between items-center">
                    <div>
                        <h3 class="text-xl font-semibold text-purple-900">TXN-{{ $row->Id }}</h3>
                        <p class="text-gray-600">{{ $row->Name }}</p>
                        <p class="text-sm text-gray-500">Requested on {{ $row->DateRequested }}</p>
                    </div>
                    <div class="flex items-center space-x-4">
                        <span class="px-3 py-1 rounded-full text-sm font-semibold 
                            @if(strtolower($row->Status) === 'pending') bg-yellow-200 text-yellow-800 
                            @elseif(strtolower($row->Status) === 'approved') bg-green-200 text-green-800 
                            @elseif(strtolower($row->Status) === 'rejected') bg-red-200 text-red-800 
                            @else bg-gray-200 text-gray-800 @endif">
                            {{ ucfirst(strtolower($row->Status)) }}
                        </span>
                        
                        {{-- Show pickup status for approved documents --}}
                        @if(strtolower($row->Status) === 'approved')
                            <span class="px-3 py-1 rounded-full text-sm font-semibold 
                                @if($row->pickup_status === 'pending') bg-blue-200 text-blue-800
                                @else bg-purple-200 text-purple-800 @endif">
                                {{ $row->pickup_status === 'picked_up' ? 'Picked Up' : 'Awaiting Pickup' }}
                            </span>
                        @endif
                        <a href="{{ route('documents.show', $row->Id) }}"
                            class="px-4 py-2 rounded-lg text-white bg-[#0F172A] hover:bg-opacity-90">
                            View Details
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="mt-6 flex justify-between items-center">
        <div class="text-sm text-gray-600">
            Showing {{ $documentRequests->firstItem() }} to {{ $documentRequests->lastItem() }} of
            {{ $documentRequests->total() }} results
        </div>
        <div class="flex items-center space-x-2">
            <span class="text-sm">Rows per page</span>
            <select class="border rounded-lg p-2 text-sm" wire:model="perPage">
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>
            <div class="flex items-center space-x-1">
                <button class="px-3 py-1 border rounded-lg text-sm text-gray-600 hover:bg-gray-100 disabled:opacity-50"
                    wire:click="previousPage" @if(!$documentRequests->onFirstPage()) wire:loading.attr="disabled" @endif
                    @if($documentRequests->onFirstPage()) disabled @endif>
                    &laquo;
                </button>
                @foreach ($documentRequests->links()->elements[0] as $page => $url)
                    @if ($page == $documentRequests->currentPage())
                        <span class="px-3 py-1 border rounded-lg bg-purple-700 text-white text-sm">
                            {{ $page }}
                        </span>
                    @else
                        <button class="px-3 py-1 border rounded-lg text-sm text-purple-700 hover:bg-gray-100"
                            wire:click="gotoPage({{ $page }})">
                            {{ $page }}
                        </button>
                    @endif
                @endforeach
                <button class="px-3 py-1 border rounded-lg text-sm text-gray-600 hover:bg-gray-100 disabled:opacity-50"
                    wire:click="nextPage" @if($documentRequests->hasMorePages()) wire:loading.attr="disabled" @endif
                    @if(!$documentRequests->hasMorePages()) disabled @endif>
                    &raquo;
                </button>
            </div>
        </div>
    </div>
</div>