<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'User Dashboard') - Tevently</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
</head>
<body class="bg-gray-100">
    <!-- Header -->
    <header class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4 flex-nowrap">
                    <a href="{{ route('user.home') }}" class="text-xl font-bold text-indigo-600 flex items-center h-10 hover:text-indigo-800 transition">Tevently</a>

                    {{-- desktop nav: inline, no-wrap --}}
                    <nav class="hidden md:flex items-center space-x-2 text-sm text-gray-700 ml-3 whitespace-nowrap">
                        <a href="{{ route('user.home') }}" class="inline-flex items-center h-8 px-3 rounded-md hover:bg-gray-100 {{ request()->routeIs('home') ? 'bg-gray-100 font-medium' : '' }}">Beranda</a>
                        <a href="{{ route('user.events.index') }}" class="inline-flex items-center h-8 px-3 rounded-md hover:bg-gray-100 {{ request()->routeIs('events.*') ? 'bg-gray-100 font-medium' : '' }}">Daftar Acara</a>
                        <a href="{{ route('user.favorites') }}" class="inline-flex items-center h-8 px-3 rounded-md hover:bg-gray-100 {{ request()->routeIs('user.favorites') ? 'bg-gray-100 font-medium' : '' }}">Favorit Saya</a>
                        <a href="{{ route('user.orders') }}" class="inline-flex items-center h-8 px-3 rounded-md hover:bg-gray-100 {{ request()->routeIs('user.orders') ? 'bg-gray-100 font-medium' : '' }}">Riwayat Pesanan</a>
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
                        <button @click="open = !open" class="flex items-center text-sm font-medium text-gray-600 hover:text-gray-800 focus:outline-none">
                            <span>Hi, {{ auth()->user()->name ?? 'User' }}</span>
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
                             class="absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-10">
                            <div class="py-1">
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profil Saya</a>
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
                <nav class="flex flex-col gap-1 text-sm text-gray-700">
                    <a href="{{ route('user.home') }}" class="block px-3 py-2 rounded-md hover:bg-gray-50 {{ request()->routeIs('home') ? 'bg-gray-100 font-medium' : '' }}">Beranda</a>
                    <a href="{{ route('user.events.index') }}" class="block px-3 py-2 rounded-md hover:bg-gray-50 {{ request()->routeIs('events.*') ? 'bg-gray-100 font-medium' : '' }}">Daftar Acara</a>
                    <a href="{{ route('user.favorites') }}" class="block px-3 py-2 rounded-md hover:bg-gray-50 {{ request()->routeIs('user.favorites') ? 'bg-gray-100 font-medium' : '' }}">Favorit Saya</a>
                    <a href="{{ route('user.orders') }}" class="block px-3 py-2 rounded-md hover:bg-gray-50 {{ request()->routeIs('user.orders') ? 'bg-gray-100 font-medium' : '' }}">Riwayat Pesanan</a>
                    <a href="{{ route('profile.edit') }}" class="block px-3 py-2 rounded-md hover:bg-gray-50 {{ request()->routeIs('profile.edit') ? 'bg-gray-100 font-medium' : '' }}">Profil Saya</a>

                    {{-- mobile logout --}}
                    <form method="POST" action="{{ route('logout') }}" class="mt-2 pt-2 border-t">
                        @csrf
                        <button type="submit" class="w-full text-left text-sm text-red-600 hover:underline px-3 py-2">Logout</button>
                    </form>
                 </nav>
             </div>
         </div>

        <script>
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
    <main class="max-w-7xl mx-auto px-4 py-6">
        <div class="bg-white rounded-lg shadow-sm p-6">
            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    <footer class="mt-auto py-4 text-center text-gray-500 text-sm">
        &copy; {{ date('Y') }} Tevently — User Panel
    </footer>
</body>
</html>