<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'User Dashboard') - Tevently</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <style>
        /* Palet: #250e2c (Dark), #837ab6 (Main), #cc8db3 (Pink Accent), #f7c2ca (Soft Pink) */
        body { 
            font-family: 'Poppins', sans-serif; 
            background-color: #F8F3F7; /* Latar belakang lembut */
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .text-custom-dark { color: #250e2c; } 
        .bg-main-purple { background-color: #837ab6; }
        .bg-pink-accent { background-color: #cc8db3; }
        .bg-soft-pink-light { background-color: #f7c2ca; }

        /* Custom active link style */
        .nav-link.active {
            background-color: #f7c2ca;
            font-weight: 600;
            color: #250e2c;
        }
    </style>
</head>
<body class="bg-custom-light">
    <!-- Header -->
    <header class="bg-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4 flex-nowrap">
                    <!-- Logo -->
                    <a href="{{ route('user.home') }}" class="text-2xl font-extrabold text-custom-dark flex items-center h-10 hover:text-main-purple transition">Tevently</a>

                    {{-- desktop nav: inline, no-wrap --}}
                    <nav class="hidden md:flex items-center space-x-2 text-sm text-gray-700 ml-3 whitespace-nowrap">
                        <a href="{{ route('user.home') }}" class="nav-link inline-flex items-center h-9 px-3 rounded-xl transition hover:bg-soft-pink-light {{ request()->routeIs('user.home') ? 'active' : '' }}">Beranda</a>
                        <a href="{{ route('user.events.index') }}" class="nav-link inline-flex items-center h-9 px-3 rounded-xl transition hover:bg-soft-pink-light {{ request()->routeIs('user.events.*') ? 'active' : '' }}">Daftar Acara</a>
                        <a href="{{ route('user.favorites') }}" class="nav-link inline-flex items-center h-9 px-3 rounded-xl transition hover:bg-soft-pink-light {{ request()->routeIs('user.favorites') ? 'active' : '' }}">Favorit Saya</a>
                        <a href="{{ route('user.orders.index') }}" class="nav-link inline-flex items-center h-9 px-3 rounded-xl transition hover:bg-soft-pink-light {{ request()->routeIs('user.orders.*') ? 'active' : '' }}">Riwayat Pesanan</a>
                    </nav>

                    {{-- mobile toggle --}}
                    <div class="md:hidden">
                        <button id="user-nav-toggle" type="button" class="inline-flex items-center justify-center p-2 rounded-md text-gray-600 hover:bg-gray-100 focus:outline-none" aria-expanded="false" aria-controls="user-mobile-nav">
                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- user info / logout (desktop) --}}
                <div class="hidden md:block">
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" class="flex items-center text-sm font-medium text-custom-dark hover:text-main-purple focus:outline-none bg-soft-pink-light px-4 py-2 rounded-xl transition">
                            <span>Hai, {{ auth()->user()->name ?? 'User' }}</span>
                            <svg class="ml-1 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>

                        <div x-show="open" @click.away="open = false" 
                             x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="transform opacity-0 scale-95"
                             x-transition:enter-end="transform opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="transform opacity-100 scale-100"
                             x-transition:leave-end="transform opacity-0 scale-95"
                             class="absolute right-0 mt-2 w-48 rounded-xl shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-10 origin-top-right">
                            <div class="py-1">
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-custom-dark hover:bg-gray-100">Profil Saya</a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">Logout</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- mobile panel --}}
        <div id="user-mobile-nav" class="md:hidden bg-white border-t shadow-sm hidden">
            <div class="max-w-7xl mx-auto px-4 py-2">
                <nav class="flex flex-col gap-1 text-sm text-custom-dark">
                    <a href="{{ route('user.home') }}" class="block px-3 py-2 rounded-md hover:bg-gray-50 {{ request()->routeIs('home') ? 'bg-soft-pink-light font-medium' : '' }}">Beranda</a>
                    <a href="{{ route('user.events.index') }}" class="block px-3 py-2 rounded-md hover:bg-gray-50 {{ request()->routeIs('events.*') ? 'bg-soft-pink-light font-medium' : '' }}">Daftar Acara</a>
                    <a href="{{ route('user.favorites') }}" class="block px-3 py-2 rounded-md hover:bg-gray-50 {{ request()->routeIs('user.favorites') ? 'bg-soft-pink-light font-medium' : '' }}">Favorit Saya</a>
                    <a href="{{ route('user.orders.index') }}" class="block px-3 py-2 rounded-md hover:bg-gray-50 {{ request()->routeIs('user.orders.*') ? 'bg-soft-pink-light font-medium' : '' }}">Riwayat Pesanan</a>
                    <a href="{{ route('profile.edit') }}" class="block px-3 py-2 rounded-md hover:bg-gray-50 {{ request()->routeIs('profile.edit') ? 'bg-soft-pink-light font-medium' : '' }}">Profil Saya</a>

                    {{-- mobile logout --}}
                    <form method="POST" action="{{ route('logout') }}" class="mt-2 pt-2 border-t">
                        @csrf
                        <button type="submit" class="w-full text-left text-sm text-red-600 hover:underline px-3 py-2">Logout</button>
                    </form>
                </nav>
            </div>
        </div>

        <script>
            // Mobile toggle script
            (() => {
                const btn = document.getElementById('user-nav-toggle');
                const panel = document.getElementById('user-mobile-nav');
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
    <main class="max-w-7xl mx-auto px-4 py-8 flex-1">
        <div class="bg-white rounded-2xl shadow-xl p-8 border border-gray-100">
            
            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    <footer class="mt-auto py-6 bg-white/50 text-center text-gray-600 text-sm border-t border-gray-200">
        &copy; {{ date('Y') }} Tevently — Panel Pengguna
    </footer>
</body>
</html>