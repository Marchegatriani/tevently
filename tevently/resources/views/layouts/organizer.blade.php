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

                    {{-- desktop nav --}}
                    <nav class="hidden md:flex items-center space-x-2 text-sm text-gray-700 ml-3 whitespace-nowrap">
                        <a href="{{ route('organizer.dashboard') }}" class="inline-flex items-center h-8 px-3 rounded-md hover:bg-gray-100 {{ request()->routeIs('organizer.dashboard') ? 'bg-gray-100 font-medium' : '' }}">Dashboard</a>
                        <a href="{{ route('organizer.events') }}" class="inline-flex items-center h-8 px-3 rounded-md hover:bg-gray-100 {{ request()->routeIs('organizer.events.*') ? 'bg-gray-100 font-medium' : '' }}">Kelola Acara</a>
                        <a href="{{ route('organizer.orders.index') }}" class="inline-flex items-center h-8 px-3 rounded-md hover:bg-gray-100 {{ request()->routeIs('organizer.orders.*') ? 'bg-gray-100 font-medium' : '' }}">Pemesanan</a>
                        {{-- <a href="{{ route('organizer.reports.index') }}" class="inline-flex items-center h-8 px-3 rounded-md hover:bg-gray-100 {{ request()->routeIs('organizer.reports.*') ? 'bg-gray-100 font-medium' : '' }}">Laporan</a> --}}
                    </nav>

                    {{-- mobile toggle --}}
                    <div class="md:hidden">
                        <button id="org-nav-toggle" type="button" class="inline-flex items-center justify-center p-2 rounded-md text-gray-600 hover:bg-gray-100 focus:outline-none" aria-expanded="false" aria-controls="org-mobile-nav">
                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- user info / logout (desktop) --}}
                <div class="hidden md:flex items-center gap-3">
                    <span class="text-sm text-gray-600">Hai, {{ auth()->user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-sm text-red-600 hover:underline ml-2">Keluar</button>
                    </form>
                </div>
             </div>
         </div>

        {{-- mobile panel --}}
        <div id="org-mobile-nav" class="md:hidden bg-white border-t shadow-sm hidden">
            <div class="max-w-7xl mx-auto px-4 py-2">
                <nav class="flex flex-col gap-1 text-sm text-gray-700">
                    <a href="{{ route('organizer.dashboard') }}" class="block px-3 py-2 rounded-md hover:bg-gray-50 {{ request()->routeIs('organizer.dashboard') ? 'bg-gray-100 font-medium' : '' }}">Dashboard</a>
                    <a href="{{ route('organizer.events') }}" class="block px-3 py-2 rounded-md hover:bg-gray-50 {{ request()->routeIs('organizer.events.*') ? 'bg-gray-100 font-medium' : '' }}">Kelola Acara</a>
                    <a href="{{ route('organizer.orders.index') }}" class="block px-3 py-2 rounded-md hover:bg-gray-50 {{ request()->routeIs('organizer.orders.*') ? 'bg-gray-100 font-medium' : '' }}">Pemesanan</a>
                    {{-- <a href="{{ route('organizer.reports.index') }}" class="block px-3 py-2 rounded-md hover:bg-gray-50 {{ request()->routeIs('organizer.reports.*') ? 'bg-gray-100 font-medium' : '' }}">Laporan</a> --}}

                    {{-- mobile logout --}}
                    <form method="POST" action="{{ route('logout') }}" class="mt-2 px-3">
                        @csrf
                        <button type="submit" class="w-full text-left text-sm text-red-600 hover:underline py-2">Keluar</button>
                    </form>
                 </nav>
             </div>
         </div>

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
    </header>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 py-6">
        <div class="bg-white rounded-lg shadow-sm p-6">
            <!-- Breadcrumb / Heading -->
            <div class="mb-6">
                <h1 class="text-2xl font-bold">@yield('heading', 'Dashboard Organizer')</h1>
                <p class="text-gray-500">@yield('subheading', 'Kelola acara dan pemesanan tiket Anda')</p>
            </div>
            
            <!-- Content Area -->
            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    <footer class="mt-auto py-4 text-center text-gray-500 text-sm">
        &copy; {{ date('Y') }} Tevently — Panel Organizer
    </footer>
</body>
</html>