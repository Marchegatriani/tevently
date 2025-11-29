@extends('layouts.user')

@section('title', 'Event Detail')

@section('content')
    <!-- Breadcrumb -->
    <div class="bg-white border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex items-center gap-2 text-sm text-gray-600">
                <a href="{{ route('user.home') }}" class="hover:text-indigo-600">Home</a>
                <span>/</span>
                <a href="{{ route('user.events.index') }}" class="hover:text-indigo-600">Events</a>
                <span>/</span>
                <span class="text-gray-900">{{ $event->title }}</span>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2">
                <!-- Event Image -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
                    <div class="h-96 bg-gradient-to-br from-slate-700 to-indigo-800 flex items-center justify-center">
                        @if($event->image_url)
                            <img src="{{ asset('storage/' . $event->image_url) }}" alt="{{ $event->title }}" class="w-full h-full object-cover">
                        @else
                            <span class="text-white text-6xl font-bold">{{ substr($event->title, 0, 2) }}</span>
                        @endif
                    </div>
                </div>

                <!-- Event Details -->
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <div class="flex items-center gap-2 mb-4">
                        <span class="px-3 py-1 bg-indigo-100 text-indigo-800 text-sm font-semibold rounded">
                            {{ $event->category->name }}
                        </span>
                        <span class="px-3 py-1 bg-green-100 text-green-800 text-sm font-semibold rounded">
                            {{ ucfirst($event->status) }}
                        </span>
                    </div>

                    <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $event->title }}</h1>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <!-- Date & Time -->
                        <div class="flex items-start gap-3">
                            <div class="flex-shrink-0 mt-1">
                                <svg class="w-6 h-6 text-indigo-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900">Date & Time</p>
                                <p class="text-gray-600">{{ $event->event_date->format('l, F d, Y') }}</p>
                                <p class="text-gray-600">{{ $event->start_time->format('h:i A') }} - {{ $event->end_time->format('h:i A') }}</p>
                            </div>
                        </div>

                        <!-- Location -->
                        <div class="flex items-start gap-3">
                            <div class="flex-shrink-0 mt-1">
                                <svg class="w-6 h-6 text-indigo-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900">Location</p>
                                <p class="text-gray-600">{{ $event->location }}</p>
                            </div>
                        </div>

                        <!-- Max Attendees -->
                        <div class="flex items-start gap-3">
                            <div class="flex-shrink-0 mt-1">
                                <svg class="w-6 h-6 text-indigo-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900">Max Attendees</p>
                                <p class="text-gray-600">{{ number_format($event->max_attendees) }} people</p>
                            </div>
                        </div>

                        <!-- Organizer -->
                        <div class="flex items-start gap-3">
                            <div class="flex-shrink-0 mt-1">
                                <svg class="w-6 h-6 text-indigo-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900">Organized By</p>
                                <p class="text-gray-600">{{ $event->organizer->name }}</p>
                            </div>
                        </div>
                    </div>

                    <hr class="my-6">

                    <!-- Description -->
                    <div>
                        <h2 class="text-xl font-bold text-gray-900 mb-3">About This Event</h2>
                        <p class="text-gray-700 leading-relaxed whitespace-pre-line">{{ $event->description }}</p>
                    </div>
                </div>

                <!-- Available Tickets -->
                @if($event->tickets->count() > 0)
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h2 class="text-xl font-bold text-gray-900 mb-4">Available Tickets</h2>
                        <div class="space-y-4">
                            @foreach($event->tickets as $ticket)
                                <div class="border border-gray-200 rounded-lg p-4 hover:border-indigo-300 transition">
                                    <div class="flex justify-between items-start">
                                        <div class="flex-1">
                                            <h3 class="font-semibold text-gray-900 text-lg">{{ $ticket->name }}</h3>
                                            @if($ticket->description)
                                                <p class="text-gray-600 text-sm mt-1">{{ $ticket->description }}</p>
                                            @endif
                                            <div class="flex items-center gap-4 mt-2 text-sm text-gray-600">
                                                <span>Available: {{ $ticket->quantity_available - $ticket->quantity_sold }}</span>
                                                <span>•</span>
                                                <span>Max {{ $ticket->max_per_order }} per order</span>
                                            </div>
                                        </div>
                                        <div class="text-right ml-4">
                                            <p class="text-2xl font-bold text-indigo-800">
                                                @if($ticket->price > 0)
                                                    Rp {{ number_format($ticket->price, 0, ',', '.') }}
                                                @else
                                                    FREE
                                                @endif
                                            </p>
                                            <a href="{{ route('bookings.create', $event, 'ticket', $ticket) }}" 
                                               class="inline-block mt-2 bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-semibold">
                                                Select
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-md p-6 sticky top-4">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Get Your Tickets</h3>
                    
                    <!-- Book Now Button -->
                    @if($event->tickets->count() > 0)
                        <a href="#tickets" class="block w-full bg-indigo-800 hover:bg-indigo-700 text-white text-center px-6 py-3 rounded-lg font-semibold mb-3">
                            Book Now
                        </a>
                    @else
                        <button disabled class="block w-full bg-gray-400 text-white text-center px-6 py-3 rounded-lg font-semibold mb-3 cursor-not-allowed">
                            No Tickets Available
                        </button>
                    @endif
                    
                    <!-- Favorite Button -->
                    <form action="{{ route('user.favorites.toggle', $event) }}" method="POST">
                        @csrf
                        <button type="submit" class="block w-full bg-gray-200 hover:bg-gray-300 text-gray-800 text-center px-6 py-3 rounded-lg font-semibold">
                            ❤️ Add to Favorites
                        </button>
                    </form>

                    <hr class="my-6">

                    <!-- Share Event -->
                    <div>
                        <h4 class="font-semibold text-gray-900 mb-3">Share This Event</h4>
                        <div class="flex gap-2">
                            <button class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm">
                                Facebook
                            </button>
                            <button class="flex-1 bg-sky-500 hover:bg-sky-600 text-white px-4 py-2 rounded-lg text-sm">
                                Twitter
                            </button>
                            <button class="flex-1 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm">
                                WhatsApp
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Similar Events -->
                @if(isset($similarEvents) && $similarEvents->count() > 0)
                    <div class="bg-white rounded-lg shadow-md p-6 mt-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-4">Similar Events</h3>
                        <div class="space-y-4">
                            @foreach($similarEvents as $similar)
                                <a href="{{ route('user.events.show', $similar->slug) }}" class="block hover:bg-gray-50 p-3 rounded-lg transition">
                                    <h4 class="font-semibold text-gray-900 mb-1">{{ $similar->title }}</h4>
                                    <p class="text-sm text-gray-600">{{ $similar->event_date->format('M d, Y') }}</p>
                                    <p class="text-sm text-gray-600">{{ $similar->location }}</p>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection