<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Event Details') }}
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('organizer.events.edit', $event) }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md font-semibold">
                    Edit Event
                </a>
                <a href="{{ route('organizer.events.index') }}" class="text-gray-600 hover:text-gray-900">
                    ← Back to Events
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Event Image -->
            @if($event->image_url)
                <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
                    <img src="{{ asset('storage/' . $event->image_url) }}" alt="{{ $event->title }}" class="w-full h-96 object-cover">
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Event Info -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <div class="flex items-center gap-2 mb-4">
                            <span class="px-3 py-1 bg-indigo-100 text-indigo-800 text-sm font-semibold rounded">
                                {{ $event->category->name }}
                            </span>
                            <span class="px-3 py-1 text-sm font-semibold rounded
                                {{ $event->status === 'published' ? 'bg-green-100 text-green-800' : '' }}
                                {{ $event->status === 'draft' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                {{ $event->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}
                                {{ $event->status === 'completed' ? 'bg-gray-100 text-gray-800' : '' }}">
                                {{ ucfirst($event->status) }}
                            </span>
                        </div>

                        <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $event->title }}</h1>

                        <div class="grid grid-cols-2 gap-4 mb-6">
                            <div>
                                <p class="text-sm text-gray-600">Date</p>
                                <p class="font-semibold">{{ $event->event_date->format('l, F d, Y') }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Time</p>
                                <p class="font-semibold">{{ $event->start_time->format('h:i A') }} - {{ $event->end_time->format('h:i A') }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Location</p>
                                <p class="font-semibold">{{ $event->location }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Max Attendees</p>
                                <p class="font-semibold">{{ number_format($event->max_attendees) }}</p>
                            </div>
                        </div>

                        <hr class="my-6">

                        <div>
                            <h2 class="text-xl font-bold text-gray-900 mb-3">Description</h2>
                            <p class="text-gray-700 whitespace-pre-line">{{ $event->description }}</p>
                        </div>
                    </div>

                    <!-- Tickets -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-xl font-bold text-gray-900">Tickets</h2>
                            <button class="text-indigo-600 hover:text-indigo-700 font-semibold text-sm">
                                + Add Ticket
                            </button>
                        </div>

                        @if($event->tickets->count() > 0)
                            <div class="space-y-3">
                                @foreach($event->tickets as $ticket)
                                    <div class="border rounded-lg p-4">
                                        <div class="flex justify-between">
                                            <div>
                                                <h3 class="font-semibold">{{ $ticket->name }}</h3>
                                                <p class="text-sm text-gray-600">{{ $ticket->description }}</p>
                                                <p class="text-sm text-gray-600 mt-1">
                                                    Available: {{ $ticket->quantity_available - $ticket->quantity_sold }} / {{ $ticket->quantity_available }}
                                                </p>
                                            </div>
                                            <div class="text-right">
                                                <p class="text-lg font-bold text-indigo-600">Rp {{ number_format($ticket->price, 0, ',', '.') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500 text-center py-8">No tickets created yet.</p>
                        @endif
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="lg:col-span-1">
                    <!-- Statistics -->
                    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                        <h3 class="text-lg font-bold mb-4">Statistics</h3>
                        <div class="space-y-4">
                            <div>
                                <p class="text-sm text-gray-600">Total Tickets</p>
                                <p class="text-2xl font-bold">{{ $event->tickets->sum('quantity_available') }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Tickets Sold</p>
                                <p class="text-2xl font-bold">{{ $event->tickets->sum('quantity_sold') }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Revenue</p>
                                <p class="text-2xl font-bold text-green-600">
                                    Rp {{ number_format($event->tickets->sum(function($ticket) {
                                        return $ticket->quantity_sold * $ticket->price;
                                    }), 0, ',', '.') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h3 class="text-lg font-bold mb-4">Actions</h3>
                        <div class="space-y-2">
                            <a href="{{ route('organizer.events.edit', $event) }}" class="block w-full text-center bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md font-semibold">
                                Edit Event
                            </a>
                            <a href="{{ route('events.show', $event) }}" target="_blank" class="block w-full text-center bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-md font-semibold">
                                View Public Page
                            </a>
                            <form method="POST" action="{{ route('organizer.events.destroy', $event) }}" 
                                  onsubmit="return confirm('Are you sure you want to delete this event?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="block w-full text-center bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md font-semibold">
                                    Delete Event
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>