@extends('layouts.organizer')

@section('title', 'Dashboard Organizer')
@section('heading', 'Dashboard Organizer')
@section('subheading', 'Ringkasan kinerja dan kontrol acara Anda')

@section('content')
<style>
    .text-custom-dark { color: #250e2c; }
    .bg-main-purple { background-color: #837ab6; }
    .bg-pink-accent { background-color: #cc8db3; }
    .bg-soft-pink-light { background-color: #f7c2ca; }
</style>

<div class="space-y-8">
    <div class="bg-soft-pink-light border border-[#f6a5c0]/50 rounded-xl p-6 shadow-md">
        <div class="flex items-center justify-between flex-wrap gap-4">
            <div>
                <h1 class="text-2xl font-bold text-custom-dark">Halo, {{ auth()->user()->name }}! 👋</h1>
                <p class="text-gray-700 mt-1">Kelola acara dan pantau kinerja Anda.</p>
            </div>
            
            <a href="{{ route('organizer.events.create') }}" 
               class="inline-flex items-center px-5 py-2 bg-main-purple hover:bg-[#9d85b6] text-white font-semibold rounded-xl transition-colors shadow-md transform hover:-translate-y-0.5">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Buat Acara Baru
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @php
            $userEvents = auth()->user()->events();
            $totalEvents = $userEvents->count();
            $publishedEvents = $userEvents->where('status', 'published')->count();
            $draftEvents = $userEvents->where('status', 'draft')->count();
            $upcomingEvents = $userEvents->where('status', 'published')->where('event_date', '>=', now())->count();
        @endphp

        <!-- Total Events -->
        <div class="bg-white rounded-xl shadow-lg border p-6 transition duration-300 hover:shadow-2xl hover:border-main-purple">
            <div class="flex items-center gap-4">
                <div class="flex-shrink-0 bg-main-purple text-white rounded-xl p-3 shadow-md shadow-[#837ab6]/40">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Acara</p>
                    <p class="text-3xl font-extrabold text-custom-dark mt-1">{{ $totalEvents }}</p>
                </div>
            </div>
        </div>

        <!-- Published -->
        <div class="bg-white rounded-xl shadow-lg border p-6 transition duration-300 hover:shadow-2xl hover:border-green-400">
            <div class="flex items-center gap-4">
                <div class="flex-shrink-0 bg-green-500 text-white rounded-xl p-3 shadow-md shadow-green-500/40">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Dipublikasi</p>
                    <p class="text-3xl font-extrabold text-custom-dark mt-1">{{ $publishedEvents }}</p>
                </div>
            </div>
        </div>

        <!-- Draft -->
        <div class="bg-white rounded-xl shadow-lg border p-6 transition duration-300 hover:shadow-2xl hover:border-yellow-400">
            <div class="flex items-center gap-4">
                <div class="flex-shrink-0 bg-yellow-500 text-white rounded-xl p-3 shadow-md shadow-yellow-500/40">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Draft</p>
                    <p class="text-3xl font-extrabold text-custom-dark mt-1">{{ $draftEvents }}</p>
                </div>
            </div>
        </div>

        <!-- Upcoming -->
        <div class="bg-white rounded-xl shadow-lg border p-6 transition duration-300 hover:shadow-2xl hover:border-pink-accent">
            <div class="flex items-center gap-4">
                <div class="flex-shrink-0 bg-pink-accent text-white rounded-xl p-3 shadow-md shadow-[#cc8db3]/40">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Mendatang</p>
                    <p class="text-3xl font-extrabold text-custom-dark mt-1">{{ $upcomingEvents }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Events -->
    <div class="bg-white rounded-xl shadow-xl border">
        <div class="p-6">
            <div class="flex justify-between items-center mb-6 border-b pb-4">
                <h3 class="text-xl font-bold text-custom-dark">Acara Terbaru</h3>
                <a href="{{ route('organizer.events.index') }}" class="text-main-purple hover:text-custom-dark font-medium text-sm flex items-center">
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
                        <div class="flex flex-wrap items-center justify-between p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors border border-gray-100">
                            <div class="flex-1 min-w-0">
                                <h4 class="font-semibold text-custom-dark">{{ $event->title }}</h4>
                                <div class="flex items-center space-x-4 mt-1 text-sm text-gray-600">
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-1 text-main-purple" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <p class="text-sm text-gray-600">{{ optional($event->event_date)->format('d M Y') ?? '-' }}</p>
                                    </span>
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-1 text-pink-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        <p class="text-sm text-gray-600">{{ $event->location ?? '—' }}</p>
                                    </span>
                                </div>
                            </div>
                            
                            <div class="flex items-center space-x-4 mt-2 lg:mt-0">
                                <span class="px-3 py-1 text-xs font-semibold rounded-full
                                    {{ $event->status === 'published' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $event->status === 'draft' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                    {{ $event->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}">
                                    {{ ucfirst($event->status) }}
                                </span>
                                <a href="{{ route('organizer.events.show', $event) }}" 
                                   class="text-main-purple hover:text-custom-dark font-medium text-sm flex items-center transition">
                                    Lihat Detail
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
                    <p class="text-gray-500 text-lg mb-4">Belum ada acara yang Anda buat.</p>
                    <a href="{{ route('organizer.events.create') }}" 
                       class="inline-flex items-center px-4 py-2 bg-main-purple hover:bg-[#9d85b6] text-white font-medium rounded-xl transition-colors shadow-md">
                        Buat Acara Pertama
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection