@extends('layouts.user')

@section('title', 'My Orders')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        
        <!-- Header Stats -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-white rounded-lg shadow-sm p-4 text-center">
                <div class="text-2xl font-bold text-indigo-600">{{ $totalOrders }}</div>
                <div class="text-gray-600">Total Orders</div>
            </div>
            <div class="bg-white rounded-lg shadow-sm p-4 text-center">
                <div class="text-2xl font-bold text-yellow-600">{{ $pendingOrders }}</div>
                <div class="text-gray-600">Pending</div>
            </div>
            <div class="bg-white rounded-lg shadow-sm p-4 text-center">
                <div class="text-2xl font-bold text-green-600">{{ $confirmedOrders }}</div>
                <div class="text-gray-600">Confirmed</div>
            </div>
            <div class="bg-white rounded-lg shadow-sm p-4 text-center">
                <div class="text-2xl font-bold text-blue-600">
                    Rp {{ number_format($orders->where('status', 'confirmed')->sum('total_amount'), 0, ',', '.') }}
                </div>
                <div class="text-gray-600">Total Spent</div>
            </div>
        </div>

        <!-- Orders Table -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">My Orders</h2>
                
                @if($orders->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Order #</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Event</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tickets</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Amount</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                {{-- Di bagian loop orders, ganti $order->ticket dengan $order->orderItems --}}
@foreach($orders as $order)
    <tr>
        <td>{{ $order->order_number }}</td>
        <td>{{ $order->event->title }}</td>
        <td>
            {{-- PERBAIKAN: Akses melalui orderItems --}}
            @foreach($order->orderItems as $item)
                <div>{{ $item->ticket->name }} ({{ $item->quantity }}x) - Rp {{ number_format($item->ticket->price) }}</div>
            @endforeach
        </td>
        <td>Rp {{ number_format($order->total_amount) }}</td>
        <td>
            <span class="badge badge-{{ $order->status === 'pending' ? 'warning' : ($order->status === 'confirmed' ? 'success' : 'danger') }}">
                {{ ucfirst($order->status) }}
            </span>
        </td>
        <td>{{ $order->created_at->format('d M Y H:i') }}</td>
        <td>
            {{-- Tombol actions --}}
            @if($order->status === 'pending')
                <form action="{{ route('organizer.orders.approve', $order) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-success btn-sm">Approve</button>
                </form>
                <form action="{{ route('organizer.orders.cancel', $order) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-danger btn-sm">Cancel</button>
                </form>
            @endif
            <a href="{{ route('organizer.orders.show', $order) }}" class="btn btn-info btn-sm">View</a>
        </td>
    </tr>
@endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $orders->links() }}
                    </div>
                @else
                    <div class="text-center py-8">
                        <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                        <p class="text-gray-500">You haven't made any orders yet.</p>
                        <a href="{{ route('user.events.index') }}" class="mt-4 inline-block bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">
                            Browse Events
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection