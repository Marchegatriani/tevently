@extends('layouts.organizer')

@section('title', 'Edit Event - Organizer')

@section('content')
<div class="py-6">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Edit Your Event</h1>
            <p class="text-gray-600">Update your event information</p>
        </div>

        <div class="bg-white shadow-sm rounded-lg">
            <form action="{{ route('organizer.events.update', $event) }}" method="POST" enctype="multipart/form-data" class="p-6">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Event Title</label>
                        <input type="text" name="title" value="{{ old('title', $event->title) }}" class="w-full rounded-md border-gray-300" required>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                        <select name="category_id" class="w-full rounded-md border-gray-300" required>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ $event->category_id == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Location</label>
                        <input type="text" name="location" value="{{ old('location', $event->location) }}" class="w-full rounded-md border-gray-300" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Max Attendees</label>
                        <input type="number" name="max_attendees" value="{{ old('max_attendees', $event->max_attendees) }}" min="1" class="w-full rounded-md border-gray-300" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Event Date</label>
                        <input type="date" name="event_date" value="{{ old('event_date', $event->event_date->format('Y-m-d')) }}" class="w-full rounded-md border-gray-300" required>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Start Time</label>
                            <input type="time" name="start_time" value="{{ old('start_time', $event->start_time->format('H:i')) }}" class="w-full rounded-md border-gray-300" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">End Time</label>
                            <input type="time" name="end_time" value="{{ old('end_time', $event->end_time->format('H:i')) }}" class="w-full rounded-md border-gray-300" required>
                        </div>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                        <textarea name="description" rows="3" class="w-full rounded-md border-gray-300" required>{{ old('description', $event->description) }}</textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select name="status" class="w-full rounded-md border-gray-300">
                            <option value="draft" {{ $event->status == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="published" {{ $event->status == 'published' ? 'selected' : '' }}>Published</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Event Image</label>
                        <input type="file" name="image" accept="image/*" class="w-full rounded-md border-gray-300">
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
                    <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded hover:bg-indigo-700">
                        Update Event
                    </button>
                    <a href="{{ route('organizer.events.show', $event) }}" class="bg-gray-300 text-gray-700 px-6 py-2 rounded hover:bg-gray-400">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection