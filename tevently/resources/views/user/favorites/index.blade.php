@extends('user.partials.navbar')

@section('title', 'My Favorites')
@section('content')
    <h2 class="text-2xl font-bold text-gray-900 mb-6">My Favorite Events</h2>

    @if($favorites->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($favorites as $favorite)
                @php $event = $favorite->event; @endphp
                @if($event)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden group">
                        <a href="{{ route('user.events.show', $event) }}" class="block">
                            <div class="h-40 overflow-hidden">
                                @if($event->image_url)
                                    <img src="{{ asset('storage/' . $event->image_url) }}" alt="{{ $event->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center">
                                        <span class="text-white text-3xl font-bold opacity-70">{{ substr($event->title, 0, 2) }}</span>
                                    </div>
                                @endif
                            </div>
                            <div class="p-4">
                                <span class="px-2 py-1 bg-indigo-100 text-indigo-800 text-xs font-semibold rounded-full">
                                    {{ $event->category->name ?? 'Uncategorized' }}
                                </span>
                                <h3 class="text-lg font-bold text-gray-900 mt-2 mb-1 truncate">{{ $event->title }}</h3>
                                <div class="text-gray-600 text-sm space-y-1">
                                    <p class="flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        <span>{{ optional($event->event_date)->format('d M Y') }}</span>
                                    </p>
                                    <p class="flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                        <span class="truncate">{{ $event->location }}</span>
                                    </p>
                                </div>
                            </div>
                        </a>
                        <div class="p-4 border-t border-gray-100 flex justify-between items-center">
                            <span class="text-sm text-gray-500">By {{ $event->organizer->name ?? 'N/A' }}</span>
                            <!-- Remove from favorites button -->
                            <form action="{{ route('user.favorites.destroy', $event) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700" title="Remove from favorites">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>

        <div class="mt-8">
            {{ $favorites->links() }}
        </div>
    @else
        <div class="text-center py-12 bg-gray-50 rounded-lg">
            <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
            <p class="text-gray-600 text-lg">You haven't added any events to favorites yet.</p>
            <a href="{{ route('user.events.index') }}" class="mt-4 inline-block bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 font-medium transition">
                Browse Events
            </a>
        </div>
    @endif
@endsection