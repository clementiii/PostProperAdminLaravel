@extends('layouts.app')

@section('content')
<div class="flex justify-center items-center min-h-screen">
    <div class="bg-white shadow-lg rounded-lg p-6 w-full max-w-md">
        <div class="flex flex-col items-center">
            <div class="relative">
                <img src="{{ asset(Auth::user()->profile_picture) }}" 
                    class="w-24 h-24 rounded-full border-4 border-purple-500 object-cover" 
                    alt="Profile Picture">
            </div>
            <h2 class="text-xl font-bold text-gray-800 mt-2">{{ Auth::user()->name }}</h2>
            <p class="text-gray-600">Administrator</p>
        </div>

        <!-- Update Profile Form -->
        <form method="POST" action="{{ route('admin.profile.update') }}" class="mt-4">
            @csrf

            <!-- Username -->
            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700">Username</label>
                <input type="text" name="username" value="{{ Auth::user()->username }}" 
                    class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-purple-300" required>
                @error('username')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Current Password -->
            <div class="mb-4" x-data="{ showPassword: false }">
                <label class="block text-sm font-semibold text-gray-700">Current Password <span class="text-red-500">*</span></label>
                <div class="relative">
                    <input :type="showPassword ? 'text' : 'password'" name="current_password" 
                        class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-purple-300" required>
                    <button type="button" class="absolute inset-y-0 right-2 flex items-center text-gray-600"
                        @click="showPassword = !showPassword">
                        <i x-show="!showPassword" class="fas fa-eye"></i>
                        <i x-show="showPassword" class="fas fa-eye-slash"></i>
                    </button>
                </div>
                @error('current_password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
                <p class="text-xs text-gray-500 mt-1">* Required for any changes to username or password</p>
            </div>

            <!-- New Password -->
            <div class="mb-4" x-data="{ showPassword: false }">
                <label class="block text-sm font-semibold text-gray-700">New Password</label>
                <div class="relative">
                    <input :type="showPassword ? 'text' : 'password'" name="new_password" 
                        class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-purple-300">
                    <button type="button" class="absolute inset-y-0 right-2 flex items-center text-gray-600"
                        @click="showPassword = !showPassword">
                        <i x-show="!showPassword" class="fas fa-eye"></i>
                        <i x-show="showPassword" class="fas fa-eye-slash"></i>
                    </button>
                </div>
                @error('new_password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
                <p class="text-xs text-gray-500 mt-1">Leave blank if you don't want to change the password</p>
            </div>

            <!-- Confirm Password -->
            <div class="mb-4" x-data="{ showPassword: false }">
                <label class="block text-sm font-semibold text-gray-700">Confirm New Password</label>
                <div class="relative">
                    <input :type="showPassword ? 'text' : 'password'" name="new_password_confirmation" 
                        class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-purple-300">
                    <button type="button" class="absolute inset-y-0 right-2 flex items-center text-gray-600"
                        @click="showPassword = !showPassword">
                        <i x-show="!showPassword" class="fas fa-eye"></i>
                        <i x-show="showPassword" class="fas fa-eye-slash"></i>
                    </button>
                </div>
            </div>

            <!-- Save Changes Button -->
            <button type="submit" class="w-full bg-purple-600 text-white py-2 rounded-lg hover:bg-purple-700">
                Save Changes
            </button>
        </form>
    </div>
</div>

<!-- Alpine.js for toggle functionality -->
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endsection