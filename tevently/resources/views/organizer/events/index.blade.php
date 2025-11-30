@extends('organizer.partials.sidebar')

@section('title', 'Event Management')
@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Alert Messages -->
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-white rounded-lg shadow p-4">
                    <p class="text-gray-600 text-sm">Total Events</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total'] }}</p>
                </div>
                <div class="bg-white rounded-lg shadow p-4">
                    <p class="text-gray-600 text-sm">Published</p>
                    <p class="text-2xl font-bold text-green-600">{{ $stats['published'] }}</p>
                </div>
                <div class="bg-white rounded-lg shadow p-4">
                    <p class="text-gray-600 text-sm">Draft</p>
                    <p class="text-2xl font-bold text-yellow-600">{{ $stats['draft'] }}</p>
                </div>
                <div class="bg-white rounded-lg shadow p-4">
                    <p class="text-gray-600 text-sm">Cancelled</p>
                    <p class="text-2xl font-bold text-red-600">{{ $stats['cancelled'] }}</p>
                </div>
            </div>

            <!-- Filters -->
            <div class="bg-white rounded-lg shadow mb-6 p-4">
                <form method="GET" action="{{ route('organizer.events.index') }}" class="flex gap-4">
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}"
                           placeholder="Search events..." 
                           class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    
                    <select name="status" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">All Status</option>
                        <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                    </select>

                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-md">
                        Filter
                    </button>
                    <a href="{{ route('organizer.events.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-2 rounded-md">
                        Clear
                    </a>
                </form>
            </div>

            <!-- Events Table -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if($events->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Event</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Location</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($events as $event)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0 h-12 w-12">
                                                        @if($event->image_url)
                                                            <img src="{{ asset('storage/' . $event->image_url) }}" alt="{{ $event->title }}" class="h-12 w-12 rounded object-cover">
                                                        @else
                                                            <div class="h-12 w-12 rounded bg-indigo-100 flex items-center justify-center">
                                                                <span class="text-indigo-600 font-semibold">{{ substr($event->title, 0, 2) }}</span>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900">{{ $event->title }}</div>
                                                        <div class="text-sm text-gray-500">{{ $event->category->name }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $event->event_date->format('M d, Y') }}
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-900">
                                                {{ Str::limit($event->location, 30) }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                    {{ $event->status === 'published' ? 'bg-green-100 text-green-800' : '' }}
                                                    {{ $event->status === 'draft' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                                    {{ $event->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}
                                                    {{ $event->status === 'completed' ? 'bg-gray-100 text-gray-800' : '' }}">
                                                    {{ ucfirst($event->status) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <div class="flex justify-end gap-2">
                                                    <a href="{{ route('organizer.events.show', $event) }}" class="text-indigo-600 hover:text-indigo-900">
                                                        View
                                                    </a>
                                                    <a href="{{ route('organizer.events.edit', $event) }}" class="text-blue-600 hover:text-blue-900">
                                                        Edit
                                                    </a>
                                                    <form method="POST" action="{{ route('organizer.events.destroy', $event) }}" 
                                                          onsubmit="return confirm('Are you sure you want to delete this event?')"
                                                          class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-600 hover:text-red-900">
                                                            Delete
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="mt-4">
                            {{ $events->links() }}
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No events</h3>
                            <p class="mt-1 text-sm text-gray-500">Get started by creating a new event.</p>
                            <div class="mt-6">
                                <a href="{{ route('organizer.events.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                                    + Create Event
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection