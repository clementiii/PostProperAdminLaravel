<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield(section: 'title')</title>

    <!-- Import Google Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">

    <!-- Import Material Symbols -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.4/dist/tailwind.min.css" rel="stylesheet">

</head>

<body>
    @extends('layouts.app')

    @section('title', 'User Accounts')

    @section('content')

        <div class="mb-6 px-6 flex flex-col items-space-between w-full">
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12 justify-items-center">
                <div
                    class="h-[150px] w-[500px] bg-gradient-to-r from-blue-500 to-blue-600 text-white p-6 rounded-lg shadow-lg shadow-blue-700  flex items-center">
                    <div class="mr-4">
                        <h3 class="text-xl pb-3">Registered Residents</h3>
                        <p id="residentsCount" class="text-4xl font-bold">{{ $registeredResidentsCount }}</p>
                    </div>
                    <i
                        class="material-icons-outlined bg-white bg-opacity-20 rounded-full !text-[64px] ml-auto p-5">group</i>
                </div>
                <div
                    class="h-[150px] w-[500px] bg-gradient-to-r from-emerald-500 to-emerald-600 text-white p-6 rounded-lg shadow-lg shadow-emerald  -700  flex items-center">
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
                            <input type="text" placeholder="Search requests..."
                                class="pl-10 pr-4 py-2 w-72 rounded-lg border focus:outline-none focus:ring-2 focus:ring-purple-600">
                            <span
                                class="material-icons-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-500">search</span>
                        </div>


                        <!-- Filter Dropdown -->
                        <div class="relative">
                            <button id="filter-btn"
                                class="flex items-center bg-gray-100 px-4 py-2 rounded-lg shadow-sm hover:bg-gray-200">
                                <span>Filter by</span>
                                <span class="material-icons-outlined ml-2">arrow_drop_down</span>
                            </button>
                            <!-- Dropdown Menu -->
                            <div id="filter-options"
                                class="absolute right-0 mt-2 bg-white border rounded-lg shadow-lg hidden w-40 z-50">
                                <ul class="text-gray-700">
                                    <li class="px-4 py-2 hover:bg-gray-100 cursor-pointer">Transaction ID</li>
                                    <li class="px-4 py-2 hover:bg-gray-100 cursor-pointer">Name</li>
                                    <li class="px-4 py-2 hover:bg-gray-100 cursor-pointer">Document Type</li>
                                    <li class="px-4 py-2 hover:bg-gray-100 cursor-pointer">Quantity</li>
                                    <li class="px-4 py-2 hover:bg-gray-100 cursor-pointer">Date Requested</li>
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
                                    Last Name:
                                    <span class="material-icons-outlined align-middle cursor-pointer">swap_vert</span>


                                </th>
                                <th class="px-6 py-4 text-lg font-semibold text-purple-800">
                                    First Name:
                                    <span class="material-icons-outlined align-middle cursor-pointer">swap_vert</span>


                                </th>
                                <th class="px-6 py-4 text-lg font-semibold text-purple-800">
                                    Address
                                    <span class="material-icons-outlined align-middle cursor-pointer">swap_vert</span>


                                </th>
                                <th class="px-6 py-4 text-lg font-semibold text-purple-800">
                                    Status
                                    <span class="material-icons-outlined align-middle cursor-pointer">swap_vert</span>


                                </th>
                                <th class="px-6 py-4 text-lg font-semibold text-purple-800">Action</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700">
                            @foreach($users as $user)
                                                    <tr class="border-t text-center">
                                                        <td class=" p-2">{{ $user->lastName }}</td>
                                                        <td class=" p-2">{{ $user->firstName }}</td>
                                                        <td class=" p-2">
                                                            {{ $user->adrHouseNo }} {{ $user->adrStreet }} {{ $user->adrZone }}
                                                        </td>
                                                        <td class="border p-2">
                                                            @php
                                                                $statusClass = match (strtolower($user->status)) {
                                                                    'pending' => 'bg-[#FEF9C3] text-white',
                                                                    'verified' => 'bg-[#DCFCE7] text-[#1A6838]',
                                                                    'rejected' => 'bg-red-500 text-white',

                                                                    default => ''
                                                                };
                                                            @endphp
                                                            <span class="px-3 py-1 rounded-full {{ $statusClass }}">
                                                                {{ ucfirst($user->status ?? 'Pending') }}
                                                            </span>
                                                        </td>

                                                        <td class=" p-2 flex justify-center items-center space-x-4">
                                                            <!-- View icon (Eye) using Material Icon -->
                                                            <a href="{{ route('users.view', $user->id) }}"
                                                                class=" text-blue-500 hover:text-blue-600">
                                                                <i class="material-icons-outlined text-[24px]">visibility</i>
                                                            </a>

                                                            <!-- Delete icon (Trash) using Material Icon -->
                                                            <button onclick="confirmDelete({{ $user->id }})"
                                                                class=" text-red-500 hover:text-red-600">
                                                                <i class="material-icons-outlined text-[24px]">delete</i>
                                                            </button>
                                                        </td>
                                                    </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

        <script>
            function confirmDelete(userId) {
                if (confirm("Are you sure you want to delete this user?")) {
                    window.location.href = "/users/delete/" + userId;
                }
            }
        </script>
    @endsection
</body>

</html>