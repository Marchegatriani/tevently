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
    <div class="flex flex-wrap w-full h-screen shadow-lg">
        <!-- Left Side (Image/Pattern) -->
        <div class="w-full lg:w-1/2 flex flex-col justify-center relative bg-cover bg-center" 
             style="background-image: url('{{ asset('images/auth/regist.png') }}');">
            <!-- Text with Custom Layout -->
            <div class="text-white text-left font-semibold text-[24px] lg:text-[32px] leading-relaxed animate-slide-in-from-left px-6 lg:px-24">
                "Join us today<br>
                and begin your<br>
                journey into the<br>
                world of entertainment!"
            </div>
        </div>

        <!-- Right Side (Text and Form) -->
        <div class="w-full lg:w-1/2 bg-white flex flex-col justify-center items-center px-4 lg:px-0 py-8 lg:py-0">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-8 mb-0">
            <h1 class="text-[24px] lg:text-[29px] font-bold mb-0">Create Your Account</h1>
            <p class="text-gray-600 mb-2 text-center text-sm lg:text-base" style="font-family: Zen Kaku Gothic Antique; font-size:14px">
                Create Your Account and Start the Fun!
            </p>
            
            <!-- Registration Form -->
            <form method="POST" action="{{ route('register') }}" class="w-full max-w-sm">
                @csrf

                <!-- Name -->
                <div class="mb-2 w-full">
                    <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Full Name</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required 
                           class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring focus:ring-[#640D5F] focus:ring-opacity-50">
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div class="mb-2 w-full">
                    <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required 
                           class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring focus:ring-[#640D5F] focus:ring-opacity-50">
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-2 w-full">
                    <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Password</label>
                    <input type="password" id="password" name="password" required 
                           class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring focus:ring-[#640D5F] focus:ring-opacity-50">
                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="mb-4 w-full">
                    <label for="password_confirmation" class="block text-gray-700 text-sm font-bold mb-2">Confirm Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required 
                           class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring focus:ring-[#640D5F] focus:ring-opacity-50">
                    @error('password_confirmation')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Register Button -->
                <div>
                    <button type="submit" 
                            class="w-full bg-[#640D5F] text-white py-2 px-4 rounded hover:bg-[#1B1464]">
                        Register
                    </button>
                </div>
            </form>

            <!-- Footer Links -->
            <p class="text-gray-500 text-sm mt-4">Already have an account? 
                <a href="{{ route('login') }}" class="text-indigo-500 hover:underline" style="font-size: 16px">Log in now!</a>
            </p>
        </div>
    </div>
</body>
</html>