@extends('layouts.user')

@section('title', $event->title)

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">{{ $event->title }}</h1>
                <p class="text-gray-600">{{ $event->category->name }} • {{ $event->location }}</p>
            </div>
            <a href="{{ route('events.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                Back to Events
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Event Image & Description -->
                <div class="bg-white rounded-lg shadow p-6">
                    @if($event->image_url)
                        <img src="{{ asset('storage/' . $event->image_url) }}" 
                             alt="{{ $event->title }}" 
                             class="w-full h-64 object-cover rounded-lg mb-4">
                    @endif
                    
                    <p class="text-gray-700 whitespace-pre-line">{{ $event->description }}</p>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-6">
                        <div class="space-y-2">
                            <p><strong>Category:</strong> {{ $event->category->name }}</p>
                            <p><strong>Location:</strong> {{ $event->location }}</p>
                            <p><strong>Date:</strong> {{ $event->event_date->format('F d, Y') }}</p>
                        </div>
                        <div class="space-y-2">
                            <p><strong>Time:</strong> {{ $event->start_time->format('h:i A') }} - {{ $event->end_time->format('h:i A') }}</p>
                            <p><strong>Capacity:</strong> {{ number_format($event->max_attendees) }} people</p>
                            <p><strong>Organizer:</strong> {{ $event->organizer->name }}</p>
                        </div>
                    </div>
                </div>

                <!-- Tickets -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold mb-4">Available Tickets</h3>
                    
                    @if($event->tickets->where('is_active', true)->count() > 0)
                        <div class="space-y-4">
                            @foreach($event->tickets->where('is_active', true) as $ticket)
                                <div class="border rounded-lg p-4 hover:shadow-md transition duration-200">
                                    <div class="flex justify-between items-start mb-2">
                                        <div>
                                            <h4 class="font-semibold text-lg">{{ $ticket->name }}</h4>
                                            @if($ticket->description)
                                                <p class="text-gray-600 text-sm mt-1">{{ $ticket->description }}</p>
                                            @endif
                                        </div>
                                        <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded text-lg font-bold">
                                            Rp {{ number_format($ticket->price) }}
                                        </span>
                                    </div>
                                    
                                    <div class="flex justify-between items-center mt-3">
                                        <div class="text-sm text-gray-600">
                                            Available: {{ $ticket->quantity_available - $ticket->quantity_sold }} / {{ $ticket->quantity_available }}
                                        </div>
                                        
                                        @if(($ticket->quantity_available - $ticket->quantity_sold) > 0)
                                            <a href="{{ route('user.bookings.create', ['event' => $event->id, 'ticket' => $ticket->id]) }}" 
                                               class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 font-medium">
                                                Book Now
                                            </a>
                                        @else
                                            <span class="bg-red-100 text-red-800 px-3 py-2 rounded text-sm font-medium">
                                                Sold Out
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-4">No tickets available for this event.</p>
                    @endif
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Action Buttons -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold mb-4">Event Actions</h3>
                    
                    <!-- Favorite Button -->
                    <form action="{{ route('user.favorites.toggle', $event) }}" method="POST" class="mb-4">
                        @csrf
                        @php
                            $isFavorite = Auth::user()->favorites->contains('event_id', $event->id);
                        @endphp
                        <button type="submit" 
                                class="w-full flex items-center justify-center gap-2 px-4 py-3 rounded border transition duration-200
                                       {{ $isFavorite ? 'bg-red-50 border-red-200 text-red-700 hover:bg-red-100' : 'bg-gray-50 border-gray-200 text-gray-700 hover:bg-gray-100' }}">
                            <svg class="w-5 h-5 {{ $isFavorite ? 'fill-red-500' : 'fill-gray-400' }}" 
                                 viewBox="0 0 24 24">
                                <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                            </svg>
                            {{ $isFavorite ? 'Remove from Favorites' : 'Add to Favorites' }}
                        </button>
                    </form>
                </div>

                <!-- Event Status -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold mb-4">Event Status</h3>
                    <div class="flex items-center justify-between mb-2">
                        <span class="px-3 py-1 rounded-full text-sm font-medium
                            {{ $event->status === 'published' ? 'bg-green-100 text-green-800' : '' }}
                            {{ $event->status === 'draft' ? 'bg-yellow-100 text-yellow-800' : '' }}
                            {{ $event->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}">
                            {{ ucfirst($event->status) }}
                        </span>
                        <span class="text-sm text-gray-600">
                            {{ $event->available_seats }} seats left
                        </span>
                    </div>
            </div>
        </div>
    </div>
</div>
@endsection