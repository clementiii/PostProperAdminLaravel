<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>View User Details</title>
    <link rel="icon" href="{{ asset('/assets/Southside.png') }}" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.4/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">
</head>

<body class="bg-gray-50">
    @extends('layouts.app')

    @section('title', 'Verify User')
    @section('content')
        <div class="container mx-auto pt-0 px-3">
            <!-- Success Alert Message -->
            @if (session('success'))
                <div id="success-alert" class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded" role="alert">
                    <div class="flex items-center">
                        <span class="material-icons-outlined mr-2">check_circle</span>
                        <span>{{ session('success') }}</span>
                    </div>
                    <div class="mt-2 text-sm">
                        Redirecting to users list in <span id="countdown">3</span> seconds...
                    </div>
                </div>

                <script>
                    // Countdown and redirect
                    let secondsLeft = 3;
                    const countdownElement = document.getElementById('countdown');
                    
                    const countdownInterval = setInterval(function() {
                        secondsLeft--;
                        countdownElement.textContent = secondsLeft;
                        
                        if (secondsLeft <= 0) {
                            clearInterval(countdownInterval);
                            window.location.href = "{{ route('users.view') }}";
                        }
                    }, 1000);
                </script>
            @endif

            <!-- Header with Back Button -->
            <div class="flex items-center mb-6">
                <a href="{{ route('users.view') }}" class="text-gray-600 mr-4">
                    <span class="material-icons-outlined">arrow_back</span>
                </a>
            </div>

            <div class="grid grid-cols-12 gap-6">
                <!-- Left Column -->
                <div class="col-span-5">
                    <!-- Profile Picture Section -->
                    <div class="bg-white rounded-lg shadow-sm mb-6">
                        <div class="bg-purple-900 text-white px-4 py-3 rounded-t-lg flex items-center">
                            <span class="material-icons-outlined mr-2">person</span>
                            <span class="font-medium">Profile Picture</span>
                        </div>
                        <div class="p-6 flex justify-center">
                            <div class="w-32 h-32 bg-gray-200 rounded-full flex items-center justify-center overflow-hidden">
                                @if($user->user_profile_picture)
                                    <img src="{{ asset($user->user_profile_picture) }}" alt="Profile Picture" class="w-full h-full object-cover">
                                @else
                                    <div class="text-center text-gray-400">
                                        <span class="material-icons-outlined text-4xl">person</span>
                                        <p class="text-xs mt-1">No profile picture</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Valid ID Section -->
                    <div class="bg-white rounded-lg shadow-sm">
                        <div class="bg-purple-900 text-white px-4 py-3 rounded-t-lg flex items-center">
                            <span class="material-icons-outlined mr-2">badge</span>
                            <span class="font-medium">Valid ID</span>
                        </div>
                        <div class="py-3">
                            <!-- ID Navigation Tabs -->
                            <div class="border-b border-gray-200 mx-3">
                                <div class="flex">
                                    <button onclick="showIDSide('front')" id="frontTab" class="w-1/2 py-2 text-center border-b-2 border-purple-900 font-medium text-purple-900">Front</button>
                                    <button onclick="showIDSide('back')" id="backTab" class="w-1/2 py-2 text-center text-gray-500">Back</button>
                                </div>
                            </div>
                            
                            <!-- ID Display Areas -->
                            <div id="frontID" class="p-3 flex items-center justify-center h-56 cursor-zoom-in" onclick="openImageModal('frontID')">
                                @if($user->user_valid_id)
                                    @php
                                        $cleanPath = ltrim(str_replace('storage/', '', $user->user_valid_id), '/');
                                    @endphp
                                    <img src="{{ asset('storage/' . $cleanPath) }}" alt="ID Front" class="max-h-full max-w-full object-contain">
                                @else
                                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 w-full h-full flex items-center justify-center">
                                        <div class="text-center text-gray-400">
                                            <span class="material-icons-outlined text-4xl">image</span>
                                            <p>No ID picture (Front)</p>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div id="backID" class="hidden p-3 flex items-center justify-center h-56 cursor-zoom-in" onclick="openImageModal('backID')">
                                @if($user->user_valid_id_back)
                                    @php
                                        $cleanPath = ltrim(str_replace('storage/', '', $user->user_valid_id_back), '/');
                                    @endphp
                                    <img src="{{ asset('storage/' . $cleanPath) }}" alt="ID Back" class="max-h-full max-w-full object-contain">
                                @else
                                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 w-full h-full flex items-center justify-center">
                                        <div class="text-center text-gray-400">
                                            <span class="material-icons-outlined text-4xl">image</span>
                                            <p>No ID picture (Back)</p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="col-span-7">
                    <div class="bg-white rounded-lg shadow-sm h-full flex flex-col">
                        <div class="bg-purple-900 text-white px-4 py-3 rounded-t-lg">
                            <h2 class="font-medium">User Information</h2>
                        </div>
                        <div class="p-5 flex-1 flex flex-col">
                            <!-- Information Tabs -->
                            <div class="border-b border-gray-200">
                                <div class="flex">
                                    <button onclick="showInfo('personal')" id="personalTab" class="px-4 py-2 border-b-2 border-purple-900 font-medium text-purple-900">Personal Information</button>
                                    <button onclick="showInfo('account')" id="accountTab" class="px-4 py-2 text-gray-500">Account Information</button>
                                </div>
                            </div>

                            <!-- Content wrapper -->
                            <div class="flex-1 flex flex-col justify-between">
                                <!-- Information sections wrapper -->
                                <div class="mt-4">
                                    <!-- Personal Information Section -->
                                    <div id="personalInfo" class="space-y-6">
                                        <div class="grid grid-cols-2 gap-x-10 gap-y-6">
                                            <div>
                                                <p class="text-gray-500 text-sm">Full Name</p>
                                                <p class="font-medium">{{ $user->firstName }} {{ $user->lastName }}</p>
                                            </div>
                                            <div>
                                                <p class="text-gray-500 text-sm">Username</p>
                                                <p class="font-medium">{{ $user->username }}</p>
                                            </div>
                                            <div>
                                                <p class="text-gray-500 text-sm">Age</p>
                                                <p class="font-medium">{{ $user->age }} years old</p>
                                            </div>
                                            <div>
                                                <p class="text-gray-500 text-sm">Gender</p>
                                                <p class="font-medium">{{ $user->gender }}</p>
                                            </div>
                                            <div>
                                                <p class="text-gray-500 text-sm">Date of Birth</p>
                                                <p class="font-medium">{{ $user->birthday }}</p>
                                            </div>
                                            <div>
                                                <p class="text-gray-500 text-sm">Address</p>
                                                <p class="font-medium">{{ $user->adrHouseNo }} {{ $user->adrStreet }} {{ $user->adrZone }}</p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Account Information Section -->
                                    <div id="accountInfo" class="hidden space-y-6">
                                        <div class="grid grid-cols-2 gap-x-10 gap-y-6">
                                            <div>
                                                <p class="text-gray-500 text-sm">Account Status</p>
                                                <span class="inline-block bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-sm">
                                                    {{ $user->status ?? 'Pending' }}
                                                </span>
                                            </div>
                                            <div>
                                                <p class="text-gray-500 text-sm">Registration Date</p>
                                                <p class="font-medium">{{ $user->created_at ? date('F d, Y', strtotime($user->created_at)) : 'Not available' }}</p>
                                            </div>
                                            <div>
                                                <p class="text-gray-500 text-sm">Last Login</p>
                                                <p class="font-medium">{{ $user->last_active ? \Carbon\Carbon::parse($user->last_active)->format('M d, Y h:i A') : 'Not available' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Action Buttons - only show if no success message -->
                                @if (!session('success'))
                                <div class="flex justify-end space-x-3 mt-auto pt-4">
                                    <form action="{{ route('users.reject', $user->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="px-5 py-2 bg-white text-gray-700 rounded-lg border border-gray-300 hover:bg-gray-100">Reject</button>
                                    </form>
                                    <form action="{{ route('users.approve', $user->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="px-5 py-2 bg-purple-700 text-white rounded-lg hover:bg-purple-800">Approve</button>
                                    </form>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Image Modal for zooming -->
        <div id="imageModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-75">
            <div class="relative bg-white p-2 rounded-lg max-w-4xl max-h-[90vh] overflow-auto">
                <button onclick="closeImageModal()" class="absolute top-2 right-2 text-gray-600 hover:text-gray-900 z-10">
                    <span class="material-icons-outlined">close</span>
                </button>
                <div class="image-zoom-container">
                    <img id="modalImage" src="" alt="ID Image" class="max-w-full max-h-[80vh] transition-transform duration-200">
                    <div class="absolute bottom-4 right-4 flex space-x-2 bg-white rounded-lg p-2 shadow-lg">
                        <button id="zoomIn" class="p-1 hover:bg-gray-200 rounded">
                            <span class="material-icons-outlined">zoom_in</span>
                        </button>
                        <button id="zoomOut" class="p-1 hover:bg-gray-200 rounded">
                            <span class="material-icons-outlined">zoom_out</span>
                        </button>
                        <button id="zoomReset" class="p-1 hover:bg-gray-200 rounded">
                            <span class="material-icons-outlined">fit_screen</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add this JavaScript to handle tab switching -->
        <script>
        // Tab switching functions - Keep existing code but modified for better transitions
        function showIDSide(side) {
            const frontID = document.getElementById('frontID');
            const backID = document.getElementById('backID');
            const frontTab = document.getElementById('frontTab');
            const backTab = document.getElementById('backTab');
            
            if (side === 'front') {
                frontID.classList.remove('hidden');
                backID.classList.add('hidden');
                frontTab.classList.add('border-b-2', 'border-purple-900', 'text-purple-900');
                frontTab.classList.remove('text-gray-500');
                backTab.classList.remove('border-b-2', 'border-purple-900', 'text-purple-900');
                backTab.classList.add('text-gray-500');
            } else {
                frontID.classList.add('hidden');
                backID.classList.remove('hidden');
                frontTab.classList.remove('border-b-2', 'border-purple-900', 'text-purple-900');
                frontTab.classList.add('text-gray-500');
                backTab.classList.add('border-b-2', 'border-purple-900', 'text-purple-900');
                backTab.classList.remove('text-gray-500');
            }
        }

        function showInfo(type) {
            const personalInfo = document.getElementById('personalInfo');
            const accountInfo = document.getElementById('accountInfo');
            const personalTab = document.getElementById('personalTab');
            const accountTab = document.getElementById('accountTab');
            
            if (type === 'personal') {
                personalInfo.classList.remove('hidden');
                accountInfo.classList.add('hidden');
                personalTab.classList.add('border-b-2', 'border-purple-900', 'text-purple-900');
                personalTab.classList.remove('text-gray-500');
                accountTab.classList.remove('border-b-2', 'border-purple-900', 'text-purple-900');
                accountTab.classList.add('text-gray-500');
            } else {
                personalInfo.classList.add('hidden');
                accountInfo.classList.remove('hidden');
                personalTab.classList.remove('border-b-2', 'border-purple-900', 'text-purple-900');
                personalTab.classList.add('text-gray-500');
                accountTab.classList.add('border-b-2', 'border-purple-900', 'text-purple-900');
                accountTab.classList.remove('text-gray-500');
            }
        }

        // Image modal and zoom functionality
        let currentZoom = 1;
        let isDragging = false;
        let startX, startY, translateX = 0, translateY = 0;
        
        function openImageModal(idType) {
            const modal = document.getElementById('imageModal');
            const modalImage = document.getElementById('modalImage');
            const imgElement = document.querySelector(`#${idType} img`);
            
            // Only open modal if there's an image
            if (imgElement) {
                modal.classList.remove('hidden');
                modalImage.src = imgElement.src;
                resetZoom();
            }
        }
        
        function closeImageModal() {
            const modal = document.getElementById('imageModal');
            modal.classList.add('hidden');
        }
        
        function resetZoom() {
            currentZoom = 1;
            translateX = 0;
            translateY = 0;
            updateImageTransform();
        }
        
        function updateImageTransform() {
            const modalImage = document.getElementById('modalImage');
            modalImage.style.transform = `scale(${currentZoom}) translate(${translateX}px, ${translateY}px)`;
        }
        
        // Zoom controls
        document.getElementById('zoomIn').addEventListener('click', function() {
            currentZoom += 0.25;
            if (currentZoom > 4) currentZoom = 4;
            updateImageTransform();
        });
        
        document.getElementById('zoomOut').addEventListener('click', function() {
            currentZoom -= 0.25;
            if (currentZoom < 0.5) currentZoom = 0.5;
            updateImageTransform();
        });
        
        document.getElementById('zoomReset').addEventListener('click', resetZoom);

        // Close modal when clicking outside
        document.getElementById('imageModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeImageModal();
            }
        });
        
        // Image panning functionality
        const modalImage = document.getElementById('modalImage');
        
        modalImage.addEventListener('mousedown', function(e) {
            if (currentZoom > 1) {
                isDragging = true;
                startX = e.clientX - translateX;
                startY = e.clientY - translateY;
                modalImage.style.cursor = 'grabbing';
            }
        });
        
        document.addEventListener('mousemove', function(e) {
            if (isDragging) {
                translateX = e.clientX - startX;
                translateY = e.clientY - startY;
                updateImageTransform();
            }
        });
        
        document.addEventListener('mouseup', function() {
            isDragging = false;
            modalImage.style.cursor = 'grab';
        });
        
        // Handle wheel zoom
        document.querySelector('.image-zoom-container').addEventListener('wheel', function(e) {
            e.preventDefault();
            if (e.deltaY < 0) {
                currentZoom += 0.1;
                if (currentZoom > 4) currentZoom = 4;
            } else {
                currentZoom -= 0.1;
                if (currentZoom < 0.5) currentZoom = 0.5;
            }
            updateImageTransform();
        });
        </script>
    @endsection

    <style>
    .image-zoom-container {
        position: relative;
        overflow: hidden;
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 300px;
        padding: 20px;
    }
    
    #modalImage {
        cursor: grab;
        transform-origin: center;
    }
    
    #modalImage:active {
        cursor: grabbing;
    }
    </style>

</body>

</html>