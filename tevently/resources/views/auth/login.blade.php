<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - Tevently</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #F8F3F7; }
        .text-custom-dark { color: #250e2c; } 
        /* Kontainer utama untuk mengatur posisi */
        #auth-container {
            position: relative;
            transform: translateX(0);
            transition: transform 0.8s cubic-bezier(0.68, -0.55, 0.27, 1.55);
        }
        /* Kontainer Visual */
        .image-placeholder {
            position: relative; /* Untuk menampung gambar absolut dan overlay */
            overflow: hidden;
        }
        /* Gambar absolut untuk mengisi seluruh kolom */
        .image-placeholder img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: 10; /* Di bawah overlay */
        }
        /* Overlay Transparan & Teks */
        .image-overlay {
            position: relative; /* Penting agar teks berada di atas gambar */
            z-index: 20;
            background-color: rgba(0, 0, 0, 0.3); /* Tambahkan overlay gelap agar teks mudah dibaca */
            backdrop-filter: blur(2px); /* Efek blur ringan pada overlay */
            padding: 3rem; 
            border-radius: 1.5rem; 
            text-shadow: 1px 1px 3px rgba(0,0,0,0.5); 
            height: 100%;
            width: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        /* Kelas animasi untuk pendaftaran */
        .slide-left {
            transform: translateX(-100%);
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4 lg:p-10">
    <div class="w-full max-w-6xl bg-white rounded-3xl shadow-2xl overflow-hidden flex transform" id="auth-container">
        
        <!-- Kolom Kiri: Form Login --><div class="w-full lg:w-1/2 p-8 sm:p-12 lg:p-16 flex-shrink-0" id="login-form-area">
            <div class="max-w-sm mx-auto">
                <div class="text-center mb-10">
                    <a href="/" class="inline-block">
                        <h1 class="text-4xl font-extrabold text-[#837ab6] mb-2">Tevently</h1>
                    </a>
                    <p class="text-gray-600">Masuk untuk menemukan dan memesan tiket event terbaik.</p>
                </div>

                <!-- Session Status -->@if (session('status'))
                    <div class="mb-4 p-4 bg-[#f7c2ca]/50 border border-[#cc8db3] text-custom-dark rounded-xl text-sm font-semibold">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email Address --><div class="mb-5">
                        <label for="email" class="block text-sm font-medium text-custom-dark mb-2">Email</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-[#9d85b6]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <input 
                                id="email" 
                                type="email" 
                                name="email" 
                                value="{{ old('email') }}"
                                required 
                                autofocus 
                                autocomplete="username"
                                class="block w-full pl-10 pr-3 py-3 border border-[#9d85b6]/50 rounded-xl focus:ring-2 focus:ring-[#f6a5c0] focus:border-[#f6a5c0] transition bg-gray-50 text-custom-dark @error('email') border-red-500 @enderror"
                                placeholder="nama@email.com"
                            >
                        </div>
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password --><div class="mb-6">
                        <label for="password" class="block text-sm font-medium text-custom-dark mb-2">Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-[#9d85b6]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <input 
                                id="password" 
                                type="password" 
                                name="password"
                                required 
                                autocomplete="current-password"
                                class="block w-full pl-10 pr-10 py-3 border border-[#9d85b6]/50 rounded-xl focus:ring-2 focus:ring-[#f6a5c0] focus:border-[#f6a5c0] transition bg-gray-50 text-custom-dark @error('password') border-red-500 @enderror"
                                placeholder="••••••••"
                            >
                            <button 
                                type="button" 
                                onclick="togglePassword('password')"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center"
                            >
                                <svg id="eye-open-login" class="h-5 w-5 text-[#9d85b6] hover:text-[#837ab6]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg id="eye-closed-login" class="h-5 w-5 text-[#9d85b6] hover:text-[#837ab6] hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                </svg>
                            </button>
                        </div>
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Remember Me & Forgot Password --><div class="flex items-center justify-between mb-8">
                        <label class="flex items-center">
                            <input 
                                id="remember_me" 
                                type="checkbox" 
                                name="remember"
                                class="rounded border-gray-300 text-[#837ab6] shadow-sm focus:ring-[#9d85b6] h-4 w-4"
                            >
                            <span class="ml-2 text-sm text-gray-600">Ingat saya</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-sm text-[#837ab6] hover:text-[#250e2c] font-medium">
                                Lupa password?
                            </a>
                        @endif
                    </div>

                    <!-- Login Button --><button 
                        type="submit"
                        class="w-full bg-[#cc8db3] hover:bg-[#f6a5c0] text-custom-dark font-bold py-3 px-4 rounded-xl transition duration-300 shadow-lg shadow-[#cc8db3]/30 transform hover:-translate-y-0.5"
                    >
                        Masuk
                    </button>
                </form>

                <!-- Register Link (using JS to trigger visual shift) --><div class="mt-8 text-center border-t border-gray-100 pt-6">
                    <p class="text-sm text-gray-600">
                        Belum punya akun? 
                        <a href="{{ route('register') }}" id="register-link" class="text-[#837ab6] hover:text-[#250e2c] font-semibold transition duration-300">
                            Daftar sekarang
                        </a>
                    </p>
                </div>
                
                <!-- Back to Home --><div class="text-center mt-6">
                    <a href="/" class="text-sm text-gray-600 hover:text-custom-dark inline-flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Kembali ke Beranda
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Kolom Kanan: Visual & Animasi (Gambar Latar Belakang Penuh) --><div class="hidden lg:block lg:w-1/2 image-placeholder h-auto flex-shrink-0">
            <!-- Gambar yang mengisi penuh kolom -->
            <img 
                src="{{ asset('storage/tampilan/848d3c9b8c998dd23bbcdaa5e633645b.jpg') }}" 
                alt="Visual Event E-Ticketing" 
                onerror="this.onerror=null;this.style.display='none';" 
                class="absolute inset-0 w-full h-full object-cover z-10"
            >
            
            <!-- Overlay Transparan & Teks -->
            <div class="image-overlay p-12">
                <h2 class="text-4xl font-extrabold text-white mb-4 text-center">
                    Selamat Datang Kembali!
                </h2>
                <p class="text-[#f7c2ca] text-lg mb-8 text-center max-w-xs">
                    Masuk untuk melanjutkan perjalanan tiket Anda dan mengelola event favorit.
                </p>
            </div>
        </div>
    </div>

    <script>
        function togglePassword(id) {
            const passwordInput = document.getElementById(id);
            const eyeOpen = document.getElementById(`eye-open-${id}`);
            const eyeClosed = document.getElementById(`eye-closed-${id}`);
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeOpen.classList.add('hidden');
                eyeClosed.classList.remove('hidden');
            } else {
                passwordInput.type = 'password';
                eyeOpen.classList.remove('hidden');
                eyeClosed.classList.add('hidden');
            }
        }
    </script>
</body>
</html>