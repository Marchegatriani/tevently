@extends('organizer.partials.navbar')

@section('title', 'Detail Event: ' . $event->title)
@section('heading', 'Detail Event: ' . Str::limit($event->title, 40))
@section('subheading', 'Informasi dan statistik event Anda')

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
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Main Content (2/3) - Detail & Description -->
            <div class="lg:col-span-2 space-y-8 order-2 lg:order-1">
                
                <!-- Event Details & Description -->
                <div class="bg-white rounded-2xl shadow-xl p-8 border border-gray-100">
                    
                    @if($event->image_url)
                        <img src="{{ asset('storage/' . $event->image_url) }}" 
                             alt="{{ $event->title }}" 
                             class="w-full h-80 object-cover rounded-xl mb-6 shadow-md border border-gray-100">
                    @else
                        <div class="w-full h-64 bg-gradient-to-br from-[#837ab6] to-[#cc8db3] flex items-center justify-center rounded-xl mb-6">
                            <span class="text-white text-4xl font-bold opacity-80">GAMBAR TIDAK TERSEDIA</span>
                        </div>
                    @endif
                    
                    <h3 class="text-xl font-bold text-custom-dark mb-4 border-b pb-2">Deskripsi Acara</h3>
                    <p class="text-gray-700 whitespace-pre-line leading-relaxed">{{ $event->description }}</p>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-8 pt-6 border-t border-gray-100">
                        <div class="space-y-3 text-sm">
                            <p><strong>Kategori:</strong> <span class="text-custom-dark font-medium">{{ $event->category->name }}</span></p>
                            <p><strong>Lokasi:</strong> <span class="text-custom-dark font-medium">{{ $event->location }}</span></p>
                            <p><strong>Kapasitas Maks:</strong> <span class="text-custom-dark font-medium">{{ number_format($event->max_attendees) }}</span></p>
                            <p><strong>Available Seats:</strong> <span class="font-bold text-green-600">{{ $event->available_seats }}</span></p>
                        </div>
                        <div class="space-y-3 text-sm">
                            <p><strong>Tanggal:</strong> <span class="text-custom-dark font-medium">{{ $event->event_date->format('d F Y') }}</span></p>
                            <p><strong>Waktu:</strong> <span class="text-custom-dark font-medium">{{ $event->start_time->format('H:i') }} - {{ $event->end_time->format('H:i') }} WIB</span></p>
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
                        <p class="text-gray-500 text-center py-4">Acara ini belum memiliki tiket.</p>
                    @endif
                </div>

            </div>

            <!-- Sidebar (1/3) - Status & Stats -->
            <div class="lg:col-span-1 space-y-6 order-1 lg:order-2">
                
                <!-- Status -->
                <div class="bg-white rounded-2xl shadow-xl p-6 border border-gray-100 sticky top-4">
                    <h3 class="text-xl font-bold text-custom-dark mb-4 border-b pb-3">Status Acara</h3>
                    
                    <span class="px-4 py-2 rounded-xl text-sm font-bold shadow-md
                        {{ $event->status === 'published' ? 'bg-green-600 text-white' : '' }}
                        {{ $event->status === 'draft' ? 'bg-yellow-500 text-white' : '' }}
                        {{ $event->status === 'cancelled' ? 'bg-red-600 text-white' : '' }}">
                        {{ ucfirst($event->status) }}
                    </span>
                    
                    @if($event->status === 'draft')
                        <p class="text-yellow-700 text-sm mt-2">Acara Anda belum terlihat oleh publik.</p>
                    @elseif($event->status === 'published')
                        <p class="text-green-700 text-sm mt-2">Acara Anda aktif dan terlihat oleh publik.</p>
                    @endif
                </div>

                <!-- Quick Stats -->
                <div class="bg-white rounded-2xl shadow-xl p-6 border border-gray-100">
                    <h3 class="text-xl font-bold text-custom-dark mb-4 border-b pb-3">Statistik Cepat</h3>
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Total Jenis Tiket:</span>
                            <span class="font-semibold text-custom-dark">{{ $event->tickets->count() }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Tiket Terjual:</span>
                            <span class="font-semibold text-[#837ab6]">{{ $event->tickets->sum('quantity_sold') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Tiket Tersedia:</span>
                            <span class="font-semibold text-green-600">{{ $event->available_seats }}</span>
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

                <!-- Quick Actions / Metadata -->
                <div class="bg-white rounded-2xl shadow-xl p-6 border border-gray-100">
                    <h3 class="text-xl font-bold text-custom-dark mb-4 border-b pb-3">Metadata</h3>
                    <div class="space-y-3 text-sm text-custom-dark">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Dibuat:</span>
                            <span class="font-medium">{{ $event->created_at->format('d M Y') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Diperbarui:</span>
                            <span class="font-medium">{{ $event->updated_at->format('d M Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection