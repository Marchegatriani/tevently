@extends('layouts.guest')

@section('title', 'Beranda')

@section('content')
<style>
    /* Latar belakang Utama dari layout adalah #F8F3F7 */
    .bg-custom-light { background-color: #F8F3F7; }
    .text-custom-dark { color: #250e2c; } 
</style>

<div class="font-sans">

    <!-- Bagian Hero -->
    <div class="bg-gradient-to-br from-[#f7c2ca] to-[#cc8db3] text-custom-dark">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-32">
            <div class="text-center">
                <h1 class="text-4xl md:text-6xl font-extrabold mb-4 tracking-tight text-custom-dark">
                    Event Seru Dimulai di Tevently !
                </h1>
                <p class="text-lg md:text-xl mb-10 text-[#837ab6] max-w-3xl mx-auto">
                    Cari dan pesan tiket untuk acara terbaik di sekitar Anda
                </p>
                
                <!-- Search Bar -->
                <form action="{{ route('guest.events.index') }}" method="GET" class="max-w-3xl mx-auto">
                    <div class="relative">
                        <input type="text" 
                               name="search" 
                               placeholder="Cari acara atau lokasi..." 
                               class="w-full px-8 py-4 rounded-3xl text-custom-dark bg-white focus:outline-none focus:ring-4 focus:ring-[#f6a5c0] placeholder-gray-500 shadow-xl transition-all duration-300 border border-gray-200">
                        <button type="submit" class="absolute right-2 top-1/2 -translate-y-1/2 bg-[#837ab6] text-white px-8 py-2.5 rounded-3xl font-bold hover:bg-[#9d85b6] transition-colors duration-300 shadow-md">
                            Cari
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bagian Acara Unggulan -->
    <div class="bg-custom-light"> <!-- Latar belakang Body Utama #F8F3F7 (Soft Light) -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
            <div class="flex justify-between items-center mb-10">
                <h2 class="text-4xl font-extrabold text-custom-dark">Acara Unggulan</h2>
                <a href="{{ route('guest.events.index') }}" class="text-[#837ab6] hover:text-custom-dark font-semibold transition-colors flex items-center gap-1">
                    Lihat Semua 
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                    </svg>
                </a>
            </div>

            @if($featuredEvents->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                @foreach($featuredEvents as $event)
                    <a href="{{ route('guest.events.show', $event) }}" class="group bg-white rounded-3xl shadow-xl overflow-hidden hover:shadow-2xl hover:shadow-[#cc8db3]/40 hover:-translate-y-2 transition-all duration-500 border border-gray-100"> 
                        <div class="h-56 overflow-hidden">
                            @if($event->image_url)
                                <!-- Pastikan path 'storage/' benar di lingkungan Anda -->
                                <img src="{{ asset('storage/' . $event->image_url) }}" alt="{{ $event->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-[#837ab6] to-[#cc8db3] flex items-center justify-center">
                                    <span class="text-white text-5xl font-bold opacity-80">{{ substr($event->title, 0, 2) }}</span>
                                </div>
                            @endif
                        </div>
                        <div class="p-8">
                            <div class="flex items-center gap-2 mb-3">
                                <span class="px-4 py-1 bg-[#f6a5c0]/50 text-custom-dark text-xs font-bold rounded-full uppercase tracking-wider">
                                    {{ $event->category->name }}
                                </span>
                            </div>
                            <h3 class="text-2xl font-bold text-custom-dark mb-4 group-hover:text-[#cc8db3] transition-colors">{{ $event->title }}</h3>
                            
                            <div class="text-gray-600 text-sm space-y-2 mb-5">
                                <!-- Tanggal -->
                                <div class="flex items-center gap-2">
                                    <svg class="w-5 h-5 text-[#cc8db3]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <span>{{ $event->event_date->format('d F Y') }}</span>
                                </div>
                                <!-- Lokasi -->
                                <div class="flex items-center gap-2">
                                    <svg class="w-5 h-5 text-[#cc8db3]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <span>{{ $event->location }}</span>
                                </div>
                            </div>
                            
                            <div class="flex items-center justify-between pt-5 border-t border-gray-100">
                                <span class="text-sm text-gray-500">Oleh {{ $event->organizer->name }}</span>
                                <span class="text-[#837ab6] font-bold group-hover:text-custom-dark transition-colors flex items-center">
                                    Lihat Detail 
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </span>
                            </div>
                        </div>
                    </a>
                @endforeach
                </div>
            @else
                <div class="text-center py-16 bg-white rounded-3xl border border-gray-100 shadow-lg">
                    <p class="text-custom-dark text-xl font-medium">Saat ini tidak ada acara unggulan yang tersedia.</p>
                    <p class="text-[#9d85b6] mt-2">Silakan cek kembali nanti atau gunakan fitur Cari di atas.</p>
                </div>
            @endif
        </div>
    </div>

</div>

@endsection