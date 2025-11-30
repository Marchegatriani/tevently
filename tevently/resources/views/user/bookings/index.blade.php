@extends('user.partials.navbar')

@section('title', 'My Bookings')
@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-4">My Bookings</h1>

    @if(session('success'))
        <div class="bg-green-100 border border-green-300 text-green-800 p-3 rounded mb-4">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-300 text-red-800 p-3 rounded mb-4">{{ session('error') }}</div>
    @endif

    @if($bookings instanceof \Illuminate\Pagination\AbstractPaginator && $bookings->count())
        <div class="bg-white rounded-lg shadow p-4">
            <table class="w-full text-sm">
                <thead class="text-left text-xs text-gray-500">
                    <tr>
                        <th class="p-2">#</th>
                        <th class="p-2">Event</th>
                        <th class="p-2">Ticket</th>
                        <th class="p-2">Quantity</th>
                        <th class="p-2">Total</th>
                        <th class="p-2">Status</th>
                        <th class="p-2"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bookings as $b)
                        <tr class="border-t">
                            <td class="p-2">{{ $b->id }}</td>
                            <td class="p-2">{{ $b->event->title ?? '-' }}</td>
                            <td class="p-2">{{ $b->ticket->name ?? '-' }}</td>
                            <td class="p-2">{{ $b->total_tickets ?? $b->quantity }}</td>
                            <td class="p-2">Rp {{ number_format($b->total_amount ?? 0, 0, ',', '.') }}</td>
                            <td class="p-2">{{ ucfirst($b->status ?? '-') }}</td>
                            <td class="p-2 text-right">
                                <a href="{{ route('bookings.show', $b->id) }}" class="text-indigo-600 hover:underline text-sm">View</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-4">
                {{ $bookings->links() }}
            </div>
        </div>
    @else
        <div class="bg-white rounded-lg shadow p-8 text-center">
            <p class="text-gray-600">Belum ada pemesanan tiket. Jelajahi acara dan pesan tiket sekarang.</p>
            <a href="{{ route('events.index') }}" class="mt-4 inline-block bg-indigo-600 text-white px-4 py-2 rounded">Browse Events</a>
        </div>
    @endif
</div>
@endsection
