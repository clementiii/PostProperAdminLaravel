<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document Requests</title>
    <link rel="icon" href="{{ asset('/assets/Southside.png') }}" type="image/png">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.4/dist/tailwind.min.css" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">

    {{-- <link rel="stylesheet" href="{{ asset('css/Documents.css') }}"> --}}

</head>

<body class="bg-gray-100">

    @extends('layouts.app')

    @section('title', 'Document Requests')

    @section('content')
    <div class="p-6 space-y-6">

        <div class="statistic-container grid grid-cols-1 md:grid-cols-5 gap-6 justify-items-center mb-6">
            <div class="card-request h-[120px] w-[280px] bg-blue-500 text-white p-6 rounded-lg shadow-lg shadow-blue-700 flex flex-col items-center justify-center">
                <h2 class="card-title text-xl font-semibold pb-2">Total Request</h2>
                <div class="card-text text-3xl font-bold" id="totalRequestCount">{{ $totalRequest }}</div>
            </div>
            <div class="card-pending h-[120px] w-[280px] bg-yellow-500 text-white p-6 rounded-lg shadow-lg shadow-yellow-700 flex flex-col items-center justify-center">
                <h2 class="card-title text-xl font-semibold pb-2">Pending</h2>
                <div class="card-text text-3xl font-bold" id="pendingCount">{{ $pendingCount }}</div>
            </div>
            <div class="card-approved h-[120px] w-[280px] bg-green-500 text-white p-6 rounded-lg shadow-lg shadow-green-700 flex flex-col items-center justify-center">
                <h2 class="card-title text-xl font-semibold pb-2">Approved</h2>
                <div class="card-text text-3xl font-bold" id="approvedCount">{{ $approvedCount }}</div>
            </div>
            <div class="card-rejected h-[120px] w-[280px] bg-red-500 text-white p-6 rounded-lg shadow-lg shadow-red-700 flex flex-col items-center justify-center">
                <h2 class="card-title text-xl font-semibold pb-2">Rejected</h2>
                <div class="card-text text-3xl font-bold" id="rejectedCount">{{ $rejectedCount }}</div>
            </div>
            <div class="card-overdue h-[120px] w-[280px] bg-gray-500 text-white p-6 rounded-lg shadow-lg shadow-gray-700 flex flex-col items-center justify-center">
                <h2 class="card-title text-xl font-semibold pb-2">Overdue</h2>
                <div class="card-text text-3xl font-bold" id="overdueCount">{{ $overdueCount }}</div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="h-1 bg-purple-800"></div> {{-- Purple Top Border --}}

            <div class="p-6 flex justify-between items-center">
                <div>
                    <h2 class="text-3xl font-semibold font-poppins text-purple-800">Document Requests</h2>
                    <p class="text-gray-500 mt-1">Manage and view all document requests</p>
                </div>
                {{-- You can add search/filter here if needed, like in dashboard.blade.php --}}
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-4 text-lg font-semibold text-purple-800 border-b-2 border-gray-200">Transaction ID</th>
                            <th class="px-6 py-4 text-lg font-semibold text-purple-800 border-b-2 border-gray-200">Name</th>
                            <th class="px-6 py-4 text-lg font-semibold text-purple-800 border-b-2 border-gray-200">Document Type</th>
                            <th class="px-6 py-4 text-lg font-semibold text-purple-800 border-b-2 border-gray-200">Date Requested</th>
                            <th class="px-6 py-4 text-lg font-semibold text-purple-800 border-b-2 border-gray-200">Date Approved</th>
                            <th class="px-6 py-4 text-lg font-semibold text-purple-800 border-b-2 border-gray-200">Status</th>
                            <th class="px-6 py-4 text-lg font-semibold text-purple-800 border-b-2 border-gray-200">Details</th>
                            <th class="px-6 py-4 text-lg font-semibold text-purple-800 border-b-2 border-gray-200">Action</th>
                            <th class="px-6 py-4 text-lg font-semibold text-purple-800 border-b-2 border-gray-200">Pickup Status</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700">
                        @foreach ($documentRequests as $row)
                        <tr class="border-t border-gray-200">
                            <td class="px-6 py-4">TXN-{{ $row->Id }}</td>
                            <td class="px-6 py-4">{{ $row->Name }}</td>
                            <td class="px-6 py-4">{{ $row->DocumentType }}</td>
                            <td class="px-6 py-4">{{ $row->DateRequested }}</td>
                            <td class="px-6 py-4">{{ $row->date_approved ?? '-' }}</td>
                            <td class="px-6 py-4">
                                @php
                                    $statusBadgeClass = '';
                                    switch(strtolower($row->Status)) {
                                        case 'pending':
                                            $statusBadgeClass = 'bg-yellow-200 text-yellow-800';
                                            break;
                                        case 'approved':
                                            $statusBadgeClass = 'bg-green-200 text-green-800';
                                            break;
                                        case 'rejected':
                                            $statusBadgeClass = 'bg-red-200 text-red-800';
                                            break;
                                        case 'cancelled':
                                            $statusBadgeClass = 'bg-gray-200 text-gray-800';
                                            break;
                                        case 'overdue':
                                            $statusBadgeClass = 'bg-gray-200 text-gray-800';
                                            break;
                                    }
                                @endphp
                                <span class="{{ $statusBadgeClass }} px-2 py-1 rounded-full font-semibold text-sm">{{ ucfirst(strtolower($row->Status)) }}</span>
                            </td>
                            <td class="px-6 py-4">
                                @if(strtolower($row->Status) === 'cancelled' && !empty($row->cancellation_reason))
                                    <button class="view-btn text-blue-600 hover:underline" onclick="showCancellationReason('{{ htmlspecialchars($row->cancellation_reason) }}')">
                                        <i class="far fa-eye"></i> Reason
                                    </button>
                                @else
                                    -
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if(strtolower($row->Status) === 'rejected')
                                    <button class="action-button button-rejected bg-red-100 text-red-700 px-3 py-1 rounded-full text-sm font-semibold" disabled>Rejected</button>
                                @elseif(strtolower($row->Status) === 'approved')
                                    <button class="action-button button-approved bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm font-semibold" disabled>Approved</button>
                                @elseif(strtolower($row->Status) === 'cancelled')
                                    <button class="action-button button-cancelled bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-sm font-semibold" disabled>Cancelled</button>
                                @elseif(strtolower($row->Status) === 'overdue')
                                    <button class="action-button button-overdue bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-sm font-semibold" disabled>Overdue</button>
                                @else
                                    <a href="{{ route('documents.show', $row->Id) }}" class="action-button text-blue-600 hover:underline">View</a>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if(strtolower($row->Status) === 'approved')
                                    @php
                                        $pickupStatus = $row->pickup_status ?? 'pending';
                                        $isPickedUp = $pickupStatus === 'picked_up';
                                    @endphp
                                    <div class="form-check form-switch flex items-center justify-center">
                                        <input class="form-check-input appearance-none w-9 align-top bg-white bg-no-repeat bg-contain float-left mr-2 cursor-pointer focus:outline-none shadow-sm" type="checkbox" role="switch" id="pickup-toggle-{{ $row->Id }}" data-request-id="{{ $row->Id }}" {{ $isPickedUp ? 'checked' : '' }} onchange="updatePickup(this, {{ $row->Id }})">
                                        <label class="form-check-label inline-block text-gray-700" for="pickup-toggle-{{ $row->Id }}">
                                            {{ $isPickedUp ? 'Picked Up' : 'Not Picked Up' }}
                                        </label>
                                    </div>
                                @else
                                    <span class="text-gray-500">N/A</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div id="cancellationModal" class="relative z-10 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
            <div class="fixed z-10 inset-0 overflow-y-auto">
                <div class="flex items-end sm:items-center justify-center min-h-full p-4 text-center sm:p-0">
                    <div class="relative bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:max-w-lg sm:w-full">
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <div class="sm:flex sm:items-start">
                                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                    <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                        Cancellation Reason
                                    </h3>
                                    <div class="mt-2">
                                        <p id="cancellationReason" class="text-sm text-gray-500">
                                            {{-- Reason will be inserted here by JS --}}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button id="closeCancellationModal" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm" data-bs-dismiss="modal">
                                Close
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    function showCancellationReason(reason) {
        document.getElementById('cancellationReason').innerText = reason;
        document.getElementById('cancellationModal').classList.remove('hidden');
    }

    document.getElementById('closeCancellationModal').addEventListener('click', function() {
        document.getElementById('cancellationModal').classList.add('hidden');
    });

    function updatePickup(checkbox, requestId) {
        const newStatus = checkbox.checked ? 'picked_up' : 'pending';
        const label = checkbox.nextElementSibling;

        $.ajax({
            url: "{{ route('documents.updatePickupStatus') }}", // **Corrected route name here**
            type: "POST",
            data: {
                requestId: requestId,
                newStatus: newStatus,
                _token: '{{ csrf_token() }}'
            },
            dataType: 'json',
            success: function(response) {
                if(response.success) {
                    label.textContent = newStatus === 'picked_up' ? 'Picked Up' : 'Not Picked Up';
                } else {
                    alert('Error updating pickup status: ' + response.error);
                    checkbox.checked = !checkbox.checked;
                    label.textContent = newStatus !== 'picked_up' ? 'Picked Up' : 'Not Picked Up';
                }
            },
            error: function(xhr, status, error) {
                alert('AJAX request failed: ' + error);
                checkbox.checked = !checkbox.checked;
                label.textContent = newStatus !== 'picked_up' ? 'Picked Up' : 'Not Picked Up';
            }
        });
    }
</script>
    @endsection

</body>

</html>