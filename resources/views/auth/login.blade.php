<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post Proper Southside - Admin</title>
    <link rel="icon" href="{{ asset('/assets/Southside.png') }}" type="image/png">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>

<body class="min-h-screen flex">
    <!-- Left Section - Background Image with Overlay -->
    <div class="w-3/4 relative flex items-center">
        <div class="absolute inset-0 bg-cover bg-center"
            style="background-image: url('{{ asset('assets/mckinley.jpg') }}');"></div>
        <div class="absolute inset-0 bg-black opacity-60"></div>
        <div class="relative z-10 pl-24 text-white">
            <div class="flex flex-col gap-2">
                <h1 class="text-5xl font-bold">Barangay Post Proper Southside</h1>
                <h2 class="text-3xl">Information System</h2>
                <p class="text-gray-200 text-lg max-w-2xl mt-4">Welcome to the official information management portal
                    for Barangay Post Proper Southside. Access community data, services, and administrative tools.</p>
            </div>
        </div>
    </div>

    <!-- Right Section - Login Form -->
    <div class="w-1/2 bg-zinc-100 flex items-center justify-center ">
        <div
            class="w-full max-w-md px-12  bg-zinc-50 p-8 rounded-xl shadow-lg hover:translate-y-[-10px] transition-all duration-200">
            <!-- Logo and Title -->
            <div class="text-center mb-8">
                <img src="{{ asset('assets/Southside.png') }}" alt="Post Proper Logo" class="mx-auto h-16 w-16">
                <h1 class="text-3xl font-semibold text-purple-700 mt-4">Post Proper Southside</h1>
                <p class="text-gray-500 text-md">ADMIN</p>
            </div>

            <!-- Display Authentication Errors -->
            @if (session('status'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    {{ session('status') }}
                </div>
            @endif

            <!-- Login Form -->
            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf
                <div>
                    <label for="username" class="block text-lg font-normal text-gray-700">Username</label>
                    <input type="text" name="username" id="username" value="{{ old('username') }}" required
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500">
                </div>

                <div>
                    <label for="password" class="block text-lg font-normal text-gray-700">Password</label>
                    <div class="relative">
                        <input type="password" name="password" id="password" required
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500">
                        <button type="button" onclick="togglePassword()"
                            class="absolute inset-y-0 right-0 flex items-center pr-3">
                            <i id="eye-icon" class="fa-solid fa-eye text-gray-400"></i>
                        </button>
                    </div>
                </div>

                <button type="submit"
                    class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-lg font-medium text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                    Login
                </button>
            </form>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordField = document.getElementById("password");
            const eyeIcon = document.getElementById("eye-icon");

            if (passwordField.type === "password") {
                passwordField.type = "text";
                eyeIcon.classList.remove("fa-eye");
                eyeIcon.classList.add("fa-eye-slash");
            } else {
                passwordField.type = "password";
                eyeIcon.classList.remove("fa-eye-slash");
                eyeIcon.classList.add("fa-eye");
            }
        }
    </script>
</body>

</html>