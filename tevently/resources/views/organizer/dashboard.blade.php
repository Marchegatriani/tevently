<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Organizer Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Welcome Card -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-2xl font-semibold mb-2">Welcome, {{ auth()->user()->name }}! 👋</h3>
                    <p class="text-gray-600">Manage your events and view your performance.</p>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="mb-6">
                <a href="{{ route('organizer.events.create') }}" class="inline-flex items-center px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg shadow">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Create New Event
                </a>
            </div>

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                @php
                    $totalEvents = auth()->user()->events()->count();
                    $publishedEvents = auth()->user()->events()->where('status', 'published')->count();
                    $draftEvents = auth()->user()->events()->where('status', 'draft')->count();
                    $upcomingEvents = auth()->user()->events()->where('status', 'published')->where('event_date', '>=', now())->count();
                @endphp

                <!-- Total Events -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-indigo-100 rounded-md p-3">
                                <svg class="h-6 w-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600">Total Events</p>
                                <p class="text-2xl font-bold text-gray-900">{{ $totalEvents }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Published -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-green-100 rounded-md p-3">
                                <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600">Published</p>
                                <p class="text-2xl font-bold text-gray-900">{{ $publishedEvents }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Draft -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-yellow-100 rounded-md p-3">
                                <svg class="h-6 w-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600">Draft</p>
                                <p class="text-2xl font-bold text-gray-900">{{ $draftEvents }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Upcoming -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-purple-100 rounded-md p-3">
                                <svg class="h-6 w-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600">Upcoming</p>
                                <p class="text-2xl font-bold text-gray-900">{{ $upcomingEvents }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Events -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold">Recent Events</h3>
                        <a href="{{ route('organizer.events.index') }}" class="text-indigo-600 hover:text-indigo-700 font-semibold text-sm">
                            View All →
                        </a>
                    </div>

                    @php
                        $recentEvents = auth()->user()->events()->latest()->take(5)->get();
                    @endphp

                    @if($recentEvents->count() > 0)
                        <div class="space-y-3">
                            @foreach($recentEvents as $event)
                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                    <div>
                                        <h4 class="font-semibold text-gray-900">{{ $event->title }}</h4>
                                        <p class="text-sm text-gray-600">{{ $event->event_date->format('M d, Y') }}</p>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="px-2 py-1 text-xs font-semibold rounded
                                            {{ $event->status === 'published' ? 'bg-green-100 text-green-800' : '' }}
                                            {{ $event->status === 'draft' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                            {{ $event->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}">
                                            {{ ucfirst($event->status) }}
                                        </span>
                                        <a href="{{ route('organizer.events.show', $event) }}" class="text-indigo-600 hover:text-indigo-700">
                                            View →
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-8">No events yet. Create your first event!</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>