@extends('layouts.user')

@section('title', 'Discover Amazing Events')

@section('content')
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white">
        <div class="max-w-7xl mx-auto px-4 py-24 text-center">
            <h1 class="text-4xl md:text-6xl font-bold mb-6">Discover Amazing Events</h1>
            <p class="text-xl mb-8">Find and book tickets to the best events</p>
            
            <form action="{{ route('events.index') }}" method="GET" class="max-w-2xl mx-auto">
                <div class="flex gap-2">
                    <input type="text" name="search" placeholder="Cari acara..." class="flex-1 px-4 py-3 rounded">
                    <button type="submit" class="bg-white text-indigo-600 px-6 py-3 rounded font-semibold">Search</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Featured Events -->
    <div class="max-w-7xl mx-auto px-4 py-16">
        <h2 class="text-3xl font-bold mb-8">Featured Events</h2>
        @if($featuredEvents->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($featuredEvents as $event)
                    <a href="{{ route('events.show', $event) }}" class="bg-white rounded-lg shadow hover:shadow-lg transition">
                        <!-- ... event card ... -->
                        <div class="p-4">
                            <div class="mt-4 flex justify-between items-center">
                                <span class="text-indigo-600 font-semibold">Pesan Sekarang</span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </div>

    <!-- CTA untuk User -->
    <div class="max-w-7xl mx-auto px-4 py-8">
        @if(auth()->user()->role === 'user' && auth()->user()->status !== 'approved')
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 text-center">
                <h3 class="text-lg font-semibold mb-2">🎉 Ingin Jadi Organizer?</h3>
                <p class="text-gray-700 mb-4">Mulai buat acara Anda sendiri</p>
                @if(auth()->user()->status === 'pending')
                    <button disabled class="bg-yellow-400 text-white px-4 py-2 rounded">Menunggu Persetujuan</button>
                @else
                    <form method="POST" action="{{ route('organizer.request') }}">
                        @csrf
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Daftar sebagai Organizer</button>
                    </form>
                @endif
            </div>
        @endif
    </div>
@endsection