@extends('admin.partials.navbar')

@section('title', 'Ticket Orders')
@section('heading', 'Ticket Orders')
@section('subheading', 'Kelola pesanan tiket')

@section('content')
	@if($orders instanceof \Illuminate\Pagination\AbstractPaginator && $orders->count() > 0)
		<table class="w-full text-sm">
			<thead class="bg-gray-50">
				<tr>
					<th class="p-3 text-left">#</th>
					<th class="p-3 text-left">Buyer</th>
					<th class="p-3 text-left">Event</th>
					<th class="p-3 text-left">Status</th>
					<th class="p-3 text-left">Total</th>
					<th class="p-3"></th>
				</tr>
			</thead>
			<tbody>
				@foreach($orders as $order)
					<tr class="border-t">
						<td class="p-3">{{ $order->id }}</td>
						<td class="p-3">{{ $order->buyer_name ?? ($order->user->name ?? '-') }}</td>
						<td class="p-3">{{ $order->event->title ?? '-' }}</td>
						<td class="p-3">{{ ucfirst($order->status ?? '-') }}</td>
						<td class="p-3">{{ number_format($order->total ?? 0, 0, ',', '.') }}</td>
						<td class="p-3 text-right">
							<a href="{{ route('admin.orders.show', $order->id) }}" class="text-indigo-600 hover:underline text-sm">View</a>
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>

		<div class="mt-4">
			{{ $orders->links() }}
		</div>
	@else
		<div class="text-center py-8">
			<p class="text-gray-500 mb-4">Belum ada pesanan tiket.</p>
			<a href="{{ route('admin.events.index') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded">Kelola Events</a>
		</div>
	@endif
@endsection