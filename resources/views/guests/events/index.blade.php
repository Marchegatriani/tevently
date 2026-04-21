@extends('layouts.guests')

@section('title', 'Jelajahi Event')

@section('content')
<style>
    .bg-custom-light { background-color: #F8F3F7; }
    .text-custom-dark { color: #250e2c; } 
</style>

<div class="font-sans bg-custom-light min-h-screen">
    <div class="bg-gradient-to-br from-[#f7c2ca] to-[#cc8db3] border-b border-[#cc8db3]/50 shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
            <h1 class="text-4xl font-extrabold text-custom-dark">Jelajahi Semua Event</h1>
            <p class="text-[#837ab6] mt-2 text-lg">Temukan acara menarik yang sedang berlangsung di dekat Anda</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="flex flex-col lg:flex-row gap-10">
            <div class="lg:w-72 flex-shrink-0">
                <div class="bg-white rounded-3xl shadow-xl p-8 sticky top-6 border border-gray-100">
                    <h2 class="font-bold text-2xl mb-6 text-custom-dark">Filter Acara</h2>
                    
                    <form method="GET" action="{{ route('guests.events.index') }}">
                        
                        <div class="mb-5">
                            <label class="block text-sm font-medium text-custom-dark mb-2">Cari</label>
                            <input type="text" 
                                   name="search" 
                                   value="{{ request('search') }}"
                                   placeholder="Nama event atau lokasi..." 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#f6a5c0] bg-white text-custom-dark">
                        </div>

                        <div class="mb-5">
                            <label class="block text-sm font-medium text-custom-dark mb-2">Kategori</label>
                            <select name="category" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#f6a5c0] bg-white text-custom-dark">
                                <option value="">Semua Kategori</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-5">
                            <label class="block text-sm font-medium text-custom-dark mb-2">Dari Tanggal</label>
                            <input type="date" 
                                   name="date_from" 
                                   value="{{ request('date_from') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#f6a5c0] bg-white text-custom-dark">
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-medium text-custom-dark mb-2">Sampai Tanggal</label>
                            <input type="date" 
                                   name="date_to" 
                                   value="{{ request('date_to') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#f6a5c0] bg-white text-custom-dark">
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-medium text-custom-dark mb-2">Urutkan Berdasarkan</label>
                            <select name="sort" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#f6a5c0] bg-white text-custom-dark">
                                <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Terbaru</option>
                                <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Terlama</option>
                                <option value="title" {{ request('sort') == 'title' ? 'selected' : '' }}>Nama (A-Z)</option>
                                <option value="date" {{ request('sort') == 'date' ? 'selected' : '' }}>Tanggal Event</option>
                            </select>
                        </div>

                        <div class="flex flex-col gap-3">
                            <button type="submit" class="w-full bg-[#837ab6] hover:bg-[#9d85b6] text-white px-4 py-3 rounded-xl font-bold transition shadow-md">
                                Terapkan Filter
                            </button>
                            <a href="{{ route('guests.events.index') }}" class="w-full text-center bg-gray-200 hover:bg-gray-300 text-custom-dark px-4 py-3 rounded-xl font-semibold transition">
                                Hapus Semua
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <div class="flex-1">
                <div class="mb-6 border-b border-gray-200 pb-4">
                    <p class="text-[#837ab6]">
                        Menampilkan {{ $events->firstItem() ?? 0 }} - {{ $events->lastItem() ?? 0 }} dari total {{ $events->total() }} event
                    </p>
                </div>

                @if($events->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                        @foreach($events as $event)
                            <a href="{{ route('guests.events.show', $event) }}" class="group bg-white rounded-3xl shadow-xl overflow-hidden hover:shadow-2xl hover:shadow-[#cc8db3]/40 hover:-translate-y-1 transition-all duration-300 border border-gray-100">
                                <div class="h-40 overflow-hidden">
                                    @if($event->image_url)
                                        <img src="{{ asset('storage/' . $event->image_url) }}" alt="{{ $event->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                    @else
                                        <div class="w-full h-40 bg-gradient-to-br from-[#837ab6] to-[#cc8db3] flex items-center justify-center">
                                            <span class="text-white text-3xl font-bold opacity-80">{{ substr($event->title, 0, 2) }}</span>
                                        </div>
                                    @endif
                                </div>
                                
                                <div class="p-6">
                                    <div class="flex items-center gap-2 mb-3">
                                        <span class="px-3 py-1 bg-[#f6a5c0]/50 text-custom-dark text-xs font-bold rounded-full uppercase tracking-wider">
                                            {{ $event->category->name }}
                                        </span>
                                    </div>
                                    
                                    <h3 class="text-lg font-bold text-custom-dark mb-3 line-clamp-2 group-hover:text-[#837ab6] transition-colors">{{ $event->title }}</h3>
                                    
                                    <div class="text-gray-600 text-sm space-y-2 mb-4">
                                        <div class="flex items-center gap-2">
                                            <svg class="w-4 h-4 text-[#cc8db3]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            <span>{{ $event->event_date->format('d F Y') }}</span>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <svg class="w-4 h-4 text-[#cc8db3]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                            <span class="line-clamp-1">{{ $event->location }}</span>
                                        </div>
                                    </div>
                                    
                                    <div class="flex items-center justify-between border-t border-gray-100 pt-4">
                                        <span class="text-sm text-gray-500">Oleh {{ $event->organizer->name }}</span>
                                        <span class="text-[#837ab6] font-semibold flex items-center group-hover:text-custom-dark transition">
                                            Detail →
                                        </span>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>

                    <div class="mt-10 text-center">
                        {{ $events->appends(request()->query())->links() }}
                    </div>
                @else
                    <div class="bg-white rounded-3xl shadow-lg p-12 text-center border border-gray-100">
                        <svg class="mx-auto h-12 w-12 text-[#cc8db3]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <h3 class="mt-4 text-xl font-medium text-custom-dark">Tidak ada event ditemukan</h3>
                        <p class="mt-2 text-[#9d85b6]">Coba sesuaikan filter atau kata kunci pencarian Anda.</p>
                        <div class="mt-6">
                            <a href="{{ route('guests.events.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-xl text-white bg-[#837ab6] hover:bg-[#9d85b6] transition">
                                Hapus Filter
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection