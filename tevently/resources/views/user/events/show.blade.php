@extends('layouts.user')

@section('title', 'Detail Event: ' . $event->title)
@section('heading', 'Detail Event')
@section('subheading', 'Informasi lengkap mengenai acara ini')

@section('content')
<style>
    .text-custom-dark { color: #250e2c; }
    .bg-main-purple { background-color: #837ab6; }
    .bg-pink-accent { background-color: #cc8db3; }
    .bg-soft-light { background-color: #F8F3F7; }
</style>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 space-y-8 order-2 lg:order-1">
            <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100">
                <div class="h-96 relative">
                    @if($event->image_url)
                        <img src="{{ asset('storage/' . $event->image_url) }}" alt="{{ $event->title }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full bg-gradient-to-br from-[#837ab6] to-[#cc8db3] flex items-center justify-center">
                            <span class="text-white text-6xl font-bold opacity-90">{{ substr($event->title, 0, 2) }}</span>
                        </div>
                    @endif
                </div>

                <div class="p-8">
                    <div class="flex items-center gap-2 mb-4">
                        <span class="px-3 py-1 bg-pink-accent/20 text-custom-dark text-sm font-semibold rounded-full">
                            {{ $event->category->name }}
                        </span>
                        <span class="px-3 py-1 text-sm font-semibold rounded-full
                            {{ $event->status === 'published' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-700' }}">
                            {{ ucfirst($event->status) }}
                        </span>
                    </div>

                    <h1 class="text-3xl font-bold text-custom-dark mb-6">{{ $event->title }}</h1>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-y-4 gap-x-8 text-sm">
                        
                        <div class="flex items-start gap-3">
                            <svg class="w-6 h-6 text-main-purple flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <div>
                                <p class="font-semibold text-custom-dark">Tanggal & Waktu</p>
                                <p class="text-gray-600">{{ $event->event_date->format('l, d F Y') }}</p>
                                <p class="text-gray-600">{{ $event->start_time->format('H:i') }} - {{ $event->end_time->format('H:i') }} WITA</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            <svg class="w-6 h-6 text-main-purple flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <div>
                                <p class="font-semibold text-custom-dark">Lokasi</p>
                                <p class="text-gray-600">{{ $event->location }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Event Description -->
                <div class="bg-white rounded-3xl shadow-xl p-8 border border-gray-100">
                    <h2 class="text-2xl font-bold text-custom-dark mb-4 border-b pb-3">Tentang Acara Ini</h2>
                    <p class="text-gray-700 leading-relaxed whitespace-pre-line">{{ $event->description }}</p>
                    
                    <div class="mt-6 pt-4 border-t border-gray-100">
                        <p class="text-sm text-gray-600">Diadakan oleh: <strong class="text-custom-dark">{{ $event->organizer->name }}</strong></p>
                    </div>
                </div>

                <!-- Available Tickets -->
                <div class="bg-white rounded-3xl shadow-xl p-8 border border-gray-100" id="tickets">
                    <h2 class="text-2xl font-bold text-custom-dark mb-6 border-b pb-3">Pilihan Tiket</h2>
                    
                    @if($event->tickets->count() > 0)
                        <div class="space-y-4">
                            @foreach($event->tickets as $ticket)
                                @php
                                    $remaining = $ticket->quantity_available - $ticket->quantity_sold;
                                    $canBuy = $remaining > 0 && $ticket->is_active && $event->status === 'published';
                                @endphp

                                <div class="border rounded-xl p-5 transition {{ $canBuy ? 'border-main-purple hover:shadow-lg' : 'border-gray-200 bg-gray-50' }}">
                                    <div class="flex justify-between items-start mb-2">
                                        <div>
                                            <h4 class="font-bold text-xl text-custom-dark">{{ $ticket->name }}</h4>
                                            <p class="text-gray-600 text-sm mt-1">{{ $ticket->description }}</p>
                                        </div>
                                        <span class="text-2xl font-extrabold text-main-purple">
                                            Rp {{ number_format($ticket->price, 0, ',', '.') }}
                                        </span>
                                    </div>
                                    
                                    <div class="text-sm text-gray-600 space-y-1 mt-3 pt-3 border-t border-gray-100">
                                        <div class="flex justify-between">
                                            <span class="font-medium">Status Penjualan:</span>
                                            <span class="font-semibold {{ $ticket->is_active ? 'text-green-600' : 'text-red-600' }}">{{ $ticket->is_active ? 'Aktif' : 'Nonaktif' }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="font-medium">Tersisa:</span>
                                            <span class="font-bold {{ $remaining <= 10 ? 'text-red-500' : 'text-custom-dark' }}">{{ $remaining }} tiket</span>
                                        </div>
                                    </div>

                                    <div class="mt-4">
                                        @if($canBuy)
                                            <a href="{{ route('user.orders.create', ['event' => $event->id, 'ticket' => $ticket->id]) }}" 
                                            class="block w-full text-center bg-pink-accent text-white px-6 py-3 rounded-xl font-bold hover:bg-[#f6a5c0] transition shadow-md">
                                                Pesan Sekarang
                                            </a>
                                        @else
                                            <button disabled class="block w-full text-center bg-gray-300 text-gray-600 px-6 py-3 rounded-xl font-bold cursor-not-allowed">
                                                {{ $remaining === 0 ? 'Habis Terjual' : 'Tidak Tersedia' }}
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-4">Tidak ada tiket yang terdaftar untuk acara ini.</p>
                    @endif
                </div>
            </div>

            <div class="lg:col-span-1 order-1 lg:order-2 space-y-8">
                <!-- Quick Actions / Status -->
                <div class="bg-white rounded-3xl shadow-xl p-6 border border-gray-100 sticky top-4">
                    <h2 class="text-xl font-bold text-custom-dark mb-4 border-b pb-3">Pesan Tiket</h2>

                    @if($event->tickets->count() > 0 && $event->status === 'published')
                        <a href="#tickets" class="block w-full bg-main-purple hover:bg-[#9d85b6] text-white text-center px-6 py-3 rounded-xl font-bold mb-3 transition shadow-lg transform hover:-translate-y-0.5">
                            Lihat Semua Pilihan Tiket
                        </a>
                    @else
                        <button disabled class="block w-full bg-gray-400 text-white text-center px-6 py-3 rounded-xl font-bold mb-3 cursor-not-allowed">
                            Pemesanan Ditutup
                        </button>
                    @endif

                    <!-- Favorite Button -->
                    {{-- Asumsi $isFavorited didefinisikan di controller --}}
                    @php $isFavorited = false; // Placeholder if not defined @endphp
                    <form action="{{ route('user.favorites.toggle', $event) }}" method="POST">
                        @csrf
                        <button type="submit" class="flex items-center justify-center w-full text-center px-6 py-3 rounded-xl font-semibold transition-colors duration-300 shadow-md
                            @if($isFavorited)
                                bg-pink-accent/20 text-pink-accent hover:bg-pink-accent/30
                            @else
                                bg-gray-200 text-custom-dark hover:bg-gray-300
                            @endif
                        ">
                            <svg class="w-5 h-5 mr-2" fill="{{ $isFavorited ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 016.364 0L12 7.636l1.318-1.318a4.5 4.5 0 116.364 6.364L12 20.364l-7.682-7.682a4.5 4.5 0 010-6.364z"></path></svg>
                            <span>{{ $isFavorited ? 'Hapus dari Favorit' : 'Tambahkan ke Favorit' }}</span>
                        </button>
                    </form>
                </div>

                <!-- Similar Events -->
                @if(isset($similarEvents) && $similarEvents->count() > 0)
                    <div class="bg-white rounded-3xl shadow-xl p-6 border border-gray-100">
                        <h2 class="text-xl font-bold text-custom-dark mb-4 border-b pb-3">Event Serupa</h2>
                        <div class="space-y-4">
                            @foreach($similarEvents as $similar)
                                <a href="{{ route('user.events.show', $similar)}}" class="block p-3 rounded-xl transition border border-gray-100 hover:bg-gray-50">
                                    <h4 class="font-semibold text-custom-dark mb-1 line-clamp-1">{{ $similar->title }}</h4>
                                    <p class="text-sm text-gray-600">{{ $similar->event_date->format('d M Y') }}</p>
                                    <p class="text-xs text-gray-500">{{ $similar->location }}</p>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection