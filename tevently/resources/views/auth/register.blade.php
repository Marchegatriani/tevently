<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Page</title>
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Zen+Kaku+Gothic+Antique&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Animasi Slide-in */
        body {
            font-family: Poppins;
        }
        @keyframes slide-in-from-left {
            0% {
                transform: translateX(-100%);
                opacity: 0;
            }
            100% {
                transform: translateX(0);
                opacity: 1;
            }
        }

        .animate-slide-in-from-left {
            animation: slide-in-from-left 2s ease-out forwards;
        }

        /* Konsistensi Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        a {
            font-family: Zen Kaku Gothic Antique; 
            font-size:14px;
        }
    </style>
</head>

<body class="bg-white min-h-screen flex items-center justify-center overflow-x-hidden">
    <div class="min-h-screen bg-gradient-to-br from-purple-600 via-blue-600 to-indigo-700 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md p-8">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Create Your Account</h1>
            <p class="text-gray-600">Join us and start your journey!</p>
        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Full Name -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-semibold mb-2">
                    Full Name
                </label>
                <input 
                    type="text" 
                    name="name" 
                    value="{{ old('name') }}"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition"
                    placeholder="Enter your full name"
                    required
                >
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-semibold mb-2">
                    Email
                </label>
                <input 
                    type="email" 
                    name="email" 
                    value="{{ old('email') }}"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition"
                    placeholder="your@email.com"
                    required
                >
                @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Account Type -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-semibold mb-2">
                    Account Type
                </label>
                <div class="grid grid-cols-2 gap-3">
                    <label class="relative cursor-pointer">
                        <input 
                            type="radio" 
                            name="role" 
                            value="user" 
                            checked
                            class="peer sr-only"
                        >
                        <div class="border-2 border-gray-300 rounded-lg p-4 text-center transition peer-checked:border-purple-500 peer-checked:bg-purple-50">
                            <svg class="w-8 h-8 mx-auto mb-2 text-gray-600 peer-checked:text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            <span class="text-sm font-medium text-gray-700">Regular User</span>
                        </div>
                    </label>

                    <label class="relative cursor-pointer">
                        <input 
                            type="radio" 
                            name="role" 
                            value="organizer"
                            class="peer sr-only"
                        >
                        <div class="border-2 border-gray-300 rounded-lg p-4 text-center transition peer-checked:border-purple-500 peer-checked:bg-purple-50">
                            <svg class="w-8 h-8 mx-auto mb-2 text-gray-600 peer-checked:text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            <span class="text-sm font-medium text-gray-700">Event Organizer</span>
                        </div>
                    </label>
                </div>
                @error('role')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-semibold mb-2">
                    Password
                </label>
                <input 
                    type="password" 
                    name="password" 
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition"
                    placeholder="Minimum 8 characters"
                    required
                >
                @error('password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-semibold mb-2">
                    Confirm Password
                </label>
                <input 
                    type="password" 
                    name="password_confirmation" 
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition"
                    placeholder="Re-enter your password"
                    required
                >
                @error('password_confirmation')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Button -->
            <button 
                type="submit" 
                class="w-full bg-gradient-to-r from-purple-600 to-blue-600 text-white font-bold py-3 px-4 rounded-lg hover:from-purple-700 hover:to-blue-700 transition duration-300 transform hover:scale-105 shadow-lg"
            >
                Register
            </button>

            <!-- Login Link -->
            <p class="text-center text-gray-600 text-sm mt-6">
                Already have an account? 
                <a href="{{ route('login') }}" class="text-purple-600 hover:text-purple-700 font-semibold">
                    Log in now!
                </a>
            </p>
        </form>
    </div>
</div>
</body>
</html>