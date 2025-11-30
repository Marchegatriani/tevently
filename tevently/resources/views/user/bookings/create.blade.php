@extends('user.partials.navbar')

@section('title', 'Checkout Ticket')
@section('content')
<div class="max-w-3xl mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-semibold mb-2">Checkout — {{ $ticket->name }}</h2>
        <p class="text-sm text-gray-500 mb-4">Event: {{ $event->title }}</p>

        @if(session('error'))
            <div class="bg-red-100 text-red-800 p-3 rounded mb-4">{{ session('error') }}</div>
        @endif

        <form method="POST" action="{{ route('bookings.store', [$event, $ticket]) }}">
            @csrf
            <div class="mb-4">
                <label class="block text-sm text-gray-700 mb-1">Price</label>
                <div class="text-lg font-bold">Rp {{ number_format($ticket->price, 0, ',', '.') }}</div>
            </div>

            <div class="mb-4">
                <label class="block text-sm text-gray-700 mb-1">Quantity (available: {{ $remaining }}, max per order: {{ $max_per_order }})</label>
                <input type="number" name="quantity" value="{{ old('quantity', 1) }}" min="1" max="{{ min($remaining, $max_per_order) }}" required
                    class="w-32 px-3 py-2 border rounded">
                @error('quantity') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex gap-3 items-center">
                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Pay / Book</button>
                <a href="{{ route('user.events.show', $event) }}" class="text-sm text-gray-600 hover:underline">Back to event</a>
            </div>
        </form>
    </div>
</div>
@endsection
