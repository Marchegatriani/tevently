@extends('layouts.user')

@section('title', 'Discover Amazing Events')

@section('content')
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-slate-700 to-indigo-800 text-white">
        <div class="max-w-7xl mx-auto px-4 py-24 text-center">
            <h1 class="text-4xl md:text-6xl font-bold mb-6">Discover Amazing Events</h1>
            <p class="text-xl mb-8">Find and book tickets to the best events</p>
            
            <form action="{{ route('events.index') }}" method="GET" class="max-w-2xl mx-auto">
                <div class="flex gap-2">
                    <input type="text" name="search" placeholder="Cari acara..." class="flex-1 px-4 py-3 rounded text-gray-800">
                    <button type="submit" class="bg-white text-indigo-600 px-6 py-3 rounded font-semibold hover:bg-gray-100">Search</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Featured Events -->
    <div class="max-w-7xl mx-auto px-4 py-16">
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-3xl font-bold">Featured Events</h2>
            <a href="{{ route('events.index') }}" class="text-indigo-600 hover:text-indigo-800 font-semibold">
                View All Events →
            </a>
        </div>
        
        @if($featuredEvents->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($featuredEvents as $event)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                        <!-- Event Image -->
                        @if($event->image_url)
                            <img src="{{ asset('storage/' . $event->image_url) }}" 
                                 alt="{{ $event->title }}" 
                                 class="w-full h-48 object-cover">
                        @else
                            <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                                </svg>
                            </div>
                        @endif
                        
                        <!-- Event Content -->
                        <div class="p-4">
                            <h3 class="font-bold text-lg mb-2 line-clamp-2">{{ $event->title }}</h3>
                            
                            <!-- Event Details -->
                            <div class="space-y-2 mb-3">
                                <div class="flex items-center text-sm text-gray-600">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    {{ $event->event_date->format('M d, Y') }}
                                </div>
                                <div class="flex items-center text-sm text-gray-600">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    {{ Str::limit($event->location, 30) }}
                                </div>
                                <div class="flex items-center text-sm text-gray-600">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                    </svg>
                                    {{ $event->category->name ?? 'No Category' }}
                                </div>
                            </div>
                            
                            <!-- Price & Button -->
                            <div class="flex justify-between items-center">
                                @php
                                    $minPrice = $event->tickets->min('price');
                                    $maxPrice = $event->tickets->max('price');
                                @endphp
                                
                                @if($minPrice)
                                    <span class="text-lg font-bold text-indigo-600">
                                        Rp {{ number_format($minPrice, 0, ',', '.') }}
                                        @if($minPrice != $maxPrice)
                                            <span class="text-sm text-gray-500">- Rp {{ number_format($maxPrice, 0, ',', '.') }}</span>
                                        @endif
                                    </span>
                                @else
                                    <span class="text-gray-500">Free</span>
                                @endif
                                
                                <a href="{{ route('user.detailEvent', $event) }}" 
                                   class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 transition">
                                    Details
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-12">
                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                </svg>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No events available</h3>
                <p class="text-gray-500">Check back later for new events.</p>
            </div>
        @endif
    </div>

    <!-- CTA untuk Apply Organizer -->
    @if(auth()->user()->role === 'user' && auth()->user()->status === 'approved')
        <div class="max-w-7xl mx-auto px-4 py-8">
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 text-center">
                <h3 class="text-lg font-semibold mb-2">🎉 Ingin Jadi Organizer?</h3>
                <p class="text-gray-700 mb-4">Mulai buat acara Anda sendiri dan kelola tiket dengan mudah</p>
                
                <form method="POST" action="{{ route('organizer.request') }}" class="inline-block">
                    @csrf
                    <button type="submit" 
                            class="bg-blue-600 text-white px-6 py-2 rounded font-semibold hover:bg-blue-700 transition"
                            onclick="return confirm('Ajukan permohonan menjadi organizer? Setelah submit, Anda akan diarahkan ke halaman pending dan tidak bisa mengakses fitur user sampai disetujui.')">
                        🚀 Daftar sebagai Organizer
                    </button>
                </form>
                <p class="text-sm text-gray-600 mt-2">Ajukan permohonan untuk menjadi event organizer</p>
            </div>
        </div>
    @endif
@endsection