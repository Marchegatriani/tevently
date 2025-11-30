@extends('admin.partials.sidebar')

@section('title', 'Edit Event - Admin')

@section('content')
<div class="py-6">
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Edit Your Event</h1>
            <p class="text-gray-600">Update your event information and manage tickets</p>
        </div>

        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                {{ session('error') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Column - Event Form -->
            <div class="lg:col-span-2">
                <div class="bg-white shadow-sm rounded-lg">
                    <form action="{{ route('admin.events.update', $event) }}" method="POST" enctype="multipart/form-data" class="p-6">
                        @csrf
                        @method('PUT')
                        
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Event Details</h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Event Title</label>
                                <input type="text" name="title" value="{{ old('title', $event->title) }}" class="w-full rounded-md border-gray-300 @error('title') border-red-500 @enderror" required>
                                @error('title')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                                <select name="category_id" class="w-full rounded-md border-gray-300 @error('category_id') border-red-500 @enderror" required>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ $event->category_id == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Location</label>
                                <input type="text" name="location" value="{{ old('location', $event->location) }}" class="w-full rounded-md border-gray-300 @error('location') border-red-500 @enderror" required>
                                @error('location')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Max Attendees</label>
                                <input type="number" name="max_attendees" value="{{ old('max_attendees', $event->max_attendees) }}" min="1" class="w-full rounded-md border-gray-300 @error('max_attendees') border-red-500 @enderror" required>
                                @error('max_attendees')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Event Date</label>
                                <input type="date" name="event_date" value="{{ old('event_date', $event->event_date->format('Y-m-d')) }}" class="w-full rounded-md border-gray-300 @error('event_date') border-red-500 @enderror" required>
                                @error('event_date')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Start Time</label>
                                    <input type="time" name="start_time" value="{{ old('start_time', $event->start_time->format('H:i')) }}" class="w-full rounded-md border-gray-300 @error('start_time') border-red-500 @enderror" required>
                                    @error('start_time')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">End Time</label>
                                    <input type="time" name="end_time" value="{{ old('end_time', $event->end_time->format('H:i')) }}" class="w-full rounded-md border-gray-300 @error('end_time') border-red-500 @enderror" required>
                                    @error('end_time')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                                <textarea name="description" rows="3" class="w-full rounded-md border-gray-300 @error('description') border-red-500 @enderror" required>{{ old('description', $event->description) }}</textarea>
                                @error('description')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                                <select name="status" class="w-full rounded-md border-gray-300 @error('status') border-red-500 @enderror">
                                    <option value="draft" {{ $event->status == 'draft' ? 'selected' : '' }}>Draft</option>
                                    <option value="published" {{ $event->status == 'published' ? 'selected' : '' }}>Published</option>
                                    <option value="cancelled" {{ $event->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    <option value="completed" {{ $event->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                </select>
                                @error('status')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Event Image</label>
                                <input type="file" name="image" accept="image/*" class="w-full rounded-md border-gray-300 @error('image') border-red-500 @enderror">
                                @error('image')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                                @if($event->image_url)
                                    <div class="mt-2">
                                        <img src="{{ asset('storage/' . $event->image_url) }}" alt="{{ $event->title }}" class="h-32 rounded">
                                        <label class="flex items-center mt-2">
                                            <input type="checkbox" name="remove_image" value="1" class="rounded border-gray-300">
                                            <span class="ml-2 text-sm text-gray-600">Remove image</span>
                                        </label>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="flex gap-4">
                            <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded hover:bg-indigo-700 transition">
                                Update Event
                            </button>
                            <a href="{{ route('admin.events.show', $event) }}" class="bg-gray-300 text-gray-700 px-6 py-2 rounded hover:bg-gray-400 transition">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Right Column - Tickets Management -->
            <div class="lg:col-span-1">
                <div class="bg-white shadow-sm rounded-lg p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-lg font-semibold text-gray-900">Tickets</h2>
                        <a href="{{ route('admin.tickets.create', $event) }}" 
                           class="bg-blue-600 text-white px-3 py-1.5 rounded text-sm hover:bg-blue-700 transition">
                            <i class="fas fa-plus mr-1"></i> Add Ticket
                        </a>
                    </div>

                    @if($event->tickets->count() > 0)
                        <div class="space-y-3">
                            @foreach($event->tickets as $ticket)
                                <div class="border rounded-lg p-4 {{ $ticket->is_active ? 'border-gray-200' : 'border-red-200 bg-red-50' }}">
                                    <div class="flex justify-between items-start mb-2">
                                        <div class="flex-1">
                                            <h3 class="font-semibold text-gray-900">{{ $ticket->name }}</h3>
                                            <p class="text-sm text-gray-600 mt-1">
                                                Rp {{ number_format($ticket->price, 0, ',', '.') }}
                                            </p>
                                        </div>
                                        <span class="px-2 py-1 rounded text-xs font-medium {{ $ticket->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $ticket->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </div>

                                    <div class="text-sm text-gray-600 space-y-1 mb-3">
                                        <p>Available: {{ $ticket->quantity_available - $ticket->quantity_sold }} / {{ $ticket->quantity_available }}</p>
                                        <p>Sold: {{ $ticket->quantity_sold }}</p>
                                        <p>Max per order: {{ $ticket->max_per_order }}</p>
                                    </div>

                                    <div class="flex gap-2">
                                        <a href="{{ route('admin.tickets.edit', [$event, $ticket]) }}" 
                                           class="flex-1 bg-indigo-600 text-white px-3 py-1.5 rounded text-sm text-center hover:bg-indigo-700 transition">
                                            <i class="fas fa-edit mr-1"></i> Edit
                                        </a>
                                        
                                        <form action="{{ route('admin.tickets.toggle', [$event, $ticket]) }}" 
                                              method="POST" 
                                              class="flex-1">
                                            @csrf
                                            <button type="submit" 
                                                    class="w-full {{ $ticket->is_active ? 'bg-yellow-600 hover:bg-yellow-700' : 'bg-green-600 hover:bg-green-700' }} text-white px-3 py-1.5 rounded text-sm transition">
                                                <i class="fas fa-{{ $ticket->is_active ? 'pause' : 'play' }} mr-1"></i>
                                                {{ $ticket->is_active ? 'Deactivate' : 'Activate' }}
                                            </button>
                                        </form>

                                        @if($ticket->quantity_sold == 0)
                                            <form action="{{ route('admin.tickets.destroy', [$event, $ticket]) }}" 
                                                  method="POST" 
                                                  onsubmit="return confirm('Are you sure you want to delete this ticket?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="bg-red-600 text-white px-3 py-1.5 rounded text-sm hover:bg-red-700 transition">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <i class="fas fa-ticket-alt text-gray-400 text-4xl mb-3"></i>
                            <p class="text-gray-600 mb-4">No tickets yet</p>
                            <a href="{{ route('admin.tickets.create', $event) }}" 
                               class="inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                                Create First Ticket
                            </a>
                        </div>
                    @endif
                </div>

                <!-- Quick Stats -->
                <div class="bg-white shadow-sm rounded-lg p-6 mt-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Stats</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Total Tickets:</span>
                            <span class="font-semibold">{{ $event->tickets->count() }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Active Tickets:</span>
                            <span class="font-semibold text-green-600">{{ $event->tickets->where('is_active', true)->count() }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Total Sold:</span>
                            <span class="font-semibold text-blue-600">{{ $event->tickets->sum('quantity_sold') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Total Revenue:</span>
                            <span class="font-semibold text-indigo-600">
                                Rp {{ number_format($event->tickets->sum(function($ticket) {
                                    return $ticket->price * $ticket->quantity_sold;
                                }), 0, ',', '.') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection