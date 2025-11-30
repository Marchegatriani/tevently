@extends('admin.partials.navbar')

@section('title', $event->title)
@section('heading', 'Detail Event: ' . Str::limit($event->title, 40))
@section('subheading', 'Informasi lengkap dan statistik acara')

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
        
        <!-- Header Actions -->
        <div class="flex justify-between items-center mb-6">
            <div class="flex space-x-3">
                <a href="{{ route('admin.events.edit', $event) }}" class="bg-[#cc8db3] text-custom-dark px-4 py-2 rounded-xl font-semibold hover:bg-[#f6a5c0] transition shadow-md">
                    Edit Event
                </a>
                <a href="{{ route('admin.events.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-xl font-semibold hover:bg-gray-600 transition shadow-md">
                    Kembali
                </a>
            </div>
            
            <!-- Status Tag Header -->
            <span class="px-4 py-2 rounded-xl text-sm font-bold shadow-md
                {{ $event->status === 'published' ? 'bg-green-600 text-white' : '' }}
                {{ $event->status === 'draft' ? 'bg-yellow-500 text-white' : '' }}
                {{ $event->status === 'cancelled' ? 'bg-red-600 text-white' : '' }}
                {{ $event->status === 'completed' ? 'bg-gray-600 text-white' : '' }}">
                Status: {{ ucfirst($event->status) }}
            </span>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Kiri (2/3) - Detail Utama & Tiket -->
            <div class="lg:col-span-2 space-y-8">
                
                <!-- Event Details & Description -->
                <div class="bg-white rounded-2xl shadow-xl p-8 border border-gray-100">
                    
                    @if($event->image_url)
                        <img src="{{ asset('storage/' . $event->image_url) }}" 
                             alt="{{ $event->title }}" 
                             class="w-full h-80 object-cover rounded-xl mb-6 shadow-md border border-gray-100">
                    @else
                        <div class="w-full h-64 bg-gradient-to-br from-[#837ab6] to-[#cc8db3] flex items-center justify-center rounded-xl mb-6">
                            <span class="text-white text-4xl font-bold opacity-80">NO IMAGE</span>
                        </div>
                    @endif
                    
                    <h3 class="text-xl font-bold text-custom-dark mb-4 border-b pb-2">Deskripsi Event</h3>
                    <p class="text-gray-700 whitespace-pre-line leading-relaxed">{{ $event->description }}</p>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-8 pt-6 border-t border-gray-100">
                        <div class="space-y-3">
                            <p class="text-sm"><strong>Kategori:</strong> <span class="text-custom-dark font-medium">{{ $event->category->name }}</span></p>
                            <p class="text-sm"><strong>Lokasi:</strong> <span class="text-custom-dark font-medium">{{ $event->location }}</span></p>
                            <p class="text-sm"><strong>Kapasitas Maks:</strong> <span class="text-custom-dark font-medium">{{ number_format($event->max_attendees) }}</span></p>
                            <p class="text-sm"><strong>Diadakan Oleh:</strong> <span class="text-custom-dark font-medium">{{ $event->organizer->name }}</span></p>
                        </div>
                        <div class="space-y-3">
                            <p class="text-sm"><strong>Tanggal:</strong> <span class="text-custom-dark font-medium">{{ $event->event_date->format('d F Y') }}</span></p>
                            <p class="text-sm"><strong>Waktu Mulai:</strong> <span class="text-custom-dark font-medium">{{ $event->start_time->format('H:i') }} WIB</span></p>
                            <p class="text-sm"><strong>Waktu Selesai:</strong> <span class="text-custom-dark font-medium">{{ $event->end_time->format('H:i') }} WIB</span></p>
                        </div>
                    </div>
                </div>

                <!-- Tickets Summary -->
                <div class="bg-white rounded-2xl shadow-xl p-8 border border-gray-100">
                    <h3 class="text-xl font-bold text-custom-dark mb-4 border-b pb-3">Daftar Tiket</h3>
                    
                    @if($event->tickets->count() > 0)
                        <div class="space-y-4">
                            @foreach($event->tickets as $ticket)
                                <div class="border rounded-xl p-4 transition {{ $ticket->is_active ? 'border-gray-200' : 'border-red-300 bg-red-50' }}">
                                    <div class="flex justify-between items-start mb-2">
                                        <h4 class="font-semibold text-lg text-custom-dark">{{ $ticket->name }}</h4>
                                        <span class="text-lg font-bold text-[#837ab6]">
                                            Rp {{ number_format($ticket->price, 0, ',', '.') }}
                                        </span>
                                    </div>
                                    <p class="text-gray-600 text-sm mb-3">{{ $ticket->description }}</p>
                                    
                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm pt-3 border-t border-gray-100">
                                        <div class="text-center">
                                            <span class="text-gray-500 block">Tersedia</span>
                                            <span class="font-bold text-custom-dark">{{ $ticket->quantity_available - $ticket->quantity_sold }}</span>
                                        </div>
                                        <div class="text-center">
                                            <span class="text-gray-500 block">Terjual</span>
                                            <span class="font-bold text-custom-dark">{{ $ticket->quantity_sold }}</span>
                                        </div>
                                        <div class="text-center">
                                            <span class="text-gray-500 block">Total Stok</span>
                                            <span class="font-bold text-custom-dark">{{ $ticket->quantity_available }}</span>
                                        </div>
                                        <div class="text-center">
                                            <span class="text-gray-500 block">Status</span>
                                            <span class="font-bold {{ $ticket->is_active ? 'text-green-600' : 'text-red-600' }}">
                                                {{ $ticket->is_active ? 'Aktif' : 'Nonaktif' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-4">Event ini belum memiliki tiket.</p>
                    @endif
                </div>

            </div>

            <!-- Kanan (1/3) - Sidebar Statistik & Info -->
            <div class="lg:col-span-1 space-y-6 order-1 lg:order-2">
                
                <!-- Statistics -->
                <div class="bg-white rounded-2xl shadow-xl p-6 border border-gray-100 sticky top-4">
                    <h3 class="text-xl font-bold text-custom-dark mb-4 border-b pb-3 border-gray-100">Statistik Penjualan</h3>
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Total Tiket Dibuat:</span>
                            <span class="font-semibold text-custom-dark">{{ $event->tickets->sum('quantity_available') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Tiket Tersedia:</span>
                            <span class="font-semibold text-green-600">{{ $event->tickets->sum('quantity_available') - $event->tickets->sum('quantity_sold') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Tiket Terjual:</span>
                            <span class="font-semibold text-[#837ab6]">{{ $event->tickets->sum('quantity_sold') }}</span>
                        </div>
                        <div class="flex justify-between text-lg pt-3 border-t border-gray-100 mt-3">
                            <span class="text-gray-600 font-bold">Total Pendapatan:</span>
                            <span class="font-extrabold text-[#cc8db3]">
                                Rp {{ number_format($event->tickets->sum(function($ticket) {
                                    return $ticket->price * $ticket->quantity_sold;
                                }), 0, ',', '.') }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Event Info & Dates -->
                <div class="bg-white rounded-2xl shadow-xl p-6 border border-gray-100">
                    <h3 class="text-xl font-bold text-custom-dark mb-4 border-b pb-3 border-gray-100">Informasi Metadata</h3>
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Dibuat pada:</span>
                            <span class="font-medium text-custom-dark">{{ $event->created_at->format('d M Y') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Terakhir Diperbarui:</span>
                            <span class="font-medium text-custom-dark">{{ $event->updated_at->format('d M Y') }}</span>
                        </div>
                        <div class="flex justify-between pt-3 border-t border-gray-100 mt-3">
                            <span class="text-gray-600">Organizer Email:</span>
                            <span class="font-medium text-custom-dark">{{ $event->organizer->email }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection