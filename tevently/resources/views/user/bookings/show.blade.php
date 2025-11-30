@extends('user.partials.navbar')

@section('title', 'Booking Detail')
@section('content')
<div class="max-w-3xl mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-semibold mb-2">Booking #{{ $order->id }}</h2>
        <p class="text-sm text-gray-500 mb-4">Event: {{ $order->event->title ?? '-' }}</p>

        <dl class="grid grid-cols-1 gap-3 text-sm">
            <div class="flex justify-between">
                <span>Ticket</span>
                <span>{{ $order->ticket->name ?? '-' }}</span>
            </div>
            <div class="flex justify-between">
                <span>Quantity</span>
                <span>{{ $order->total_tickets ?? $order->quantity }}</span>
            </div>
            <div class="flex justify-between">
                <span>Total</span>
                <span>Rp {{ number_format($order->total_amount ?? 0, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between">
                <span>Status</span>
                <span>{{ ucfirst($order->status ?? '-') }}</span>
            </div>
        </dl>

        <div class="mt-4">
            <a href="{{ route('bookings.index') }}" class="text-indigo-600 hover:underline">Back to bookings</a>
        </div>
    </div>
</div>
@endsection
