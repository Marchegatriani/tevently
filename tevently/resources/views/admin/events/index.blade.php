@extends('layouts.admin')

@section('title', 'Kelola Event')
@section('heading', 'Kelola Event')
@section('subheading', 'Kontrol dan manajemen semua acara')

@section('header-actions')
    <a href="{{ route('admin.events.create') }}" 
       class="inline-flex items-center px-4 py-2 bg-[#837ab6] text-white rounded-xl text-sm font-semibold hover:bg-[#9d85b6] transition shadow-md">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        Buat Event Baru
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
            <div class="mb-6 bg-green-100 border border-green-400 text-green-800 px-4 py-3 rounded-xl relative font-medium shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 bg-red-100 border border-red-400 text-red-800 px-4 py-3 rounded-xl relative font-medium shadow-sm">
                {{ session('error') }}
            </div>
        @endif

        <div class="bg-white overflow-hidden shadow-xl rounded-2xl mb-6 border border-gray-100">
            <div class="p-6">
                <form method="GET" class="flex flex-col md:flex-row gap-4 items-end">
                    
                    <div class="flex-1 min-w-0">
                        <label class="block text-sm font-medium text-custom-dark mb-1">Cari Event</label>
                        <input type="text" name="search" value="{{ request('search') }}" 
                               placeholder="Cari berdasarkan judul event..." 
                               class="w-full rounded-xl border-gray-300 shadow-sm focus:border-main-purple focus:ring-main-purple transition bg-gray-50 px-4 py-2">
                    </div>

                    <div class="w-full md:w-auto">
                        <label class="block text-sm font-medium text-custom-dark mb-1">Status</label>
                        <select name="status" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-main-purple focus:ring-main-purple transition bg-gray-50 px-4 py-2">
                            <option value="">Semua Status</option>
                            <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
                            <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>

                    <div class="flex gap-3 w-full md:w-auto">
                        <button type="submit" class="bg-main-purple hover:bg-[#9d85b6] text-white font-semibold px-4 py-2 rounded-xl shadow-md transition w-1/2 md:w-auto">
                            Filter
                        </button>
                        <a href="{{ route('admin.events.index') }}" class="bg-gray-200 hover:bg-gray-300 text-custom-dark font-semibold px-4 py-2 rounded-xl transition w-1/2 md:w-auto text-center">
                            Hapus
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow-xl rounded-2xl border border-gray-100">
            <div class="p-6">
                @if($events->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-soft-pink-light">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-custom-dark uppercase">Event</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-custom-dark uppercase">Penyelenggara</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-custom-dark uppercase">Tanggal</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-custom-dark uppercase">Status</th>
                                    <th class="px-6 py-3 text-right text-xs font-bold text-custom-dark uppercase">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($events as $event)
                                    <tr>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center">
                                                @if($event->image_url)
                                                    <img src="{{ asset('storage/' . $event->image_url) }}" alt="{{ $event->title }}" 
                                                         class="h-10 w-10 rounded-lg object-cover mr-3 border border-gray-200">
                                                @else
                                                    <div class="h-10 w-10 rounded-lg bg-main-purple/20 flex items-center justify-center mr-3 border border-gray-200">
                                                        <span class="text-main-purple text-xs font-bold">{{ strtoupper(substr($event->title, 0, 2)) }}</span>
                                                    </div>
                                                @endif
                                                <div>
                                                    <div class="font-semibold text-custom-dark">{{ $event->title }}</div>
                                                    <div class="text-xs text-gray-500">{{ $event->category->name ?? 'Tanpa Kategori' }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-sm">
                                            <div class="font-medium text-custom-dark">{{ $event->organizer->name }}</div>
                                            <div class="text-xs text-gray-500">{{ $event->organizer->email }}</div>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-700">
                                            {{ $event->event_date->format('d M Y') }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="px-3 py-1 text-xs font-semibold rounded-full
                                                {{ $event->status === 'published' ? 'bg-green-100 text-green-800' : '' }}
                                                {{ $event->status === 'draft' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                                {{ $event->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}">
                                                {{ ucfirst($event->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-right text-sm">
                                            <div class="flex justify-end gap-3">
                                                <a href="{{ route('admin.events.show', $event) }}" class="text-[#837ab6] hover:text-[#9d85b6] font-semibold">
                                                    Lihat
                                                </a>
                                                <a href="{{ route('admin.events.edit', $event) }}" class="text-[#cc8db3] hover:text-[#f6a5c0] font-semibold">
                                                    Edit
                                                </a>
                                                
                                                @if($event->organizer_id === auth()->id())
                                                    <form method="POST" action="{{ route('admin.events.destroy', $event) }}" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" 
                                                                onclick="return confirm('Apakah Anda yakin ingin menghapus event ini?')"
                                                                class="text-red-600 hover:text-red-800 font-semibold transition">
                                                            Hapus
                                                        </button>
                                                    </form>
                                                @else
                                                    <span class="text-gray-400" title="Hanya bisa menghapus event sendiri">Hapus</span>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-8">
                        {{ $events->links() }}
                    </div>
                @else
                    <div class="text-center py-12">
                        <p class="text-gray-500 text-lg">Tidak ada event ditemukan sesuai kriteria.</p>
                        <a href="{{ route('admin.events.create') }}" class="text-main-purple hover:text-custom-dark mt-2 inline-block font-semibold">
                            Buat event pertama Anda sekarang.
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection