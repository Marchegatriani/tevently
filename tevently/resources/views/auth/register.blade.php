<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - Tevently</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { 
            font-family: 'Poppins', sans-serif; 
            background-color: #F8F3F7; /* Latar belakang lembut */
        }
        .text-custom-dark { 
            color: #250e2c; /* Warna teks utama */
        } 
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4">
    
    <!-- Kontainer Login/Register Tunggal, Terpusat -->
    <div class="w-full max-w-lg bg-white rounded-3xl shadow-2xl p-8 sm:p-10 border border-gray-100">
        <div class="max-w-sm mx-auto">
            
            <div class="text-center mb-10">
                <a href="/" class="inline-block">
                    <h1 class="text-4xl font-extrabold text-[#837ab6] mb-2">Tevently</h1>
                </a>
                <p class="text-gray-600">Daftar akun baru Anda</p>
            </div>
            
            <!-- Form Register -->
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Nama Lengkap -->
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-custom-dark mb-2">Nama Lengkap</label>
                    <input 
                        type="text" 
                        name="name" 
                        id="name"
                        value="{{ old('name') }}"
                        class="w-full px-4 py-3 border border-[#9d85b6]/50 rounded-xl focus:ring-2 focus:ring-[#f6a5c0] focus:border-[#f6a5c0] transition bg-gray-50 text-custom-dark @error('name') border-red-500 @enderror"
                        placeholder="Masukkan nama lengkap Anda"
                        required
                    >
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-custom-dark mb-2">Email</label>
                    <input 
                        type="email" 
                        name="email" 
                        id="email"
                        value="{{ old('email') }}"
                        class="w-full px-4 py-3 border border-[#9d85b6]/50 rounded-xl focus:ring-2 focus:ring-[#f6a5c0] focus:border-[#f6a5c0] transition bg-gray-50 text-custom-dark @error('email') border-red-500 @enderror"
                        placeholder="nama@email.com"
                        required
                    >
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Pilihan Role -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-custom-dark mb-2">Jenis Akun</label>
                    <div class="grid grid-cols-2 gap-3">
                        <label class="relative cursor-pointer">
                            <input 
                                type="radio" 
                                name="role" 
                                value="user" 
                                checked
                                class="peer sr-only"
                            >
                            <div class="border-2 border-gray-300 rounded-xl p-3 text-center transition peer-checked:border-[#cc8db3] peer-checked:bg-[#f7c2ca]/50 hover:bg-gray-50">
                                <svg class="w-7 h-7 mx-auto mb-1 text-gray-600 peer-checked:text-[#837ab6]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                <span class="text-xs font-medium text-gray-700">User</span>
                            </div>
                        </label>

                        <label class="relative cursor-pointer">
                            <input 
                                type="radio" 
                                name="role" 
                                value="organizer"
                                class="peer sr-only"
                            >
                            <div class="border-2 border-gray-300 rounded-xl p-3 text-center transition peer-checked:border-[#cc8db3] peer-checked:bg-[#f7c2ca]/50 hover:bg-gray-50">
                                <svg class="w-7 h-7 mx-auto mb-1 text-gray-600 peer-checked:text-[#837ab6]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                <span class="text-xs font-medium text-gray-700">Event Organizer</span>
                            </div>
                        </label>
                    </div>
                    @error('role')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-custom-dark mb-2">Password</label>
                    <input 
                        type="password" 
                        name="password" 
                        id="password_reg"
                        class="w-full px-4 py-3 border border-[#9d85b6]/50 rounded-xl focus:ring-2 focus:ring-[#f6a5c0] focus:border-[#f6a5c0] transition bg-gray-50 text-custom-dark @error('password') border-red-500 @enderror"
                        placeholder="Minimal 8 karakter"
                        required
                    >
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="mb-8">
                    <label for="password_confirmation" class="block text-sm font-medium text-custom-dark mb-2">Konfirmasi Password</label>
                    <input 
                        type="password" 
                        name="password_confirmation" 
                        id="password_confirmation"
                        class="w-full px-4 py-3 border border-[#9d85b6]/50 rounded-xl focus:ring-2 focus:ring-[#f6a5c0] focus:border-[#f6a5c0] transition bg-gray-50 text-custom-dark @error('password_confirmation') border-red-500 @enderror"
                        placeholder="Ulangi password Anda"
                        required
                    >
                    @error('password_confirmation')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <button 
                    type="submit" 
                    class="w-full bg-[#837ab6] hover:bg-[#9d85b6] text-white font-bold py-3 px-4 rounded-xl transition duration-300 shadow-lg shadow-[#837ab6]/30 transform hover:-translate-y-0.5"
                >
                    Daftar
                </button>
            </form>

            <!-- Login Link -->
            <div class="mt-8 text-center border-t border-gray-100 pt-6">
                <p class="text-sm text-gray-600">
                    Sudah punya akun? 
                    <a href="{{ route('login') }}" id="login-link" class="text-[#cc8db3] hover:text-[#250e2c] font-semibold transition duration-300">
                        Masuk sekarang
                    </a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>