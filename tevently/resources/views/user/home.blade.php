@extends('user.partials.navbar')

@section('title', 'Beranda')

@section('content')
<style>
    /* Palet: #250e2c (Dark), #837ab6 (Main), #cc8db3 (Pink Accent) */
    .text-custom-dark { color: #250e2c; }
    .bg-main-purple { background-color: #837ab6; }
</style>

<div class="font-sans">

    <!-- Bagian Hero -->
    <div class="bg-gradient-to-br from-[#f7c2ca] to-[#cc8db3] text-custom-dark rounded-xl shadow-lg -mt-4 mb-10 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-28">
            <div class="text-center">
                <h1 class="text-5xl md:text-6xl font-extrabold mb-6 tracking-tight text-custom-dark">
                    Temukan Acara Luar Biasa
                </h1>
                <p class="text-lg md:text-xl mb-10 text-[#837ab6] max-w-3xl mx-auto">
                    Cari dan pesan tiket untuk acara terbaik yang terjadi di dekat Anda.
                </p>
                
                <!-- Search Bar -->
                <form action="{{ route('user.events.index') }}" method="GET" class="max-w-2xl mx-auto">
                    <div class="relative">
                        <input type="text" 
                               name="search" 
                               placeholder="Cari acara atau lokasi..." 
                               class="w-full px-8 py-4 rounded-3xl text-custom-dark bg-white focus:outline-none focus:ring-4 focus:ring-[#f6a5c0] placeholder-gray-500 shadow-xl transition-all duration-300 border border-gray-200">
                        <button type="submit" class="absolute right-2 top-1/2 -translate-y-1/2 bg-main-purple text-white px-8 py-2.5 rounded-3xl font-bold hover:bg-[#9d85b6] transition-colors duration-300 shadow-md transform hover:-translate-y-0.5">
                            Cari
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Featured Events -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex justify-between items-center mb-8 border-b pb-3">
            <h2 class="text-3xl font-bold text-custom-dark">Acara Unggulan</h2>
            <a href="{{ route('user.events.index') }}" class="text-main-purple hover:text-custom-dark font-semibold transition-colors flex items-center gap-1">
                Lihat Semua →
            </a>
        </div>

        @if($featuredEvents->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($featuredEvents as $event)
                    <a href="{{ route('user.events.show', $event) }}" class="group bg-white rounded-3xl shadow-xl overflow-hidden hover:shadow-2xl hover:shadow-[#cc8db3]/40 hover:-translate-y-2 transition-all duration-300 border border-gray-100">
                        
                        <!-- Image/Placeholder -->
                        <div class="h-48 overflow-hidden relative">
                            @if($event->image_url)
                                <img src="{{ asset('storage/' . $event->image_url) }}" alt="{{ $event->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-[#837ab6] to-[#cc8db3] flex items-center justify-center">
                                    <span class="text-white text-4xl font-bold opacity-70">{{ substr($event->title, 0, 2) }}</span>
                                </div>
                            @endif
                        </div>
                        
                        <div class="p-6">
                            <div class="flex items-center gap-2 mb-2">
                                <span class="px-3 py-1 bg-[#f7c2ca]/50 text-custom-dark text-xs font-bold rounded-full uppercase">
                                    {{ $event->category->name }}
                                </span>
                            </div>
                            
                            <h3 class="text-xl font-bold text-custom-dark mb-3 group-hover:text-main-purple transition-colors">{{ $event->title }}</h3>
                            
                            <div class="text-gray-600 text-sm space-y-2 mb-4">
                                
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-pink-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <span>{{ $event->event_date->format('d M Y') }}</span>
                                </div>
                                
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-pink-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <span>{{ $event->location }}</span>
                                </div>
                            </div>
                            
                            <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                                <span class="text-sm text-gray-500">Oleh {{ $event->organizer->name }}</span>
                                <span class="text-main-purple font-semibold group-hover:text-custom-dark transition-colors flex items-center">
                                    Lihat Detail →
                                </span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            <div class="text-center py-12 bg-white rounded-3xl shadow-lg border border-gray-100">
                <p class="text-gray-500 text-lg">Saat ini tidak ada acara unggulan yang tersedia.</p>
                <a href="{{ route('user.events.index') }}" class="text-main-purple hover:text-custom-dark font-semibold mt-4 inline-block">
                    Jelajahi semua acara.
                </a>
            </div>
        @endif
    </div>
</div>
@endsection