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
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center">
                    <a href="{{ route('users.view') }}" class="text-gray-600 mr-2">
                        <span class="material-icons-outlined">arrow_back</span>
                    </a>
                    <h1 class="text-xl font-semibold text-purple-900">Verify Users</h1>
                </div>
            </div>

            <div class="flex gap-4">
                <!-- Left Column -->
                <div class="w-1/4">
                    <!-- Profile Picture Section -->
                    <div class="bg-white rounded-lg shadow-sm mb-4">
                        <div class="bg-purple-900 text-white p-4 rounded-t-lg">
                            <div class="flex items-center">
                                <span class="material-icons-outlined mr-2">person</span>
                                <span class="font-medium text-2xl">Profile Picture</span>
                            </div>
                        </div>
                        <div class="p-8">
                            <div class="w-full aspect-square bg-gray-100 rounded-full flex items-center justify-center">
                                @if($user->user_profile_picture)
                                    <img src="{{ asset($user->user_profile_picture) }}" alt="Profile Picture" class="w-full h-full object-cover rounded-full">
                                @else
                                    <span class="material-icons-outlined text-gray-400 text-6xl">person</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Valid ID Section -->
                    <div class="bg-white rounded-lg shadow-sm">
                        <div class="bg-purple-900 text-white p-4 rounded-t-lg">
                            <div class="flex items-center">
                                <span class="material-icons-outlined mr-2">badge</span>
                                <span class="font-medium text-2xl">Valid ID</span>
                            </div>
                        </div>
                        <div class="p-4">
                            <!-- ID Navigation Tabs -->
                            <div class="flex border-b mb-4">
                                <button onclick="showIDSide('front')" class="flex-1 py-2 px-4 text-center border-b-2 border-purple-900 font-medium text-purple-900">Front</button>
                                <button onclick="showIDSide('back')" class="flex-1 py-2 px-4 text-center text-gray-500">Back</button>
                            </div>
                            
                            <!-- ID Display Areas -->
                            <div id="frontID" class="border-2 border-dashed border-gray-300 rounded-lg p-4 h-48 flex items-center justify-center">
                                @if($user->user_valid_id)
                                    <img src="{{ asset(str_replace('uploads/', 'storage/uploads/', $user->user_valid_id)) }}" alt="ID Front" class="max-h-full object-contain">
                                @else
                                    <div class="text-center text-gray-400">
                                        <span class="material-icons-outlined text-4xl">image</span>
                                        <p>No ID picture (Front)</p>
                                    </div>
                                @endif
                            </div>

                            <div id="backID" class="hidden border-2 border-dashed border-gray-300 rounded-lg p-4 h-48  items-center justify-center">
                                @if($user->user_valid_id_back)
                                    <img src="{{ asset(str_replace('uploads/', 'storage/uploads/', $user->user_valid_id_back)) }}" alt="ID Back" class="max-h-full object-contain">
                                @else
                                    <div class="text-center text-gray-400">
                                        <span class="material-icons-outlined text-4xl">image</span>
                                        <p>No ID picture (Back)</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="w-2/3">
                    <div class="bg-white rounded-lg shadow-sm h-full flex flex-col">
                        <div class="bg-purple-900 text-white p-4 rounded-t-lg">
                            <h2 class="text-2xl font-medium">User Information</h2>
                        </div>
                        <div class="p-6 flex-1 flex flex-col">
                            <!-- Information Tabs -->
                            <div class="flex border-b mb-6">
                                <button onclick="showInfo('personal')" class="mr-6 text-xl py-2 border-b-2 border-purple-900 font-medium text-purple-900">Personal Information</button>
                                <button onclick="showInfo('account')" class="text-xl py-2 text-gray-500">Account Information</button>
                            </div>

                            <!-- Content wrapper -->
                            <div class="flex-1 flex flex-col justify-between">
                                <!-- Information sections wrapper -->
                                <div>
                                    <!-- Personal Information Section -->
                                    <div id="personalInfo" class="space-y-6">
                                        <div class="grid grid-cols-2 gap-8">
                                            <div>
                                                <p class="text-gray-500 text-lg">Full Name</p>
                                                <p class="font-medium text-xl">{{ $user->firstName }} {{ $user->lastName }}</p>
                                            </div>
                                            <div>
                                                <p class="text-gray-500 text-lg">Username</p>
                                                <p class="font-medium text-xl">{{ $user->username }}</p>
                                            </div>
                                            <div>
                                                <p class="text-gray-500 text-lg">Age</p>
                                                <p class="font-medium text-xl">{{ $user->age }} years old</p>
                                            </div>
                                            <div>
                                                <p class="text-gray-500 text-lg">Gender</p>
                                                <p class="font-medium text-xl">{{ $user->gender }}</p>
                                            </div>
                                            <div>
                                                <p class="text-gray-500 text-lg">Date of Birth</p>
                                                <p class="font-medium text-xl">{{ $user->birthday }}</p>
                                            </div>
                                            <div>
                                                <p class="text-gray-500 text-lg">Address</p>
                                                <p class="font-medium text-xl">{{ $user->adrHouseNo }} {{ $user->adrStreet }} {{ $user->adrZone }}</p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Account Information Section -->
                                    <div id="accountInfo" class="hidden space-y-6">
                                        <div class="grid grid-cols-2 gap-8">
                                            <div>
                                                <p class="text-gray-500 text-lg">Account Status</p>
                                                <span class="inline-block bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full">
                                                    {{ $user->status ?? 'Pending' }}
                                                </span>
                                            </div>
                                            <div>
                                                <p class="text-gray-500 text-lg">Registration Date</p>
                                                <p class="font-medium text-xl">{{ $user->created_at ? date('F d, Y', strtotime($user->created_at)) : 'Not available' }}</p>
                                            </div>
                                            <div>
                                                <p class="text-gray-500 text-lg">Last Login</p>
                                                <p class="font-medium text-xl">{{ $user->last_active ? \Carbon\Carbon::parse($user->last_active)->format('M d, Y h:i A') : 'Not available' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Action Buttons - only show if no success message -->
                                @if (!session('success'))
                                <div class="flex justify-end space-x-3 mt-auto pt-6 border-t border-gray-200 dark:bg-white/10">
                                    <form action="{{ route('users.reject', $user->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="px-6 py-3 text-lg font-medium bg-white text-gray-700 rounded-lg border border-gray-300 hover:bg-gray-500 hover:text-white">Reject</button>
                                    </form>
                                    <form action="{{ route('users.approve', $user->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="px-6 py-3 text-lg font-medium bg-purple-700 text-white rounded-lg hover:bg-purple-800">Approve</button>
                                    </form>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add this JavaScript to handle tab switching -->
        <script>
        function showIDSide(side) {
            const frontID = document.getElementById('frontID');
            const backID = document.getElementById('backID');
            const buttons = document.querySelectorAll('[onclick^="showIDSide"]');
            
            buttons.forEach(button => {
                button.classList.remove('border-b-2', 'border-purple-900', 'text-purple-900');
                button.classList.add('text-gray-500');
            });
            
            if (side === 'front') {
                frontID.classList.remove('hidden');
                backID.classList.add('hidden');
                buttons[0].classList.add('border-b-2', 'border-purple-900', 'text-purple-900');
            } else {
                frontID.classList.add('hidden');
                backID.classList.remove('hidden');
                buttons[1].classList.add('border-b-2', 'border-purple-900', 'text-purple-900');
            }
        }

        function showInfo(type) {
            const personalInfo = document.getElementById('personalInfo');
            const accountInfo = document.getElementById('accountInfo');
            const buttons = document.querySelectorAll('[onclick^="showInfo"]');
            
            buttons.forEach(button => {
                button.classList.remove('border-b-2', 'border-purple-900', 'text-purple-900');
                button.classList.add('text-gray-500');
            });
            
            if (type === 'personal') {
                personalInfo.classList.remove('hidden');
                accountInfo.classList.add('hidden');
                buttons[0].classList.add('border-b-2', 'border-purple-900', 'text-purple-900');
            } else {
                personalInfo.classList.add('hidden');
                accountInfo.classList.remove('hidden');
                buttons[1].classList.add('border-b-2', 'border-purple-900', 'text-purple-900');
            }
        }
        </script>
    @endsection

</body>

</html>