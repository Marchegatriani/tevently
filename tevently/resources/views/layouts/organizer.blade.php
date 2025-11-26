<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Organizer Dashboard') - Tevently</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <!-- Header -->
    <header class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4 flex-nowrap">
                    <a href="{{ route('home') }}" class="text-xl font-bold text-indigo-600 flex items-center h-10">Tevently</a>

                    <nav class="hidden md:flex items-center space-x-2 text-sm text-gray-700 ml-3 whitespace-nowrap">
                        <a href="{{ route('organizer.events.index') }}" class="inline-flex items-center h-8 px-3 rounded-md hover:bg-gray-100 {{ request()->routeIs('organizer.events.*') ? 'bg-gray-100 font-medium' : '' }}">Kelola Acara Saya</a>
                        <a href="{{ route('organizer.orders.index') }}" class="inline-flex items-center h-8 px-3 rounded-md hover:bg-gray-100 {{ request()->routeIs('organizer.orders.*') ? 'bg-gray-100 font-medium' : '' }}">Pemesanan Tiket</a>
                        {{-- <a href="{{ route('organizer.reports.index') }}" class="inline-flex items-center h-8 px-3 rounded-md hover:bg-gray-100 {{ request()->routeIs('organizer.reports.*') ? 'bg-gray-100 font-medium' : '' }}">Laporan</a>
                    --}}
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
                <a href="{{ route('organizer.events.index') }}" class="block px-3 py-2 rounded-md hover:bg-gray-50 {{ request()->routeIs('organizer.events.*') ? 'bg-gray-100 font-medium' : '' }}">Acara Saya</a>
                <a href="{{ route('organizer.orders.index') }}" class="block px-3 py-2 rounded-md hover:bg-gray-50 {{ request()->routeIs('organizer.orders.*') ? 'bg-gray-100 font-medium' : '' }}">Pemesanan Tiket</a>
                {{-- <a href="{{ route('organizer.reports.index') }}" class="block px-3 py-2 rounded-md hover:bg-gray-50 {{ request()->routeIs('organizer.reports.*') ? 'bg-gray-100 font-medium' : '' }}">Laporan</a>
             --}}
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

    <script>
        (() => {
            const btn = document.getElementById('org-nav-toggle');
            const panel = document.getElementById('org-mobile-nav');
            if (!btn || !panel) return;
            btn.addEventListener('click', () => {
                panel.classList.toggle('hidden');
                const expanded = btn.getAttribute('aria-expanded') === 'true';
                btn.setAttribute('aria-expanded', (!expanded).toString());
            });
        })();
    </script>
</body>
</html>