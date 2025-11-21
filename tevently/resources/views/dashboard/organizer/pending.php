<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pending Approval') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @php
                        $user = auth()->user();
                    @endphp

                    @if($user->role !== 'organizer')
                        <div class="text-red-600">
                            <h3 class="text-lg font-semibold mb-4">❌ Access Denied</h3>
                            <p>This page is only for Event Organizers.</p>
                        </div>
                    @elseif($user->status === 'pending')
                        <h3 class="text-lg font-semibold mb-4">⏳ Akun Anda Sedang Ditinjau</h3>
                        <p class="text-gray-600">
                            Terima kasih telah mendaftar sebagai Event Organizer. 
                            Akun Anda sedang dalam proses peninjauan oleh Admin. 
                            Anda akan menerima notifikasi setelah akun Anda disetujui.
                        </p>
                    @elseif($user->status === 'rejected')
                        <h3 class="text-lg font-semibold mb-4 text-red-600">❌ Akun Anda Ditolak</h3>
                        <p class="text-gray-600 mb-4">
                            Maaf, pengajuan Anda sebagai Event Organizer ditolak oleh Admin.
                        </p>
                        <form method="POST" action="{{ route('profile.destroy') }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                Hapus Akun
                            </button>
                        </form>
                    @else
                        <h3 class="text-lg font-semibold mb-4 text-green-600">✅ Akun Anda Sudah Disetujui!</h3>
                        <p class="text-gray-600 mb-4">
                            Silakan akses dashboard organizer Anda.
                        </p>
                        <a href="{{ route('organizer.dashboard') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Go to Dashboard
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>