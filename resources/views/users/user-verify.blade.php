<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.4/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">
</head>

<body class="bg-gray-50">
    @extends('layouts.app')

    @section('title', 'User Verify')
    @section('content')
        <div class="container mx-auto p-6">
            <!-- Header with Back Button -->
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center">
                    <a href="{{ route('users.view') }}" class="text-gray-600 mr-4">
                        <span class="material-icons-outlined">arrow_back</span>
                    </a>
                    <h1 class="text-2xl font-semibold text-purple-900">Verify Users</h1>
                </div>
                <!-- User Avatar -->
                <div class="w-10 h-10 rounded-full bg-gray-200">
                    <!-- Add admin avatar here -->
                </div>
            </div>

            <div class="flex gap-6">
                <!-- Left Column -->
                <div class="w-1/4">
                    <!-- Profile Picture Section -->
                    <div class="bg-white rounded-lg shadow-sm mb-6">
                        <div class="bg-purple-900 text-white px-4 py-3 rounded-t-lg">
                            <div class="flex items-center">
                                <span class="material-icons-outlined mr-2">account_circle</span>
                                <span class="font-semibold">Profile Picture</span>
                            </div>
                        </div>
                        <div class="p-6">
                            <div
                                class="w-full aspect-square bg-gray-100 rounded-full flex items-center justify-center overflow-hidden">
                                @if($user->user_profile_picture && $user->user_profile_picture !== '')
                                    <img src="{{ asset($user->user_profile_picture) }}" alt="Profile Picture"
                                        class="w-full h-full object-cover">
                                @else
                                    <span class="material-icons-outlined text-gray-400 text-6xl">person</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Valid ID Section -->
                    <div class="bg-white rounded-lg shadow-sm">
                        <div class="bg-purple-900 text-white px-4 py-3 rounded-t-lg">
                            <div class="flex items-center">
                                <span class="material-icons-outlined mr-2">verified</span>
                                <span class="font-semibold">Valid ID</span>
                            </div>
                        </div>
                        <div class="p-6 space-y-4">
                            <div>
                                <p class="text-sm mb-2">Front</p>
                                <div
                                    class="border-2 border-dashed border-gray-300 rounded-lg overflow-hidden {{ $user->user_valid_id ? 'p-0' : 'p-4' }} flex items-center justify-center h-32">
                                    @if($user->user_valid_id && $user->user_valid_id !== '')
                                        <img src="{{ asset($user->user_valid_id) }}" alt="ID Front"
                                            class="w-full h-full object-contain">
                                    @else
                                        <span class="material-icons-outlined text-gray-400">image</span>
                                    @endif
                                </div>
                            </div>
                            <div>
                                <p class="text-sm mb-2">Back</p>
                                <div
                                    class="border-2 border-dashed border-gray-300 rounded-lg overflow-hidden {{ $user->user_valid_id_back ? 'p-0' : 'p-4' }} flex items-center justify-center h-32">
                                    @if($user->user_valid_id_back && $user->user_valid_id_back !== '')
                                        <img src="{{ asset($user->user_valid_id_back) }}" alt="ID Back"
                                            class="w-full h-full object-contain">
                                    @else
                                        <span class="material-icons-outlined text-gray-400">image</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="w-3/4">
                    <div class="bg-white rounded-lg shadow-sm">
                        <div class="bg-purple-900 text-white px-6 py-3 rounded-t-lg">
                            <h2 class="text-xl font-semibold">User Information</h2>
                        </div>
                        <div class="p-6">
                            <!-- Personal Information -->
                            <div class="mb-8">
                                <h3 class="text-purple-900 font-semibold mb-4">Personal Information</h3>
                                <div class="grid grid-cols-2 gap-y-6">
                                    <div>
                                        <p class="text-sm text-gray-600">Full Name</p>
                                        <p class="font-medium">{{ $user->firstName }} {{ $user->lastName }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Username</p>
                                        <p class="font-medium">{{ $user->username }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Age</p>
                                        <p class="font-medium">{{ $user->age }} years old</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Gender</p>
                                        <p class="font-medium">{{ $user->gender }}</p>
                                    </div>
                                    <div class="flex items-start">
                                        <span class="material-icons-outlined text-gray-500 mr-2">calendar_today</span>
                                        <div>
                                            <p class="text-sm text-gray-600">Date of Birth</p>
                                            <p class="font-medium">{{ $user->birthday }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-start">
                                        <span class="material-icons-outlined text-gray-500 mr-2">location_on</span>
                                        <div>
                                            <p class="text-sm text-gray-600">Address</p>
                                            <p class="font-medium">{{ $user->adrHouseNo }} {{ $user->adrStreet }}
                                                {{ $user->adrZone }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Account Information -->
                            <div>
                                <h3 class="text-purple-900 font-semibold mb-4">Account Information</h3>
                                <div class="grid grid-cols-2 gap-y-6">
                                    <div>
                                        <p class="text-sm text-gray-600">Account Status</p>
                                        <span
                                            class="inline-block bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-sm">
                                            {{ $user->status ?? 'Pending' }}
                                        </span>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Registration Date</p>
                                        <p class="font-medium">
                                            @if($user->created_at)
                                                {{ date('F d, Y', strtotime($user->created_at)) }}
                                            @else
                                                Not available
                                            @endif
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Last Login</p>
                                        <p class="font-medium">
                                            @if($user->updated_at)
                                                {{ date('F d, Y h:i A', strtotime($user->updated_at)) }}
                                            @else
                                                Not available
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex justify-end space-x-3 mt-8">
                                <form action="{{ route('users.reject', $user->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit"
                                        class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
                                        Reject
                                    </button>
                                </form>
                                <form action="{{ route('users.approve', $user->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit"
                                        class="px-4 py-2 bg-purple-700 text-white rounded-lg hover:bg-purple-800">
                                        Approve
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection

</body>

</html>