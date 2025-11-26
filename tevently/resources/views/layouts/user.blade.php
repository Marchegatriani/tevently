<!DOCTYPE html>
<html>
<head>
    <title>@yield('title') - E-Ticket</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <!-- Header -->
    <nav class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="font-bold text-xl text-blue-600">
                        EventTicket
                    </a>
                </div>

                <!-- Navigation -->
                <div class="flex space-x-8 items-center">
                    <a href="{{ route('home') }}" class="text-gray-700 hover:text-blue-600">Beranda</a>
                    <a href="{{ route('events.index') }}" class="text-gray-700 hover:text-blue-600">Daftar Acara</a>
                    {{-- <a href="{{ route('user.favorites') }}" class="text-gray-700 hover:text-blue-600">Favorit Saya</a>
                    {{-- <a href="{{ route('user.orders') }}" class="text-gray-700 hover:text-blue-600">Riwayat Pesanan</a>
                     --}}
                    <!-- User -->
                    <div class="flex items-center space-x-4">
                        <span class="text-sm">{{ Auth::user()->name }}</span>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded text-sm">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Content -->
    <main class="py-6">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="mt-auto py-4 text-center text-gray-500 text-sm">
        &copy; {{ date('Y') }} Tevently — User Panel
    </footer>
</body>
</html>