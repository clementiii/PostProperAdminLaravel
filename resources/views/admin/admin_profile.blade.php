@extends('layouts.app')

@section('content')
<div class="flex justify-center items-center min-h-screen bg-gray-100">
    <div class="bg-white shadow-lg rounded-lg w-full max-w-md">
        <!-- Profile Header -->
        <div class="bg-purple-700 rounded-t-lg py-6 flex flex-col items-center">
            <img src="{{ asset($admin->profile_picture) }}" 
                alt="Profile Picture" 
                class="w-24 h-24 rounded-full border-4 border-white">
            <h2 class="text-white text-2xl font-semibold mt-2">{{ $admin->name }}</h2>
            <p class="text-gray-300">Administrator</p>
        </div>

        <!-- Profile Form -->
        <div class="p-6">
            <form action="{{ route('admin.profile.update') }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-gray-700 font-medium">Name</label>
                    <input type="text" name="name" value="{{ old('name', $admin->name) }}" 
                        class="w-full px-4 py-2 border rounded-md focus:ring focus:ring-purple-300">
                </div>

                <div>
                    <label class="block text-gray-700 font-medium">Username</label>
                    <input type="text" name="username" value="{{ old('username', $admin->username) }}" 
                        class="w-full px-4 py-2 border rounded-md focus:ring focus:ring-purple-300">
                </div>

                <div>
                    <label class="block text-gray-700 font-medium">Current Password</label>
                    <input type="password" name="current_password" 
                        class="w-full px-4 py-2 border rounded-md focus:ring focus:ring-purple-300">
                </div>

                <div>
                    <label class="block text-gray-700 font-medium">New Password</label>
                    <input type="password" name="new_password" 
                        class="w-full px-4 py-2 border rounded-md focus:ring focus:ring-purple-300">
                </div>

                <div>
                    <label class="block text-gray-700 font-medium">Confirm New Password</label>
                    <input type="password" name="password_confirmation" 
                        class="w-full px-4 py-2 border rounded-md focus:ring focus:ring-purple-300">
                </div>

                <!-- Submit Button -->
                <div class="mt-4">
                    <button type="submit" class="w-full bg-purple-700 text-white py-2 rounded-md flex items-center justify-center space-x-2 hover:bg-purple-800">
                        <span class="material-icons">lock</span>
                        <span>Save Changes</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
