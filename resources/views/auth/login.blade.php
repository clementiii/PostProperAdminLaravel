<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Southside Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body class="min-h-screen flex items-center justify-center bg-cover bg-center" style="background-image: url('{{ asset('assets/mckinley.jpg') }}');">

    <!-- Overlay -->
    <div class="absolute inset-0 bg-black bg-opacity-50"></div>

    <!-- Login Container -->
    <div class="relative w-full max-w-md bg-purple-900 bg-opacity-90 rounded-lg shadow-xl p-8 text-white">
        
        <!-- Logo Section -->
        <div class="flex items-center justify-center mb-6">
            <img src="{{ asset('assets/Southside.png') }}" alt="Southside Logo" class="w-12 h-12">
            <h1 class="text-2xl font-bold ml-2">Southside Admin</h1>
        </div>

        <!-- Login Title -->
        <h2 class="text-center text-2xl font-semibold mb-4">Login</h2>

        <!-- Display Authentication Errors -->
        @if (session('status'))
            <p class="text-center bg-red-500 text-white py-2 px-4 rounded-md mb-4">{{ session('status') }}</p>
        @endif

        <!-- Display Validation Errors -->
        @if ($errors->any())
            <div class="bg-red-500 text-white py-2 px-4 rounded-md mb-4">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>⚠️ {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Login Form -->
        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf
            <div>
                <label for="username" class="block text-sm font-medium">Username</label>
                <input type="text" name="username" value="{{ old('username') }}" required
                    class="w-full px-4 py-2 text-gray-900 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-400 focus:outline-none">
                @error('username')
                    <p class="text-red-300 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="relative">
                <label for="password" class="block text-sm font-medium">Password</label>
                <div class="relative">
                    <input type="password" name="password" id="password" required
                        class="w-full px-4 py-2 text-gray-900 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-400 focus:outline-none pr-12">
                    <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-4 flex items-center text-gray-500 hover:text-gray-700">
                        <i id="eye-icon" class="fa-solid fa-eye text-lg"></i>
                    </button>
                </div>
                @error('password')
                    <p class="text-red-300 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>            

            <button type="submit"
                class="w-full bg-purple-600 hover:bg-purple-500 text-white font-semibold py-2 rounded-lg transition duration-300 shadow-md">
                Login
            </button>
        </form>
    </div>

    <!-- Show Password Toggle Script -->
    <script>
        function togglePassword() {
            let passwordField = document.getElementById("password");
            let eyeIcon = document.getElementById("eye-icon");
    
            if (passwordField.type === "password") {
                passwordField.type = "text";
                eyeIcon.classList.remove("fa-eye");
                eyeIcon.classList.add("fa-eye-slash"); // Closed eye icon
            } else {
                passwordField.type = "password";
                eyeIcon.classList.remove("fa-eye-slash");
                eyeIcon.classList.add("fa-eye"); // Open eye icon
            }
        }
    </script>

</body>
</html>
