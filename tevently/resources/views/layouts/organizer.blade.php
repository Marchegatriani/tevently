<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Organizer Dashboard') - Tevently</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <!-- Header -->
    <header class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo dan Navigasi -->
                <div class="flex items-center space-x-8">
                    <a href="{{ route('home') }}" class="text-xl font-bold text-indigo-600">Tevently</a>
                    
                    <!-- Navigasi Horizontal -->
                    <nav class="hidden md:flex items-center space-x-1">
                        <a href="{{ route('organizer.dashboard') }}" class="px-3 py-2 text-sm font-medium rounded-md hover:bg-gray-100 {{ request()->routeIs('organizer.dashboard') ? 'bg-gray-100 text-gray-900' : 'text-gray-700' }}">
                            Dashboard
                        </a>
                        <a href="{{ route('organizer.events.index') }}" class="px-3 py-2 text-sm font-medium rounded-md hover:bg-gray-100 {{ request()->routeIs('organizer.events.*') ? 'bg-gray-100 text-gray-900' : 'text-gray-700' }}">
                            Acara Saya
                        </a>
                        <a href="{{ route('organizer.orders.index') }}" class="px-3 py-2 text-sm font-medium rounded-md hover:bg-gray-100 {{ request()->routeIs('organizer.orders.*') ? 'bg-gray-100 text-gray-900' : 'text-gray-700' }}">
                            Pemesanan
                        </a>
                        {{-- <a href="{{ route('organizer.reports.index') }}" class="px-3 py-2 text-sm font-medium rounded-md hover:bg-gray-100 {{ request()->routeIs('organizer.reports.*') ? 'bg-gray-100 text-gray-900' : 'text-gray-700' }}">
                            Laporan
                        </a> --}}
                    </nav>
                </div>

                <!-- User Info -->
                <div class="flex items-center space-x-4">
                    <span class="text-sm text-gray-700">Hai, {{ auth()->user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-sm text-red-600 hover:text-red-700 hover:underline">
                            Keluar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    <!-- Mobile Navigation -->
    <div id="org-mobile-nav" class="md:hidden bg-white border-t shadow-sm hidden">
        <div class="max-w-7xl mx-auto px-4 py-2">
            <nav class="flex flex-col gap-1 text-sm text-gray-700">
                <a href="{{ route('organizer.dashboard') }}" class="block px-3 py-2 rounded-md hover:bg-gray-50">Beranda</a>
                <a href="{{ route('organizer.events.index') }}" class="block px-3 py-2 rounded-md hover:bg-gray-50 {{ request()->routeIs('organizer.events.*') ? 'bg-gray-100 font-medium' : '' }}">Acara Saya</a>
                <a href="{{ route('organizer.orders.index') }}" class="block px-3 py-2 rounded-md hover:bg-gray-50 {{ request()->routeIs('organizer.orders.*') ? 'bg-gray-100 font-medium' : '' }}">Tiket</a>
                {{-- <a href="{{ route('organizer.reports.index') }}" class="block px-3 py-2 rounded-md hover:bg-gray-50 {{ request()->routeIs('organizer.reports.*') ? 'bg-gray-100 font-medium' : '' }}">Laporan</a> --}}
            </nav>
        </div>
    </div>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <p class="text-center text-sm text-gray-500">
                &copy; {{ date('Y') }} Tevently — Panel Organizer
            </p>
        </div>
    </footer>
</