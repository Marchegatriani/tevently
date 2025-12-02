@extends('layouts.user')

@section('title', 'Konfirmasi Pembatalan Pesanan')

@section('content')
<style>
    .text-custom-dark { color: #250e2c; }
    .bg-main-purple { background-color: #837ab6; }
    .bg-soft-pink-light { background-color: #f7c2ca; }
</style>

<div class="max-w-2xl mx-auto">
    <div class="text-center">
        <svg class="mx-auto h-16 w-16 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
        </svg>
        <h1 class="text-3xl font-extrabold text-custom-dark mt-4">Konfirmasi Pembatalan</h1>
        <p class="text-gray-600 mt-2">Apakah Anda yakin ingin membatalkan pesanan ini? Tindakan ini tidak dapat diurungkan.</p>
    </div>

    {{-- Order Summary --}}
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 mt-8">
        <h2 class="text-xl font-bold text-custom-dark mb-4 border-b pb-3">Detail Pesanan #{{ $order->id }}</h2>
        <div class="space-y-4 text-sm">
            <div class="flex justify-between">
                <span class="text-gray-500">Acara:</span>
                <span class="font-semibold text-custom-dark">{{ $order->event->title ?? 'N/A' }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-500">Tanggal Pesan:</span>
                <span class="font-semibold text-gray-700">{{ $order->created_at->format('d F Y') }}</span>
            </div>
            <div class="flex justify-between items-center border-t pt-4 mt-4">
                <span class="text-gray-500 text-base">Total Pembayaran:</span>
                <span class="text-2xl font-bold text-main-purple">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
            </div>
        </div>
    </div>

    <div class="mt-8 flex flex-col sm:flex-row justify-center items-center gap-4">
        <form action="{{ route('user.orders.cancel', $order) }}" method="POST" class="w-full sm:w-auto">
            @csrf
            @method('DELETE')
            <button type="submit" class="w-full text-center px-8 py-3 bg-red-600 text-white rounded-xl font-semibold hover:bg-red-700 transition shadow-md transform hover:-translate-y-0.5">
                Ya, Batalkan Pesanan
            </button>
        </form>
        <a href="{{ route('user.orders.show', $order) }}" class="w-full sm:w-auto text-center px-8 py-3 bg-gray-200 text-custom-dark rounded-xl font-semibold hover:bg-gray-300 transition transform hover:-translate-y-0.5">
            Tidak, Kembali
        </a>
    </div>
</div>

@endsection