@extends('admin.partials.sidebar')

@section('title', 'Create Event')

@section('content')
<div class="py-6">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Create New Event</h1>
            <p class="text-gray-600">Create event with organizer and tickets</p>
        </div>

        <div class="bg-white shadow rounded-lg p-6">
            <form action="{{ route('admin.events.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <!-- Event Basic Info -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <!-- Organizer -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Organizer *</label>
                        <select name="organizer_id" class="w-full rounded-md border-gray-300" required>
                            <option value="">Select Organizer</option>
                            @foreach($organizers as $org)
                                <option value="{{ $org->id }}" {{ old('organizer_id') == $org->id ? 'selected' : '' }}>
                                    {{ $org->name }} ({{ $org->email }})
                                </option>
                            @endforeach
                        </select>
                        @error('organizer_id')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>

                    <!-- Title & Category -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Title *</label>
                        <input type="text" name="title" value="{{ old('title') }}" 
                               class="w-full rounded-md border-gray-300" required>
                        @error('title')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Category *</label>
                        <select name="category_id" class="w-full rounded-md border-gray-300" required>
                            <option value="">Select Category</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>

                    <!-- Location & Max Attendees -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Location *</label>
                        <input type="text" name="location" value="{{ old('location') }}" 
                               class="w-full rounded-md border-gray-300" required>
                        @error('location')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Max Attendees *</label>
                        <input type="number" name="max_attendees" value="{{ old('max_attendees', 100) }}" 
                               min="1" class="w-full rounded-md border-gray-300" required>
                        @error('max_attendees')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>

                    <!-- Date & Time -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Event Date *</label>
                        <input type="date" name="event_date" value="{{ old('event_date') }}" 
                               min="{{ date('Y-m-d') }}" class="w-full rounded-md border-gray-300" required>
                        @error('event_date')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Start *</label>
                            <input type="time" name="start_time" value="{{ old('start_time', '19:00') }}" 
                                   class="w-full rounded-md border-gray-300" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">End *</label>
                            <input type="time" name="end_time" value="{{ old('end_time', '22:00') }}" 
                                   class="w-full rounded-md border-gray-300" required>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Description *</label>
                        <textarea name="description" rows="3" class="w-full rounded-md border-gray-300" 
                                  required>{{ old('description') }}</textarea>
                        @error('description')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>

                    <!-- Status & Image -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select name="status" class="w-full rounded-md border-gray-300">
                            <option value="draft">Draft</option>
                            <option value="published" selected>Published</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Image</label>
                        <input type="file" name="image" accept="image/*" class="w-full rounded-md border-gray-300">
                        <p class="text-xs text-gray-500 mt-1">Max 2MB</p>
                    </div>
                </div>

                <!-- Tickets Section -->
                <div class="border-t pt-6 mt-6">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-lg font-semibold">Tickets</h2>
                        <button type="button" onclick="addTicket()" 
                                class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 text-sm">
                            + Add Ticket
                        </button>
                    </div>
                    
                    <div id="tickets-container">
                        @include('admin.events.partials.ticket-form', ['index' => 0, 'ticket' => null])
                    </div>
                </div>

                <!-- Buttons -->
                <div class="flex gap-4 mt-6 pt-6 border-t">
                    <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-md hover:bg-indigo-700">
                        Create Event
                    </button>
                    <a href="{{ route('admin.events.index') }}" class="bg-gray-300 text-gray-700 px-6 py-2 rounded-md hover:bg-gray-400">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
let ticketCount = 1;
function addTicket() {
    const container = document.getElementById('tickets-container');
    const template = `@include('admin.partials.ticket-form', ['index' => '${ticketCount}', 'ticket' => null, 'removable' => true])`;
    container.insertAdjacentHTML('beforeend', template);
    ticketCount++;
}
</script>
@endsection