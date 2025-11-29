@extends('layouts.organizer')

@section('title', 'Dashboard Organizer')
@section('content')
<div class="space-y-6">
    <!-- Header Welcome -->
    <div class="bg-white rounded-lg shadow-sm border p-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Halo, {{ auth()->user()->name }}! 👋</h1>
                <p class="text-gray-600 mt-1">Kelola acara dan pantau kinerja Anda</p>
            </div>
            <a href="{{ route('organizer.events.create') }}" 
               class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Buat Acara Baru
            </a>
        </div>
    </div>

    <!-- Statistics Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        @php
            $totalEvents = auth()->user()->events()->count();
            $publishedEvents = auth()->user()->events()->where('status', 'published')->count();
            $draftEvents = auth()->user()->events()->where('status', 'draft')->count();
            $upcomingEvents = auth()->user()->events()->where('status', 'published')->where('event_date', '>=', now())->count();
        @endphp

        <!-- Total Events -->
        <div class="bg-white rounded-lg shadow-sm border p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-indigo-100 rounded-lg p-3">
                    <svg class="h-6 w-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Acara</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $totalEvents }}</p>
                </div>
            </div>
        </div>

        <!-- Published -->
        <div class="bg-white rounded-lg shadow-sm border p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-green-100 rounded-lg p-3">
                    <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Dipublikasi</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $publishedEvents }}</p>
                </div>
            </div>
        </div>

        <!-- Draft -->
        <div class="bg-white rounded-lg shadow-sm border p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-yellow-100 rounded-lg p-3">
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

        <!-- Upcoming -->
        <div class="bg-white rounded-lg shadow-sm border p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-purple-100 rounded-lg p-3">
                    <svg class="h-6 w-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Mendatang</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $upcomingEvents }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Events -->
    <div class="bg-white rounded-lg shadow-sm border">
        <div class="p-6">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-semibold text-gray-900">Acara Terbaru</h3>
                <a href="{{ route('organizer.events.index') }}" class="text-indigo-600 hover:text-indigo-700 font-medium text-sm flex items-center">
                    Lihat Semua
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>

            @php
                $recentEvents = auth()->user()->events()->latest()->take(5)->get();
            @endphp

            @if($recentEvents->count() > 0)
                <div class="space-y-4">
                    @foreach($recentEvents as $event)
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                            <div class="flex-1">
                                <h4 class="font-semibold text-gray-900">{{ $event->title }}</h4>
                                <div class="flex items-center space-x-4 mt-1 text-sm text-gray-600">
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
-                                        <p class="text-sm text-gray-600">{{ $event->event_date->format('d M Y') }}</p>
+                                        <p class="text-sm text-gray-600">{{ optional($event->event_date)->format('d M Y') ?? '-' }}</p>
                                    </span>
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
-                                        <p class="text-sm text-gray-600">{{ $event->location }}</p>
+                                        <p class="text-sm text-gray-600">{{ $event->location ?? '—' }}</p>
                                    </span>
                                </div>
                            </div>
                            <div class="flex items-center space-x-4">
                                <span class="px-3 py-1 text-xs font-semibold rounded-full
                                    {{ $event->status === 'published' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $event->status === 'draft' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                    {{ $event->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}">
                                    {{ ucfirst($event->status) }}
                                </span>
                                <a href="{{ route('organizer.events.show', $event) }}" 
                                   class="text-indigo-600 hover:text-indigo-700 font-medium text-sm flex items-center">
                                    Lihat
                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <p class="text-gray-500 text-lg mb-4">Belum ada acara</p>
                    <a href="{{ route('organizer.events.create') }}" 
                       class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg transition-colors">
                        Buat Acara Pertama
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection