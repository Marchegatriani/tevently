@extends('layouts.guest')

@section('title', 'Event Detail')

@section('content')
    <!-- Event Detail -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Breadcrumb -->
        <div class="mb-6">
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-2 text-sm">
                    <li>
                        <a href="/" class="text-gray-500 hover:text-indigo-600">Home</a>
                    </li>
                    <li>
                        <span class="text-gray-400">/</span>
                    </li>
                    <li>
                        <a href="{{ route('guest.events.index') }}" class="text-gray-500 hover:text-indigo-600">Events</a>
                    </li>
                    <li>
                        <span class="text-gray-400">/</span>
                    </li>
                    <li class="text-gray-900 font-medium">{{ Str::limit($event->name, 30) }}</li>
                </ol>
            </nav>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2">
                <!-- Event Image -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
                    @if($event->image)
                        <img src="{{ asset('storage/' . $event->image) }}" alt="{{ $event->name }}" class="w-full h-96 object-cover">
                    @else
                        <div class="w-full h-96 bg-gradient-to-br from-indigo-400 to-purple-500 flex items-center justify-center">
                            <span class="text-white text-6xl font-bold">{{ substr($event->name, 0, 2) }}</span>
                        </div>
                    @endif
                </div>

                <!-- Event Info -->
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <div class="flex items-center gap-2 mb-4">
                        <span class="px-3 py-1 bg-indigo-100 text-indigo-800 text-sm font-semibold rounded">
                            {{ $event->category->name }}
                        </span>
                        @if(\Carbon\Carbon::parse($event->date)->isFuture())
                            <span class="px-3 py-1 bg-green-100 text-green-800 text-sm font-semibold rounded">
                                Upcoming
                            </span>
                        @else
                            <span class="px-3 py-1 bg-gray-100 text-gray-800 text-sm font-semibold rounded">
                                Past Event
                            </span>
                        @endif
                    </div>

                    <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $event->name }}</h1>

                    <div class="space-y-3 mb-6">
                        <div class="flex items-center gap-3 text-gray-700">
                            <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span class="font-medium">{{ \Carbon\Carbon::parse($event->date)->format('l, F d, Y') }}</span>
                        </div>

                        <div class="flex items-center gap-3 text-gray-700">
                            <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span class="font-medium">{{ \Carbon\Carbon::parse($event->date)->format('h:i A') }}</span>
                        </div>

                        <div class="flex items-center gap-3 text-gray-700">
                            <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span>{{ $event->location }}</span>
                        </div>

                        <div class="flex items-center gap-3 text-gray-700">
                            <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <span>Organized by <strong>{{ $event->organizer->name }}</strong></span>
                        </div>
                    </div>

                    <div class="border-t pt-6">
                        <h2 class="text-xl font-bold text-gray-900 mb-3">About This Event</h2>
                        <div class="text-gray-700 leading-relaxed whitespace-pre-line">{{ $event->description }}</div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <!-- Ticket Options -->
                <div class="bg-white rounded-lg shadow-md p-6 sticky top-4">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">Available Tickets</h2>

                    @if($event->tickets->count() > 0)
                        <div class="space-y-4">
                            @foreach($event->tickets as $ticket)
                                <div class="border border-gray-200 rounded-lg p-4 hover:border-indigo-500 transition">
                                    <div class="flex justify-between items-start mb-2">
                                        <div>
                                            <h3 class="font-semibold text-gray-900">{{ $ticket->type }}</h3>
                                            <p class="text-sm text-gray-600">{{ $ticket->description }}</p>
                                        </div>
                                    </div>
                                    
                                    <div class="flex justify-between items-center mt-3">
                                        <div>
                                            <p class="text-2xl font-bold text-indigo-600">
                                                Rp {{ number_format($ticket->price, 0, ',', '.') }}
                                            </p>
                                            <p class="text-xs text-gray-500">
                                                {{ $ticket->available_quantity }} / {{ $ticket->quantity }} left
                                            </p>
                                        </div>
                                        
                                        @auth
                                            @if($ticket->available_quantity > 0 && \Carbon\Carbon::parse($event->date)->isFuture())
                                                <a href="{{ route('tickets.order', $ticket) }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md text-sm font-semibold">
                                                    Buy Now
                                                </a>
                                            @else
                                                <button disabled class="bg-gray-300 text-gray-500 px-4 py-2 rounded-md text-sm font-semibold cursor-not-allowed">
                                                    Sold Out
                                                </button>
                                            @endif
                                        @else
                                            <a href="{{ route('login') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md text-sm font-semibold">
                                                Login to Buy
                                            </a>
                                        @endauth
                                    </div>

                                    @if($ticket->available_quantity > 0 && $ticket->available_quantity <= 10)
                                        <div class="mt-2 text-xs text-orange-600 font-medium">
                                            ⚠️ Only {{ $ticket->available_quantity }} tickets left!
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                            </svg>
                            <p class="mt-2 text-gray-500">No tickets available yet</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection