<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    @extends('layouts.app')

    @section('title', 'Admin Profile')

    @section('content')
        <div class="container mx-auto p-6">
            <div class="max-w-4xl mx-auto bg-white shadow-lg rounded-lg p-6">
                <div class="flex items-center space-x-4">
                    <!-- Profile Picture -->
                    <div class="w-24 h-24">
                        <img src="https://via.placeholder.com/100" alt="Profile Picture"
                            class="w-full h-full rounded-full border border-gray-300">
                    </div>
                    <div>
                        <h2 class="text-2xl font-semibold text-gray-800">Admin Name</h2>
                        <p class="text-gray-600">Administrator</p>
                    </div>
                </div>

                <div class="mt-6">
                    <h3 class="text-xl font-semibold text-gray-700">Profile Information</h3>
                    <div class="mt-4 space-y-3">
                        <div class="flex items-center space-x-2">
                            <span class="material-symbols-outlined text-gray-600">mail</span>
                            <p class="text-gray-700">admin@example.com</p>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="material-symbols-outlined text-gray-600">call</span>
                            <p class="text-gray-700">+123 456 7890</p>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="material-symbols-outlined text-gray-600">location_on</span>
                            <p class="text-gray-700">123 Admin Street, City</p>
                        </div>
                    </div>
                </div>

                <div class="mt-6">
                    <h3 class="text-xl font-semibold text-gray-700">Account Settings</h3>
                    <div class="mt-4 space-y-3">
                        <a href="#" class="flex items-center space-x-2 text-blue-600 hover:underline">
                            <span class="material-symbols-outlined">edit</span>
                            <span>Edit Profile</span>
                        </a>
                        <a href="#" class="flex items-center space-x-2 text-red-600 hover:underline">
                            <span class="material-symbols-outlined">logout</span>
                            <span>Logout</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endsection

</body>

</html>