@extends('layouts.user')

@section('title', 'Discover Amazing Events')

@section('content')
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
            <div class="text-center">
                <h1 class="text-4xl md:text-6xl font-bold mb-6">
                    Discover Amazing Events
                </h1>
                <p class="text-xl md:text-2xl mb-8 text-indigo-100">
                    Find and book tickets to the best events happening near you
                </p>
                
                <!-- Search Bar -->
                <form action="{{ route('events.index') }}" method="GET" class="max-w-2xl mx-auto">
                    <div class="flex gap-2">
                        <input type="text" 
                               name="search" 
                               placeholder="Search events or locations..." 
                               class="flex-1 px-6 py-4 rounded-lg text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <button type="submit" class="bg-white text-indigo-600 px-8 py-4 rounded-lg font-semibold hover:bg-gray-100">
                            Search
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Become Organizer CTA (show for guest or eligible users) -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @auth
            @php $role = auth()->user()->role; $status = auth()->user()->status ?? null; @endphp
            @if(! in_array($role, ['organizer','admin']))
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <h3 class="text-lg font-semibold text-blue-900">🎉 Ingin Menyelenggarakan Acara?</h3>
                        <p class="text-gray-700">Daftarkan diri sebagai Event Organizer dan mulailah membuat acara Anda sendiri.</p>
                    </div>
                    <div>
                        @if($status === 'pending')
                            <button disabled class="px-4 py-2 bg-yellow-400 text-white rounded-md cursor-not-allowed">Request Pending</button>
                        @elseif($status === 'approved')
                            <a href="{{ route('organizer.dashboard') }}" class="inline-block px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">Go to Organizer Dashboard</a>
                        @elseif($status === 'rejected')
                            <form method="POST" action="{{ route('organizer.request') }}" class="inline-block">
                                @csrf
                                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Re-apply as Organizer</button>
                            </form>
                        @else
                            <form method="POST" action="{{ route('organizer.request') }}" class="inline-block">
                                @csrf
                                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Become an Organizer</button>
                            </form>
                        @endif
                    </div>
                </div>
            @endif
        @else
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 text-center">
                <p class="text-gray-700 mb-4">Mau jadi penyelenggara? Silakan login atau daftar dulu.</p>
                <div class="flex justify-center gap-3">
                    <a href="{{ route('login') }}" class="px-4 py-2 bg-white text-indigo-600 border border-indigo-600 rounded-md hover:bg-indigo-50">Login</a>
                    <a href="{{ route('register') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Register</a>
                </div>
            </div>
        @endauth
    </div>

    <!-- Featured Events -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-3xl font-bold text-gray-900">Featured Events</h2>
            <a href="{{ route('events.index') }}" class="text-indigo-600 hover:text-indigo-700 font-semibold">
                View All →
            </a>
        </div>

        @if($featuredEvents->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($featuredEvents as $event)
                    <a href="{{ route('events.show', $event) }}" class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition">
                        <div class="h-48 bg-gradient-to-br from-indigo-400 to-purple-500 flex items-center justify-center">
                            @if($event->image_url)
                                <img src="{{ asset('storage/' . $event->image_url) }}" alt="{{ $event->title }}" class="w-full h-full object-cover">
                            @else
                                <span class="text-white text-4xl font-bold">{{ substr($event->title, 0, 2) }}</span>
                            @endif
                        </div>
                        <div class="p-6">
                            <div class="flex items-center gap-2 mb-2">
                                <span class="px-2 py-1 bg-indigo-100 text-indigo-800 text-xs font-semibold rounded">
                                    {{ $event->category->name }}
                                </span>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $event->title }}</h3>
                            <div class="text-gray-600 text-sm space-y-1 mb-4">
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <span>{{ $event->event_date->format('M d, Y') }}</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <span>{{ $event->location }}</span>
                                </div>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-500">By {{ $event->organizer->name }}</span>
                                <span class="text-indigo-600 font-semibold">View Details →</span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            <div class="text-center py-12">
                <p class="text-gray-500 text-lg">No events available at the moment.</p>
            </div>
        @endif
    </div>
@endsection