<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Permohonan Organizer Ditolak - Tevently</title>
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
        <div class="bg-white rounded-3xl shadow-2xl border border-red-300 p-10 text-center">
            <a href="/" class="inline-block mb-6">
                <h1 class="text-3xl font-extrabold text-[#837ab6]">Tevently</h1>
            </a>
            
            <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </div>
            
            <h1 class="text-3xl font-bold text-custom-dark mb-4">Permohonan Ditolak</h1>
            
            <p class="text-gray-600 mb-8 max-w-sm mx-auto leading-relaxed">
                Maaf, permohonan Anda untuk menjadi Event Organizer **tidak disetujui** oleh administrator. 
                Anda tetap dapat menggunakan akun ini sebagai Pengguna Biasa, atau menghapusnya.
            </p>

            <div class="bg-red-50 border border-red-300 rounded-xl px-4 py-3 mb-8 shadow-inner">
                <div class="flex items-center justify-center space-x-2 text-red-700">
                    <span class="font-bold">Status: Ditolak</span>
                </div>
            </div>

            <div class="space-y-3">
                <form action="{{ route('organizer.delete-account') }}" method="POST" class="w-full">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            onclick="return confirm('Yakin ingin menghapus akun Anda? Tindakan ini tidak dapat dibatalkan.')"
                            class="w-full bg-red-600 text-white px-6 py-3 rounded-xl hover:bg-red-700 transition font-bold shadow-lg transform hover:-translate-y-0.5">
                        Hapus Akun & Keluar
                    </button>
                </form>
            </div>

            <div class="mt-8 pt-6 border-t border-gray-200">
                <p class="text-sm text-gray-500">
                    Merasa ini kesalahan? 
                    <a href="mailto:support@tevently.com" class="text-main-purple hover:text-custom-dark font-medium">
                        Hubungi Support
                    </a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>