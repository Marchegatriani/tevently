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
                <!-- Logo dan Navigasi -->
                <div class="flex items-center space-x-8">
                    <a href="{{ route('home') }}" class="text-xl font-bold text-indigo-600">Tevently</a>
                    
                    <!-- Navigasi Horizontal -->
                    <nav class="hidden md:flex space-x-1">
                        <a href="{{ route('admin.dashboard') }}" class="px-3 py-2 rounded-md text-sm {{ request()->routeIs('admin.dashboard') ? 'bg-gray-100 font-medium' : 'hover:bg-gray-100' }}">Dashboard</a>
                        <a href="{{ route('admin.users.index') }}" class="px-3 py-2 rounded-md text-sm {{ request()->routeIs('admin.users.*') ? 'bg-gray-100 font-medium' : 'hover:bg-gray-100' }}">Users</a>
                        <a href="#" class="px-3 py-2 rounded-md text-sm hover:bg-gray-100">Events</a>
                        <a href="#" class="px-3 py-2 rounded-md text-sm hover:bg-gray-100">Reports</a>
                    </nav>
                </div>
                
                <!-- User Info -->
                <div class="flex items-center space-x-4">
                    <span class="text-sm">Hi, {{ auth()->user()->name ?? 'Admin' }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-sm text-red-600 hover:underline">Logout</button>
                    </form>
                </div>
            </div>
        </div>
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