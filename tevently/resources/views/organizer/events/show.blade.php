@extends('organizer.partials.navbar')

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
            <div class="flex space-x-2">
                <a href="{{ route('organizer.events.edit', $event) }}" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">
                    Edit
                </a>
                <a href="{{ route('organizer.events.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                    Back
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Event Details -->
                <div class="bg-white rounded-lg shadow p-6">
                    @if($event->image_url)
                        <img src="{{ asset('storage/' . $event->image_url) }}" 
                             alt="{{ $event->title }}" 
                             class="w-full h-64 object-cover rounded-lg mb-4">
                    @endif
                    
                    <h3 class="text-lg font-semibold mb-3">Description</h3>
                    <p class="text-gray-700 whitespace-pre-line">{{ $event->description }}</p>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-6">
                        <div class="space-y-2">
                            <p><strong>Category:</strong> {{ $event->category->name }}</p>
                            <p><strong>Location:</strong> {{ $event->location }}</p>
                            <p><strong>Date:</strong> {{ $event->event_date->format('F d, Y') }}</p>
                        </div>
                        <div class="space-y-2">
                            <p><strong>Time:</strong> {{ $event->start_time->format('h:i A') }} - {{ $event->end_time->format('h:i A') }}</p>
                            <p><strong>Max Attendees:</strong> {{ number_format($event->max_attendees) }}</p>
                            <p><strong>Available Seats:</strong> {{ $event->available_seats }}</p>
                        </div>
                    </div>
                </div>

                <!-- Tickets -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold mb-4">Your Tickets</h3>
                    @if($event->tickets->count() > 0)
                        <div class="space-y-4">
                            @foreach($event->tickets as $ticket)
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
                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                                        <div class="text-center">
                                            <span class="text-gray-500 block">Available</span>
                                            <span class="font-semibold text-green-600">{{ $ticket->quantity_available - $ticket->quantity_sold }}</span>
                                        </div>
                                        <div class="text-center">
                                            <span class="text-gray-500 block">Sold</span>
                                            <span class="font-semibold">{{ $ticket->quantity_sold }}</span>
                                        </div>
                                        <div class="text-center">
                                            <span class="text-gray-500 block">Total</span>
                                            <span class="font-semibold">{{ $ticket->quantity_available }}</span>
                                        </div>
                                        <div class="text-center">
                                            <span class="text-gray-500 block">Status</span>
                                            <span class="font-semibold {{ $ticket->is_active ? 'text-green-600' : 'text-red-600' }}">
                                                {{ $ticket->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-4">No tickets created yet.</p>
                        <a href="{{ route('organizer.events.edit', $event) }}" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                            Add Tickets
                        </a>
                    @endif
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Status -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold mb-4">Event Status</h3>
                    <span class="px-3 py-1 rounded-full text-sm font-medium
                        {{ $event->status === 'published' ? 'bg-green-100 text-green-800' : '' }}
                        {{ $event->status === 'draft' ? 'bg-yellow-100 text-yellow-800' : '' }}">
                        {{ ucfirst($event->status) }}
                    </span>
                    
                    @if($event->status === 'draft')
                        <p class="text-yellow-600 text-sm mt-2">Your event is not visible to public.</p>
                    @else
                        <p class="text-green-600 text-sm mt-2">Your event is live and visible to public.</p>
                    @endif
                </div>

                <!-- Quick Stats -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold mb-4">Quick Stats</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Total Tickets:</span>
                            <span class="font-semibold">{{ $event->tickets->count() }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Tickets Sold:</span>
                            <span class="font-semibold">{{ $event->tickets->sum('quantity_sold') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Available:</span>
                            <span class="font-semibold text-green-600">{{ $event->available_seats }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Revenue:</span>
                            <span class="font-semibold text-blue-600">Rp {{ number_format($event->tickets->sum(function($ticket) { return $ticket->price * $ticket->quantity_sold; })) }}</span>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold mb-4">Quick Actions</h3>
                    <div class="space-y-2">
                        <a href="{{ route('organizer.events.edit', $event) }}" class="block w-full bg-indigo-600 text-white text-center py-2 rounded hover:bg-indigo-700">
                            Edit Event
                        </a>
                        @if($event->tickets->count() === 0)
                            <a href="{{ route('organizer.events.edit', $event) }}" class="block w-full bg-green-600 text-white text-center py-2 rounded hover:bg-green-700">
                                Add Tickets
                            </a>
                        @endif
                        @if($event->status === 'draft')
                            <form action="{{ route('organizer.events.update', $event) }}" method="POST" class="mt-2">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="published">
                                <button type="submit" class="w-full bg-green-600 text-white py-2 rounded hover:bg-green-700">
                                    Publish Event
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection