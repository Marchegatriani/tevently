@extends('user.partials.navbar')

@section('title', 'Detail Pesanan #' . $order->id)

@section('content')
<style>
    .text-custom-dark { color: #250e2c; }
    .bg-main-purple { background-color: #837ab6; }
    .bg-soft-pink-light { background-color: #f7c2ca; }
</style>

<div class="space-y-8">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-custom-dark">Detail Pesanan #{{ $order->id }}</h1>
            <p class="text-gray-500 mt-1">Dibuat pada {{ $order->created_at->format('d F Y, H:i') }}</p>
        </div>
        <a href="{{ route('user.orders.index') }}" class="inline-flex items-center gap-2 text-main-purple hover:text-custom-dark font-semibold transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            Kembali ke Riwayat Pesanan
        </a>
    </div>

    @if(session('success')) 
        <div class="bg-green-100 p-4 rounded-xl border border-green-400 text-green-800 font-medium shadow-sm">{{ session('success') }}</div> 
    @endif
    @if(session('error')) 
        <div class="bg-red-100 p-4 rounded-xl border border-red-400 text-red-800 font-medium shadow-sm">{{ session('error') }}</div> 
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <div class="lg:col-span-2 space-y-6">
            {{-- Order Summary --}}
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                <h2 class="text-xl font-bold text-custom-dark mb-4 border-b pb-3">Ringkasan Pesanan</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-500">Status Pesanan</p>
                        @php
                            $statusClass = [
                                'confirmed' => 'bg-green-100 text-green-800',
                                'pending' => 'bg-yellow-100 text-yellow-800',
                                'cancelled' => 'bg-red-100 text-red-800',
                                'completed' => 'bg-blue-100 text-blue-800',
                            ][$order->status] ?? 'bg-gray-100 text-gray-800';
                        @endphp
                        <span class="px-3 py-1 text-sm font-bold rounded-full {{ $statusClass }} inline-block mt-1">
                            {{ ucfirst($order->status) }}
                        </span>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Total Pembayaran</p>
                        <p class="text-2xl font-bold text-main-purple mt-1">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>

            {{-- Ticket Details --}}
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                <h2 class="text-xl font-bold text-custom-dark mb-4 border-b pb-3">Detail Tiket</h2>
                <ul class="divide-y divide-gray-200">
                    @foreach($order->orderItems as $item)
                    <li class="py-4 flex justify-between items-center">
                        <div>
                            <p class="font-bold text-custom-dark">{{ $item->ticket->name }}</p>
                            <p class="text-sm text-gray-500">{{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                        </div>
                        <p class="font-semibold text-gray-800">Rp {{ number_format($item->quantity * $item->price, 0, ',', '.') }}</p>
                    </li>
                    @endforeach
                </ul>
            </div>

            <div class="flex items-center gap-4 pt-4 border-t">
                @if($order->status === 'confirmed')
                    <a href="{{ route('user.orders.download-ticket', $order) }}" class="w-full sm:w-auto text-center px-6 py-3 bg-green-500 text-white rounded-xl font-semibold hover:bg-green-600 transition shadow-md">
                        Download E-Ticket
                    </a>
                @endif

                @if($order->status === 'pending')
                    <a href="{{ route('user.orders.cancel.confirm', $order) }}" class="w-full sm:w-auto text-center px-6 py-3 bg-red-500 text-white rounded-xl font-semibold hover:bg-red-600 transition shadow-md">
                        Batalkan Pesanan
                    </a>
                @endif
            </div>
        </div>

        <div class="lg:col-span-1 space-y-6">
            {{-- Event Info --}}
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-custom-dark mb-4">Informasi Acara</h3>
                @if($order->event)
                    <div class="space-y-3 text-sm">
                        <a href="{{ route('user.events.show', $order->event) }}" class="text-lg font-bold text-main-purple hover:underline">{{ $order->event->title }}</a>
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-gray-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            <span class="font-medium text-gray-700">{{ \Carbon\Carbon::parse($order->event->event_date)->translatedFormat('l, d F Y') }}</span>
                        </div>
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-gray-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            <span class="font-medium text-gray-700">{{ $order->event->location }}</span>
                        </div>
                    </div>
                @else
                    <p class="text-gray-500">Informasi acara tidak tersedia (mungkin telah dihapus).</p>
                @endif
            </div>

            {{-- Buyer Info --}}
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-custom-dark mb-4">Informasi Pembeli</h3>
                @if($order->user)
                    <div class="space-y-3 text-sm">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-gray-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            <span class="font-medium text-gray-700">{{ $order->user->name }}</span>
                        </div>
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-gray-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            <span class="font-medium text-gray-700">{{ $order->user->email }}</span>
                        </div>
                    </div>
                @else
                    <p class="text-gray-500">Informasi pembeli tidak tersedia.</p>
                @endif
            </div>
        </div>

    </div>
</div>
@endsection