@extends('organizer.partials.sidebar')

@section('title','Orders')
@section('heading','Orders')
@section('content')
<div class="space-y-4">
	@if(session('success')) <div class="bg-green-100 p-3 rounded">{{ session('success') }}</div> @endif
	@if(session('error')) <div class="bg-red-100 p-3 rounded">{{ session('error') }}</div> @endif

	<div class="bg-white rounded-lg shadow p-4">
		<table class="w-full text-sm">
			<thead class="bg-gray-50 text-xs text-gray-500">
				<tr>
					<th class="p-2 text-left">#</th>
					<th class="p-2 text-left">Event</th>
					<th class="p-2 text-left">Ticket</th>
					<th class="p-2 text-left">Customer</th>
					<th class="p-2 text-left">Qty</th>
					<th class="p-2 text-left">Total</th>
					<th class="p-2 text-left">Status</th>
					<th class="p-2"></th>
				</tr>
			</thead>
			<tbody>
				@forelse($orders as $o)
					<tr class="border-t">
						<td class="p-2">{{ $o->id }}</td>
						<td class="p-2">{{ $o->event->title ?? '-' }}</td>
						<td class="p-2">{{ $o->ticket->name ?? '-' }}</td>
						<td class="p-2">{{ $o->user->name ?? '-' }}</td>
						<td class="p-2">{{ $o->total_tickets ?? $o->quantity }}</td>
						<td class="p-2">Rp {{ number_format($o->total_amount ?? 0,0,',','.') }}</td>
						<td class="p-2">{{ ucfirst($o->status ?? '-') }}</td>
						<td class="p-2 text-right">
							<a href="{{ route('organizer.orders.show', $o->id) }}" class="text-indigo-600 hover:underline text-sm">View</a>
						</td>
					</tr>
				@empty
					<tr><td colspan="8" class="p-4 text-center text-gray-500">Belum ada pesanan</td></tr>
				@endforelse
			</tbody>
		</table>

		<div class="mt-4">
			{{ $orders->links() }}
		</div>
	</div>
</div>
@endsection
