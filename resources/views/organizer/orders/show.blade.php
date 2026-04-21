@extends('layouts.organizer')

@section('title', 'Detail Pesanan')
@section('heading', 'Detail Pesanan')
@section('subheading', 'Informasi lengkap dan aksi terkait pesanan')

@section('content')
<style>
    .text-custom-dark { color: #250e2c; }
    .bg-main-purple { background-color: #837ab6; }
    .text-main-purple { color: #837ab6; }
    .bg-pink-accent { background-color: #cc8db3; }
</style>

<div class="space-y-6">

    <div class="flex justify-start">
        <a href="{{ route('organizer.orders.index') }}"
            class="bg-gray-200 text-custom-dark px-5 py-2 rounded-xl font-semibold hover:bg-gray-300 transition shadow-md flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd"
                    d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                    clip-rule="evenodd" />
            </svg>
            Kembali ke Daftar Pesanan
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-xl p-6 border border-gray-100">

        <div class="flex flex-wrap items-start justify-between border-b border-gray-100 pb-4 mb-6">
            <div class="mb-4 md:mb-0">
                <p class="text-lg text-gray-600">
                    Event:
                    <span class="font-bold text-main-purple">
                        {{ $order->event->title ?? '-' }}
                    </span>
                </p>
            </div>

            <div class="text-right">
                @php
                    $statusClasses = [
                        'expired' => 'bg-red-500',
                        'confirmed' => 'bg-main-purple',
                        'pending' => 'bg-pink-accent',
                        'cancelled' => 'bg-pink-accent',
                    ];
                    $statusClass = $statusClasses[$order->status ?? 'pending'] ?? 'bg-gray-500';
                @endphp

                <p class="text-sm text-gray-500 mb-1 py-2">Status Pesanan:</p>
                <span class="px-5 py-2 rounded-full text-md font-extrabold text-white {{ $statusClass }} shadow-lg">
                    {{ strtoupper($order->status ?? '-') }}
                </span>

                <p class="text-xl font-extrabold text-main-purple mt-4">
                    Total: Rp{{ number_format($order->total_amount ?? 0, 0, ',', '.') }}
                </p>
            </div>
        </div>

        <div class="mb-8 p-4 bg-gray-50 rounded-lg">
            <h4 class="text-xl font-bold text-custom-dark mb-4">Informasi Pelanggan</h4>
            <dl class="grid grid-cols-1 sm:grid-cols-2 gap-y-2 text-md">
                <div class="flex">
                    <dt class="text-gray-500 w-1/3">Nama:</dt>
                    <dd class="font-medium text-custom-dark w-2/3">
                        {{ $order->user->name ?? '-' }}
                    </dd>
                </div>
                <div class="flex">
                    <dt class="text-gray-500 w-1/3">Email:</dt>
                    <dd class="font-medium text-custom-dark w-2/3">
                        {{ $order->user->email ?? '-' }}
                    </dd>
                </div>
                <div class="flex">
                    <dt class="text-gray-500 w-1/3">Tgl Pesanan:</dt>
                    <dd class="font-medium text-custom-dark w-2/3">
                        {{ $order->created_at->format('d F Y H:i') }}
                    </dd>
                </div>
            </dl>
        </div>

        <div class="mb-8">
            <h4 class="text-xl font-bold text-custom-dark mb-4 border-b pb-2">Tiket yang Dipesan</h4>

            @forelse($order->orderItems as $item)
                <div class="flex justify-between items-center py-3 border-b border-dashed">
                    <div>
                        <p class="font-extrabold text-custom-dark text-lg">
                            {{ $item->ticket->name ?? 'Tiket Dihapus' }}
                        </p>
                        <p class="text-gray-500 text-sm">
                            Rp{{ number_format($item->unit_price ?? 0, 0, ',', '.') }} x {{ $item->quantity }}
                        </p>
                    </div>

                    <div class="font-bold text-custom-dark">
                        Rp {{ number_format($item->unit_price * $item->quantity, 0, ',', '.') }}
                    </div>
                </div>
            @empty
                <p class="text-gray-600">Tidak ada item tiket dalam pesanan ini.</p>
            @endforelse

            <div class="flex justify-between items-center py-4 mt-4 bg-main-purple/10 rounded-lg p-3">
                <p class="text-xl font-extrabold text-custom-dark">TOTAL PEMBAYARAN</p>
                <p class="text-2xl font-extrabold text-main-purple">
                    Rp {{ number_format($order->total_amount ?? 0, 0, ',', '.') }}
                </p>
            </div>
        </div>

        <div class="mt-6 pt-4 border-t border-gray-100">
            <div class="flex flex-wrap gap-4">

                @if($order->status === 'pending')

                    <form method="POST" action="{{ route('organizer.orders.approve', $order->id) }}">
                        @csrf
                        <button
                            class="px-5 py-3 bg-green-600 text-white font-semibold rounded-xl hover:bg-green-700 transition shadow-md flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                            Setujui Pesanan
                        </button>
                    </form>
                @else
                    <p class="text-gray-600 text-sm italic">
                        Pesanan berstatus **{{ ucfirst($order->status) }}**. Tidak ada aksi lebih lanjut yang tersedia.
                    </p>
                @endif

            </div>
        </div>

    </div>
</div>
@endsection