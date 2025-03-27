<div class="p-6 space-y-6">
    <div class="statistic-container grid grid-cols-1 md:grid-cols-5 gap-6 justify-items-center mb-12">
        <div
            class="relative h-[8.5rem] w-[23rem] bg-blue-500 text-white p-6 rounded-lg shadow-lg shadow-blue-700 flex items-center">
            <div>
                <h2 class="card-title text-xl font-semibold pb-2">Total Requests</h2>
                <div class="card-text text-3xl font-bold">{{ $totalRequest }}</div>
            </div>
            <i class="material-icons-outlined bg-white bg-opacity-20 rounded-full !text-[48px] ml-auto p-5">info</i>
        </div>
        <div
            class="relative h-[8.5rem] w-[23rem] bg-yellow-500 text-white p-6 rounded-lg shadow-lg shadow-yellow-700 flex items-center">
            <div>
                <h2 class="card-title text-xl font-semibold pb-2">Pending</h2>
                <div class="card-text text-3xl font-bold">{{ $pendingCount }}</div>
            </div>
            <i
                class="material-icons-outlined bg-white bg-opacity-20 rounded-full !text-[48px] ml-auto p-5">hourglass_empty</i>
        </div>
        <div
            class="relative h-[8.5rem] w-[23rem] bg-green-500 text-white p-6 rounded-lg shadow-lg shadow-green-700 flex items-center">
            <div>
                <h2 class="card-title text-xl font-semibold pb-2">Approved</h2>
                <div class="card-text text-3xl font-bold">{{ $approvedCount }}</div>
            </div>
            <i
                class="material-icons-outlined bg-white bg-opacity-20 rounded-full !text-[48px] ml-auto p-5">check_circle</i>
        </div>
        <div
            class="relative h-[8.5rem] w-[23rem] bg-red-500 text-white p-6 rounded-lg shadow-lg shadow-red-700 flex items-center">
            <div>
                <h2 class="card-title text-xl font-semibold pb-2">Rejected</h2>
                <div class="card-text text-3xl font-bold">{{ $rejectedCount }}</div>
            </div>
            <i class="material-icons-outlined bg-white bg-opacity-20 rounded-full !text-[48px] ml-auto p-5">cancel</i>
        </div>
        <div
            class="relative h-[8.5rem] w-[23rem] bg-gray-500 text-white p-6 rounded-lg shadow-lg shadow-gray-700 flex items-center">
            <div>
                <h2 class="card-title text-xl font-semibold pb-2">Overdue</h2>
                <div class="card-text text-3xl font-bold">{{ $overdueCount }}</div>
            </div>
            <i class="material-icons-outlined bg-white bg-opacity-20 rounded-full !text-[48px] ml-auto p-5">schedule</i>
        </div>
    </div>

    <div>
        <div class="flex space-x-4 mb-6">
            <input type="text" placeholder="Search by name or transaction ID" class="w-full p-3 border rounded-lg"
                wire:model.debounce.500ms="search"> <!-- Added debounce for better performance -->
            <select class="p-3 border rounded-lg" wire:model="statusFilter">
                <option value="">All Statuses</option>
                <option value="pending">Pending</option>
                <option value="approved">Approved</option>
                <option value="rejected">Rejected</option>
                <option value="overdue">Overdue</option>
            </select>
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
                        <a href="{{ route('documents.show', $row->Id) }}" class="text-blue-600 hover:underline">View
                            Details</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="mt-6">
        {{ $documentRequests->links() }}
    </div>
</div>