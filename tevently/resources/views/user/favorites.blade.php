@extends('layouts.user')

@section('title', 'Event Favorit Saya')
@section('heading', 'Event Favorit Saya')
@section('subheading', 'Daftar acara yang Anda tandai sebagai favorit')

@section('content')
<style>
    .text-custom-dark { color: #250e2c; }
    .bg-main-purple { background-color: #837ab6; }
    .bg-pink-accent { background-color: #cc8db3; }
    .bg-soft-pink-light { background-color: #f7c2ca; }
</style>

<div class="max-w-7xl mx-auto px-4 py-8">
    
    @if($favorites->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($favorites as $favorite)
                @php $event = $favorite->event; @endphp
                @if($event)
                    <div class="bg-white rounded-3xl shadow-xl overflow-hidden group hover:shadow-2xl hover:shadow-[#cc8db3]/40 transition duration-300">
                        
                        <a href="{{ route('user.events.show', $event) }}" class="block">
                            
                            <div class="h-40 overflow-hidden relative">
                                @if($event->image_url)
                                    <img src="{{ asset('storage/' . $event->image_url) }}" alt="{{ $event->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-[#837ab6] to-[#cc8db3] flex items-center justify-center">
                                        <span class="text-white text-3xl font-bold opacity-70">{{ substr($event->title, 0, 2) }}</span>
                                    </div>
                                @endif
                                <div class="absolute top-4 left-4">
                                    <span class="bg-white/90 backdrop-blur-sm text-custom-dark text-xs font-bold px-3 py-1 rounded-full shadow-sm uppercase tracking-wider border border-gray-100">
                                        {{ $event->category->name ?? 'Tanpa Kategori' }}
                                    </span>
                                </div>
                            </div>
                            
                            <div class="p-6">
                                <h3 class="text-xl font-bold text-custom-dark mt-1 mb-3 truncate group-hover:text-main-purple transition-colors">{{ $event->title }}</h3>
                                
                                <div class="text-gray-600 text-sm space-y-2">
                                    <p class="flex items-center gap-3">
                                        <div class="w-6 h-6 rounded-lg bg-soft-pink-light flex items-center justify-center flex-shrink-0 text-pink-accent">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        </div>
                                        <span class="font-medium">{{ optional($event->event_date)->format('d M Y') }}</span>
                                    </p>
                                    <p class="flex items-center gap-3">
                                        <div class="w-6 h-6 rounded-lg bg-soft-pink-light flex items-center justify-center flex-shrink-0 text-pink-accent">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                        </div>
                                        <span class="truncate font-medium">{{ $event->location }}</span>
                                    </p>
                                </div>
                            </div>
                        </a>
                        
                        <div class="p-4 border-t border-gray-100 flex justify-between items-center bg-gray-50/50">
                            <span class="text-sm text-gray-500">Oleh {{ $event->organizer->name ?? 'N/A' }}</span>
                            
                            <!-- Remove from favorites button -->
                            <form action="{{ route('user.favorites.destroy', $event) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-red-500 hover:text-red-700 transition hover:bg-white rounded-full shadow-sm" title="Hapus dari Favorit">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>

        <div class="mt-10 flex justify-center">
            {{ $favorites->links() }}
        </div>
        
    @else
        <div class="bg-white rounded-3xl shadow-xl p-10 text-center border border-gray-100">
            <div class="w-16 h-16 bg-[#f7c2ca]/20 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-[#cc8db3]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
            </div>
            <p class="text-gray-600 text-lg mb-6">Anda belum menambahkan event ke daftar favorit.</p>
            <a href="{{ route('user.events.index') }}" class="inline-block bg-main-purple text-white px-6 py-3 rounded-xl hover:bg-[#9d85b6] font-bold transition shadow-md transform hover:-translate-y-0.5">
                Jelajahi Event Sekarang
            </a>
        </div>
    @endif
</div>
@endsection