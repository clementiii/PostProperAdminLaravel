<head>
    <title>Admin Profile</title>
</head>

@extends('layouts.app')
@section('title', 'Admin Profile')
@section('content')
<div class="bg-gray-100">
    <div class="flex justify-center">
        <div class="bg-white shadow-lg rounded-lg w-full max-w-md">
            <!-- Success Message -->
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <!-- General Error Message -->
            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif
            
            <!-- Info Message -->
            @if(session('info'))
                <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded mb-4 relative" role="alert">
                    <span class="block sm:inline">{{ session('info') }}</span>
                </div>
            @endif

            <div class="flex flex-col items-center bg-purple-800 py-6 rounded-t-lg">
                <div class="relative group">
                    @if(Auth::user()->profile_picture)
                        <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}" 
                            class="w-24 h-24 rounded-full border-4 border-white object-cover" 
                            alt="Profile Picture">
                    @else
                        <div class="w-24 h-24 rounded-full border-4 border-white bg-gray-200 flex items-center justify-center">
                            <i class="fas fa-user text-gray-400 text-3xl"></i>
                        </div>
                    @endif
                    <div class="absolute inset-0 bg-black bg-opacity-50 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity cursor-pointer"
                            onclick="document.getElementById('profile-picture-modal').classList.remove('hidden')">
                        <i class="fas fa-camera text-white text-xl"></i>
                    </div>
                </div>
                <h2 class="text-xl font-bold text-white mt-2">{{ Auth::user()->name }}</h2>
                <p class="text-white text-sm">Administrator</p>
            </div>

            <!-- Update Profile Form -->
            <form method="POST" action="{{ route('admin.profile.update') }}" class="mt-4 p-4">
                @csrf

                <!-- Name Field - Add this field based on the image -->
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-purple-700">Name</label>
                    <input type="text" name="name" value="{{ Auth::user()->name }}" 
                        class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-purple-300" required>
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Username -->
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-purple-700">Username</label>
                    <input type="text" name="username" value="{{ Auth::user()->username }}" 
                        class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-purple-300" required>
                    @error('username')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Current Password - Modified to match design -->
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-purple-700">Current Password</label>
                    <input type="password" name="current_password" 
                        class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-purple-300" required>
                    @error('current_password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- New Password - Modified to match design -->
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-purple-700">New Password</label>
                    <input type="password" name="new_password" 
                        class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-purple-300">
                    @error('new_password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password - Modified to match design -->
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-purple-700">Confirm New Password</label>
                    <input type="password" name="new_password_confirmation" 
                        class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-purple-300">
                </div>

                <!-- Save Changes Button - Updated to match design -->
                <button type="submit" class="w-full bg-purple-700 text-white py-2 rounded-lg hover:bg-purple-800 flex items-center justify-center">
                    <i class="fas fa-save mr-2"></i> Save Changes
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Profile Picture Upload Modal -->
<div id="profile-picture-modal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg p-6 w-full max-w-md">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-800">Update Profile Picture</h3>
            <button type="button" class="text-gray-500 hover:text-gray-700" 
                onclick="document.getElementById('profile-picture-modal').classList.add('hidden')">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <form method="POST" action="{{ route('admin.profile.update-picture') }}" enctype="multipart/form-data">
            @csrf
            
            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Choose a new profile picture</label>
                <div class="flex items-center justify-center border-2 border-dashed border-gray-300 rounded-lg p-4">
                    <div class="text-center" id="upload-area">
                        <i class="fas fa-cloud-upload-alt text-gray-400 text-3xl mb-2"></i>
                        <p class="text-sm text-gray-500">Click to browse or drag and drop</p>
                        <p class="text-xs text-gray-400 mt-1">JPG, JPEG or PNG (max. 10MB)</p>
                        <input type="file" name="profile_picture" id="profile-picture-input" class="hidden" 
                            accept="image/jpeg,image/jpg,image/png" onchange="previewImage(this)">
                    </div>
                    <div id="preview-container" class="hidden">
                        <img id="preview-image" class="max-h-40 rounded">
                        <button type="button" class="mt-2 text-sm text-red-500" onclick="resetUpload()">Remove</button>
                    </div>
                </div>
                @error('profile_picture')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="flex justify-end mt-4">
                <button type="button" class="px-4 py-2 border border-gray-300 rounded-lg mr-2 hover:bg-gray-100"
                    onclick="document.getElementById('profile-picture-modal').classList.add('hidden')">
                    Cancel
                </button>
                <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700">
                    Upload
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Alpine.js for toggle functionality -->
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

<!-- Script for image preview -->
<script>
    document.getElementById('upload-area').addEventListener('click', function() {
        document.getElementById('profile-picture-input').click();
    });
    
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function(e) {
                document.getElementById('preview-image').src = e.target.result;
                document.getElementById('upload-area').classList.add('hidden');
                document.getElementById('preview-container').classList.remove('hidden');
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
    
    function resetUpload() {
        document.getElementById('profile-picture-input').value = '';
        document.getElementById('preview-container').classList.add('hidden');
        document.getElementById('upload-area').classList.remove('hidden');
    }
    
    // Add drag and drop functionality
    const uploadArea = document.getElementById('upload-area');
    
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        uploadArea.addEventListener(eventName, preventDefaults, false);
    });
    
    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }
    
    ['dragenter', 'dragover'].forEach(eventName => {
        uploadArea.addEventListener(eventName, highlight, false);
    });
    
    ['dragleave', 'drop'].forEach(eventName => {
        uploadArea.addEventListener(eventName, unhighlight, false);
    });
    
    function highlight() {
        uploadArea.classList.add('border-purple-500', 'bg-purple-50');
    }
    
    function unhighlight() {
        uploadArea.classList.remove('border-purple-500', 'bg-purple-50');
    }
    
    uploadArea.addEventListener('drop', handleDrop, false);
    
    function handleDrop(e) {
        const dt = e.dataTransfer;
        const files = dt.files;
        
        if (files.length) {
            document.getElementById('profile-picture-input').files = files;
            previewImage(document.getElementById('profile-picture-input'));
        }
    }
</script>
@endsection