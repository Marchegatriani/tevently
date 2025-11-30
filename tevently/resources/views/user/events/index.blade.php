@extends('user.partials.navbar')

@section('title', 'Katalog Event')

@section('content')
<style>
    /* Latar belakang Utama dari layout adalah #F8F3F7 */
    .bg-custom-light { background-color: #F8F3F7; }
    .text-custom-dark { color: #250e2c; } 
</style>

<div class="font-sans bg-custom-light min-h-screen">
    
    <!-- Header Katalog -->
    <div class="bg-[#f7c2ca] border-b border-[#cc8db3]/50 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
            <h1 class="text-4xl font-extrabold text-custom-dark">Jelajahi Semua Event</h1>
            <p class="text-[#837ab6] mt-2 text-lg">Temukan acara menarik yang sedang berlangsung di dekat Anda</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="flex flex-col lg:flex-row gap-10">
            <!-- Filter Sidebar -->
            <div class="lg:w-72 flex-shrink-0">
                <div class="bg-white rounded-3xl shadow-xl p-8 sticky top-6 border border-gray-100">
                    <h2 class="font-bold text-2xl mb-6 text-custom-dark">Filter Acara</h2>
                    
                    <form method="GET" action="{{ route('user.events.index') }}">
                        
                        <!-- Pencarian -->
                        <div class="mb-5">
                            <label class="block text-sm font-medium text-custom-dark mb-2">Cari</label>
                            <input type="text" 
                                   name="search" 
                                   value="{{ request('search') }}"
                                   placeholder="Nama event atau lokasi..." 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#f6a5c0] bg-white text-custom-dark transition shadow-sm">
                        </div>

                        <!-- Kategori -->
                        <div class="mb-5">
                            <label class="block text-sm font-medium text-custom-dark mb-2">Kategori</label>
                            <select name="category" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#f6a5c0] bg-white text-custom-dark transition shadow-sm">
                                <option value="">Semua Kategori</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Rentang Tanggal -->
                        <div class="mb-5">
                            <label class="block text-sm font-medium text-custom-dark mb-2">Dari Tanggal</label>
                            <input type="date" 
                                   name="date_from" 
                                   value="{{ request('date_from') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#f6a5c0] bg-white text-custom-dark transition shadow-sm">
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-medium text-custom-dark mb-2">Sampai Tanggal</label>
                            <input type="date" 
                                   name="date_to" 
                                   value="{{ request('date_to') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#f6a5c0] bg-white text-custom-dark transition shadow-sm">
                        </div>

                        <!-- Urutkan -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-custom-dark mb-2">Urutkan Berdasarkan</label>
                            <select name="sort" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#f6a5c0] bg-white text-custom-dark transition shadow-sm">
                                <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Terbaru</option>
                                <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Terlama</option>
                                <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Nama (A-Z)</option>
                                <option value="date" {{ request('sort') == 'date' ? 'selected' : '' }}>Tanggal Event</option>
                            </select>
                        </div>

                        <div class="flex flex-col gap-3">
                            <button type="submit" class="w-full bg-[#837ab6] hover:bg-[#9d85b6] text-white px-4 py-3 rounded-xl font-bold transition shadow-md transform hover:-translate-y-0.5">
                                Terapkan Filter
                            </button>
                            <a href="{{ route('user.events.index') }}" class="w-full text-center bg-gray-200 hover:bg-gray-300 text-custom-dark px-4 py-3 rounded-xl font-semibold transition transform hover:-translate-y-0.5">
                                Hapus Semua
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Events Grid -->
            <div class="flex-1">
                <div class="mb-6 border-b border-gray-200 pb-4">
                    <p class="text-[#837ab6] font-medium">
                        Menampilkan {{ $events->firstItem() ?? 0 }} - {{ $events->lastItem() ?? 0 }} dari total {{ $events->total() }} event
                    </p>
                </div>

                @if($events->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        @foreach($events as $event)
                            <a href="{{ route('user.events.show', $event) }}" class="group bg-white rounded-3xl shadow-xl overflow-hidden hover:shadow-2xl hover:shadow-[#cc8db3]/40 hover:-translate-y-1 transition-all duration-300 border border-gray-100 block h-full flex flex-col">
                                <!-- Image/Placeholder -->
                                <div class="h-48 overflow-hidden relative">
                                    @if($event->image)
                                        <img src="{{ asset('storage/' . $event->image) }}" alt="{{ $event->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                    @else
                                        <div class="w-full h-full bg-gradient-to-br from-[#837ab6] to-[#cc8db3] flex items-center justify-center">
                                            <span class="text-white text-4xl font-bold opacity-80">{{ substr($event->name, 0, 2) }}</span>
                                        </div>
                                    @endif
                                    <div class="absolute top-4 right-4">
                                        <span class="bg-white/90 backdrop-blur-sm text-custom-dark text-xs font-bold px-3 py-1 rounded-full shadow-sm uppercase tracking-wider border border-gray-100">
                                            {{ $event->category->name }}
                                        </span>
                                    </div>
                                </div>
                                
                                <div class="p-6 flex flex-col flex-grow">
                                    <!-- Title -->
                                    <h3 class="text-xl font-bold text-custom-dark mb-3 line-clamp-2 group-hover:text-[#837ab6] transition-colors">{{ $event->name }}</h3>
                                    
                                    <div class="text-gray-600 text-sm space-y-3 mb-6 flex-grow">
                                        <!-- Date -->
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-lg bg-[#f6a5c0]/20 flex items-center justify-center flex-shrink-0 text-[#cc8db3]">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                            <span class="font-medium">{{ \Carbon\Carbon::parse($event->date)->format('d F Y') }}</span>
                                        </div>
                                        <!-- Location -->
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-lg bg-[#f6a5c0]/20 flex items-center justify-center flex-shrink-0 text-[#cc8db3]">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                                </svg>
                                            </div>
                                            <span class="line-clamp-1 font-medium">{{ $event->location }}</span>
                                        </div>
                                    </div>
                                    
                                    <!-- Organizer & Details -->
                                    <div class="flex items-center justify-between border-t border-gray-100 pt-4 mt-auto">
                                        <div class="flex items-center gap-2">
                                            <div class="w-6 h-6 rounded-full bg-gray-200 flex items-center justify-center text-xs font-bold text-gray-500">
                                                {{ substr($event->organizer->name, 0, 1) }}
                                            </div>
                                            <span class="text-xs text-gray-500 font-medium truncate max-w-[100px]">{{ $event->organizer->name }}</span>
                                        </div>
                                        <span class="text-[#837ab6] font-bold text-sm flex items-center group-hover:text-custom-dark transition">
                                            Lihat Detail 
                                            <svg class="w-4 h-4 ml-1 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                                        </span>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="mt-12 flex justify-center">
                        {{ $events->appends(request()->query())->links() }}
                    </div>
                @else
                    <!-- No Events Found Message -->
                    <div class="bg-white rounded-3xl shadow-lg p-12 text-center border border-gray-100">
                        <div class="w-20 h-20 bg-[#f6a5c0]/20 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="h-10 w-10 text-[#cc8db3]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="mt-2 text-xl font-bold text-custom-dark">Tidak ada event ditemukan</h3>
                        <p class="mt-2 text-gray-500">Coba sesuaikan filter atau kata kunci pencarian Anda untuk hasil yang lebih baik.</p>
                        <div class="mt-8">
                            <a href="{{ route('user.events.index') }}" class="inline-flex items-center px-6 py-3 border border-transparent shadow-md text-sm font-bold rounded-xl text-white bg-[#837ab6] hover:bg-[#9d85b6] transition transform hover:-translate-y-0.5">
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