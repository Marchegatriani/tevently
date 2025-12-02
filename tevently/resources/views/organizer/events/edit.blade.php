@extends('layouts.organizer')

@section('title', 'Edit Event - Organizer')
@section('heading', 'Edit Event')
@section('subheading', 'Perbarui informasi acara dan kelola tiket')

@section('header-actions')
    <a href="{{ route('organizer.events.index') }}" 
       class="inline-flex items-center px-4 py-2 bg-gray-500 text-white rounded-xl text-sm font-semibold hover:bg-gray-600 transition shadow-md">
        ← Kembali ke Daftar Acara
    </a>
@endsection

@section('content')
<style>
    /* Palet: #250e2c (Dark), #837ab6 (Main), #cc8db3 (Pink Accent), #f6a5c0 (Light Pink) */
    .text-custom-dark { color: #250e2c; }
    .bg-main-purple { background-color: #837ab6; }
    .bg-pink-accent { background-color: #cc8db3; }
    .bg-soft-light { background-color: #F8F3F7; }
</style>

<div class="py-6 bg-soft-light">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        
        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="mb-6 bg-green-100 border border-green-400 text-green-800 px-4 py-3 rounded-xl shadow-sm font-medium">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 bg-red-100 border border-red-400 text-red-800 px-4 py-3 rounded-xl shadow-sm font-medium">
                {{ session('error') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Left Column - Event Form (2/3 width) -->
            <div class="lg:col-span-2 order-2 lg:order-1">
                <div class="bg-white shadow-xl rounded-2xl p-8 border border-gray-100">
                    <form action="{{ route('organizer.events.update', $event) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PUT')
                        
                        <h2 class="text-2xl font-bold text-custom-dark mb-6">Detail Acara</h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            
                            <!-- Event Title -->
                            <div>
                                <label class="block text-sm font-semibold text-custom-dark mb-2">Judul Acara</label>
                                <input type="text" name="title" value="{{ old('title', $event->title) }}" 
                                    class="w-full px-4 py-3 bg-gray-50 rounded-xl border shadow-sm focus:ring-main-purple focus:border-main-purple transition @error('title') border-red-500 @enderror" required>
                                @error('title')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- Category -->
                            <div>
                                <label class="block text-sm font-semibold text-custom-dark mb-2">Kategori</label>
                                <select name="category_id" class="w-full px-4 py-3 bg-gray-50 rounded-xl border shadow-sm focus:ring-main-purple focus:border-main-purple transition @error('category_id') border-red-500 @enderror" required>
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

                            <!-- Location -->
                            <div>
                                <label class="block text-sm font-semibold text-custom-dark mb-2">Lokasi</label>
                                <input type="text" name="location" value="{{ old('location', $event->location) }}" 
                                    class="w-full px-4 py-3 bg-gray-50 rounded-xl border shadow-sm focus:ring-main-purple focus:border-main-purple transition @error('location') border-red-500 @enderror" required>
                                @error('location')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Max Attendees -->
                            <div>
                                <label class="block text-sm font-semibold text-custom-dark mb-2">Kapasitas Maksimum</label>
                                <input type="number" name="max_attendees" value="{{ old('max_attendees', $event->max_attendees) }}" min="1" 
                                    class="w-full px-4 py-3 bg-gray-50 rounded-xl border shadow-sm focus:ring-main-purple focus:border-main-purple transition @error('max_attendees') border-red-500 @enderror" required>
                                @error('max_attendees')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Event Date -->
                            <div>
                                <label class="block text-sm font-semibold text-custom-dark mb-2">Tanggal Acara</label>
                                <input type="date" name="event_date" value="{{ old('event_date', $event->event_date->format('Y-m-d')) }}" 
                                    class="w-full px-4 py-3 bg-gray-50 rounded-xl border shadow-sm focus:ring-main-purple focus:border-main-purple transition @error('event_date') border-red-500 @enderror" required>
                                @error('event_date')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Time Split -->
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-semibold text-custom-dark mb-2">Waktu Mulai</label>
                                    <input type="time" name="start_time" value="{{ old('start_time', $event->start_time->format('H:i')) }}" 
                                        class="w-full px-4 py-3 bg-gray-50 rounded-xl border shadow-sm focus:ring-main-purple focus:border-main-purple transition @error('start_time') border-red-500 @enderror" required>
                                    @error('start_time')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-custom-dark mb-2">Waktu Selesai</label>
                                    <input type="time" name="end_time" value="{{ old('end_time', $event->end_time->format('H:i')) }}" 
                                        class="w-full px-4 py-3 bg-gray-50 rounded-xl border shadow-sm focus:ring-main-purple focus:border-main-purple transition @error('end_time') border-red-500 @enderror" required>
                                    @error('end_time')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            
                            <!-- Description (Full Width) -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-semibold text-custom-dark mb-2">Deskripsi</label>
                                <textarea name="description" rows="4" 
                                    class="w-full px-4 py-3 bg-gray-50 rounded-xl border shadow-sm focus:ring-main-purple focus:border-main-purple transition @error('description') border-red-500 @enderror" required>{{ old('description', $event->description) }}</textarea>
                                @error('description')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Status -->
                            <div>
                                <label class="block text-sm font-semibold text-custom-dark mb-2">Status</label>
                                <select name="status" class="w-full px-4 py-3 bg-gray-50 rounded-xl border shadow-sm focus:ring-main-purple focus:border-main-purple transition @error('status') border-red-500 @enderror">
                                    <option value="draft" {{ $event->status == 'draft' ? 'selected' : '' }}>Draft</option>
                                    <option value="published" {{ $event->status == 'published' ? 'selected' : '' }}>Published</option>
                                    <option value="cancelled" {{ $event->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    <option value="completed" {{ $event->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                </select>
                                @error('status')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- Event Image Upload/Remove -->
                            <div>
                                <label class="block text-sm font-semibold text-custom-dark mb-2">Gambar Acara</label>
                                <input type="file" name="image" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-gray-200 file:text-custom-dark hover:file:bg-gray-300">
                                @error('image')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                                @if($event->image_url)
                                    <div class="mt-4 flex items-center gap-3 bg-gray-50 p-3 rounded-xl border border-gray-200">
                                        <img src="{{ asset('storage/' . $event->image_url) }}" alt="{{ $event->title }}" class="h-10 w-10 object-cover rounded-lg">
                                        <div>
                                            <p class="text-xs text-gray-700 font-medium">Gambar saat ini</p>
                                            <label class="flex items-center mt-1">
                                                <input type="checkbox" name="remove_image" value="1" class="rounded border-gray-300 text-red-600 focus:ring-red-500">
                                                <span class="ml-2 text-xs text-red-600 font-medium">Hapus Gambar</span>
                                            </label>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex gap-4 pt-4 border-t border-gray-100 mt-6">
                            <button type="submit" class="bg-main-purple text-white px-6 py-3 rounded-xl font-bold hover:bg-[#9d85b6] transition duration-300 shadow-lg shadow-[#837ab6]/40 transform hover:-translate-y-0.5">
                                Perbarui Acara
                            </button>
                            <a href="{{ route('organizer.events.show', $event) }}" class="bg-gray-300 text-custom-dark px-6 py-3 rounded-xl font-bold hover:bg-gray-400 transition duration-300 transform hover:-translate-y-0.5">
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Right Column - Tickets Management (1/3 width) -->
            <div class="lg:col-span-1 order-1 lg:order-2">
                <div class="bg-white shadow-xl rounded-2xl p-6 border border-gray-100 sticky top-4">
                    <div class="flex justify-between items-center mb-6 border-b pb-4 border-gray-100">
                        <h2 class="text-xl font-bold text-custom-dark">Kelola Tiket</h2>
                        <a href="{{ route('organizer.tickets.create', $event) }}" 
                           class="bg-pink-accent text-white px-4 py-2 rounded-xl text-sm font-semibold hover:bg-[#f6a5c0] transition shadow-md">
                            + Tambah Tiket
                        </a>
                    </div>

                    @if($event->tickets->count() > 0)
                        <div class="space-y-4">
                            @foreach($event->tickets as $ticket)
                                <div class="border rounded-xl p-4 transition {{ $ticket->is_active ? 'border-gray-200' : 'border-red-300 bg-red-50' }}">
                                    <div class="flex justify-between items-start mb-2">
                                        <div class="flex-1">
                                            <h3 class="font-semibold text-custom-dark text-lg">{{ $ticket->name }}</h3>
                                            <p class="text-sm mt-1 font-bold text-[#837ab6]">
                                                Rp {{ number_format($ticket->price, 0, ',', '.') }}
                                            </p>
                                        </div>
                                        <span class="px-3 py-1 rounded-full text-xs font-medium {{ $ticket->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $ticket->is_active ? 'Aktif' : 'Nonaktif' }}
                                        </span>
                                    </div>

                                    <div class="text-sm text-gray-600 space-y-1 mb-4">
                                        <p>Tersedia: <span class="font-semibold">{{ $ticket->quantity_available - $ticket->quantity_sold }}</span> / {{ $ticket->quantity_available }}</p>
                                        <p>Terjual: <span class="font-semibold">{{ $ticket->quantity_sold }}</span></p>
                                        <p>Maks per order: {{ $ticket->max_per_order }}</p>
                                    </div>

                                    <div class="flex gap-2 text-sm font-semibold">
                                        <a href="{{ route('organizer.tickets.edit', [$event, $ticket]) }}" 
                                           class="flex-1 text-center bg-gray-200 text-custom-dark px-3 py-1.5 rounded-xl hover:bg-gray-300 transition">
                                            Edit
                                        </a>
                                        
                                        <form action="{{ route('organizer.tickets.toggle', [$event, $ticket]) }}" 
                                              method="POST" 
                                              class="flex-1">
                                            @csrf
                                            <button type="submit" 
                                                    class="w-full px-3 py-1.5 rounded-xl transition shadow-md text-white 
                                                        {{ $ticket->is_active ? 'bg-yellow-600 hover:bg-yellow-700' : 'bg-green-600 hover:bg-green-700' }}">
                                                {{ $ticket->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8 bg-gray-50 rounded-xl border border-gray-100">
                            <p class="text-gray-600 mb-4">Acara ini belum memiliki tiket.</p>
                            <a href="{{ route('organizer.tickets.create', $event) }}" 
                               class="inline-block bg-pink-accent text-white px-4 py-2 rounded-xl hover:bg-[#f6a5c0] transition font-semibold">
                                Tambahkan Tiket Pertama
                            </a>
                        </div>
                    @endif
                </div>

                <!-- Quick Stats -->
                <div class="bg-white shadow-xl rounded-2xl p-6 border border-gray-100 mt-6">
                    <h3 class="text-xl font-bold text-custom-dark mb-4 border-b pb-3 border-gray-100">Statistik Cepat</h3>
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Total Jenis Tiket:</span>
                            <span class="font-semibold text-custom-dark">{{ $event->tickets->count() }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Tiket Aktif:</span>
                            <span class="font-semibold text-green-600">{{ $event->tickets->where('is_active', true)->count() }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Total Terjual:</span>
                            <span class="font-semibold text-[#837ab6]">{{ $event->tickets->sum('quantity_sold') }}</span>
                        </div>
                        <div class="flex justify-between text-lg pt-3 border-t border-gray-100">
                            <span class="text-gray-600 font-bold">Total Pendapatan:</span>
                            <span class="font-extrabold text-[#cc8db3]">
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