<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Profile</title>
    <!-- Google Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!-- Google Material Symbols -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100">
    @extends('layouts.app')

    @section('title', 'ADMIN PROFILE')

    @section('content')
        <div class="container mx-auto p-6">
            <!-- View Profile Form -->
            <div id="viewProfile" class="max-w-2xl mx-auto bg-white rounded-lg shadow-lg overflow-hidden">
                <!-- Purple Header Section -->
                <div class="bg-purple-700 p-12 text-center relative">
                    <!-- Profile Picture -->
                    <div class="w-32 h-32 mx-auto mb-6">
                        <img src="{{ $admin->profile_picture }}" alt="Profile Picture"
                            class="w-full h-full rounded-full border-4 border-white">
                    </div>
                    <!-- Name and Role -->
                    <h2 class="text-2xl text-white font-semibold mb-2">{{ $admin->name }}</h2>
                    <p class="text-white opacity-90 text-lg">Administrator</p>
                </div>

                <!-- Profile Information Section -->
                <div class="p-10 space-y-6">
                    <!-- Name Field -->
                    <div class="space-y-2">
                        <label class="text-purple-700 font-medium text-lg">Name</label>
                        <input type="text" value="{{ $admin->name }}" readonly
                            class="w-full p-3 bg-gray-50 border border-gray-200 rounded text-lg">
                    </div>

                    <!-- Username Field -->
                    <div class="space-y-2">
                        <label class="text-purple-700 font-medium text-lg">Username</label>
                        <input type="text" value="{{ $admin->username }}" readonly
                            class="w-full p-3 bg-gray-50 border border-gray-200 rounded text-lg">
                    </div>

                    <!-- Current Password Field -->
                    <div class="space-y-2 relative">
                        <label class="text-purple-700 font-medium text-lg">Current Password</label>
                        <div class="relative">
                            <input type="password" id="passwordField" value="********" readonly
                                class="w-full p-3 bg-gray-50 border border-gray-200 rounded text-lg">
                            <span
                                class="material-symbols-outlined absolute right-3 top-1/2 transform -translate-y-1/2 cursor-pointer text-gray-500 hover:text-gray-700"
                                id="togglePassword" onclick="togglePasswordVisibility()">
                                visibility
                            </span>
                        </div>
                    </div>

                    <!-- Edit Profile Button -->
                    <button onclick="showEditForm()"
                        class="w-full bg-purple-700 text-white py-3 px-6 rounded hover:bg-purple-800 transition flex items-center justify-center space-x-2 text-lg mt-8">
                        <span class="material-symbols-outlined">edit</span>
                        <span>Edit Profile</span>
                    </button>
                </div>
            </div>

            <!-- Edit Profile Form -->
            <div id="editProfile" class="max-w-2xl mx-auto bg-white rounded-lg shadow-lg overflow-hidden hidden">
                <div class="bg-purple-700 p-12 text-center relative">
                    <!-- Back Button - Added at the top left -->
                    <button onclick="showViewForm()"
                        class="absolute top-4 left-4 text-white hover:text-gray-200 flex items-center space-x-1">
                        <span class="material-symbols-outlined">arrow_back</span>
                        <span>Back</span>
                    </button>

                    <!-- Profile Picture with overlay -->
                    <div class="w-32 h-32 mx-auto mb-6 profile-picture-container"
                        onclick="document.getElementById('profile_picture_input').click()">
                        <img src="{{ $admin->profile_picture }}" alt="Profile Picture"
                            class="w-full h-full rounded-full border-4 border-white">
                        <div class="profile-picture-overlay">
                            <span class="material-symbols-outlined camera-icon">photo_camera</span>
                        </div>
                        <input type="file" id="profile_picture_input" name="profile_picture" accept="image/*" class="hidden"
                            onchange="previewImage(this)">
                    </div>
                    <!-- Name and Role -->
                    <h2 class="text-2xl text-white font-semibold mb-2">{{ $admin->name }}</h2>
                    <p class="text-white opacity-90 text-lg">Administrator</p>
                </div>

                <form id="updateProfileForm" class="p-10 space-y-6">
                    <div class="space-y-2">
                        <label class="text-purple-700 font-medium text-lg">Name</label>
                        <input type="text" name="name" value="{{ $admin->name }}"
                            class="w-full p-3 bg-white border border-gray-200 rounded text-lg">
                    </div>

                    <div class="space-y-2">
                        <label class="text-purple-700 font-medium text-lg">Username</label>
                        <input type="text" name="username" value="{{ $admin->username }}"
                            class="w-full p-3 bg-white border border-gray-200 rounded text-lg">
                    </div>

                    <div class="space-y-2">
                        <label class="text-purple-700 font-medium text-lg">Current Password</label>
                        <input type="password" name="current_password"
                            class="w-full p-3 bg-white border border-gray-200 rounded text-lg">
                    </div>

                    <div class="space-y-2">
                        <label class="text-purple-700 font-medium text-lg">New Password</label>
                        <input type="password" name="new_password"
                            class="w-full p-3 bg-white border border-gray-200 rounded text-lg">
                    </div>

                    <div class="space-y-2">
                        <label class="text-purple-700 font-medium text-lg">Confirm New Password</label>
                        <input type="password" name="confirm_password"
                            class="w-full p-3 bg-white border border-gray-200 rounded text-lg">
                    </div>

                    <button type="submit"
                        class="w-full bg-purple-700 text-white py-3 px-6 rounded hover:bg-purple-800 transition flex items-center justify-center space-x-2 text-lg mt-8">
                        <span class="material-symbols-outlined">save</span>
                        <span>Save Changes</span>
                    </button>
                </form>
            </div>
        </div>
    @endsection

    <style>
        .profile-picture-container {
            position: relative;
            cursor: pointer;
        }

        .profile-picture-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .profile-picture-container:hover .profile-picture-overlay {
            opacity: 1;
        }

        .camera-icon {
            color: white;
            font-size: 2rem;
        }
    </style>

    <script>
        function togglePasswordVisibility() {
            const passwordField = document.getElementById('passwordField');
            const toggleIcon = document.getElementById('togglePassword');

            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                toggleIcon.textContent = 'visibility_off';
            } else {
                passwordField.type = 'password';
                toggleIcon.textContent = 'visibility';
            }
        }

        function showEditForm() {
            document.getElementById('viewProfile').classList.add('hidden');
            document.getElementById('editProfile').classList.remove('hidden');
        }

        function showViewForm() {
            document.getElementById('editProfile').classList.add('hidden');
            document.getElementById('viewProfile').classList.remove('hidden');
        }

        function previewImage(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function (e) {
                    // Update both view and edit form profile pictures
                    const profilePictures = document.querySelectorAll('.profile-picture-container img');
                    profilePictures.forEach(img => {
                        img.src = e.target.result;
                    });
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        document.getElementById('updateProfileForm').addEventListener('submit', function (e) {
            e.preventDefault();

            const formData = new FormData(this);

            fetch('{{ route("admin.profile.update") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
                body: formData // Remove JSON.stringify and send FormData directly
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Profile updated successfully');
                        window.location.reload();
                    } else {
                        alert(data.message || 'Error updating profile');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error updating profile');
                });
        });
    </script>
</body>

</html>