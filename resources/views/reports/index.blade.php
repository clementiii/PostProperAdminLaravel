<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.4/dist/tailwind.min.css" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">

    {{-- You can remove the Reports.css link if you are fully transitioning to Tailwind --}}
    {{-- <link rel="stylesheet" href="{{ asset('css/Reports.css') }}"> --}}

</head>

<body class="bg-gray-100">

    @extends('layouts.dashboard-topbar')

    @section('title', 'Incident Reports') {{-- Set the title for the Reports page --}}

    @section('content')
    <div class="p-6 space-y-6">

        <div class="statistic-container grid grid-cols-1 md:grid-cols-3 gap-6 justify-items-center mb-6">
            <div class="card-request h-[120px] w-[280px] bg-blue-500 text-white p-6 rounded-lg shadow-lg shadow-blue-700 flex flex-col items-center justify-center">
                <h2 class="card-title text-xl font-semibold pb-2">Total Reports</h2>
                <div class="card-text text-3xl font-bold" id="totalReportCount">{{ $totalReports }}</div>
            </div>
            <div class="card-pending h-[120px] w-[280px] bg-yellow-500 text-white p-6 rounded-lg shadow-lg shadow-yellow-700 flex flex-col items-center justify-center">
                <h2 class="card-title text-xl font-semibold pb-2">Pending</h2>
                <div class="card-text text-3xl font-bold" id="pendingCount">{{ $pendingReports }}</div>
            </div>
            <div class="card-approved h-[120px] w-[280px] bg-green-500 text-white p-6 rounded-lg shadow-lg shadow-green-700 flex flex-col items-center justify-center">
                <h2 class="card-title text-xl font-semibold pb-2">Resolved</h2>
                <div class="card-text text-3xl font-bold" id="resolvedCount">{{ $resolvedReports }}</div>
            </div>
        </div>


        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="h-1 bg-purple-800"></div> {{-- Purple Top Border --}}

            <div class="p-6 flex justify-between items-center">
                <div>
                    <h2 class="text-3xl font-semibold font-poppins text-purple-800">Incident Reports</h2>
                    <p class="text-gray-500 mt-1">Manage and view all incident reports</p>
                </div>
                {{-- You can add search/filter here if needed, similar to documents.blade.php or dashboard.blade.php --}}
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse table">
                    <thead class="bg-gray-100">
                        <tr>
                            <th data-sort="string" class="px-6 py-4 text-lg font-semibold text-purple-800 border-b-2 border-gray-200">Name</th>
                            <th data-sort="string" class="px-6 py-4 text-lg font-semibold text-purple-800 border-b-2 border-gray-200">Title</th>
                            <th data-sort="string" class="px-6 py-4 text-lg font-semibold text-purple-800 border-b-2 border-gray-200">Description</th>
                            <th data-sort="date" class="px-6 py-4 text-lg font-semibold text-purple-800 border-b-2 border-gray-200">Date Submitted</th>
                            <th data-sort="status" class="px-6 py-4 text-lg font-semibold text-purple-800 border-b-2 border-gray-200">Status</th>
                            <th class="px-6 py-4 text-lg font-semibold text-purple-800 border-b-2 border-gray-200">Action</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700">
                        @if(!empty($reports))
                            @foreach($reports as $report)
                                <tr class="border-t border-gray-200">
                                    <td class="px-6 py-4">{{ htmlspecialchars($report->name) }}</td>
                                    <td class="px-6 py-4">{{ htmlspecialchars($report->title) }}</td>
                                    <td class="px-6 py-4">{{ htmlspecialchars(app('App\Http\Controllers\ReportsController')->truncateDescription($report->description)) }}</td>
                                    <td class="px-6 py-4">{{ date('m/d/Y', strtotime($report->date_submitted)) }}</td>
                                    <td class="px-6 py-4">
                                        @php
                                            $statusBadgeClass = '';
                                            $status = strtolower($report->status);
                                            switch($status) {
                                                case 'pending':
                                                    $statusBadgeClass = 'bg-yellow-200 text-yellow-800';
                                                    break;
                                                case 'resolved':
                                                    $statusBadgeClass = 'bg-green-200 text-green-800';
                                                    break;
                                            }
                                        @endphp
                                        <span class="{{ $statusBadgeClass }} px-2 py-1 rounded-full font-semibold text-sm">{{ ucfirst(htmlspecialchars($status)) }}</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if ($status === 'resolved')
                                            <button class="action-button button-approved bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm font-semibold" disabled>Resolved</button>
                                        @else
                                            <a href="report_verify.php?id={{ htmlspecialchars($report->id) }}" class="action-button text-blue-600 hover:underline">View</a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr><td colspan='6' class="px-6 py-4 text-center">No reports found.</td></tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>


    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Table sorting functionality - JS code from your original file remains the same
            const table = document.querySelector(".table");
            const headers = table.querySelectorAll("th[data-sort]");
            const rows = Array.from(table.querySelectorAll("tbody tr"));
            let sortDirection = {};

            headers.forEach((header, index) => {
                const type = header.getAttribute("data-sort");
                sortDirection[type] = 1;

                header.addEventListener("click", () => {
                    let sortedRows;

                    if (type === "status") {
                        const statusOrderAsc = { "pending": 1, "resolved": 2 };
                        const statusOrderDesc = { "resolved": 1, "pending": 2 };
                        const currentOrder = sortDirection[type] === 1 ? statusOrderAsc : statusOrderDesc;
                        sortedRows = rows.sort((a, b) => currentOrder[a.cells[index].innerText.toLowerCase()] - currentOrder[b.cells[index].innerText.toLowerCase()]);
                        sortDirection[type] *= -1;
                    } else if (type === "string") {
                        sortedRows = rows.sort((a, b) => a.cells[index].innerText.localeCompare(b.cells[index].innerText) * sortDirection[type]);
                        sortDirection[type] *= -1;
                    } else if (type === "date") {
                        sortedRows = rows.sort((a, b) => (new Date(b.cells[index].innerText) - new Date(a.cells[index].innerText)) * sortDirection[type]);
                        sortDirection[type] *= -1;
                    }

                    const tbody = table.querySelector("tbody");
                    tbody.innerHTML = "";
                    sortedRows.forEach(row => tbody.appendChild(row));
                });
            });
        });
    </script>

    {{-- Bootstrap JS (If needed, though Tailwind might replace Bootstrap's need for styling) --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script> --}}
</body>
</html>
@endsection