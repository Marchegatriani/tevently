@extends('user.partials.navbar')

@section('title', 'Detail Pemesanan')
@section('heading', 'Detail Pemesanan')
@section('subheading', 'Rincian lengkap pesanan tiket Anda')

@section('content')
<style>
    .text-custom-dark { color: #250e2c; }
    .bg-main-purple { background-color: #837ab6; }
    .bg-pink-accent { background-color: #cc8db3; }
</style>

<div class="max-w-3xl mx-auto px-4 py-8">
    <div class="bg-white rounded-3xl shadow-xl p-8 border border-gray-100">

        <h2 class="text-2xl font-bold text-custom-dark mb-1">Pemesanan #{{ $order->id }}</h2>
        <p class="text-gray-600 mb-6 border-b pb-4">Acara: <strong class="text-main-purple">{{ $order->event->title ?? '-' }}</strong></p>

        <dl class="grid grid-cols-1 md:grid-cols-2 gap-y-4 gap-x-8 text-sm">
            <div class="md:col-span-2 border-b border-gray-100 pb-2">
                <dt class="text-lg font-semibold text-custom-dark">Jenis Tiket</dt>
                <dd class="text-2xl font-extrabold text-main-purple">{{ $order->ticket->name ?? '-' }}</dd>
            </div>

            <div class="border-b border-gray-100 pb-2">
                <dt class="text-gray-500">Kuantitas</dt>
                <dd class="font-bold text-custom-dark text-xl">{{ $order->total_tickets ?? $order->quantity }}</dd>
            </div>
            
            <div class="border-b border-gray-100 pb-2">
                <dt class="text-gray-500">Harga Satuan</dt>
                <dd class="font-medium text-custom-dark text-xl">Rp {{ number_format($order->ticket->price ?? 0, 0, ',', '.') }}</dd>
            </div>

            <div class="border-b border-gray-100 pb-2">
                <dt class="text-gray-500">Tanggal Pesan</dt>
                <dd class="font-medium text-custom-dark">{{ $order->created_at->format('d F Y H:i') }}</dd>
            </div>

            <div class="border-b border-gray-100 pb-2">
                <dt class="text-gray-500">Status</dt>
                @php
                    $statusClass = [
                        'approved' => 'bg-green-100 text-green-800',
                        'pending' => 'bg-yellow-100 text-yellow-800',
                        'cancelled' => 'bg-red-100 text-red-800',
                        'completed' => 'bg-blue-100 text-blue-800',
                    ][$order->status ?? 'pending'] ?? 'bg-gray-100 text-gray-700';
                @endphp
                <dd>
                    <span class="px-3 py-1 text-sm font-semibold rounded-full {{ $statusClass }}">
                        {{ ucfirst($order->status ?? '-') }}
                    </span>
                </dd>
            </div>

        </dl>

        <div class="mt-6 pt-4 border-t border-gray-200 flex justify-between items-center">
            <span class="text-xl font-bold text-custom-dark">Total Pembayaran</span>
            <span class="text-3xl font-extrabold text-pink-accent">Rp {{ number_format($order->total_amount ?? 0, 0, ',', '.') }}</span>
        </div>


        <div class="mt-8 pt-4 border-t border-gray-100">
            <a href="{{ route('bookings.index') }}" class="text-main-purple hover:text-custom-dark font-medium text-sm transition">← Kembali ke Daftar Pemesanan</a>
        </div>
    </div>
</div>
@endsection