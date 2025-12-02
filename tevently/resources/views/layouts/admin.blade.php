<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') - Tevently</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { 
            font-family: 'Poppins', sans-serif; 
            background-color: #F8F3F7;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .text-custom-dark { color: #250e2c; } 
        .bg-main-purple { background-color: #837ab6; }
        .bg-pink-accent { background-color: #cc8db3; }
        .bg-soft-pink-light { background-color: #f7c2ca; }

        .pagination { display: flex; list-style: none; }
        .pagination svg { height: 1.25rem; }
        .pagination a, .pagination span { 
            padding: 0.5rem 0.75rem; 
            border: 1px solid #E5E7EB;
            margin-right: -1px;
            color: #837ab6;
            transition: all 0.2s;
        }
        .pagination .active span {
            background-color: #837ab6;
            border-color: #837ab6;
            color: white;
            font-weight: 600;
        }
        .pagination a:hover {
            background-color: #f7c2ca;
            color: #250e2c;
        }
    </style>
</head>
<body>
    <header class="bg-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4 flex-nowrap">
                    <a href="{{ route('admin.dashboard') }}" class="text-2xl font-extrabold text-custom-dark flex items-center h-10 hover:text-main-purple transition">Tevently</a>

                    <nav class="hidden md:flex items-center space-x-2 text-sm text-gray-700 ml-3 whitespace-nowrap">
                        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center h-9 px-3 rounded-xl transition hover:bg-soft-pink-light {{ request()->routeIs('admin.dashboard') ? 'bg-soft-pink-light font-bold text-custom-dark' : '' }}">Dashboard</a>
                        <a href="{{ route('admin.users.index') }}" class="inline-flex items-center h-9 px-3 rounded-xl transition hover:bg-soft-pink-light {{ request()->routeIs('admin.users.*') ? 'bg-soft-pink-light font-bold text-custom-dark' : '' }}">Pengguna</a>
                        <a href="{{ route('admin.events.index') }}" class="inline-flex items-center h-9 px-3 rounded-xl transition hover:bg-soft-pink-light {{ request()->routeIs('admin.events.*') ? 'bg-soft-pink-light font-bold text-custom-dark' : '' }}">Event</a>
                        <a href="{{ route('admin.orders.index') }}" class="inline-flex items-center h-9 px-3 rounded-xl transition hover:bg-soft-pink-light {{ request()->routeIs('admin.orders.*') ? 'bg-soft-pink-light font-bold text-custom-dark' : '' }}">Pesanan Tiket</a>
                        <a href="{{ route('admin.reports') }}" class="inline-flex items-center h-9 px-3 rounded-xl transition hover:bg-soft-pink-light {{ request()->routeIs('admin.reports') ? 'bg-soft-pink-light font-bold text-custom-dark' : '' }}">Laporan</a>
                    </nav>

                    <div class="md:hidden">
                        <button id="admin-nav-toggle" type="button" class="inline-flex items-center justify-center p-2 rounded-md text-gray-600 hover:bg-gray-100 focus:outline-none" aria-expanded="false" aria-controls="admin-mobile-nav">
                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="hidden md:flex items-center gap-3">
                    <span class="text-sm text-gray-700">Hi, {{ auth()->user()->name ?? 'Admin' }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-sm bg-pink-accent text-white px-4 py-2 rounded-xl font-semibold hover:bg-[#f6a5c0] transition shadow-sm">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div id="admin-mobile-nav" class="md:hidden bg-white border-t shadow-sm hidden">
            <div class="max-w-7xl mx-auto px-4 py-2">
                <nav class="flex flex-col gap-1 text-sm text-custom-dark">
                    <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 rounded-xl hover:bg-gray-50 {{ request()->routeIs('admin.dashboard') ? 'bg-soft-pink-light font-bold' : '' }}">Dashboard</a>
                    <a href="{{ route('admin.users.index') }}" class="block px-3 py-2 rounded-xl hover:bg-gray-50 {{ request()->routeIs('admin.users.*') ? 'bg-soft-pink-light font-bold' : '' }}">Pengguna</a>
                    <a href="{{ route('admin.events.index') }}" class="block px-3 py-2 rounded-xl hover:bg-gray-50 {{ request()->routeIs('admin.events.*') ? 'bg-soft-pink-light font-bold' : '' }}">Event</a>
                    <a href="{{ route('admin.orders.index') }}" class="block px-3 py-2 rounded-xl hover:bg-gray-50 {{ request()->routeIs('admin.orders.*') ? 'bg-soft-pink-light font-bold' : '' }}">Pesanan Tiket</a>
                    <a href="{{ route('admin.reports') }}" class="block px-3 py-2 rounded-xl hover:bg-gray-50 {{ request()->routeIs('admin.reports') ? 'bg-soft-pink-light font-bold' : '' }}">Laporan</a>

                    <form method="POST" action="{{ route('logout') }}" class="mt-2 pt-2 border-t border-gray-100">
                        @csrf
                        <button type="submit" class="w-full text-left text-sm text-red-600 hover:underline py-2">Logout</button>
                    </form>
                </nav>
            </div>
        </div>

        <script>
            (() => {
                const btn = document.getElementById('admin-nav-toggle');
                const panel = document.getElementById('admin-mobile-nav');
                if (!btn || !panel) return;
                btn.addEventListener('click', () => {
                    panel.classList.toggle('hidden');
                    const expanded = btn.getAttribute('aria-expanded') === 'true';
                    btn.setAttribute('aria-expanded', (!expanded).toString());
                });
            })();
        </script>
    </header>

    <main>
        <div class="bg-white rounded-2xl shadow-xl p-8 border border-gray-100">
            <div class="mb-6 pb-4 border-b border-gray-100 flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-extrabold text-custom-dark">@yield('heading', 'Overview')</h1>
                    <p class="text-gray-500 mt-1">@yield('subheading', 'Ringkasan dan kontrol administrasi')</p>
                </div>
                
                @yield('header-actions')
            </div>
            
            @yield('content')
        </div>
    </main>

    <footer class="mt-auto py-6 bg-white/50 text-center text-gray-600 text-sm border-t border-gray-200">
        &copy; {{ date('Y') }} Tevently — Admin Panel
    </footer>
</body>
</html>