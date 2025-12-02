@extends('layouts.admin')

@section('title', 'Buat Tiket Baru')
@section('heading', 'Buat Tiket Baru')
@section('subheading', 'Tambahkan jenis tiket untuk event: ' . $event->title)

@section('content')
<style>
    .text-custom-dark { color: #250e2c; }
    .bg-main-purple { background-color: #837ab6; }
    .bg-pink-accent { background-color: #cc8db3; }
</style>

<div class="container mx-auto px-4 py-8 max-w-3xl">
    <div class="mb-6">
        <nav class="text-sm text-gray-600">
            <a href="{{ route('admin.events.index') }}" class="hover:text-main-purple">Daftar Event</a>
            <span class="mx-2">/</span>
            @if($event->exists)
            <a href="{{ route('admin.events.show', $event) }}" class="hover:text-main-purple">{{ Str::limit($event->title, 30) }}</a>
            @else
            <span class="text-gray-400">{{ Str::limit($event->title, 30) }} (Baru)</span>
            @endif
            <span class="mx-2">/</span>
            <span class="font-bold text-custom-dark">Buat Tiket</span>
        </nav>
    </div>

    <div class="bg-white rounded-2xl shadow-xl p-8 border border-gray-100">
        <h1 class="text-2xl font-bold text-custom-dark mb-1">Buat Jenis Tiket Baru</h1>
        <p class="text-gray-600 mt-1 mb-6">Untuk acara: <strong>{{ $event->title }}</strong></p>
        
        @if ($event->exists)
            <form action="{{ route('admin.tickets.store', $event) }}" method="POST">
        @else
            <form action="{{ route('admin.tickets.store_with_pending_event') }}" method="POST">
        @endif
            @csrf

            <div class="mb-5">
                <label for="name" class="block text-sm font-semibold text-custom-dark mb-2">
                    Nama Tiket <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       id="name" 
                       name="name" 
                       value="{{ old('name') }}"
                       placeholder="Contoh: VIP, Reguler, Early Bird"
                       class="w-full px-4 py-3 bg-gray-50 rounded-xl border shadow-sm focus:ring-main-purple focus:border-main-purple transition @error('name') border-red-500 @enderror" 
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
                          class="w-full px-4 py-3 bg-gray-50 rounded-xl border shadow-sm focus:ring-main-purple focus:border-main-purple transition @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
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
                           value="{{ old('price') }}"
                           min="0"
                           step="100"
                           placeholder="50000"
                           class="w-full px-4 py-3 bg-gray-50 rounded-xl border shadow-sm focus:ring-main-purple focus:border-main-purple transition @error('price') border-red-500 @enderror" 
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
                           value="{{ old('quantity_available') }}"
                           min="1"
                           placeholder="100"
                           class="w-full px-4 py-3 bg-gray-50 rounded-xl border shadow-sm focus:ring-main-purple focus:border-main-purple transition @error('quantity_available') border-red-500 @enderror" 
                           required>
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
                           value="{{ old('max_per_order', 5) }}"
                           min="1"
                           placeholder="5"
                           class="w-full px-4 py-3 bg-gray-50 rounded-xl border shadow-sm focus:ring-main-purple focus:border-main-purple transition @error('max_per_order') border-red-500 @enderror" 
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
                    <input type="date" 
                           id="sales_start" 
                           name="sales_start" 
                           value="{{ old('sales_start') }}"
                           class="w-full px-4 py-3 bg-gray-50 rounded-xl border shadow-sm focus:ring-main-purple focus:border-main-purple transition @error('sales_start') border-red-500 @enderror" style="line-height: 1.5rem;"
                           required>
                    @error('sales_start')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="sales_end" class="block text-sm font-semibold text-custom-dark mb-2">
                        Penjualan Berakhir <span class="text-red-500">*</span>
                    </label>
                    <input type="date" 
                           id="sales_end" 
                           name="sales_end" 
                           value="{{ old('sales_end') }}"
                           class="w-full px-4 py-3 bg-gray-50 rounded-xl border shadow-sm focus:ring-main-purple focus:border-main-purple transition @error('sales_end') border-red-500 @enderror" style="line-height: 1.5rem;"
                           required>
                    @error('sales_end')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex gap-4 pt-4 border-t border-gray-100">
                <button type="submit" 
                    class="bg-main-purple hover:bg-[#9d85b6] text-white font-bold py-3 px-6 rounded-xl transition shadow-lg shadow-[#837ab6]/40 transform hover:-translate-y-0.5">
                    @if ($event->exists)
                        Buat Tiket
                    @else
                        Selesaikan & Buat Event
                    @endif
                </button>
                <a href="{{ $event->exists ? route('admin.events.show', $event) : route('admin.events.create') }}" 
                   class="bg-gray-300 hover:bg-gray-400 text-custom-dark font-bold py-3 px-6 rounded-xl text-center transition transform hover:-translate-y-0.5">
                    Kembali ke Detail Event
                </a>
            </div>
            
        </form>
    </div>
</div>
@endsection