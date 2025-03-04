<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    <!-- Import Google Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">

    <!-- Add your CSS files here (e.g., TailwindCSS or your custom styles) -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.4/dist/tailwind.min.css" rel="stylesheet">

    <!-- Optional: Include Font Awesome for any extra icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">

</head>

<body class="bg-gray-100">

    <!-- Include Dashboard Layout -->
    @extends('layouts.dashboard-topbar')

    @section('title', 'Dashboard')

    @section('content')
        <div class="p-6 space-y-6 flex flex-col items-space-between w-full">

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12 justify-items-center">
                <div
                    class="h-[150px] w-[500px] bg-gradient-to-r from-blue-500 to-blue-600 text-white p-6 rounded-lg shadow-lg flex items-center">
                    <div class="mr-4">
                        <h3 class="text-xl pb-3">Registered Residents</h3>
                        <p id="residentsCount" class="text-4xl font-bold">{{ $registeredResidents }}</p>
                    </div>
                    <i
                        class="material-icons-outlined bg-white bg-opacity-20 rounded-full !text-[64px] ml-auto p-5">group</i>
                </div>
                <div class="h-[150px] w-[500px] bg-yellow-500 text-white p-6 rounded-lg shadow-lg flex items-center">
                    <div class="mr-4">
                        <h3 class="text-xl pb-3">Pending Documents</h3>
                        <p id="pendingDocsCount" class="text-4xl font-bold">{{ $pendingDocuments }}</p>
                    </div>
                    <i
                        class="material-icons-outlined bg-white bg-opacity-20 rounded-full !text-[64px] ml-auto p-5">description</i>
                </div>
                <div class="h-[150px] w-[500px] bg-red-500 text-white p-6 rounded-lg shadow-lg flex items-center">
                    <div class="mr-4">
                        <h3 class="text-xl pb-3">Incident Reports</h3>
                        <p id="incidentCount" class="text-4xl font-bold">{{ $incidentReports }}</p>
                    </div>
                    <i
                        class="material-icons-outlined bg-white bg-opacity-20 rounded-full !text-[64px] ml-auto p-5">report</i>
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
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-6 py-4 text-lg font-semibold text-purple-800">
                                    Transaction ID
                                    <span class="material-icons-outlined align-middle cursor-pointer">swap_vert</span>

                                </th>
                                <th class="px-6 py-4 text-lg font-semibold text-purple-800">
                                    Name
                                    <span class="material-icons-outlined align-middle cursor-pointer">swap_vert</span>

                                </th>
                                <th class="px-6 py-4 text-lg font-semibold text-purple-800">
                                    Document Type
                                    <span class="material-icons-outlined align-middle cursor-pointer">swap_vert</span>

                                </th>
                                <th class="px-6 py-4 text-lg font-semibold text-purple-800">
                                    Quantity
                                    <span class="material-icons-outlined align-middle cursor-pointer">swap_vert</span>

                                </th>
                                <th class="px-6 py-4 text-lg font-semibold text-purple-800">
                                    Date Requested
                                    <span class="material-icons-outlined align-middle cursor-pointer">swap_vert</span>
                                </th>
                                <th class="px-6 py-4 text-lg font-semibold text-purple-800">Action</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700">

                            <!-- Static Rows -->
                            <tr class="border-t">
                                <td class="px-6 py-4">TXN-20</td>
                                <td class="px-6 py-4">Robert Youngstown</td>
                                <td class="px-6 py-4">Barangay Clearance</td>
                                <td class="px-6 py-4">2</td>
                                <td class="px-6 py-4">Dec 07, 2024</td>
                                <td class="px-6 py-4">
                                    <button class="view-btn text-blue-600 hover:underline"
                                        onclick="openModal('TXN-20', 'Robert Youngstown', 'Barangay Clearance', 2, 'Dec 07, 2024')">
                                        <i class="far fa-eye"></i>
                                    </button>
                                </td>
                            </tr>

                            <tr class="border-t">
                                <td class="px-6 py-4">TXN-21</td>
                                <td class="px-6 py-4">Angelica Santos</td>
                                <td class="px-6 py-4">Barangay Certificate</td>
                                <td class="px-6 py-4">2</td>
                                <td class="px-6 py-4">Dec 01, 2024</td>
                                <td class="px-6 py-4">
                                    <button class="view-btn text-blue-600 hover:underline"
                                        onclick="openModal('TXN-21', 'Angelica Santos', 'Barangay Certificate', 2, 'Dec 01, 2024')">
                                        <i class="far fa-eye"></i>
                                    </button>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Modal -->
            <div id="modal" class="relative z-10 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                <div
                    class="fixed  inset-0 left-0 top-0 bg-black bg-opacity-50 w-screen h-screen flex justify-center items-center">
                    <div class="bg-white rounded shadow-lg flex flex-col p-8 w-[40%] relative">
                        <div class="flex flex-col w-full border-b pb-4">
                            <h2 class="text-2xl font-semibold">Request Details</h2>
                            <p class="text-gray-500">View complete information about this document request</p>
                            <div class="absolute top-[2.5rem] right-[2.5rem] flex items-center space-x-12">
                                <span
                                    class="bg-yellow-100 text-yellow-800 text-sm font-semibold px-3 py-1 rounded-full">Pending</span>
                                <button onclick="closeModal()" class="material-icons-outlined">close</button>
                            </div>
                        </div>

                        <div class="mt-6 space-y-4">
                            <h3 class="text-purple-800 font-semibold">Document Information</h3>
                            <div class="grid grid-cols-2 gap-4">

                                <div>
                                    <i class="material-icons-outlined align-middle mr-2 text-gray-500">tag</i>
                                    <span class="font-semibold">Transaction ID:</span> <span id="modalTxnId">TXN-20</span>
                                </div>
                                <div>
                                    <i class="material-icons-outlined align-middle mr-2 text-gray-500">description</i>
                                    <span class="font-semibold">Document Type:</span> <span id="modalDocumentType">Barangay
                                        Clearance</span>
                                </div>
                                <div>
                                    <i class="material-icons-outlined align-middle mr-2 text-gray-500">attach_money</i>
                                    <span class="font-semibold">Price:</span> <span id="modalPrice">100.00</span>
                                </div>
                                <div>
                                    <i class="material-icons-outlined align-middle mr-2 text-gray-500">event</i>
                                    <span class="font-semibold">Date Requested:</span> <span id="modalDate">December 7,
                                        2024</span>
                                </div>
                            </div>
                        </div>
                        <div class="mt-6 space-y-4">
                            <h3 class="text-purple-800 font-semibold">Personal Information</h3>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <i class="material-icons-outlined align-middle mr-2 text-gray-500">person</i>
                                    <span class="font-semibold">Full Name:</span> <span id="modalName">Robert
                                        Youngstown</span>
                                </div>
                                <div>
                                    <i class="material-icons-outlined align-middle mr-2 text-gray-500">male</i>
                                    <span class="font-semibold">Gender:</span> <span id="modalGender">Male</span>
                                </div>
                                <div>
                                    <i class="material-icons-outlined align-middle mr-2 text-gray-500">favorite</i>
                                    <span class="font-semibold">Civil Status:</span> <span
                                        id="modalCivilStatus">Single</span>
                                </div>
                                <div>
                                    <i class="material-icons-outlined align-middle mr-2 text-gray-500">location_on</i>
                                    <span class="font-semibold">Address:</span>
                                    <span id="modalAddress">123 Street Zone, Post Proper Southside, Taguig City</span>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 space-y-4">
                            <h3 class="text-purple-800 font-semibold">Additional Information</h3>
                            <div class="grid grid-cols-2 gap-4 text-gray-700">
                                <div>
                                    <i class="material-icons-outlined align-middle mr-2 text-gray-500">badge</i>
                                    <span class="font-semibold">TIN No.:</span> <span id="modalTin">123456789012</span>
                                </div>
                                <div>
                                    <i class="material-icons-outlined align-middle mr-2 text-gray-500">fingerprint</i>
                                    <span class="font-semibold">CTC No.:</span> <span id="modalCtc">123456789012</span>
                                </div>
                            </div>
                        </div>
                        <div class="mt-8 flex justify-end">
                            <button onclick="closeModal()"
                                class="px-6 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700">
                                Close
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            // Open Modal with Data
            function openModal(txnId, name, documentType, price, date, gender, civilStatus, address, tin, ctc) {
                document.getElementById('modalTxnId').textContent = txnId;
                document.getElementById('modalName').textContent = name;
                document.getElementById('modalDocumentType').textContent = documentType;
                document.getElementById('modalPrice').textContent = price;
                document.getElementById('modalDate').textContent = date;
                document.getElementById('modalGender').textContent = gender;
                document.getElementById('modalCivilStatus').textContent = civilStatus;
                document.getElementById('modalAddress').textContent = address;
                document.getElementById('modalTin').textContent = tin;
                document.getElementById('modalCtc').textContent = ctc;

                document.getElementById('modal').classList.remove('hidden');
            }

            // Close Modal
            function closeModal() {
                document.querySelector('.relative.z-10').classList.add('hidden');
            }

            // Toggle Filter Dropdown
            const filterBtn = document.getElementById('filter-btn');
            const filterOptions = document.getElementById('filter-options');

            filterBtn.addEventListener('click', () => {
                filterOptions.classList.toggle('hidden');
            });

            // Close Dropdown on Outside Click
            document.addEventListener('click', (event) => {
                if (!filterBtn.contains(event.target) && !filterOptions.contains(event.target)) {
                    filterOptions.classList.add('hidden');
                }
            });
        </script>

    @endsection

</body>

</html>