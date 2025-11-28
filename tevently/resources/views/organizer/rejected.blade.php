<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Organizer Application Rejected - Tevently</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center">
    <div class="max-w-md w-full mx-4">
        <div class="bg-white rounded-lg shadow-sm border border-red-200 p-8 text-center">
            <!-- Icon -->
            <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </div>
            
            <!-- Title -->
            <h1 class="text-2xl font-bold text-gray-900 mb-3">Permohonan Ditolak</h1>
            
            <!-- Message -->
            <p class="text-gray-600 mb-6">
                Maaf, permohonan Anda untuk menjadi Organizer tidak disetujui. 
                Anda dapat terus menggunakan platform sebagai pengguna biasa.
            </p>

            <!-- Status Badge -->
            <div class="bg-red-50 border border-red-200 rounded-lg px-4 py-3 mb-6">
                <div class="flex items-center justify-center space-x-2 text-red-700">
                    <span class="font-medium">Status: Permohonan Ditolak</span>
                </div>
            </div>

            <!-- Actions -->
            <div class="space-y-3">
                <a href="{{ route('home') }}" 
                   class="w-full bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition block text-center">
                    Lanjut sebagai Pengguna
                </a>
                
                <form action="{{ route('organizer.delete-account') }}" method="POST" class="w-full">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            onclick="return confirm('Apakah Anda yakin ingin menghapus akun? Tindakan ini tidak dapat dibatalkan.')"
                            class="w-full bg-red-600 text-white px-6 py-3 rounded-lg hover:bg-red-700 transition">
                        Hapus Akun Saya
                    </button>
                </form>
            </div>

            <!-- Info -->
            <p class="text-sm text-gray-500 mt-6">
                Jika Anda merasa ini adalah kesalahan, silakan hubungi tim support kami.
            </p>
        </div>
    </div>
</body>
</html>