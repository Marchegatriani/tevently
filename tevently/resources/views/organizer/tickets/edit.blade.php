@extends('layouts.organizer')

@section('title', 'Edit Tiket')
@section('heading', 'Edit Tiket')
@section('subheading', 'Perbarui detail tiket untuk event')

@section('content')
<style>
    .text-custom-dark { color: #250e2c; }
    .bg-main-purple { background-color: #837ab6; }
    .bg-pink-accent { background-color: #cc8db3; }
</style>

<div class="container mx-auto px-4 py-8 max-w-3xl">
    @if(session('success'))
        <div class="mb-6 bg-green-100 p-4 rounded-xl border border-green-400 text-green-800 font-medium shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-xl p-8 border border-gray-100">
        <h1 class="text-2xl font-bold text-custom-dark mb-1">Edit Jenis Tiket: {{ $ticket->name }}</h1>
        <p class="text-gray-600 mt-1 mb-6">Untuk acara: <strong>{{ $event->title }}</strong></p>
        
        <form action="{{ route('organizer.tickets.update', [$event, $ticket]) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-5">
                <label for="name" class="block text-sm font-semibold text-custom-dark mb-2">
                    Nama Tiket <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       id="name" 
                       name="name" 
                       value="{{ old('name', $ticket->name) }}"
                       placeholder="Contoh: VIP, Reguler, Early Bird"
                       class="w-full px-4 py-3 bg-gray-50 rounded-xl border border-gray-300 shadow-sm focus:ring-main-purple focus:border-main-purple transition @error('name') border-red-500 @enderror" 
                       required>
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-5">
                <label for="description" class="block text-sm font-semibold text-custom-dark mb-2">
                    Deskripsi
                </label>
                <textarea id="description" 
                          name="description" 
                          rows="3"
                          placeholder="Jelaskan jenis tiket ini (opsional)"
                          class="w-full px-4 py-3 bg-gray-50 rounded-xl border border-gray-300 shadow-sm focus:ring-main-purple focus:border-main-purple transition @error('description') border-red-500 @enderror">{{ old('description', $ticket->description) }}</textarea>
                @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-5">
                <div>
                    <label for="price" class="block text-sm font-semibold text-custom-dark mb-2">
                        Harga (Rp) <span class="text-red-500">*</span>
                    </label>
                    <input type="number" 
                           id="price" 
                           name="price" 
                           value="{{ old('price', $ticket->price) }}"
                           min="0"
                           step="100"
                           placeholder="50000"
                           class="w-full px-4 py-3 bg-gray-50 rounded-xl border border-gray-300 shadow-sm focus:ring-main-purple focus:border-main-purple transition @error('price') border-red-500 @enderror" 
                           required>
                    @error('price')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="quantity_available" class="block text-sm font-semibold text-custom-dark mb-2">
                        Kuantitas Tersedia <span class="text-red-500">*</span>
                    </label>
                    <input type="number" 
                           id="quantity_available" 
                           name="quantity_available" 
                           value="{{ old('quantity_available', $ticket->quantity_available) }}"
                           min="{{ $ticket->quantity_sold }}"
                           placeholder="100"
                           class="w-full px-4 py-3 bg-gray-50 rounded-xl border border-gray-300 shadow-sm focus:ring-main-purple focus:border-main-purple transition @error('quantity_available') border-red-500 @enderror" 
                           required>
                    <p class="text-xs text-red-500 mt-1">Minimal {{ $ticket->quantity_sold }} (sudah terjual).</p>
                    @error('quantity_available')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="max_per_order" class="block text-sm font-semibold text-custom-dark mb-2">
                        Maksimal per Pesanan <span class="text-red-500">*</span>
                    </label>
                    <input type="number" 
                           id="max_per_order" 
                           name="max_per_order" 
                           value="{{ old('max_per_order', $ticket->max_per_order) }}"
                           min="1"
                           placeholder="5"
                           class="w-full px-4 py-3 bg-gray-50 rounded-xl border border-gray-300 shadow-sm focus:ring-main-purple focus:border-main-purple transition @error('max_per_order') border-red-500 @enderror" 
                           required>
                    <p class="text-xs text-gray-500 mt-1">Maks tiket yang dapat dibeli oleh 1 pembeli.</p>
                    @error('max_per_order')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div>
                    <label for="sales_start" class="block text-sm font-semibold text-custom-dark mb-2">
                        Penjualan Dimulai <span class="text-red-500">*</span>
                    </label>
                    <input type="datetime-local" 
                           id="sales_start" 
                           name="sales_start" 
                           value="{{ old('sales_start', \Carbon\Carbon::parse($ticket->sales_start)->format('Y-m-d\TH:i')) }}"
                           class="w-full px-4 py-3 bg-gray-50 rounded-xl border border-gray-300 shadow-sm focus:ring-main-purple focus:border-main-purple transition @error('sales_start') border-red-500 @enderror"
                           required>
                    @error('sales_start')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="sales_end" class="block text-sm font-semibold text-custom-dark mb-2">
                        Penjualan Berakhir <span class="text-red-500">*</span>
                    </label>
                    <input type="datetime-local" 
                           id="sales_end" 
                           name="sales_end" 
                           value="{{ old('sales_end', \Carbon\Carbon::parse($ticket->sales_end)->format('Y-m-d\TH:i')) }}"
                           class="w-full px-4 py-3 bg-gray-50 rounded-xl border border-gray-300 shadow-sm focus:ring-main-purple focus:border-main-purple transition @error('sales_end') border-red-500 @enderror"
                           required>
                    @error('sales_end')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex gap-4 pt-4 border-t border-gray-100">
                <button type="submit" 
                        class="flex-1 bg-main-purple hover:bg-[#9d85b6] text-white font-bold py-3 px-6 rounded-xl transition shadow-lg shadow-[#837ab6]/40 transform hover:-translate-y-0.5">
                    Perbarui Tiket
                </button>
                <a href="{{ route('organizer.events.show', $event) }}" 
                   class="flex-1 bg-gray-300 hover:bg-gray-400 text-custom-dark font-bold py-3 px-6 rounded-xl text-center transition transform hover:-translate-y-0.5">
                    Kembali ke Detail Event
                </a>
            </div>
        </form>
    </div>
</div>
@endsection