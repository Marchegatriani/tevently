@extends('layouts.guest')

@section('title', 'Detail Event')

@section('content')
<style>
    /* Latar belakang Utama dari layout adalah #F8F3F7 (Soft Light) */
    .bg-custom-light { background-color: #F8F3F7; }
    /* Warna teks utama (ungu gelap) */
    .text-custom-dark { color: #250e2c; } 
</style>

<div class="font-sans bg-custom-light min-h-screen">
    <!-- Event Detail Container -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Breadcrumb -->
        <div class="mb-8">
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-2 text-sm">
                    <li>
                        <a href="/" class="text-gray-500 hover:text-[#837ab6]">Beranda</a>
                    </li>
                    <li>
                        <span class="text-gray-400">/</span>
                    </li>
                    <li>
                        <a href="{{ route('guest.events.index') }}" class="text-gray-500 hover:text-[#837ab6]">Jelajahi Event</a>
                    </li>
                    <li>
                        <span class="text-gray-400">/</span>
                    </li>
                    <li class="text-custom-dark font-medium">{{ Str::limit($event->name, 30) }}</li>
                </ol>
            </nav>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
            <!-- Main Content (2/3 width) -->
            <div class="lg:col-span-2">
                <!-- Event Image -->
                <div class="bg-white rounded-3xl shadow-xl overflow-hidden mb-8 border border-gray-100">
                    @if($event->image)
                        <img src="{{ asset('storage/' . $event->image) }}" alt="{{ $event->name }}" class="w-full h-96 object-cover">
                    @else
                        <div class="w-full h-96 bg-gradient-to-br from-[#837ab6] to-[#cc8db3] flex items-center justify-center">
                            <span class="text-white text-6xl font-bold">{{ substr($event->name, 0, 2) }}</span>
                        </div>
                    @endif
                </div>

                <!-- Event Info -->
                <div class="bg-white rounded-3xl shadow-xl p-8 mb-8 border border-gray-100">
                    
                    <div class="flex items-center gap-2 mb-4">
                        <span class="px-3 py-1 bg-[#f6a5c0]/50 text-custom-dark text-sm font-bold rounded-full uppercase">
                            {{ $event->category->name }}
                        </span>
                        @if(\Carbon\Carbon::parse($event->date)->isFuture())
                            <span class="px-3 py-1 bg-[#837ab6]/20 text-[#837ab6] text-sm font-semibold rounded-full">
                                Mendatang
                            </span>
                        @else
                            <span class="px-3 py-1 bg-gray-200 text-gray-700 text-sm font-semibold rounded-full">
                                Event Lalu
                            </span>
                        @endif
                    </div>

                    <h1 class="text-4xl font-extrabold text-custom-dark mb-6">{{ $event->name }}</h1>

                    <div class="space-y-4 mb-8">
                        
                        <div class="flex items-center gap-3 text-gray-700">
                            <svg class="w-6 h-6 text-[#cc8db3]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span class="font-semibold">{{ \Carbon\Carbon::parse($event->date)->format('l, d F Y') }}</span>
                        </div>

                        <div class="flex items-center gap-3 text-gray-700">
                            <svg class="w-6 h-6 text-[#cc8db3]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span class="font-semibold">{{ \Carbon\Carbon::parse($event->date)->format('H:i') }} WIB</span>
                        </div>

                        <div class="flex items-center gap-3 text-gray-700">
                            <svg class="w-6 h-6 text-[#cc8db3]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span>{{ $event->location }}</span>
                        </div>

                        <div class="flex items-center gap-3 text-gray-700">
                            <svg class="w-6 h-6 text-[#cc8db3]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <span>Diadakan oleh <strong>{{ $event->organizer->name }}</strong></span>
                        </div>
                    </div>

                    <div class="border-t border-gray-100 pt-6">
                        <h2 class="text-2xl font-bold text-custom-dark mb-4">Tentang Event Ini</h2>
                        <div class="text-gray-700 leading-relaxed whitespace-pre-line">{{ $event->description }}</div>
                    </div>
                </div>
            </div>

            <!-- Sidebar (1/3 width) -->
            <div class="lg:col-span-1">
                <!-- Ticket Options -->
                <div class="bg-white rounded-3xl shadow-xl p-8 sticky top-4 border border-gray-100">
                    <h2 class="text-2xl font-bold text-custom-dark mb-6">Tiket Tersedia</h2>

                    @if($event->tickets->count() > 0)
                        <div class="space-y-4">
                            @foreach($event->tickets as $ticket)
                                <div class="border border-gray-200 rounded-xl p-5 hover:border-[#837ab6] transition">
                                    <div class="flex justify-between items-start mb-2">
                                        <div>
                                            <h3 class="font-semibold text-custom-dark text-lg">{{ $ticket->type }}</h3>
                                            <p class="text-sm text-gray-600">{{ $ticket->description }}</p>
                                        </div>
                                    </div>
                                    
                                    <div class="flex justify-between items-center mt-4">
                                        <div>
                                            <p class="text-3xl font-extrabold text-[#837ab6]">
                                                Rp {{ number_format($ticket->price, 0, ',', '.') }}
                                            </p>
                                            <p class="text-xs text-gray-500">
                                                {{ $ticket->available_quantity }} / {{ $ticket->quantity }} tersisa
                                            </p>
                                        </div>
                                        
                                        @auth
                                            @if($ticket->available_quantity > 0 && \Carbon\Carbon::parse($event->date)->isFuture())
                                                <a href="{{ route('tickets.order', $ticket) }}" class="bg-[#cc8db3] hover:bg-[#f6a5c0] text-custom-dark px-5 py-2.5 rounded-xl text-sm font-bold transition shadow-md">
                                                    Beli Sekarang
                                                </a>
                                            @else
                                                <button disabled class="bg-gray-300 text-gray-500 px-5 py-2.5 rounded-xl text-sm font-bold cursor-not-allowed">
                                                    Habis Terjual
                                                </button>
                                            @endif
                                        @else
                                            <a href="{{ route('login') }}" class="bg-[#837ab6] hover:bg-[#9d85b6] text-white px-5 py-2.5 rounded-xl text-sm font-bold shadow-md">
                                                Login untuk Membeli
                                            </a>
                                        @endauth
                                    </div>

                                    @if($ticket->available_quantity > 0 && $ticket->available_quantity <= 10)
                                        <div class="mt-3 text-xs text-[#cc8db3] font-bold">
                                            ⚠️ Hanya tersisa {{ $ticket->available_quantity }} tiket!
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <svg class="mx-auto h-12 w-12 text-[#cc8db3]/70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                            </svg>
                            <p class="mt-2 text-gray-600">Belum ada tiket tersedia saat ini.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection