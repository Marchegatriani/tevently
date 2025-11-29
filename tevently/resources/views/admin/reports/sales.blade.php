@extends('layouts.admin')

@section('title', 'Sales Report')
@section('heading', 'Sales Report')
@section('subheading', 'Detail laporan penjualan tiket')

@section('content')
<!-- Filter Section -->
<div class="mb-6 bg-gray-50 p-4 rounded-lg">
    <form method="GET" action="{{ route('admin.reports.sales') }}" class="flex flex-wrap gap-4 items-end">
        <div class="flex-1 min-w-[200px]">
            <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Start Date</label>
            <input 
                type="date" 
                id="start_date"
                name="start_date" 
                value="{{ request('start_date') }}"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500"
            >
        </div>
        
        <div class="flex-1 min-w-[200px]">
            <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">End Date</label>
            <input 
                type="date" 
                id="end_date"
                name="end_date" 
                value="{{ request('end_date') }}"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500"
            >
        </div>
        
        <div class="flex gap-2">
            <button 
                type="submit" 
                class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition"
            >
                Apply Filter
            </button>
            <a 
                href="{{ route('admin.reports.sales') }}" 
                class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition"
            >
                Reset
            </a>
        </div>
    </form>
</div>

<!-- Summary Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
    <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg p-6 text-white">
        <p class="text-blue-100 text-sm font-medium">Total Sales</p>
        <p class="text-3xl font-bold mt-1">{{ number_format($totalSales) }}</p>
        <p class="text-blue-100 text-xs mt-2">Approved orders</p>
    </div>
    
    <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-lg p-6 text-white">
        <p class="text-green-100 text-sm font-medium">Total Revenue</p>
        <p class="text-3xl font-bold mt-1">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
        <p class="text-green-100 text-xs mt-2">From all sales</p>
    </div>
</div>

<!-- Sales Table -->
<div class="overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order ID</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Event</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ticket</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse($sales as $order)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 text-sm font-medium text-indigo-600">
                    #{{ $order->id }}
                </td>
                <td class="px-6 py-4">
                    <div class="text-sm font-medium text-gray-900">{{ $order->user->name ?? 'N/A' }}</div>
                    <div class="text-sm text-gray-500">{{ $order->user->email ?? '' }}</div>
                </td>
                <td class="px-6 py-4">
                    <div class="text-sm font-medium text-gray-900">{{ $order->event->name ?? 'N/A' }}</div>
                    <div class="text-sm text-gray-500">{{ $order->event->location ?? '' }}</div>
                </td>
                <td class="px-6 py-4 text-sm text-gray-900">
                    {{ $order->ticket->type ?? 'N/A' }}
                </td>
                <td class="px-6 py-4 text-sm text-gray-900">
                    {{ $order->quantity }}
                </td>
                <td class="px-6 py-4 text-sm font-semibold text-green-600">
                    Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                </td>
                <td class="px-6 py-4 text-sm text-gray-500">
                    {{ $order->created_at->format('d M Y') }}<br>
                    <span class="text-xs">{{ $order->created_at->format('H:i') }}</span>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <p class="mt-2">Tidak ada data penjualan</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Pagination -->
@if($sales->hasPages())
<div class="mt-6">
    {{ $sales->links() }}
</div>
@endif
@endsection