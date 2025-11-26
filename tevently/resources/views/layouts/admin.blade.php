<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') - Tevently</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <!-- Header -->
    <header class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4 flex-nowrap">
                    <a href="{{ route('home') }}" class="text-xl font-bold text-indigo-600 flex items-center h-10">Tevently</a>

                    {{-- desktop nav: inline, no-wrap --}}
                    <nav class="hidden md:flex items-center space-x-2 text-sm text-gray-700 ml-3 whitespace-nowrap">
                        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center h-8 px-3 rounded-md hover:bg-gray-100 {{ request()->routeIs('admin.dashboard') ? 'bg-gray-100 font-medium' : '' }}">Dashboard</a>
                        <a href="{{ route('admin.users.index') }}" class="inline-flex items-center h-8 px-3 rounded-md hover:bg-gray-100 {{ request()->routeIs('admin.users.*') ? 'bg-gray-100 font-medium' : '' }}">Users</a>
                        <a href="{{ route('admin.events.index') }}" class="inline-flex items-center h-8 px-3 rounded-md hover:bg-gray-100 {{ request()->routeIs('admin.events.*') ? 'bg-gray-100 font-medium' : '' }}">Events</a>
                        <a href="{{ route('admin.orders.index') }}" class="inline-flex items-center h-8 px-3 rounded-md hover:bg-gray-100 {{ request()->routeIs('admin.orders.*') ? 'bg-gray-100 font-medium' : '' }}">Ticket Orders</a>
                        <a href="{{ route('admin.reports.index') }}" class="inline-flex items-center h-8 px-3 rounded-md hover:bg-gray-100 {{ request()->routeIs('admin.reports.*') ? 'bg-gray-100 font-medium' : '' }}">Reports</a>
                    </nav>

                    {{-- mobile toggle --}}
                    <div class="md:hidden">
                        <button id="admin-nav-toggle" type="button" class="inline-flex items-center justify-center p-2 rounded-md text-gray-600 hover:bg-gray-100 focus:outline-none" aria-expanded="false" aria-controls="admin-mobile-nav">
                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- user info / logout (desktop) --}}
                <div class="hidden md:flex items-center gap-3">
                    <span class="text-sm text-gray-600">Hi, {{ auth()->user()->name ?? 'Admin' }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-sm text-red-600 hover:underline ml-2">Logout</button>
                    </form>
                </div>
             </div>
         </div>

        {{-- mobile panel --}}
        <div id="admin-mobile-nav" class="md:hidden bg-white border-t shadow-sm hidden">
            <div class="max-w-7xl mx-auto px-4 py-2">
                <nav class="flex flex-col gap-1 text-sm text-gray-700">
                    <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 rounded-md hover:bg-gray-50 {{ request()->routeIs('admin.dashboard') ? 'bg-gray-100 font-medium' : '' }}">Dashboard</a>
                    <a href="{{ route('admin.users.index') }}" class="block px-3 py-2 rounded-md hover:bg-gray-50 {{ request()->routeIs('admin.users.*') ? 'bg-gray-100 font-medium' : '' }}">Users</a>
                    <a href="{{ route('admin.events.index') }}" class="block px-3 py-2 rounded-md hover:bg-gray-50 {{ request()->routeIs('admin.events.*') ? 'bg-gray-100 font-medium' : '' }}">Events</a>
                    <a href="{{ route('admin.orders.index') }}" class="block px-3 py-2 rounded-md hover:bg-gray-50 {{ request()->routeIs('admin.orders.*') ? 'bg-gray-100 font-medium' : '' }}">Ticket Orders</a>
                    <a href="{{ route('admin.reports.index') }}" class="block px-3 py-2 rounded-md hover:bg-gray-50 {{ request()->routeIs('admin.reports.*') ? 'bg-gray-100 font-medium' : '' }}">Reports</a>

                    {{-- mobile logout --}}
                    <form method="POST" action="{{ route('logout') }}" class="mt-2 px-3">
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

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 py-6">
        <div class="bg-white rounded-lg shadow-sm p-6">
            <!-- Breadcrumb / Heading -->
            <div class="mb-6">
                <h1 class="text-2xl font-bold">@yield('heading', 'Overview')</h1>
                <p class="text-gray-500">@yield('subheading', 'Ringkasan dan kontrol administrasi')</p>
            </div>
            
            <!-- Content Area (Kosong untuk diisi oleh child template) -->
            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    <footer class="mt-auto py-4 text-center text-gray-500 text-sm">
        &copy; {{ date('Y') }} Tevently — Admin Panel
    </footer>
</body>
</html>