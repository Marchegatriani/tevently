@extends('layouts.organizer')

@section('title','Order Detail')
@section('heading','Order Detail')
@section('content')
<div class="bg-white rounded-lg p-6 shadow">
	<div class="flex items-start justify-between">
		<div>
			<h3 class="text-lg font-semibold">Order #{{ $order->id }}</h3>
			<p class="text-sm text-gray-500">Customer: {{ $order->user->name ?? '-' }}</p>
			<p class="text-sm text-gray-500">Event: {{ $order->event->title ?? '-' }}</p>
		</div>
		<div class="text-right">
			<p class="text-sm text-gray-500">Status: <strong>{{ ucfirst($order->status) }}</strong></p>
			<p class="text-sm text-gray-500">Total: Rp {{ number_format($order->total_amount ?? 0,0,',','.') }}</p>
		</div>
	</div>

	<div class="mt-4">
		<dl class="grid grid-cols-1 md:grid-cols-2 gap-3 text-sm">
			<div><dt class="text-gray-500">Ticket</dt><dd class="font-medium">{{ $order->ticket->name ?? '-' }}</dd></div>
			<div><dt class="text-gray-500">Quantity</dt><dd class="font-medium">{{ $order->total_tickets ?? $order->quantity }}</dd></div>
		</dl>
	</div>

	<div class="mt-4 flex gap-2">
		@if($order->status === 'pending')
			<form method="POST" action="{{ route('organizer.orders.approve', $order->id) }}">
				@csrf
				<button class="px-3 py-2 bg-green-600 text-white rounded">Approve</button>
			</form>
			<form method="POST" action="{{ route('organizer.orders.cancel', $order->id) }}">
				@csrf
				<button class="px-3 py-2 bg-red-600 text-white rounded">Cancel</button>
			</form>
		@elseif($order->status === 'confirmed')
			<form method="POST" action="{{ route('organizer.orders.cancel', $order->id) }}">
				@csrf
				<button class="px-3 py-2 bg-red-600 text-white rounded">Cancel</button>
			</form>
		@endif
	</div>
</div>
@endsection
