@extends('admin.partials.sidebar')

@section('title', 'Manage Events')
@section('heading', 'Manage Events')
@section('subheading', 'Kontrol Event')

@section('content')
    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Alert Messages -->
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Simple Filter -->
            <div class="bg-white rounded-lg shadow mb-6 p-4">
                <form method="GET" class="flex gap-4">
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="Search events..." class="flex-1 border rounded px-3 py-2">
                    <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded">Search</button>
                    <a href="{{ route('admin.events.index') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded">Clear</a>
                </form>
            </div>

            <!-- Create Button -->
            <div class="mb-4">
                <a href="{{ route('admin.events.create') }}" class="bg-green-600 text-white px-4 py-2 rounded inline-flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Create Event
                </a>
            </div>

            <!-- Events Table -->
            <div class="bg-white rounded-lg shadow">
                <div class="p-6">
                    @if($events->count() > 0)
                        <table class="min-w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Event</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Organizer</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($events as $event)
                                    <tr>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center">
                                                @if($event->image_url)
                                                    <img src="{{ asset('storage/' . $event->image_url) }}" alt="{{ $event->title }}" 
                                                         class="h-10 w-10 rounded object-cover mr-3">
                                                @endif
                                                <div>
                                                    <div class="font-medium">{{ $event->title }}</div>
                                                    <div class="text-sm text-gray-500">{{ $event->category->name ?? 'No Category' }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm">{{ $event->organizer->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $event->organizer->email }}</div>
                                        </td>
                                        <td class="px-6 py-4 text-sm">
                                            {{ $event->event_date->format('M d, Y') }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="px-2 py-1 text-xs rounded-full
                                                {{ $event->status === 'published' ? 'bg-green-100 text-green-800' : '' }}
                                                {{ $event->status === 'draft' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                                {{ $event->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}">
                                                {{ ucfirst($event->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <div class="flex justify-end gap-2">
                                                <a href="{{ route('admin.events.show', $event) }}" class="text-blue-600 hover:text-blue-900 text-sm">
                                                    View
                                                </a>
                                                <a href="{{ route('admin.events.edit', $event) }}" class="text-indigo-600 hover:text-indigo-900 text-sm">
                                                    Edit
                                                </a>
                                                <!-- Hanya bisa hapus event yang dibuat oleh admin -->
                                                @if($event->organizer_id === auth()->id())
                                                    <form method="POST" action="{{ route('admin.events.destroy', $event) }}" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" 
                                                                onclick="return confirm('Delete this event?')"
                                                                class="text-red-600 hover:text-red-900 text-sm">
                                                            Delete
                                                        </button>
                                                    </form>
                                                @else
                                                    <span class="text-gray-400 text-sm" title="Can only delete your own events">Delete</span>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <!-- Pagination -->
                        <div class="mt-4">
                            {{ $events->links() }}
                        </div>
                    @else
                        <div class="text-center py-8">
                            <p class="text-gray-500">No events found.</p>
                            <a href="{{ route('admin.events.create') }}" class="text-indigo-600 hover:text-indigo-900 mt-2 inline-block">
                                Create your first event
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection