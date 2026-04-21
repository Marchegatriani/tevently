<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menunggu Persetujuan Organizer - Tevently</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { 
            font-family: 'Poppins', sans-serif; 
            background-color: #F8F3F7;
        }
        .text-custom-dark { color: #250e2c; } 
        .bg-main-purple { background-color: #837ab6; }
        .bg-pink-accent { background-color: #cc8db3; }
    </style>
</head>
<body class="bg-custom-light min-h-screen flex items-center justify-center p-4">
    <div class="max-w-lg w-full mx-auto">
        <div class="bg-white rounded-3xl shadow-2xl border border-[#f7c2ca] p-10 text-center">
            <a href="/" class="inline-block mb-6">
                <h1 class="text-3xl font-extrabold text-[#837ab6]">Tevently</h1>
            </a>
            
            <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            
            <h1 class="text-3xl font-bold text-custom-dark mb-4">Menunggu Persetujuan</h1>
            
            <p class="text-gray-600 mb-8 max-w-sm mx-auto leading-relaxed">
                Permohonan Anda untuk menjadi **Organizer** sedang dalam proses peninjauan oleh Administrator. 
                Kami akan memberitahu Anda setelah status akun diperbarui.
            </p>

            <div class="bg-gray-50 rounded-xl p-5 mb-8 text-left border border-gray-100">
                <h3 class="font-bold text-custom-dark mb-3 text-lg border-b pb-2">Informasi Pemohon</h3>
                <dl class="text-sm grid grid-cols-1 md:grid-cols-2 gap-y-2">
                    <dt class="text-gray-500">Nama:</dt>
                    <dd class="font-medium text-custom-dark">{{ auth()->user()->name }}</dd>
                    <dt class="text-gray-500">Email:</dt>
                    <dd class="font-medium text-custom-dark">{{ auth()->user()->email }}</dd>
                </dl>
            </div>

            <div class="bg-[#f7c2ca] border border-[#cc8db3] rounded-xl px-4 py-3 mb-8 shadow-inner">
                <div class="flex items-center justify-center space-x-2 text-custom-dark">
                    <div class="w-3 h-3 bg-yellow-500 rounded-full animate-pulse"></div>
                    <span class="font-bold">Status: Menunggu Persetujuan</span>
                </div>
            </div>

            <div class="space-y-3">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full bg-main-purple hover:bg-[#9d85b6] text-white px-5 py-3 rounded-xl font-bold transition shadow-lg transform hover:-translate-y-0.5">
                        Logout
                    </button>
                </form>
            </div>

            <div class="mt-8 pt-6 border-t border-gray-200">
                <p class="text-sm text-gray-500">
                    Butuh bantuan? Hubungi: <a href="mailto:admin@tevently.com" class="text-main-purple hover:text-custom-dark font-medium">admin@tevently.com</a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>