@extends('layouts.organizer')

@section('title', 'Kelola Acara')
@section('heading', 'Kelola Acara Anda')
@section('subheading', 'Ringkasan dan daftar lengkap acara yang Anda buat')

@section('header-actions')
    <a href="{{ route('organizer.events.create') }}" 
       class="inline-flex items-center px-5 py-2 bg-[#837ab6] text-white rounded-xl text-sm font-semibold hover:bg-[#9d85b6] transition shadow-md transform hover:-translate-y-0.5">
        + Buat Acara Baru
    </a>
@endsection

@section('content')
<style>
    .text-custom-dark { color: #250e2c; }
    .bg-main-purple { background-color: #837ab6; }
    .bg-pink-accent { background-color: #cc8db3; }
    .bg-soft-pink-light { background-color: #f7c2ca; }
</style>

<div class="py-2">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        
        @if(session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-800 px-4 py-3 rounded-xl relative font-medium shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            
            <!-- Total Events -->
            <div class="bg-white rounded-xl shadow-lg border p-5 transition duration-300 hover:shadow-2xl hover:border-main-purple">
                <p class="text-sm font-medium text-gray-600">Total Acara</p>
                <p class="text-3xl font-extrabold text-custom-dark mt-1">{{ $stats['total'] }}</p>
            </div>
            
            <!-- Published -->
            <div class="bg-white rounded-xl shadow-lg border p-5 transition duration-300 hover:shadow-2xl hover:border-green-400">
                <p class="text-sm font-medium text-gray-600">Dipublikasi</p>
                <p class="text-3xl font-extrabold text-green-600 mt-1">{{ $stats['published'] }}</p>
            </div>
            
            <!-- Draft -->
            <div class="bg-white rounded-xl shadow-lg border p-5 transition duration-300 hover:shadow-2xl hover:border-yellow-400">
                <p class="text-sm font-medium text-gray-600">Draft</p>
                <p class="text-3xl font-extrabold text-yellow-600 mt-1">{{ $stats['draft'] }}</p>
            </div>
            
            <!-- Cancelled -->
            <div class="bg-white rounded-xl shadow-lg border p-5 transition duration-300 hover:shadow-2xl hover:border-red-400">
                <p class="text-sm font-medium text-gray-600">Dibatalkan</p>
                <p class="text-3xl font-extrabold text-red-600 mt-1">{{ $stats['cancelled'] }}</p>
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-white overflow-hidden shadow-xl rounded-2xl mb-6 border border-gray-100">
            <div class="p-6">
                <form method="GET" action="{{ route('organizer.events.index') }}" class="flex flex-col md:flex-row gap-4 items-end">
                    
                    <div class="flex-1 min-w-0">
                        <label class="block text-sm font-medium text-custom-dark mb-1">Cari Acara</label>
                        <input type="text" name="search" value="{{ request('search') }}" 
                               placeholder="Cari berdasarkan judul event..." 
                               class="w-full rounded-xl border-gray-300 shadow-sm focus:border-main-purple focus:ring-main-purple transition bg-gray-50 px-4 py-2">
                    </div>

                    <div class="w-full md:w-auto">
                        <label class="block text-sm font-medium text-custom-dark mb-1">Status</label>
                        <select name="status" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-main-purple focus:ring-main-purple transition bg-gray-50 px-4 py-2">
                            <option value="">Semua Status</option>
                            <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
                            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                        </select>
                    </div>

                    <div class="flex gap-3 w-full md:w-auto">
                        <button type="submit" class="bg-main-purple hover:bg-[#9d85b6] text-white font-semibold px-6 py-2 rounded-xl shadow-md transition w-1/2 md:w-auto">
                            Filter
                        </button>
                        <a href="{{ route('organizer.events.index') }}" class="bg-gray-200 hover:bg-gray-300 text-custom-dark font-semibold px-6 py-2 rounded-xl transition w-1/2 md:w-auto text-center">
                            Hapus
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Events Table -->
        <div class="bg-white overflow-hidden shadow-xl rounded-2xl border border-gray-100">
            <div class="p-6">
                @if($events->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-soft-pink-light">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-custom-dark uppercase tracking-wider">Event</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-custom-dark uppercase tracking-wider">Tanggal</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-custom-dark uppercase tracking-wider">Lokasi</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-custom-dark uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-right text-xs font-bold text-custom-dark uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($events as $event)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-12 w-12">
                                                    @if($event->image_url)
                                                        <img src="{{ asset('storage/' . $event->image_url) }}" alt="{{ $event->title }}" class="h-12 w-12 rounded-lg object-cover border border-gray-200">
                                                    @else
                                                        <div class="h-12 w-12 rounded-lg bg-main-purple/20 flex items-center justify-center border border-gray-200">
                                                            <span class="text-main-purple font-semibold">{{ substr($event->title, 0, 2) }}</span>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-semibold text-custom-dark">{{ $event->title }}</div>
                                                    <div class="text-xs text-gray-500">{{ $event->category->name }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                            {{ $event->event_date->format('d M Y') }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-700">
                                            {{ Str::limit($event->location, 30) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-3 py-1 text-xs font-semibold rounded-full
                                                {{ $event->status === 'published' ? 'bg-green-100 text-green-800' : '' }}
                                                {{ $event->status === 'draft' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                                {{ $event->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}
                                                {{ $event->status === 'completed' ? 'bg-gray-200 text-gray-700' : '' }}">
                                                {{ ucfirst($event->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <div class="flex justify-end gap-3">
                                                <a href="{{ route('organizer.events.show', $event) }}" class="text-main-purple hover:text-custom-dark transition">
                                                    Lihat
                                                </a>
                                                <a href="{{ route('organizer.events.edit', $event) }}" class="text-pink-accent hover:text-[#f6a5c0] transition">
                                                    Edit
                                                </a>
                                                
                                                <form method="POST" action="{{ route('organizer.events.destroy', $event) }}" 
                                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus acara ini?')"
                                                      class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-800 transition">
                                                        Hapus
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
                    <div class="mt-8">
                        {{ $events->links() }}
                    </div>
                @else
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-[#cc8db3]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <h3 class="mt-2 text-xl font-medium text-custom-dark">Tidak ada acara yang Anda buat.</h3>
                        <p class="mt-1 text-sm text-gray-500">Mulai dengan membuat acara baru pertama Anda.</p>
                        <div class="mt-6">
                            <a href="{{ route('organizer.events.create') }}" class="inline-flex items-center px-4 py-2 bg-main-purple hover:bg-[#9d85b6] text-white font-medium rounded-xl shadow-md">
                                + Buat Acara Baru
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection