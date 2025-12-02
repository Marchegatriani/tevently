@extends('layouts.user')

@section('title', 'Tiket Kamu')

@section('content')

@php
    $event = optional(optional($item->order)->event);
    $user = optional(optional($item->order)->user);
    $ticket = $item->ticket ?? null;
@endphp

<div class="max-w-4xl mx-auto p-4">
    
    <div class="bg-white border-4 border-[#837ab6] rounded-3xl shadow-xl font-poppins relative overflow-hidden flex">
        
        <div class="p-6 flex-1">
            
            <div class="flex justify-between items-start mb-4">
                <h2 class="text-xl font-extrabold text-[#837ab6]">
                    Tevently
                </h2>
                <p class="text-sm font-bold text-[#cc8db3] border border-[#cc8db3] px-3 py-1 rounded-full whitespace-nowrap">
                    {{ $event->category->name ?? 'Kategori' }}
                </p>
            </div>

            <h1 class="text-2xl font-extrabold text-[#250e2c] leading-snug">
                {{ $event->title ?? 'Event Tidak Tersedia' }}
            </h1>
            <p class="text-[#837ab6] mt-1 text-sm font-medium">Tiket Masuk</p>

            <div class="mt-5 grid grid-cols-3 gap-y-4 gap-x-6 text-sm">
                <div>
                    <span class="text-xs text-gray-500 block">TANGGAL</span>
                    <p class="font-semibold">
                        @if($event->event_date)
                            {{ \Carbon\Carbon::parse($event->event_date)->translatedFormat('d F Y') }}
                        @else
                            N/A
                        @endif
                    </p>
                </div>

                <div>
                    <span class="text-xs text-gray-500 block">WAKTU</span>
                    <p class="font-semibold">
                        @if($event->start_time)
                            {{ \Carbon\Carbon::parse($event->start_time)->format('H:i') }} WIB
                        @else
                            -
                        @endif
                    </p>
                </div>

                <div>
                    <span class="text-xs text-gray-500 block">JENIS TIKET</span>
                    <p class="font-extrabold text-[#cc8db3]">{{ $ticket->name ?? 'N/A' }}</p>
                </div>

                <div class="col-span-2">
                    <span class="text-xs text-gray-500 block">LOKASI</span>
                    <p class="font-semibold">{{ $event->location ?? 'Lokasi tidak tersedia' }}</p>
                </div>
                
                <div>
                    <span class="text-xs text-gray-500 block">PEMESAN</span>
                    <p class="font-semibold">{{ $user->name ?? 'User tidak ditemukan' }}</p>
                </div>
            </div>
            
        </div>

        <div class="w-1 bg-[#f7c2ca] border-l border-dashed border-gray-400 relative">
            <div class="absolute -top-4 -left-4 w-8 h-8 rounded-full bg-white border-2 border-[#837ab6]"></div>
            <div class="absolute -bottom-4 -left-4 w-8 h-8 rounded-full bg-white border-2 border-[#837ab6]"></div>
        </div>

        <div class="bg-gray-100 p-6 w-1/3 min-w-[200px] flex flex-col justify-between items-center text-center">
            
        <div class="w-28 h-28 bg-white border border-gray-300 flex items-center justify-center rounded-lg shadow-inner mb-4">
            <img 
                src="{{ asset('storage/tampilan/qrCode.png') }}" 
                alt="QR Code untuk Pesanan" 
                class="w-full h-full object-cover rounded-lg"
            >
        </div>

            <div class="flex justify-center space-x-6 text-sm">
                <div>
                    <span class="text-xs text-gray-500 block">KUANTITAS</span>
                    <p class="font-extrabold text-lg text-[#250e2c]">{{ $item->quantity ?? 1 }}</p>
                </div>
                <div>
                    <span class="text-xs text-gray-500 block">HARGA</span>
                    <p class="font-extrabold text-lg text-[#cc8db3]">
                        Rp {{ number_format($ticket->price ?? 0, 0, ',', '.') }}
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="mt-6 w-full">
        <a href="#" class="w-full block text-center px-4 py-2 rounded-xl bg-[#cc8db3] text-white font-semibold shadow-md hover:bg-[#b676a0] transition text-sm">
            Download Tiket
        </a>
    </div>
</div>

@endsection