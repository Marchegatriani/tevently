@extends('layouts.admin')

@section('title', 'Detail Pesanan')
@section('heading', 'Detail Pesanan #{{ $order->id }}')
@section('subheading', 'Informasi dan aksi terkait pesanan')

@section('content')
<style>
    .text-custom-dark { color: #250e2c; }
    .bg-main-purple { background-color: #837ab6; }
    .bg-pink-accent { background-color: #cc8db3; }
    .bg-soft-light { background-color: #F8F3F7; }
</style>

<div class="max-w-7xl mx-auto px-4 lg:px-8">
    <div class="flex justify-end mb-6">
        <a href="{{ route('admin.orders.index') }}" class="bg-gray-300 text-custom-dark px-5 py-2 rounded-xl font-semibold hover:bg-gray-400 transition shadow-md">
            ← Kembali ke Daftar Pesanan
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2">
            <div class="bg-white shadow-xl rounded-2xl p-8 border border-gray-100">
                <h5 class="text-2xl font-bold text-custom-dark mb-6 border-b pb-3">Informasi Pesanan</h5>
                
                <table class="w-full text-sm text-gray-700">
                    <tbody>
                        <tr class="border-b border-gray-100">
                            <th class="py-3 text-left font-semibold">Pelanggan</th>
                            <td class="py-3 font-medium text-custom-dark">{{ $order->user->name }} ({{ $order->user->email }})</td>
                        </tr>
                        <tr class="border-b border-gray-100">
                            <th class="py-3 text-left font-semibold">Event</th>
                            <td class="py-3 font-medium text-custom-dark">{{ $order->event->title }}</td>
                        </tr>
                        <tr class="border-b border-gray-100">
                            <th class="py-3 text-left font-semibold">Jenis Tiket</th>
                            <td class="py-3 font-medium text-custom-dark">{{ $order->ticket->name }} (Rp {{ number_format($order->ticket->price, 0, ',', '.') }})</td>
                        </tr>
                        <tr class="border-b border-gray-100">
                            <th class="py-3 text-left font-semibold">Kuantitas</th>
                            <td class="py-3 font-medium text-custom-dark">{{ $order->quantity }} tiket</td>
                        </tr>
                        <tr class="border-b border-gray-100">
                            <th class="py-3 text-left font-semibold text-lg">Total Pembayaran</th>
                            <td class="py-3 font-extrabold text-main-purple text-lg">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                        </tr>
                        <tr class="border-b border-gray-100">
                            <th class="py-3 text-left font-semibold">Status</th>
                            <td class="py-3">
                                @php
                                    $statusClasses = [
                                        'approved' => 'bg-green-100 text-green-800',
                                        'pending' => 'bg-yellow-100 text-yellow-800',
                                        'cancelled' => 'bg-red-100 text-red-800',
                                        'completed' => 'bg-blue-100 text-blue-800',
                                    ];
                                    $currentStatusClass = $statusClasses[$order->status] ?? 'bg-gray-100 text-gray-700';
                                @endphp
                                <span class="px-3 py-1 text-sm font-semibold rounded-full {{ $currentStatusClass }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th class="py-3 text-left font-semibold">Tanggal Pesanan</th>
                            <td class="py-3 font-medium text-custom-dark">{{ $order->created_at->format('d M Y H:i') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        
        <div class="lg:col-span-1">
            <div class="bg-white shadow-xl rounded-2xl p-6 border border-gray-100 sticky top-4">
                <h5 class="text-xl font-bold text-custom-dark mb-4 border-b pb-3">Aksi</h5>
                
                @if($order->status == 'pending')
                    <div class="flex flex-col gap-3">
                        <form action="{{ route('admin.orders.approve', $order) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full bg-green-600 text-white font-semibold py-3 rounded-xl hover:bg-green-700 transition shadow-md">
                                Setujui Pesanan
                            </button>
                        </form>
                        
                        <form action="{{ route('admin.orders.cancel', $order) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full bg-red-600 text-white font-semibold py-3 rounded-xl hover:bg-red-700 transition shadow-md" 
                                    onclick="return confirm('Apakah Anda yakin ingin membatalkan pesanan ini?')">
                                Batalkan Pesanan
                            </button>
                        </form>
                    </div>
                @else
                    <p class="text-gray-600 text-sm">Tidak ada aksi yang tersedia untuk pesanan berstatus **{{ ucfirst($order->status) }}**.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection