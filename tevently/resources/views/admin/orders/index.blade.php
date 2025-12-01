@extends('admin.partials.navbar')

@section('title', 'Kelola Pesanan')
@section('heading', 'Kelola Pesanan Tiket')
@section('subheading', 'Ringkasan dan manajemen pesanan yang masuk')

@section('content')
<style>
    .text-custom-dark { color: #250e2c; }
    .bg-main-purple { background-color: #837ab6; }
    .bg-soft-pink-light { background-color: #f7c2ca; }
</style>

<div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
    
    @if($orders instanceof \Illuminate\Pagination\AbstractPaginator && $orders->count() > 0)
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-soft-pink-light">
                    <tr>
                        <th class="p-4 text-left text-xs font-bold text-custom-dark uppercase tracking-wider">No.</th>
                        <th class="p-4 text-left text-xs font-bold text-custom-dark uppercase tracking-wider">Pembeli</th>
                        <th class="p-4 text-left text-xs font-bold text-custom-dark uppercase tracking-wider">Event Terkait</th>
                        <th class="p-4 text-left text-xs font-bold text-custom-dark uppercase tracking-wider">Status</th>
                        <th class="p-4 text-left text-xs font-bold text-custom-dark uppercase tracking-wider">Total Pembayaran</th>
                        <th class="p-4"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($orders as $index => $order)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="p-4 font-semibold text-gray-700">{{ $orders->firstItem() + $index }}</td>
                            
                            <td class="p-4">
                                <div class="font-medium text-custom-dark">{{ $order->buyer_name ?? ($order->user->name ?? '-') }}</div>
                                <div class="text-xs text-gray-500">{{ $order->user->email ?? $order->user_email ?? '-' }}</div>
                            </td>
                            
                            <td class="p-4 text-sm text-gray-700">
                                {{ $order->event->title ?? 'Event Dihapus' }}
                            </td>
                            
                            <td class="p-4">
                                @php
                                    $statusClass = [
                                        'completed' => 'bg-green-100 text-green-800',
                                        'approved' => 'bg-green-100 text-green-800',
                                        'pending' => 'bg-yellow-100 text-yellow-800',
                                        'cancelled' => 'bg-red-100 text-red-800',
                                    ][$order->status ?? 'pending'] ?? 'bg-gray-100 text-gray-700';
                                @endphp
                                <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $statusClass }}">
                                    {{ ucfirst($order->status ?? '-') }}
                                </span>
                            </td>
                            
                            <td class="p-4 font-bold text-main-purple">
                                Rp {{ number_format($order->total_amount ?? 0, 0, ',', '.') }}
                            </td>
                            
                            <td class="p-4 text-right">
                                <a href="{{ route('admin.orders.show', $order->id) }}" class="text-main-purple hover:text-custom-dark font-semibold text-sm transition">
                                    Lihat Detail
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-gray-200">
            {{ $orders->links() }}
        </div>
        
    @else
        <div class="text-center py-12">
            <svg class="mx-auto h-12 w-12 text-[#cc8db3]/70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
            </svg>
            <p class="text-gray-600 text-lg mb-4 mt-2">Belum ada pesanan tiket yang tercatat.</p>
            <a href="{{ route('admin.events.index') }}" class="inline-flex items-center px-4 py-2 bg-main-purple text-white rounded-xl font-semibold hover:bg-[#9d85b6] transition shadow-md">
                Kelola Events
            </a>
        </div>
    @endif
</div>
@endsection