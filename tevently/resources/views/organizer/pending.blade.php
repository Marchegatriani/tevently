<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Organizer Approval Pending - Tevently</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center">
    <div class="max-w-md w-full mx-4">
        <div class="bg-white rounded-lg shadow-sm border border-yellow-200 p-8 text-center">
            <!-- Icon -->
            <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            
            <!-- Title -->
            <h1 class="text-2xl font-bold text-gray-900 mb-3">Menunggu Persetujuan</h1>
            
            <!-- Message -->
            <p class="text-gray-600 mb-6">
                Permohonan Anda untuk menjadi Organizer sedang dalam proses peninjauan oleh Admin. 
                Biasanya membutuhkan waktu 1-2 hari kerja.
            </p>

            <!-- Status Badge -->
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg px-4 py-3 mb-6">
                <div class="flex items-center justify-center space-x-2 text-yellow-700">
                    <div class="w-2 h-2 bg-yellow-500 rounded-full animate-pulse"></div>
                    <span class="font-medium">Status: Menunggu Persetujuan</span>
                </div>
            </div>

            <!-- Actions -->
            <div class="space-y-3">
                {{-- Cancel request --}}
                <form method="POST" action="{{ route('organizer.cancel') }}" onsubmit="return confirm('Yakin ingin membatalkan permintaan menjadi organizer?');">
                    @csrf
                    <button type="submit" class="w-full text-sm bg-gray-100 text-gray-800 border border-gray-200 px-4 py-2 rounded-lg hover:bg-gray-200">
                        Batalkan Permintaan
                    </button>
                </form>

                {{-- Delete account (danger) --}}
                <form method="POST" action="{{ route('organizer.delete-account') }}" onsubmit="return confirm('Yakin ingin menghapus akun Anda? Tindakan ini permanen.');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full text-sm text-red-600 border border-red-200 px-4 py-2 rounded-lg hover:bg-red-50">
                        Hapus Akun
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>