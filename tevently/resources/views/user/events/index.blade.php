@extends('user.partials.navbar')

@section('title', 'Event Catalog')

@section('content')
    <div class="bg-white border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <h1 class="text-3xl font-bold text-gray-900">Browse Events</h1>
            <p class="text-gray-600 mt-2">Discover amazing events happening near you</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Sidebar Filters -->
            <div class="lg:w-64 flex-shrink-0">
                <div class="bg-white rounded-lg shadow p-6 sticky top-4">
                    <h2 class="font-bold text-lg mb-4">Filters</h2>
                    
                    <form method="GET" action="{{ route('guest.events.index') }}">
                        <!-- Search -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                            <input type="text" 
                                   name="search" 
                                   value="{{ request('search') }}"
                                   placeholder="Event or location..." 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        </div>

                        <!-- Category -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                            <select name="category" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                <option value="">All Categories</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Date Range -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Date From</label>
                            <input type="date" 
                                   name="date_from" 
                                   value="{{ request('date_from') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Date To</label>
                            <input type="date" 
                                   name="date_to" 
                                   value="{{ request('date_to') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        </div>

                        <!-- Sort -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Sort By</label>
                            <select name="sort" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest</option>
                                <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest</option>
                                <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Name (A-Z)</option>
                                <option value="date" {{ request('sort') == 'date' ? 'selected' : '' }}>Event Date</option>
                            </select>
                        </div>

                        <div class="flex flex-col gap-2">
                            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md font-semibold">
                                Apply Filters
                            </button>
                            <a href="{{ route('guest.events.index') }}" class="w-full text-center bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-md font-semibold">
                                Clear All
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Events Grid -->
            <div class="flex-1">
                <div class="mb-4 flex justify-between items-center">
                    <p class="text-gray-600">
                        Showing {{ $events->firstItem() ?? 0 }} - {{ $events->lastItem() ?? 0 }} of {{ $events->total() }} events
                    </p>
                </div>

                @if($events->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($events as $event)
                            <a href="{{ route('guest.events.show', $event) }}" class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition">
                                <div class="h-48 bg-gradient-to-br from-indigo-400 to-purple-500 flex items-center justify-center">
                                    @if($event->image)
                                        <img src="{{ asset('storage/' . $event->image) }}" alt="{{ $event->name }}" class="w-full h-full object-cover">
                                    @else
                                        <span class="text-white text-4xl font-bold">{{ substr($event->name, 0, 2) }}</span>
                                    @endif
                                </div>
                                <div class="p-6">
                                    <div class="flex items-center gap-2 mb-2">
                                        <span class="px-2 py-1 bg-indigo-100 text-indigo-800 text-xs font-semibold rounded">
                                            {{ $event->category->name }}
                                        </span>
                                    </div>
                                    <h3 class="text-xl font-bold text-gray-900 mb-2 line-clamp-2">{{ $event->name }}</h3>
                                    <div class="text-gray-600 text-sm space-y-1 mb-4">
                                        <div class="flex items-center gap-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            <span>{{ \Carbon\Carbon::parse($event->date)->format('M d, Y') }}</span>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                            <span class="line-clamp-1">{{ $event->location }}</span>
                                        </div>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm text-gray-500">By {{ $event->organizer->name }}</span>
                                        <span class="text-indigo-600 font-semibold">Details →</span>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="mt-8">
                        {{ $events->appends(request()->query())->links() }}
                    </div>
                @else
                    <div class="bg-white rounded-lg shadow p-12 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <h3 class="mt-2 text-lg font-medium text-gray-900">No events found</h3>
                        <p class="mt-1 text-gray-500">Try adjusting your filters or search terms</p>
                        <div class="mt-6">
                            <a href="{{ route('guest.events.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                                Clear Filters
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection