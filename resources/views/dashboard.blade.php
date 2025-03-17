<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="icon" href="{{ asset('/assets/Southside.png') }}" type="image/png">
    
    <!-- Import Google Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">


    <!-- Add your CSS files here (e.g., TailwindCSS or your custom styles) -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.4/dist/tailwind.min.css" rel="stylesheet">


    <!-- Optional: Include Font Awesome for any extra icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">


    @livewireStyles
</head>


<body class="bg-gray-100">


    <!-- Include Dashboard Layout -->
    @extends('layouts.dashboard-topbar')


    @section('title', 'Dashboard')


    @section('content')
        <div class="p-6 space-y-6 flex flex-col items-space-between w-full">
            @livewire('document-request-table')
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
                            <span id="modalStatusContainer" class="text-sm font-semibold px-3 py-1 rounded-full">
                                <span id="modalStatus"></span>
                            </span>
                            <button onclick="closeModal()" class="material-icons-outlined">close</button>
                        </div>
                    </div>


                    <div class="mt-6 space-y-4">
                        <h3 class="text-purple-800 font-semibold">Document Information</h3>
                        <div class="grid grid-cols-2 gap-4">


                            <div>
                                <i class="material-icons-outlined align-middle mr-2 text-gray-500">tag</i>
                                <span class="font-semibold">Transaction ID:</span> <span id="modalTxnId"></span>
                            </div>
                            <div>
                                <i class="material-icons-outlined align-middle mr-2 text-gray-500">description</i>
                                <span class="font-semibold">Document Type:</span> <span id="modalDocumentType"></span>
                            </div>
                            <div>
                                <i class="material-icons-outlined align-middle mr-2 text-gray-500">attach_money</i>
                                <span class="font-semibold">Price:</span> <span id="modalPrice"></span>
                            </div>
                            <div>
                                <i class="material-icons-outlined align-middle mr-2 text-gray-500">event</i>
                                <span class="font-semibold">Date Requested:</span> <span id="modalDate"></span>
                            </div>
                        </div>
                    </div>
                    <div class="mt-6 space-y-4">
                        <h3 class="text-purple-800 font-semibold">Personal Information</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <i class="material-icons-outlined align-middle mr-2 text-gray-500">person</i>
                                <span class="font-semibold">Full Name:</span> <span id="modalName"></span>
                            </div>
                            <div>
                                <i class="material-icons-outlined align-middle mr-2 text-gray-500">male</i>
                                <span class="font-semibold">Gender:</span> <span id="modalGender"></span>
                            </div>
                            <div>
                                <i class="material-icons-outlined align-middle mr-2 text-gray-500">favorite</i>
                                <span class="font-semibold">Civil Status:</span> <span id="modalCivilStatus"></span>
                            </div>
                            <div>
                                <i class="material-icons-outlined align-middle mr-2 text-gray-500">location_on</i>
                                <span class="font-semibold">Address:</span>
                                <span id="modalAddress"></span>
                            </div>
                        </div>
                    </div>


                    <div class="mt-6 space-y-4">
                        <h3 class="text-purple-800 font-semibold">Additional Information</h3>
                        <div class="grid grid-cols-2 gap-4 text-gray-700">
                            <div>
                                <i class="material-icons-outlined align-middle mr-2 text-gray-500">badge</i>
                                <span class="font-semibold">TIN No.:</span> <span id="modalTin"></span>
                            </div>
                            <div>
                                <i class="material-icons-outlined align-middle mr-2 text-gray-500">fingerprint</i>
                                <span class="font-semibold">CTC No.:</span> <span id="modalCtc"></span>
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


        @livewireScripts
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="{{ asset('js/dashboard.js') }}"></script>
    @endsection


</body>


</html>