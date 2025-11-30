@extends('admin.partials.navbar')

@section('title', 'Dashboard')
@section('heading', 'Dashboard')
@section('subheading', 'Ringkasan dan kontrol administrasi')

@section('content')
<style>
    /* Menggunakan warna aksen dari palet Soft Light Velvet */
    .bg-soft-pink { background-color: #f7c2ca; }
    .text-deep-purple { color: #250e2c; }
    .bg-main-purple { background-color: #837ab6; }
    .bg-medium-purple { background-color: #9d85b6; }
    .bg-pink-accent { background-color: #cc8db3; }
</style>

    <!-- Welcome -->
    <div class="mb-8">
        <div class="bg-soft-pink border border-[#f6a5c0]/50 rounded-xl p-6 shadow-md">
            <h3 class="text-xl font-bold text-deep-purple">Selamat Datang, {{ auth()->user()->name }} 👋</h3>
            <p class="text-sm text-gray-700 mt-2">Anda memiliki akses penuh untuk mengelola sistem sebagai administrator.</p>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        
        <!-- Total Users -->
        <div class="bg-white rounded-xl p-5 shadow-lg border border-gray-100 transition duration-300 hover:shadow-xl hover:border-main-purple">
            <div class="flex items-center gap-4">
                <div class="bg-main-purple text-white rounded-xl p-3 shadow-md shadow-[#837ab6]/40">
                    <!-- icon: Total Users -->
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1z" /></svg>
                </div>
                <div>
                    <p class="text-xs text-gray-500 font-semibold uppercase">Total Pengguna</p>
                    <p class="text-3xl font-extrabold text-deep-purple mt-1">{{ \App\Models\User::count() }}</p>
                </div>
            </div>
        </div>

        <!-- Pending Organizers -->
        <div class="bg-white rounded-xl p-5 shadow-lg border border-gray-100 transition duration-300 hover:shadow-xl hover:border-medium-purple">
            <div class="flex items-center gap-4">
                <div class="bg-medium-purple text-white rounded-xl p-3 shadow-md shadow-[#9d85b6]/40">
                    <!-- icon: Pending Organizers -->
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
                <div>
                    <p class="text-xs text-gray-500 font-semibold uppercase">Penyelenggara Tertunda</p>
                    {{-- Note: Logika di sini mungkin perlu disesuaikan di controller, tapi saya pertahankan logika Blade yang ada --}}
                    <p class="text-3xl font-extrabold text-deep-purple mt-1">{{ \App\Models\User::where('role', 'user')->where('status', 'pending')->count() }}</p>
                </div>
            </div>
        </div>

        <!-- Total Events -->
        <div class="bg-white rounded-xl p-5 shadow-lg border border-gray-100 transition duration-300 hover:shadow-xl hover:border-pink-accent">
            <div class="flex items-center gap-4">
                <div class="bg-pink-accent text-white rounded-xl p-3 shadow-md shadow-[#cc8db3]/40">
                    <!-- icon: Total Events -->
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                </div>
                <div>
                    <p class="text-xs text-gray-500 font-semibold uppercase">Total Event</p>
                    <p class="text-3xl font-extrabold text-deep-purple mt-1">{{ \App\Models\Event::count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-xl p-6 shadow-lg border border-gray-100">
        <h4 class="text-lg font-bold text-deep-purple mb-4">Aksi Cepat</h4>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            
            <!-- Manage Users -->
            <a href="{{ route('admin.users.index') }}" class="flex flex-col items-center justify-center gap-2 p-5 border border-gray-200 rounded-xl bg-gray-50 hover:bg-white transition duration-300 shadow-sm hover:shadow-lg">
                <div class="bg-main-purple text-white rounded-full p-3 shadow-lg shadow-[#837ab6]/40">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1z" /></svg>
                </div>
                <p class="text-sm font-bold text-deep-purple mt-2">Kelola Pengguna</p>
                <p class="text-xs text-gray-500 text-center">Lihat & kelola semua akun</p>
            </a>

            <!-- Manage Events -->
            <a href="{{ route('admin.events.index') }}" class="flex flex-col items-center justify-center gap-2 p-5 border border-gray-200 rounded-xl bg-gray-50 hover:bg-white transition duration-300 shadow-sm hover:shadow-lg">
                <div class="bg-medium-purple text-white rounded-full p-3 shadow-lg shadow-[#9d85b6]/40">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                </div>
                <p class="text-sm font-bold text-deep-purple mt-2">Kelola Event</p>
                <p class="text-xs text-gray-500 text-center">Setujui acara & kelola tiket</p>
            </a>

            <!-- View Reports -->
            <a href="{{ route('admin.reports.index') }}" class="flex flex-col items-center justify-center gap-2 p-5 border border-gray-200 rounded-xl bg-gray-50 hover:bg-white transition duration-300 shadow-sm hover:shadow-lg">
                <div class="bg-pink-accent text-white rounded-full p-3 shadow-lg shadow-[#cc8db3]/40">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zM9 0V9a2 2 0 01-2 2H5a2 2 0 01-2-2V0m4 6h2m-6 0h2m-2 6h2m-2 6h2m10-6h2m-2 6h2m-2-6V9a2 2 0 01-2-2H5a2 2 0 01-2 2v6a2 2 0 002 2h2a2 2 0 002-2z"/>
                    </svg>
                </div>
                <p class="text-sm font-bold text-deep-purple mt-2">Lihat Laporan</p>
                <p class="text-xs text-gray-500 text-center">Penjualan dan statistik sistem</p>
            </a>
            
            <!-- Manage Orders -->
            <a href="{{ route('admin.orders.index') }}" class="flex flex-col items-center justify-center gap-2 p-5 border border-gray-200 rounded-xl bg-gray-50 hover:bg-white transition duration-300 shadow-sm hover:shadow-lg">
                <div class="bg-gray-500 text-white rounded-full p-3 shadow-lg shadow-gray-500/40">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                    </svg>
                </div>
                <p class="text-sm font-bold text-deep-purple mt-2">Kelola Pesanan</p>
                <p class="text-xs text-gray-500 text-center">Lihat dan setujui pesanan tiket</p>
            </a>
        </div>
    </div>
@endsection